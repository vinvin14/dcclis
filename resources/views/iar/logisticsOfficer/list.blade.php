@extends('interface.main')
@section('title', 'Inspection & Acceptance Report')
@section('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page')
    <h2 >Inspection and Acceptance Report(s)</h2>
    <p class="text-muted font-italic">In this page you will be able to manage all IAR filed by different offices</p>

    <a href="{{ route('iar.logisticsOfficer.create') }}" class="btn btn-info shadow-sm"><i class="fas fa-plus"></i> Create new IAR</a>
    @include('interface.prompt.system-message')
    <div class="card shadow-sm my-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>IAR #</th>
                        <th>Source</th>
                        <th>Date Recorded</th>
                        <th>Recorded By</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($iar as $row)
                            <tr>
                                <td>{{ $row->iar_number }}</td>
                                <td>
                                    @if(!empty($row->ptr_number))
                                        PTR #:.{{ $row->ptr_number }}
                                    @else
                                        PR #:
                                    @endempty
                                </td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->logistics_officer }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('iar.logisticsOfficer.show', $row->id) }}" class="mx-2" data-toggle="tooltip" data-placement="left" title="View IAR"><i class="fas fa-eye"></i></a>
                                        @if (in_array('destroy', unserialize(Cookie::get('permissions'))['iar']))
                                        <form action="{{ route('iar.logisticsOfficer.destroy', $row->id) }}" method="post">
                                            @method('delete')
                                            <button type="submit" style="border: none;background-color:transparent" class="mx-2 text-danger" data-toggle="tooltip" data-placement="left" title="Delete this IAR" onclick="return confirm('Are you sure you want to delete this record?')"><i class="far fa-trash-alt"></i></button>
                                        </form>
                                        @endif
                                    </div>
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
