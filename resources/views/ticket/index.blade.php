@extends('templates.app_dashboard')

@section('content')
<div class="container mt-5">
    @if (Session::get('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('dashboard.ticket.export') }}" class="btn btn-warning me-2">Export Data</a>
        <a href="{{ route('dashboard.ticket.trash') }}" class="btn btn-danger me-2">Data Sampah</a>
        <a href="{{ route('dashboard.ticket.create') }}" class="btn btn-success">Add Ticket</a>
    </div>
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <table class="table table-responsive table-bordered mt-3" id="ticketTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Thumbnail</th>
                <th>Price</th>
                <th>Promo</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Option</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#ticketTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.ticket.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name', width: '200px' },
                { data: 'thumbnail', name: 'thumbnail', width: '200px' },
                { data: 'price', name: 'price' },
                { data: 'promo_name', name: 'promo.name' },
                { data: 'description', name: 'description' },
                { data: 'start_date', name: 'start_date',width: '150px' },
                { data: 'end_date', name: 'end_date' ,width: '150px'},
                { data: 'action', name: 'action', orderable: false, searchable: false, width: '180px' }
            ]
        });
    });
</script>
@endpush