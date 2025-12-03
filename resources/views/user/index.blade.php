@extends('templates.app_dashboard')

@section('content')
    <div class="container mt-5">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        <div class="d-flex justify-content-end mt-3">
            <a href="{{ route('dashboard.export') }}" class="btn btn-warning me-2">Export Data</a>
            <a href="{{ route('dashboard.trash') }}" class="btn btn-danger me-2">Data Sampah</a>
            <a href="{{ route('dashboard.user.create') }}" class="btn btn-success">Add User</a>
        </div>
        <table class="table table-responsive table-bordered mt-3" id="userTable">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Option</th>
            </thead>
        </table>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dashboard.user.datatables') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush