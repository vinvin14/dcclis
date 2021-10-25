@extends('interface.main')
@section('title', 'RIS')
@section('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page')
    
    <h2 >Requests & Issuances</h2>
    <p class="text-muted font-italic">In this page you will be able to manage all RIS filed by your office</p>

    <a href="{{ route('ris.create') }}" onclick="return confirm('Are you sure you want to create this request?')" class="btn btn-info shadow-sm"><i class="fas fa-plus"></i> Create new RIS</a>
    @include('interface.prompt.system-message')
    <div class="card shadow-sm my-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>RIS #</th>
                        <th>Date Submitted</th>
                        <th>Total Items</th>
                        <th>Request Status</th>
                        <th>Issuance Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($ris as $row)
                            <tr>
                                <td>{{ $row->ris_number }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->total_items }}</td>
                                <td>{{ $row->status }}</td>
                                <td>{{ $row->issuance_status }}</td>
                                <td>
                                    <a href="{{ route('ris.show', $row->id) }}" class="mx-2" data-toggle="tooltip" data-placement="left" title="View RIS"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('ris.destroy', $row->id) }}" class="mx-2 text-danger" data-toggle="tooltip" data-placement="left" title="Delete this RIS" onclick="return confirm('Are you sure you want to delete this record?')"><i class="far fa-trash-alt"></i></a>
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
    <!-- Page level plugins -->
    <script src="{{ asset('includes/sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('includes/sbadmin/js/demo/datatables-demo.js') }}"></script>

@endsection