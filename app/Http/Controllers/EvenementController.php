<?php

namespace App\Http\Controllers;

use App\Models\EvenementModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class EvenementController extends Controller
{
    /**
     * List paginated events with simple search.
     */
    public function index(Request $request)
    {
        $query = EvenementModel::query();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function($q) use ($search) {
                $q->where('Naam', 'like', "%{$search}%")
                  ->orWhere('Locatie', 'like', "%{$search}%");
            });
        }

        $events = $query->orderBy('Datum', 'desc')->paginate(10);

        return view('evenements.index', compact('events'));
    }

    /**
     * Show create form, also send existing date+location pairs for quick duplicate checks.
     */
    public function create()
    {
        $existingDateLocations = EvenementModel::query()
            ->get(['Datum', 'Locatie'])
            ->map(fn($e) => [
                'date' => \Illuminate\Support\Carbon::parse($e->Datum)->format('Y-m-d'),
                'location' => $e->Locatie,
            ])
            ->values()
            ->all();

        return view('evenements.create', compact('existingDateLocations'));
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        // 1) Field validation
        $data = $request->validate([
            'Naam' => ['required','string','max:255'],
            'Datum' => ['required','date','after_or_equal:today'],
            'Locatie' => ['required','string','max:255'],
            'AantalTicketsPerTijdslot' => ['required','integer','min:0','max:500000'],
            'BeschikbareStands'       => ['required','integer','min:0','max:500000'],
            'IsActief' => ['sometimes','boolean'],
            'Opmerking' => ['nullable','string','max:255'],
        ]);

        // 2) Composite unique: (Datum, Locatie)
        $request->validate([
            'Datum' => Rule::unique((new EvenementModel)->getTable(), 'Datum')
                ->where(fn (QueryBuilder $q) => $q->where('Locatie', $request->input('Locatie'))),
        ]);

        // Normalize checkbox
        $data['IsActief'] = $request->boolean('IsActief');

        $event = EvenementModel::create($data);

        // Backlog log
        $this->commitLog('EVENT CREATE', [
            'id' => $event->id,
            'after' => $event->getAttributes(),
        ]);

        // UI-commit bericht voor index toast
        $request->session()->flash('commit_msg', sprintf(
            'Event #%d aangemaakt: "%s" op %s (%s).',
            $event->id,
            $event->Naam ?? '-',
            $event->Locatie ?? '-',
            \Illuminate\Support\Carbon::parse($event->Datum ?? null)->format('Y-m-d')
        ));

        return redirect()->route('evenements.index')->with('ok', 'Evenement succesvol aangemaakt.');
    }

    /**
     * Show edit form.
     */
    public function edit(EvenementModel $evenement)
    {
        $existingDateLocations = EvenementModel::query()
            ->where('id', '!=', $evenement->id)
            ->get(['Datum', 'Locatie'])
            ->map(fn($e) => [
                'date' => \Illuminate\Support\Carbon::parse($e->Datum)->format('Y-m-d'),
                'location' => $e->Locatie,
            ])
            ->values()
            ->all();

        return view('evenements.edit', compact('evenement', 'existingDateLocations'));
    }

    /**
     * Update an event and write a git-like backlog message.
     */
    public function update(Request $request, EvenementModel $evenement)
    {
        // Capture original values before changes for a readable diff
        $before = $evenement->getOriginal();

        $data = $request->validate([
            'Naam' => ['required','string','max:255'],
            'Datum' => ['required','date','after_or_equal:today'],
            'Locatie' => ['required','string','max:255'],
            'AantalTicketsPerTijdslot' => ['required','integer','min:0','max:500000'],
            'BeschikbareStands'       => ['required','integer','min:0','max:500000'],
            'IsActief' => ['sometimes','boolean'],
            'Opmerking' => ['nullable','string','max:255'],
        ]);

        // Unique (Datum, Locatie) but ignore current row
        $request->validate([
            'Datum' => Rule::unique((new EvenementModel)->getTable(), 'Datum')
                ->where(fn (QueryBuilder $q) => $q->where('Locatie', $request->input('Locatie')))
                ->ignore($evenement->id, 'id'),
        ]);

        $data['IsActief'] = $request->boolean('IsActief');

        // Apply update
        $evenement->update($data);

        // Build a minimal diff of changed attributes (exclude timestamp noise)
        $changes = $evenement->getChanges();
        unset($changes[$evenement::UPDATED_AT]);

        $diff = [];
        foreach ($changes as $key => $newVal) {
            $diff[$key] = [
                'from' => $before[$key] ?? null,
                'to'   => $newVal,
            ];
        }

        // Backlog log
        $this->commitLog('EVENT UPDATE', [
            'id' => $evenement->id,
            'diff' => $diff,
            'after' => $evenement->getAttributes(),
        ]);

        // UI-commit bericht voor index toast (korte diff)
        $humanDiff = implode(', ', array_map(
            fn($k, $v) => $k.' ('.(string)($v['from'] ?? '').' → '.(string)($v['to'] ?? '').')',
            array_keys($diff),
            $diff
        ));

        $request->session()->flash('commit_msg', sprintf(
            'Event #%d bijgewerkt%s%s',
            $evenement->id,
            $humanDiff ? ': ' : '',
            $humanDiff
        ));

        return redirect()->route('evenements.index')->with('ok', 'Evenement succesvol bijgewerkt.');
    }

    /**
     * Show single event page.
     */
    public function show(EvenementModel $evenement)
    {
        return view('evenements.show', compact('evenement'));
    }

    /**
     * Delete an event and write a git-like backlog message.
     */
    public function destroy(EvenementModel $evenement)
    {
        try {
            if ($evenement->IsActief) {
                return back()->with('error', 'Actieve evenementen kunnen niet worden verwijderd. Zet het evenement eerst inactief.');
            }

            // Keep a snapshot before record is gone
            $snapshot = $evenement->getAttributes();

            $evenement->delete();

            // Backlog log
            $this->commitLog('EVENT DELETE', [
                'id' => $snapshot['id'] ?? null,
                'deleted_record' => $snapshot,
            ]);

            // UI-commit bericht voor index toast
            $msg = sprintf(
                'Event #%d verwijderd: "%s" op %s (%s).',
                $snapshot['id'] ?? 0,
                $snapshot['Naam'] ?? '-',
                $snapshot['Locatie'] ?? '-',
                isset($snapshot['Datum']) ? \Illuminate\Support\Carbon::parse($snapshot['Datum'])->format('Y-m-d') : '-'
            );
            session()->flash('commit_msg', $msg);

            return back()->with('ok', 'Evenement succesvol verwijderd.');
        } catch (\Throwable $e) {
            // Log failure with context for debugging
            $this->commitLog('EVENT DELETE FAILED', [
                'id' => $evenement->id,
                'error' => $e->getMessage(),
            ]);

            return back()->with('error', 'Kon het evenement niet verwijderen: '.$e->getMessage());
        }
    }

    /**
     * Small helper that writes a consistent, git-like log line with rich context.
     *
     * Examples in laravel.log:
     *   [EVENT UPDATE] id=42 actor=3 route=evenements.update ... diff={...}
     */
    protected function commitLog(string $action, array $payload = []): void
    {
        $user = Auth::user();
        $req  = request();

        // Correlation id makes it easy to group related log lines
        $correlationId = $req->headers->get('X-Request-Id') ?: Str::uuid()->toString();

        Log::info("[$action]", array_merge($payload, [
            'actor_id'     => $user?->id,
            'actor_name'   => $user?->name,
            'ip'           => $req->ip(),
            'user_agent'   => $req->userAgent(),
            'route'        => optional($req->route())->getName(),
            'url'          => $req->fullUrl(),
            'request_id'   => $correlationId,
        ]));
    }
}
