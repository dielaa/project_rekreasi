@extends('templates.app')

@section('content')
    <div id="intro-example" class="p-5 text-center bg-image"
        style=" height: 60vh ; background-image: url('https://i.pinimg.com/736x/9d/8d/44/9d8d44ba566ccc795a13668a846581f2.jpg');">
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.7);">
            <div class="d-flex justify-content-left align-items-center h-100">
                <div class="text-white text-start ms-5" style="padding-top: 150px; max-width: 600px;">
                    <h1 class="mb-3">Ready to explore the deep blue?</h1>
                    <p>Get your Seaworld tickets and jump into an underwater adventure full of amazing sea life, thrilling
                        attractions, and fun for everyone!
                        Don't wait book your tickets now and make a splash at Seaworld!</p>
                    <h5 class="mb-4"></h5>
                </div>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div aria-label="breadcrumb">
            <h2 class="fw-bold">Ticket</h2>
            <p class="text-secondary mb-4">Book Your Tickets Today!</p>
        </div>
        <div class="row mt-3">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <label for="exampleFormControlInput1" class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" id="inputDate">
                    </div>
                </div>
                @foreach ($ticket as $data)
                    <div class="mt-2">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-md-2">
                                    <img style="width: 100%;height: 80px;" src="{{ asset('storage/' . $data->thumbnail) }}"
                                        alt="Thumbnail">
                                </div>
                                <div class="col-md-10">
                                    <h5 class="card-title">{{$data->name}}</h5>
                                    <p class="card-text">{{$data->description}}</p>
                                    @php
                                        $originalPrice = $data->price;
                                        $discount = $data->promo ? ($originalPrice * $data->promo->percent / 100) : 0;
                                        $finalPrice = $data->price;
                                    @endphp

                                    <h5>
                                        Rp{{ number_format($finalPrice, 0, ',', '.') }}

                                    </h5>
                                    @php
                                        $cart = session('cart', []);
                                        $inCart = isset($cart[$data->id]);
                                    @endphp
                                    @if ($inCart)
                                        <div class="d-flex align-items-center">
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                <input type="hidden" name="qty" value="{{ $cart[$data->id]['qty'] - 1 }}">
                                                <button class="btn btn-outline-secondary btn-sm" @if ($cart[$data->id]['qty'] <= 1)
                                                disabled @endif>-</button>
                                            </form>
                                            <span class="mx-2">{{ $cart[$data->id]['qty'] }}</span>
                                            <form action="{{ route('cart.update') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                <input type="hidden" name="qty" value="{{ $cart[$data->id]['qty'] + 1 }}">
                                                <button class="btn btn-outline-secondary btn-sm">+</button>
                                            </form>
                                        </div>
                                    @else
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="ticket_id" value="{{ $data->id }}">
                                            <button class="btn btn-primary" type="submit">Add</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h3>Shopping Cart</h3>
                        <hr>
                        @php
                            $visitDate = session('visit_date');
                            $cart = session('cart', []); //disimpen ke session, bukan ke db
                        @endphp
                        @if ($visitDate)
                            <p style="color: #4da04dff;"><strong>Date: {{ date('d M Y', strtotime($visitDate)) }}</strong></p>
                        @endif
                        @if (count($cart) == 0)
                            <p class="text-muted">Cart is empty</p>
                        @else
                            @foreach ($cart as $id => $item)
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <strong>{{ $item['name'] }}</strong><br>Rp{{ number_format($item['price'], 0, ',', '.') }}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <input type="hidden" name="qty" value="{{ $item['qty'] - 1 }}">
                                            <button class="btn btn-outline-secondary btn-sm" @if ($item['qty'] <= 1) disabled
                                            @endif>-</button>
                                        </form>
                                        <span class="mx-2">{{ $item['qty'] }}</span>
                                        <form action="{{ route('cart.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                            <button class="btn btn-outline-secondary btn-sm">+</button>
                                        </form>
                                        <form action="{{ route('cart.remove') }}" method="POST" class="ms-2">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $id }}">
                                            <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                            <hr>
                            @php
                                $total = array_sum(array_map(fn($i) => $i['price'] * $i['qty'], $cart));
                            @endphp
                            <h5>Total: Rp{{ number_format($total, 0, ',', '.') }}</h5>
                            <!-- <div style="color: black; font-weight: bold; cursor:pointer;" class="w-100 text-center" id="btnOrder">RINGKASAN PEMESANAN</div> -->
                            <a href="{{ auth()->check() ? route('reservation.summary') : route('login') }}"
                                class="btn btn-success w-100">Reservation Summary</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('inputDate').addEventListener('change', function () {
            const selectedDate = this.value;

            if (selectedDate) {
                window.location.href = `{{ route('ticket') }}?date=${selectedDate}`;
            }
        });
    </script>
@endpush