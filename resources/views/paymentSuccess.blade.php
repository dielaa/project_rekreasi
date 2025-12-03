@extends('templates.app')

@section('content')
    <style>
        .navbar {
            background: #004d73 !important;
        }
    </style>
    <div class="container d-flex justify-content-center" style="margin-top:110px !important;">
        <div class="card col-md-6 p-3">
            <div class="card-body">
                <h4 class="text-center mb-3">Payment Receipt</h4>
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ route('export_pdf', $transaction->no) }}" class="btn btn-secondary btn-sm px-4 py-2"
                        style="font-size: 14px; border-radius: 6px;">
                        Download (.pdf)
                    </a>
                </div>
                <div>
                    <p class="mb-1"><strong>Invoice:</strong> {{ $transaction->no }}</p>
                    <p class="mb-1"><strong>User:</strong> {{ $transaction->user ? $transaction->user->name : '-' }}</p>
                    <p class="mb-1"><strong>Payment Method:</strong>
                        {{ $transaction->payment ? $transaction->payment->type_payment : '-' }}</p>
                    <hr>
                    <h6 class="mt-2">Ticket Details</h6>
                    @foreach ($transaction->details as $d)
                        <strong>{{ $d->ticket->name }}</strong><br>
                        <small><strong>Date:</strong> {{ $d->date }}</small><br>
                        <small><strong>Qty:</strong> {{ $d->qty }}</small>
                    @endforeach
                    <hr>
                    <p class="mb-1"><strong>Promo:</strong>
                        @php
                            $promoModel = $transaction->promo_id ? $transaction->promo()->first() : null;
                        @endphp

                        @if ($promoModel)
                            {{ $promoModel->type_promo }} {{ $promoModel->percent }}%
                        @else
                            -
                        @endif
                    </p>
                    <p class="mb-1"><strong>Total:</strong> Rp{{ number_format($transaction->total, 0, ',', '.') }}</p>
                    <p class="mb-1"><strong>Final Payment:</strong> Rp{{ number_format($transaction->sub_total, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

@endsection