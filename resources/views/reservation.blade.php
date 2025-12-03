@extends('templates.app')

@section('content')
    <style>
        .navbar {
            background: #004d73 !important;
        }
    </style>
    <div class="container card my-5 p-4 mt-5" style="margin-top:110px !important;">
        <div class="card-body">
            <h3 class="text-center mb-4">Reservation Summary</h3>
            <p><strong>Visit Date:</strong> {{ $visitDate ?? '-' }}</p>
            <hr>
            <h5 class="mb-3">Detail Ticket</h5>
            @foreach ($summary as $item)
                <div class="d-flex justify-content-between mb-3">
                    <div>
                        <strong>{{ $item['name'] }}</strong><br>
                        <small class="text-secondary">
                            Original Price: Rp{{ number_format($item['original_price'], 0, ',', '.') }}
                        </small><br>
                    </div>
                    <div class="text-end">
                        Qty: <strong>{{ $item['qty'] }}</strong><br>
                        Subtotal: <br>
                        <strong>Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</strong>
                    </div>
                </div>
                <hr>
            @endforeach
            <h4 class="text-end">Total: Rp{{ number_format($total, 0, ',', '.') }}</h4>
            <h4 id="promoTotal" class="text-end text-success mt-2"></h4>
            <div class="mt-4">
                <label class="fw-bold">Choose a Promo (Opsional)</label>
                <select name="promo_id" id="promo_id" class="form-select">
                    <option value="" selected>Choose Promo</option>
                    <!-- <option value="0" data-percent="0">No Promo</option> -->
                    @foreach ($promos as $promo)
                        <option value="{{ $promo->id }}" data-percent="{{ $promo->percent }}">
                            {{ $promo->name }} - {{ $promo->percent }}%
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mt-4">
                <label class="fw-bold">Choose Payment Method</label>
                <select name="payment_id" id="payment_id" class="form-select">
                    <option value="" selected disabled>Choose Payment Method</option>
                    @foreach ($payments as $payment)
                        <option value="{{ $payment->id }}">{{ $payment->type_payment }}</option>
                    @endforeach
                </select>
            </div>

            <form action="{{ route('payment') }}" method="GET" id="paymentForm" class="mt-4">
                <input type="hidden" id="final_total" name="final_total" value="{{ $total }}">
                <input type="hidden" id="final_promo_id" name="final_promo_id">
                <input type="hidden" id="selected_payment" name="payment_id">
                <input type="hidden" id="selected_promo" name="promo_id">

                <button type="submit" class="btn w-100 text-white fw-bold" style="background: #0b3b5c;">Pay Now</button>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        let originalTotal = {{ $total }};
        document.getElementById('promo_id').addEventListener('change', function () {
            let percent = parseInt(this.selectedOptions[0].dataset.percent || 0);
            let newTotal = originalTotal - (originalTotal * percent / 100);
            document.getElementById("promoTotal").innerHTML =
                `Total After Promo (${percent}%): <strong>Rp${newTotal.toLocaleString('id-ID')}</strong>`;
            document.getElementById('final_total').value = newTotal;
            document.getElementById('final_promo_id').value = this.value;
            document.getElementById('selected_promo').value = this.value;
        });
        document.getElementById('payment_id').addEventListener('change', function () {
            document.getElementById('selected_payment').value = this.value;
        });
        document.getElementById("paymentForm").addEventListener("submit", function (e) {

            // if (document.getElementById('selected_promo').value === "") {
            //     e.preventDefault();
            //     alert("Please select a promo (or choose No Promo).");
            //     return;
            // }


            if (!document.getElementById('selected_payment').value) {
                e.preventDefault();
                alert("Please select a payment method.");
                return;
            }
        });

    </script>
@endpush