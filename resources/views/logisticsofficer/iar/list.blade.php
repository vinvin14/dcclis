@extends('layout.main')
@section('title', 'Inspection & Acceptance Report')
@section('styles')
    <!-- Custom styles for this page -->
    {{-- <link href="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('themes/sbadminb5/css/datatables.css') }}"> --}}
@endsection
@section('page')
<h4 class="mb-3">Inspection and Acceptance Report(s)</h4>
    <div class="card">
        <div class="card-body px-4">
            {{-- <p class="text-muted font-italic">In this page you will be able to manage all IAR filed by different offices</p> --}}
            {{-- <button type="button" class="btn btn-primary">Primary</button> --}}
            <a href="{{ route('logisticsofficer.iar.create') }}" class="btn btn-primary shadow-sm"><i class="fas fa-plus"></i> New IAR</a>
            @include('interface.prompt.system-message')
            <div class="card my-3">
                <div class="card-header fw-bold">
                    IAR List
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table">
                        <thead>
                            <tr>
                                <th>IAR #</th>
                                <th>Source</th>
                                <th>Date Recorded</th>
                                <th>Recorded By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </tfoot>
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
                                            <a href="{{ route('logisticsofficer.iar.show', $row->id) }}" class="mx-2" data-toggle="tooltip" data-placement="left" title="View IAR"><i class="fas fa-eye"></i></a>
                                            @if (in_array('destroy', unserialize(Cookie::get('permissions'))['iar']))
                                            <form action="{{ route('logisticsofficer.iar.destroy', $row->id) }}" method="post">
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
                {{-- <div class="card-body">
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
                                                <a href="{{ route('logisticsofficer.iar.show', $row->id) }}" class="mx-2" data-toggle="tooltip" data-placement="left" title="View IAR"><i class="fas fa-eye"></i></a>
                                                @if (in_array('destroy', unserialize(Cookie::get('permissions'))['iar']))
                                                <form action="{{ route('logisticsofficer.iar.destroy', $row->id) }}" method="post">
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
                </div> --}}
            </div>
        </div>
    </div>
@endsection
{{-- @section('scripts')
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

@endsection --}}
