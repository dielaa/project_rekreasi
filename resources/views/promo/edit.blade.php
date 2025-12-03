@extends('templates.app_dashboard')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h5 class="text-center mb-3">Add Promo Data</h5>
        <form method="POST" action="{{ route('dashboard.promo.update',['id'=>$promos->id]) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $promos->name }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="5"
                    class="form-control @error('description') is-invalid @enderror">{{ $promos->description }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="percent" class="form-label">Percent</label>
                <input type="number" name="percent" id="percent" 
                    class="form-control @error('percent') is-invalid @enderror" value="{{ $promos->percent }}" max="100" min="1">
                @error('percent')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date" 
                    class="form-control @error('start_date') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($promos->start_date)->format('Y-m-d') }}">
                @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" rows="5"
                    class="form-control @error('end_date') is-invalid @enderror" value="{{ \Carbon\Carbon::parse($promos->end_date)->format('Y-m-d') }}">
                @error('end_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit Data</button>
        </form>
    </div>
@endsection