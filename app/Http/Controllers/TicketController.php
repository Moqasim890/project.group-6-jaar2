<?php

namespace App\Http\Controllers;

use App\Models\TicketModel;
use App\Mail\TicketConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\PrijsModel;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evenementen = TicketModel::getAllEvents();
        return view('Tickets.index', compact('evenementen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'evenement_id' => 'required|integer|exists:evenements,id',
            'tarief' => 'required|numeric|min:0',
            'tijdslot' => 'required',
            'datum' => 'required|date'
        ]);

        TicketModel::createTicket($validated);
        return redirect()->route('Tickets.index')
            ->with('success', 'Ticket succesvol aangemaakt!');
    }

    /**
     * Display the specified resource.
     */
    public function show(request $request, $evenement)
    {

        //alle prijzen die bij de evenement horen
        $prijzen = PrijsModel::where('EvenementId', $evenement->id)->get()->groupBy('Datum');
        return view('Tickets.show', compact( 'prijzen', 'evenement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $ticket = TicketModel::getTicketByID($id);
        return view('Tickets.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'evenement_id' => 'required|integer|exists:evenements,id',
            'tarief' => 'required|numeric|min:0',
            'tijdslot' => 'required',
            'datum' => 'required|date'
        ]);

        TicketModel::updateTicket($id, $validated);
        return redirect()->route('Tickets.show', $id)
            ->with('success', 'Ticket succesvol bijgewerkt!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        TicketModel::deleteTicket($id);
        return redirect()->route('Tickets.index');
    }

    /**
     * Show the ticket purchase form (GET request)
     */
    public function showkopen($id)
    {
        $evenement = TicketModel::getEventById($id);
        $prijzen = TicketModel::getTicketsByEventId($id);
        return view('Tickets.kopen', compact('evenement', 'prijzen'));
    }

    /**
     * Process ticket purchase (POST request)
     */
    public function kopen(Request $request)
    {
        // Validate input including email
        $validated = $request->validate([
            'evenement_id' => 'required|exists:evenements,id',
            'aantal' => 'required|array',
            'email' => 'required|email',
            'naam' => 'nullable|string|max:255'
        ], [
            'email.required' => 'Een geldig e-mailadres is verplicht.',
            'email.email' => 'Voer een geldig e-mailadres in.'
        ]);

        try {
            // Use fixed bezoeker ID (bijvoorbeeld ID 1 voor "Gast")
            $guestBezoekerId = 1;

            // Process each ticket purchase
            $totalTickets = 0;
            $purchasedTickets = [];

            foreach ($validated['aantal'] as $prijsId => $aantal) {
                if ($aantal > 0) {
                    // Get prijs info to get the correct datum
                    $prijsInfo = \App\Models\PrijsModel::getPrijsById($prijsId);

                    if ($prijsInfo) {
                        \Illuminate\Support\Facades\DB::select('CALL SP_KopenTicket(?, ?, ?, ?, ?)', [
                            $guestBezoekerId,
                            $validated['evenement_id'],
                            $prijsId,
                            $aantal,
                            $prijsInfo->Datum
                        ]);
                        $totalTickets += $aantal;
                        $purchasedTickets[] = [
                            'aantal' => $aantal,
                            'prijs' => $prijsInfo->Tarief,
                            'tijdslot' => $prijsInfo->Tijdslot,
                            'datum' => $prijsInfo->Datum
                        ];
                    }
                }
            }

            if ($totalTickets === 0) {
                return back()->withErrors(['aantal' => 'Selecteer minimaal één ticket.'])
                    ->withInput();
            }

            // Try to send confirmation email
            $emailSent = $this->sendTicketConfirmationEmail(
                $validated['email'],
                $validated['naam'] ?? 'Klant',
                $validated['evenement_id'],
                $totalTickets,
                $purchasedTickets
            );

            if (!$emailSent) {
                // Email failed - show error and keep form data
                return back()
                    ->withErrors(['email' => 'De bevestigingsmail kon niet worden verzonden. Controleer of het e-mailadres correct is en probeer het opnieuw.'])
                    ->withInput();
            }

            // Success!
            return redirect()->route('Tickets.index')
                ->with('success', "Tickets succesvol gekocht! Bevestiging verzonden naar {$validated['email']}");

        } catch (\Exception $e) {
            Log::error('Ticket purchase error: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => 'Er is een fout opgetreden bij het kopen van tickets. Probeer het opnieuw.'])
                ->withInput();
        }
    }

    private function sendTicketConfirmationEmail($email, $naam, $evenementId, $totalTickets, $purchasedTickets)
    {
        try {
            // Validate email format more strictly
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Log::warning("Invalid email format: {$email}");
                return false;
            }

            // Check if email domain has valid MX records (optional but recommended)
            $domain = substr(strrchr($email, "@"), 1);
            if (!checkdnsrr($domain, 'MX')) {
                Log::warning("Email domain has no MX records: {$domain}");
                return false;
            }

            // Get event information
            $evenement = TicketModel::getEventById($evenementId);
            $evenementNaam = $evenement->Naam ?? 'Evenement';

            // Calculate total amount
            $totalBedrag = 0;
            foreach ($purchasedTickets as $ticket) {
                $totalBedrag += $ticket['prijs'] * $ticket['aantal'];
            }

            // Send the actual email
            try {
                Mail::to($email)->send(new TicketConfirmation(
                    $naam,
                    $evenementNaam,
                    $totalTickets,
                    $purchasedTickets,
                    $totalBedrag
                ));

                Log::info("Ticket confirmation email sent successfully to: {$email}", [
                    'naam' => $naam,
                    'evenement' => $evenementNaam,
                    'total_tickets' => $totalTickets,
                    'total_bedrag' => $totalBedrag
                ]);

                return true;
            } catch (\Exception $e) {
                Log::error("Failed to send email to {$email}: " . $e->getMessage());
                return false;
            }

        } catch (\Exception $e) {
            Log::error("Email validation/sending error: " . $e->getMessage());
            return false;
        }
    }
}
