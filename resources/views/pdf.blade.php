<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proof of Ticket Purchase</title>
    <style>
        .wrapper {
            width: 300px;
            margin: 20px auto;
            border: 1px solid #eaeaea;
            border-radius: 6px;
            padding: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h3 style="text-align:center;">Proof of Ticket Purchase</h3>
        <p style="margin:4px 0;"><strong>Invoice:</strong> {{ $transaction['no'] }}</p>
        <p style="margin:4px 0;"><strong>User:</strong>
            @if (!empty($transaction['user']))
                {{ $transaction['user']['name'] }}
            @else
                -
            @endif
        </p>
        <p style="margin:4px 0;"><strong>Payment Method:</strong>
            @if (!empty($transaction['payment']))
                {{ $transaction['payment']['type_payment'] }}
            @else
                -
            @endif
        </p>
        <hr style="margin:14px 0;">
        <h4 style="margin:0 0 10px 0; font-size:16px;">Ticket Details</h4>
        @foreach ($transaction['details'] as $d)
            <div style="margin-bottom:10px;">
                <strong>{{ $d['ticket']['name'] }}</strong><br>
                <small><strong>Date:</strong> {{ $d['date'] }}</small><br>
                <small><strong>Qty:</strong> {{ $d['qty'] }}</small>
            </div>
        @endforeach
        <hr style="margin:14px 0;">
        <p style="margin:4px 0;"><strong>Promo:</strong>
            @if (!empty($transaction['promo']) && isset($transaction['promo']['type_promo']))
                {{ $transaction['promo']['type_promo'] }} {{ $transaction['promo']['percent'] ?? '' }}%
            @else
                -
            @endif
        </p>
        <p style="margin:4px 0;"><strong>Total: </strong>Rp{{ number_format(($transaction['total'] ?? 0), 0, ',', '.') }}</p>
        <p style="margin:4px 0;"><strong>Final Payment: </strong>Rp{{ number_format(($transaction['sub_total'] ?? 0), 0, ',', '.') }}</p>
    </div>
</body>
</html>
