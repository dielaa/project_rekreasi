@extends('templates.app_dashboard')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h5 class="text-center mb-3">Add Payment Data</h5>
        <form method="POST" action="{{ route('dashboard.payment.store') }}">
            @csrf
            <div class="mb-3">
                <label for="type_payment" class="form-label">Type Payment</label>
                <input name="type_payment" type="text" class="form-control @error('type_payment') is-invalid @enderror" value="{{ old('type_payment') }}">
                @error('type_payment')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit Data</button>
        </form>
    </div>
@endsection