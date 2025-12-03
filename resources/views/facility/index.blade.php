@extends('templates.app_dashboard')

@section('content')
<div class="container mt-5">
    @if (Session::get('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('dashboard.facility.export') }}" class="btn btn-warning me-2">Export Data</a>
        <a href="{{ route('dashboard.facility.trash') }}" class="btn btn-danger me-2">Data Sampah</a>
        <a href="{{ route('dashboard.facility.create') }}" class="btn btn-success">Add Facility</a>
    </div>
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <table class="table table-responsive table-bordered mt-3" id="facilityTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Location</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>Operational</th>
                <th>Status</th>
                <th>Option</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#facilityTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.facility.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'location', name: 'location' },
                { data: 'description', name: 'description' },
                { data: 'capacity', name: 'capacity' },
                { data: 'operational_hours', name: 'operational_hours' },
                { data: 'status', name: 'status', width: '100px' },
                { data: 'action', name: 'action', orderable: false, searchable: false, width: '180px' }
            ]
        });
    });
</script>
@endpush

