@extends('interface.main')
@section('title', 'Inspection & Acceptance Report')
@section('styles')
    <!-- Custom styles for this page -->
    <link href="{{ asset('includes/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection
@section('page')
    <a href="{{ route('logisticsofficer.iar.index') }}" class="font-weight-normal link-light"><i class="far fa-arrow-alt-circle-left"></i> Back to IAR List</a>
    <div class="card shadow-sm w-50 mt-2">
        <div class="card-header">
            Create new IAR
        </div>
        <div class="card-body container">
            <form action="{{ route('logisticsofficer.iar.store') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="" class="font-weight-bold">Source</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="source" id="ptr" value="option1">
                        <label class="form-check-label" for="exampleRadios1">
                            From PTR
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="source" id="po" value="option2">
                        <label class="form-check-label" for="po">
                            From Puchase Order
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="font-weight-bold">Date of Delivery</label>
                    <input type="date" name="date_of_delivery" class="form-control" required>
                </div>
                <div class="form-group" id="ptr-container" style="display: none">
                    <label for="" class="font-weight-bold">PTR #</label>
                    <input type="text" name="ptr_number" class="form-control" id="ptr-number">
                </div>
                <div class="form-group" id="po-container" style="display: none">
                    <label for="" class="font-weight-bold">Purchase Order #</label>
                    <input type="text" name="po_number" class="form-control" id="po-number">
                </div>
                <button class="btn btn-primary btn-block">Create this Record</button>
            </form>
        </div>    
    </div>  
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            var poField = $('#po-number');
            var poContainer = $('#po-container');

            var ptrField = $('#ptr-number');
            var ptrContainer = $('#ptr-container');

            $('#po').click(function () {
                poContainer.show();
                ptrContainer.hide();

                poField.prop('required', true);
                ptrField.prop('required', false);
                
            });

            $('#ptr').click(function () {
                poContainer.hide();
                ptrContainer.show();

                ptrField.prop('required', true);
                poField.prop('required', false);
            });
        });
    </script>
@endsection