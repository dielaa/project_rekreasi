@extends('templates.app_dashboard')

@section('content')
    <div class="w-75 d-block mx-auto mt-3 p-4">
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
        <h5 class="text-center mb-3">Add Facility Data</h5>
        <form method="POST" action="{{ route('dashboard.facility.store') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text"  name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}">
                @error('location')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" rows="5"
                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="text" name="capacity" id="capacity" 
                    class="form-control @error('capacity') is-invalid @enderror" value="{{ old('capacity') }}">
                @error('capacity')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="operational_hours" class="form-label">Operational</label>
                <input type="text" name="operational_hours" id="operational_hours" class="form-control @error('operational_hours') is-invalid @enderror" value="{{ old('operational_hours') }}">
                @error('operational_hours')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-select @error('status') is-invalid @enderror">
                    <option value="Active">Active</option>
                    <option value="Non-active">Non-Active</option>
                </select>
                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Submit Data</button>
        </form>
    </div>
@endsection