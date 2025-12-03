@extends('templates.app_dashboard')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end mt-3 gap-3">
            <a href="{{ route('dashboard.user.index') }}" class="btn btn-success">Go Back</a>
        </div>
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
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
                ajax: "{{ route('dashboard.trash.datatables') }}",
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