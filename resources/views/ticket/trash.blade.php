@extends('templates.app_dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('dashboard.ticket.index') }}" class="btn btn-secondary">Go Back</a>
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
            ajax: "{{ route('dashboard.ticket.trash.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name', width: '200px' },
                { data: 'thumbnail', name: 'thumbnail', width: '200px' },
                { data: 'price', name: 'price' },
                { data: 'promo_name', name: 'promo.name' },
                { data: 'description', name: 'description' },
                { data: 'start_date', name: 'start_date',width: '150px' },
                { data: 'end_date', name: 'end_date' ,width: '150px'},
                { data: 'action', name: 'action', orderable: false, searchable: false, width: '300px' }
            ]
        });
    });
</script>
@endpush