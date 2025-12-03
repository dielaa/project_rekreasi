@extends('templates.app_dashboard')

@section('content')
<div class="container mt-5">
    @if (Session::get('failed'))
        <div class="alert alert-danger">{{ Session::get('failed') }}</div>
    @endif
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('dashboard.payment.export') }}" class="btn btn-warning me-2">Export Data</a>
        <a href="{{ route('dashboard.payment.trash') }}" class="btn btn-danger me-2">Data Sampah</a>
        <a href="{{ route('dashboard.payment.create') }}" class="btn btn-success">Add Type Payment</a>
    </div>
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif
    <table class="table table-responsive table-bordered mt-3" id="paymentTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#paymentTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.payment.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'type_payment', name: 'type_payment' },
                { data: 'action', name: 'action', orderable: false, searchable: false, width: '180px' }
            ]
        });
    });
</script>
@endpush