@extends('templates.app_dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="{{ route('dashboard.payment.index') }}" class="btn btn-secondary">Go Back</a>
        </div>
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <h3 class="my-3">Data Trash : Payment </h3>
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
            ajax: "{{ route('dashboard.payment.trash.datatables') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'type_payment', name: 'type_payment' },
                { data: 'action', name: 'action', orderable: false, searchable: false, width: '390px' }
            ]
        });
    });
</script>
@endpush