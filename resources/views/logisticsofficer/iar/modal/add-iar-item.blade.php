  {{-- modal to add items --}}
  <div class="modal fade" id="add-iar-item-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Item for <span class="font-weight-bold">{{ $iar->iar_number }}</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="">Item Category</label>
                <select name="" id="item-category" data-office="{{ Cookie::get('office') }}" class="form-select">
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
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Close</button>
        </div>
    </div>
    </div>
</div>
