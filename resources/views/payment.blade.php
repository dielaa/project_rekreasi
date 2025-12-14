@extends('templates.app')

@section('content')
    <style>
        .navbar {
            background: #004d73 !important;
        }
    </style>
    <div class="container card my-5 p-4 mt-5" style="margin-top:110px !important;">
        <div class="card-body">
            <h3 class="text-center mb-3">Complete Your Payment</h3>
            <p><strong>No Inv :</strong> {{ $invoice }}</p>
            <p><strong>Date :</strong> {{ $date }}</p>
            <p><strong>Amount :</strong> Rp{{ number_format($amount, 0, ',', '.') }}</p>
            @if ($paymentMethod === 'QRIS')
                <hr>
                <h4 class="text-center">Scan QRIS to Pay</h4>
                <div class="text-center my-3">{!! $qrisSvg !!}</div>
                <p class="text-center text-muted">QR scan using OVO, Dana, Gopay, ShopeePay, etc.</p>
            @else
                <p><strong>Virtual Account :</strong> {{ $virtual }}</p>
            @endif
            <hr>
            <form action="{{ route('finish.payment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="invoice" value="{{ $invoice }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <input type="hidden" name="promo_id" value="{{ $promoId }}">
                <input type="hidden" name="promo_value" value="{{ $promoValue }}">
                <input type="hidden" name="payment_method" value="{{ $paymentId }}">
                <input type="hidden" name="virtual" value="{{ $virtual }}">

                <input type="hidden" name="total" value="{{ $amount }}">
                <input type="hidden" name="sub_total" value="{{ $amount }}">
                <label class="fw-bold">Upload Payment Evidence</label>
                <input type="file" class="form-control mb-3" name="payment_proof" required>
                <button class="btn w-100 text-white fw-bold" style="background:#0b3b5c;">
                    Finished Pay
                </button>
            </form>
        </div>
    </div>
@endsection