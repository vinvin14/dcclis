@extends('interface.main')
@section('title', $ris->ris_number)
@section('styles')
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
    </style>
    <link href="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page')

    <h2 class="mb-4">Current RIS</h2>

    
    <a href="{{ route('ris.list') }}" class="font-weight-normal link-light"><i class="fas fa-angle-double-left"></i> Back to RIS List</a>
    <div class="card shadow-sm my-2">
        <div class="card-body">
            <div class="border-bottom font-weight-bold d-flex">
                <div class="flex-grow-1">Information</div>
                <span class="pb-2 minmax" id="minimize-ris" data-status="max"><i class="fas fa-minus"></i></span>
            </div>
            @include('interface.prompt.system-message')
            <div id="ris-container">
                <div class="row my-3">
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <label for="">RIS Number</label>
                        <div class="font-weight-bold">{{ $ris->ris_number }}</div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <label for="">Requesting Office</label>
                        <div class="font-weight-bold">{{ $ris->office_name }}</div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <label for="">Date Submitted</label>
                        <div class="font-weight-bold">{{ $ris->created_at }}</div>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <label for="">Request Status</label>
                        <div class="font-weight-bold">{{ $ris->status }}</div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <label for="">Approved By</label>
                        <div class="font-weight-bold">{{ $ris->approved_by }}</div>
                    </div>
                    <div class="col-xs-12 col-md-4 col-lg-4">
                        <label for="">Issuance Status</label>
                        <div class="font-weight-bold">{{ $ris->issuance_status }}</div>
                    </div>
                </div>
                <div class="form-group my-3">
                    <label for="">Reason for Status</label>
                    <textarea name="" id="" class="form-control" cols="30" rows="3" readonly>{{ $ris->reason_for_status }}</textarea>
                </div>
                @if (Cookie::get('role') == 'Logistics Officer')
                <button class="btn btn-info my-1 btn-block" id="ris-update-trigger" data-id="{{ $ris->id }}">Update Information</button>
                @endif
            </div>
        </div>  
    </div>
    <hr>
    <div class="card shadow-sm my-3">
        <div class="card-body">
            <div class="border-bottom font-weight-bold d-flex">
                <div class="flex-grow-1">Requested Item(s)</div>
                <span class="pb-2 minmax" id="minimize-ris-items" data-status="max"><i class="fas fa-minus"></i></span>
            </div>
            <div id="ris-items-container">
                <button class="btn btn-info shadow-sm my-2" id="add-item-trigger"><i class="fas fa-plus"></i> Add New Item</button>
                <div class="table-responsive my-2">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Item Title</th>
                            <th>Item Category</th>
                            <th>Request/Approved Qty</th>
                            <th>Request Status</th>
                            <th>Date Submitted</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($ris_items as $ris_item)
                            <tr>
                                <td>{{ $ris_item->title }}</td>
                                <td>{{ $ris_item->category_name }}</td>
                                <td>{{ $ris_item->request_qty }}/{{ $ris_item->approved_qty }}</td>
                                <td>{{ $ris_item->status }}</td>
                                <td>{{ $ris_item->created_at }}</td>
                                <td>
                                    <a href="{{ route('ris.item.show', $ris_item->id) }}" class="mx-2" data-toggle="tooltip" data-placement="left" title="View RIS Item"><i class="fas fa-eye"></i></a>

                                    <a href="{{ route('ris.item.delete', $ris_item->id) }}" class="mx-2 text-danger" data-toggle="tooltip" data-placement="left" title="Delete this RIS"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- modal update --}}
    <div class="modal fade" id="ris-update-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Update <span class="font-weight-bold">{{ $ris->ris_number }}</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('ris.update', $ris->id) }}" method="post">
            <div class="modal-body">
                    @method('put')
                    @if (Cookie::get('role') == 'Super Admin')
                    <div class="form-group">
                        <label for="">Approved By</label>
                        <input type="text" name="approved_by" id="approved-by" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Approved Date</label>
                        <input type="text" name="date_approved" id="date-approved" class="form-control">
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="">Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-control">
                            <option value="">-</option>
                            <option value="approved">Approved</option>
                            <option value="declined">Declined</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Reason for Status</label>
                        <textarea name="reason_for_status" class="form-control" id="reason-for-status" cols="30" rows="10">  </textarea>
                    </div>
                
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </form>
            </div>
        </div>
        </div>
    </div>
    {{-- modal add items --}}
  
    <div class="modal fade" id="add-item-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Item for <span class="font-weight-bold">{{ $ris->ris_number }}</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">Item Category</label>
                    <select name="" id="item-category" data-office="{{ Cookie::get('office') }}" class="form-control">
                        <option value="">-</option>
                        @foreach ($item_categories as $categories)
                            <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="ris-item-container">

                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Add Item</button>
            </div>
        </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('includes/js/utilities.js') }}"></script>
    <script src="{{ asset('includes/js/ris/items.js') }}"></script>
    <script>
         $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        
        windowMaxMin('#minimize-ris', '#ris-container');
        windowMaxMin('#minimize-ris-items', '#ris-items-container');

        $(document).ready(function () {
            
            $('#ris-update-trigger').click(function () {
                var risID = $(this).data('id');
              
                $.ajax({
                    url: '/ajax/ris/'+risID,
                    type: 'get',
                    success: function (data) {
                        console.log(data);
                        $('#status').val(data.status);
                        $('#reason-for-status').val(data.reason_for_status);
                    }
                });
                $('#ris-update-modal').modal('show');
            });
            $('#add-item-trigger').click(function () {
                $('#add-item-modal').modal('show');
                $('#item-category').on('input', function () {
                    var category = $(this).val();
                    var office = $(this).data('office');
                    var container = $('#ris-item-container');

                    risAddIarItem(office, category, container);
                });
            });
        });

    </script>
    <!-- Page level plugins -->
    
    <script src="{{ asset('includes/sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('includes/sbadmin/js/demo/datatables-demo.js') }}"></script>
@endsection 