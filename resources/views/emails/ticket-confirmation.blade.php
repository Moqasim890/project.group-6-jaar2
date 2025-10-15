<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticketbevestiging</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .email-header p {
            margin: 10px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }
        .email-body {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            margin: 0 0 10px 0;
            color: #667eea;
            font-size: 16px;
        }
        .ticket-list {
            list-style: none;
            padding: 0;
            margin: 15px 0;
        }
        .ticket-item {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ticket-details {
            flex: 1;
        }
        .ticket-details strong {
            color: #333;
            font-size: 16px;
            display: block;
            margin-bottom: 5px;
        }
        .ticket-details span {
            color: #666;
            font-size: 14px;
        }
        .ticket-price {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
        }
        .total-section {
            background-color: #667eea;
            color: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 6px;
            text-align: center;
        }
        .total-section h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            font-weight: normal;
            opacity: 0.9;
        }
        .total-amount {
            font-size: 32px;
            font-weight: bold;
            margin: 0;
        }
        .footer-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            font-size: 14px;
            color: #856404;
        }
        .email-footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #e0e0e0;
        }
        .email-footer p {
            margin: 5px 0;
        }
        .check-icon {
            display: inline-block;
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            line-height: 60px;
            font-size: 30px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="check-icon">✓</div>
            <h1>Ticketaankoop Geslaagd!</h1>
            <p>Bedankt voor je bestelling</p>
        </div>

        <div class="email-body">
            <p class="greeting">Beste {{ $naam }},</p>

            <p>Je tickets voor <strong>{{ $evenementNaam }}</strong> zijn succesvol aangeschaft!</p>

            <div class="info-box">
                <h3>📋 Overzicht van je tickets</h3>
                <p><strong>Totaal aantal tickets:</strong> {{ $totalTickets }}</p>
            </div>

            <ul class="ticket-list">
                @foreach($purchasedTickets as $ticket)
                <li class="ticket-item">
                    <div class="ticket-details">
                        <strong>{{ $ticket['aantal'] }}x {{ $ticket['tijdslot'] ?? 'Ticket' }}</strong>
                        <span>📅 Datum: {{ \Carbon\Carbon::parse($ticket['datum'])->format('d-m-Y') }}</span>
                    </div>
                    <div class="ticket-price">
                        €{{ number_format($ticket['prijs'] * $ticket['aantal'], 2, ',', '.') }}
                    </div>
                </li>
                @endforeach
            </ul>

            <div class="total-section">
                <h3>Totaalbedrag</h3>
                <p class="total-amount">€{{ number_format($totalBedrag, 2, ',', '.') }}</p>
            </div>

            <div class="footer-note">
                <strong>⚠️ Belangrijk:</strong><br>
                Bewaar deze e-mail goed. Je hebt deze nodig bij de ingang van het evenement.<br>
                Toon deze bevestiging (digitaal of geprint) aan de kassa voor toegang.
            </div>

            <p>Heb je vragen over je bestelling? Neem dan contact met ons op.</p>

            <p style="margin-top: 30px;">
                Met vriendelijke groet,<br>
                <strong>Het Evenementen Team</strong>
            </p>
        </div>

        <div class="email-footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>Dit is een automatisch gegenereerde e-mail. Je hoeft hier niet op te antwoorden.</p>
            <p>&copy; {{ date('Y') }} Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>
</html>
