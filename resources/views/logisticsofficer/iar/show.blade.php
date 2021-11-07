@extends('interface.main')
@section('title', 'Inspection & Acceptance Report')
@section('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
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
    </style>
@endsection
@section('page')
<a href="{{ route('logisticsofficer.iar.index') }}" class="font-weight-normal link-light"><i class="far fa-arrow-alt-circle-left"></i> Back to IAR List</a>
    <div class="row mt-2">
        <div class="col-xs-12 col-md-3 col-lg-3">
            <div class="card shadow-sm">
                <div class="card-header">
                    IAR Details
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Date of Delivery</label>
                        {{-- <div>{{ \Carbon\Carbon::parse($iar->date_of_delivery)->format('F')  }}</div> --}}
                        <div>{{ \Carbon\Carbon::parse($iar->date_of_delivery)->format('F j, Y')  }}</div>
                    </div>
                    <div class="form-group">
                        <label for="" class="font-weight-bold">Recorded By</label>
                        <div>{{$iar->logistics_officer}}</div>
                    </div>
                    @if (!empty ($iar->ptr_number))
                        <div class="form-group">
                            <label for="" class="font-weight-bold">PTR #:</label>
                            <div>{{ $iar->ptr_number }}</div>
                        </div>
                    @endif
                    @if (!empty($iar->po_number))
                        <div class="form-group">
                            <label for="" class="font-weight-bold">Purchase Order #:</label>
                            <div>{{ $iar->po_number }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-9 col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header">
                    IAR Items
                </div>
                <div class="card-body">
                    <button class="btn btn-info mb-2" id="iar-item-trigger"><i class="fas fa-plus"></i> Add IAR Item</button>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Item Title</th>
                                <th>Office/Section</th>
                                <th>Current Qty</th>
                                <th>Issued Qty</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($iar->iarItem as $row)
                                    <tr>
                                        <td>{{ $row->item->title }}</td>
                                        <td>{{ $row->item->office->name }}</td>
                                        <td>{{ $row->current_qty }}</td>
                                        <td>{{ $row->issued_qty }}</td>
                                        <td>{{ $row->status }}</td>
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
                </div>
            </div>
        </div>
    </div>
    

    {{-- modal to add items --}}
    <div class="modal fade" id="add-iar-item-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Item for <span class="font-weight-bold">{{ $iar->iar_number }}</span></h5>
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
                <div class="row">
                    <div class="col-8 border-right">
                        <div class="row container" id="items" style="max-height: 600px; overflow-y: auto">
                            {{-- ajax items --}}
                        </div>
                    </div>
                    <div class="col-4" id="iar-item-details">
                    </div>


                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('includes/js/interface/iar.js') }}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });

        $(document).ready(function () {
            var itemsContainer = $('#items');
            var itemDetails = $('#iar-item-details');

            $('#iar-item-trigger').click(function () {
                $('#add-iar-item-modal').modal({backdrop: 'static', keyboard: false});
                $('#item-category').on('input',function () {
                    var category = $(this).val();
                    axios.get('/axios/items?category='+category)
                    .then(function (response) {
                        var data = response.data;
                        data.forEach( function (index) {
                            itemsContainer.html('');
                            itemsContainer.append(interfaceAddIarItem(index));

                            $('div[id="item-thumbnail"]').click( function () {
                                
                                axios.get('/axios/items?id='+ $(this).data('id'))
                                .then(function (response) {
                                    console.log(response.data.title);
                                    itemDetails.html('');
                                    itemDetails.append('' +
                                        '<form action="logisticsofficer/iar/item/store" method="post">' +
                                            '<h4>Item Selected</h4>' +
                                            '<div class="form-group">'+
                                                '<label class="font-weight-bold">Title</label>' +
                                                '<div>'+ response.data.title +'</div>' +
                                            '</div>' +
                                            '<div class="form-group">'+
                                                '<label class="font-weight-bold">Specifications</label>' +
                                                '<div>'+ response.data.specifications +'</div>' +
                                            '</div>' +
                                            '<div class="form-group">' +
                                                '<label class="font-weight-bold">Quantity</label>' +
                                                '<div class="d-flex align-items-center">'+
                                                // '<div class="col-1">'+
                                                '<span id="deduct-qty" class="btn btn-primary mr-1">-</span>'+
                                                // '</div>'+
                                                // '<div class="col-4">'+
                                                '<input type="number" id="beginning_qty" name="beginning_qty" class="form-control text-center" value="1">'+
                                                // '</div>'+
                                                // '<div class="col-1">'+
                                                '<span id="add-qty" class="btn btn-primary ml-1">+</span>'+
                                                // '</div>'+
                                            '</div>'+
                                            '</div>' +
                                            '<button type="submit" class="btn btn-primary btn-block">Add Item</button>' +
                                        '</form>'
                                    );
                                    qtyTicker($('#add-qty'), $('#deduct-qty'), $('#beginning_qty'))
                                });
                                // console.log(itemID)
                                $(this).data('clicked', true);
                                $(this).find('.card').addClass('border-success');
                                $(this).css('opacity', '1');
                                $(this).find('.card-img-top').css('opacity', 1);  
                            });     
                             
                            $('div[id="item-thumbnail"]').mouseenter( function () {
                                $(this).css('opacity', '1');
                                $(this).css('transition', '1s');
                            } ).mouseleave( function () {
                                if (! $(this).data('clicked')) {
                                    $(this).css('opacity', '0.7');
                                    $(this).css('transition', '1s');
                                }
                            } );    
                        });
                    });
                })
            })
        });
    </script>
    <!-- Page level plugins -->
    <script src="{{ asset('includes/sbadmin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('includes/sbadmin/js/demo/datatables-demo.js') }}"></script>

@endsection