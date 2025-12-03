@extends('templates.app_dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="{{ route('dashboard.facility.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
        @if (Session::get('success'))
            <div class="alert alert-success mt-3">{{ Session::get('success') }}</div>
        @endif
        <h3 class="my-3">Data Trash : Facility </h3>
        <table class="table table-responsive table-bordered mt-3" id="facilityTable">
            <thead class="text-center">
                <th>#</th>
                <th>Name</th>
                <th>Location</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>Operational</th>
                <th>Status</th>
                <th>Option</th>
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
            ajax: "{{ route('dashboard.facility.trash.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'location', name: 'location' },
                { data: 'description', name: 'description'},
                { data: 'capacity', name: 'capacity' },
                { data: 'operational_hours', name: 'operational_hours',width: '120px' },
                { data: 'status', name: 'status', width: '100px' },
                { data: 'action', name: 'action', orderable: false, searchable: false, width: '390px' }
            ]
        });
    });
</script>
@endpush

