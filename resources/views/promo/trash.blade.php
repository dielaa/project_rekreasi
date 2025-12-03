@extends('templates.app_dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="{{ route('dashboard.promo.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <table class="table table-responsive table-bordered mt-3" id="promoTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Percent</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Option</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#promoTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.promo.trash.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'description', name: 'description' },
                { data: 'percent', name: 'percent' },
                { data: 'start_date', name: 'start_date',width: '100px' },
                { data: 'end_date', name: 'end_date',width: '100px' },
                { data: 'action', name: 'action', orderable: false, searchable: false, width: '300px' }
            ]
        });
    });
</script>
@endpush