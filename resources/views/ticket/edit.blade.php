@extends('templates.app_dashboard')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h5 class="text-center mb-3">Add Ticket Data</h5>
        <form method="POST" action="{{ route('dashboard.ticket.update', ['id' => $data->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    value="{{ $data->name }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="thumbnail" class="form-label">Thumbnail</label>
                <input name="thumbnail" type="file" class="form-control @error('thumbnail') is-invalid @enderror">
                @error('thumbnail')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input name="price" type="text" class="form-control @error('price') is-invalid @enderror"
                    value="{{ $data->price }}">
                @error('price')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" type="text" class="form-control @error('description') is-invalid @enderror"
                    rows="5">{{ $data->description }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="promo" class="form-label">Promo</label>
                <select name="promo_id" class="form-select">
                    <option value="">Choose One</option>
                    @foreach ($promos as $p)
                        <option value="{{ $p->id }}" {{ $data->promo_id == $p->id ? "selected" : "" }}>{{ $p->name }}</option>
                    @endforeach
                </select>
                @error('promo')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" name="start_date" id="start_date"
                    class="form-control @error('start_date') is-invalid @enderror" value="{{ $data->start_date }}">
                @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" name="end_date" id="end_date" rows="5"
                    class="form-control @error('end_date') is-invalid @enderror" value="{{ $data->end_date }}">
                @error('end_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit Data</button>
            <a href="{{ route('dashboard.ticket.index') }}" class="btn btn-secondary">Cancel</a>

        </form>
    </div>
@endsection