@extends('layout.main')
@section('title', 'Inspection & Acceptance Report')
@section('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    {{-- <link href="{{asset('includes/bootstrap-5.1.3/css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    <style>
        .modal-lg{
            max-width: 80%;
        }
        .minmax{
            cursor: pointer;
        }
        .minmax:hover{
            color: black;
        }
        #item-thumbnail {
            cursor: pointer;
        }
        #change-title-trigger {
            cursor: pointer;
            color: #C0C0C0;
        }
        #change-title-trigger:hover {
            color: #67B4E9;
        }
    </style>
@endsection
@section('page')
<h3>Inspection & Acceptance Report Information</h3>
{{-- <a href="{{ route('logisticsofficer.iar.index') }}" class="font-weight-normal link-light"><i class="far fa-arrow-alt-circle-left"></i> Back to IAR List</a> --}}
    <div class="row mt-3">
        <div class="col-xs-12 col-md-3 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    IAR Details
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="" class="fw-bold">IAR Number</label>
                        <div>{{ $iar->iar_number }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="fw-bold">Date of Delivery</label>
                        {{-- <div>{{ \Carbon\Carbon::parse($iar->date_of_delivery)->format('F')  }}</div> --}}
                        <div>{{ \Carbon\Carbon::parse($iar->date_of_delivery)->format('F j, Y')  }}</div>
                    </div>
                    <div class="mb-3">
                        <label for="" class="fw-bold">Recorded By</label>
                        <div>{{$iar->logistics_officer}}</div>
                    </div>
                    @if (!empty ($iar->ptr_number))
                        <div class="mb-3">
                            <label for="" class="fw-bold">PTR #:</label>
                            <div>{{ $iar->ptr_number }}</div>
                        </div>
                    @endif
                    @if (!empty($iar->po_number))
                        <div class="mb-3">
                            <label for="" class="fw-bold">Purchase Order #:</label>
                            <div>{{ $iar->po_number }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-9 col-lg-9 border-left">
            <div class="card shadow-sm">
                <div class="card-header fw-bold">
                    IAR Items
                </div>
                <div class="card-body">
                    <button class="btn btn-primary mb-3" id="iar-item-trigger" data-id="{{ $iar->id }}"><i class="fas fa-plus"></i> Add IAR Item</button>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Item Title</th>
                                <th>Office/Section</th>
                                <th>Current Qty</th>
                                <th>Issued Qty</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                                @foreach ($iar->iarItem as $row)

                                    <tr>
                                        <td>{{ $row->item->title }}</td>
                                        <td>{{ $row->office->short_name }}</td>
                                        <td>{{ $row->current_qty }}</td>
                                        <td>
                                            @if ($row->issued_qty)
                                            {{ $row->issued_qty }}
                                            @else
                                            0
                                            @endif
                                        </td>
                                        <td>₱{{ $row->price }}</td>
                                        <td>{{ $row->status }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="mx-2" id="update-iar-item" data-id="{{ $row->id }}" data-toggle="tooltip" data-placement="left" title="View IAR" style="cursor: pointer"><i class="fas fa-eye"></i></a>
                                                @if (in_array('destroy',$permissions['iar']))
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
                </div>
            </div>
        </div>
    </div>

    @include('logisticsofficer.iar.modal.add-iar-item')
    @include('logisticsofficer.iar.modal.update-iar-item')

@endsection
@section('scripts')
    <script src="{{ asset('includes/js/logisticsofficer/iar.js') }}"></script>
    <script src="{{ asset('includes/js/logisticsofficer/interface/iar.js') }}"></script>
    <script src="{{ asset('includes/js/interface/utilities.js') }}"></script>
    <script src="{{ asset('includes/js/jquery.nice-number.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('includes/sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('includes/bootstrap-5.1.3/js/bootstrap.js') }}"></script>


    <!-- Page level custom scripts -->
    <script src="{{ asset('includes/sbadmin/js/demo/datatables-demo.js') }}"></script>

    <script src="{{ asset('includes/js/swal.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(document).ready(function () {
            addIarItem();
            updateIarItem();
        });

    </script>
    

@endsection
