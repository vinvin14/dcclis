<!-- Modal update iar item -->
<div class="modal fade" id="update-iar-item-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Update Item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="" class="font-weight-bold">Item Title</label>
                <div id="item-title"></div>
                <small id="change-title-trigger">Change title</small>
                {{-- <select name="" id="item-title" class="form-control">
                    <option value="">-</option>
                    @foreach ($items as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                    @endforeach
                </select> --}}
            </div>
            <div class="mb-3" id="new-title" style="display: none">
                <span class="float-right text-danger cursor" id="new-item-title-close" title="close"><i class="far fa-times-circle"></i> Cancel</span>
                <label for="" class="font-weight-bold">New Item Title</label>
                {{-- <input class="form-control" name="new-item-title"> --}}
                <input type="search" id="new-item-title" class="form-control" autocomplete="off">
                <div id="new-title-container"></div>
            </div>
            <div class="mb-3">
                <label class="font-weight-bold">Current Qty</label>
                <div class="d-flex align-items-center">
                    <span id="deduct-qty" class="btn btn-primary mr-1">-</span>
                    <input type="number" id="current-qty" name="current_qty" class="form-control text-center" >
                    <span id="add-qty" class="btn btn-primary ml-1">+</span>
                </div>
            </div>
            <div class="mb-3">
                <label for="" class="font-weight-bold">Price</label>
                <input type="number" name="" id="price" class="form-control">
            </div>
            <div class="mb-3">
                <label for="" class="font-weight-bold">Office</label>
                <select name="" id="office" class="form-control" required>
                    <option value="">-</option>
                    @foreach ($offices as $office)
                        <option value="{{ $office->id }}">{{ $office->short_name }} - {{ $office->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="modal-close"  data-bs-dismiss="modal" aria-label="Close">Close</button>
        <button type="button" id="iar-item-update-submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
    </div>
</div>
