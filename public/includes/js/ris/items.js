function risUpdate()
{
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
}

function risAddIarItem()
{
    $('#add-item-trigger').click(function () {
        var risID = $(this).data('risid');

        $('#add-item-modal').modal({backdrop: 'static', keyboard: false});
        $('#add-item-modal').on('hidden.bs.modal', function () {
            $('#ris-item-container').html('');
            $('#ris-item-details').html('');
            $('#item-category').val('');
        });
        $('#item-category').on('input', function () {
            var category = $(this).val();
            var office = $(this).data('office');
            var container = $('#ris-item-container');

            $.ajax({
                url: '/ajax/iar/items/forris/'+office+'/'+category,
                type: 'get',
                success: function (data) {
                    console.log(data)
                    container.html('');
                    data.forEach(function (index){
                        container.append('' +
                                            '<div class="col-xs-12 col-md-4 col-lg-4 my-2" id="item-thumbnail" style="opacity:0.7 !important" data-office="'+index.receiving_office+'" data-id="'+index.id+'">' +
                                                '<div class="card" >' +
                                                '<img class="card-img-top" height="120px" src="/storage/utilities/no_jpg.jpg" alt="Card image cap">' +
                                                '<div class="card-body text-center">' +
                                                '<div class="font-weight-bold text-truncate">'+ index.title +'</div>' +
                                                '<div class="font-weight-bold text-truncate price"><small>Item Price: </small><br> ₱<span id="price">'+ index.price +'</span></div>' +
                                                '<div class="font-weight-bold text-truncate"><small>Available Qty: </small><br>'+ index.remaining_qty +'</div>' +
                                                '</div>' +
                                                '</div>' +
                                            '</div>'
                        );
                    });
                    $('div[id="item-thumbnail"]').click( function () {
                        var itemID = $(this).data('id');
                        var office = $(this).data('office');
                        var container = $('#ris-item-details');

                        // console.log(itemID)
                        $(this).data('clicked', true);
                        $(this).find('.card').addClass('border-success');
                        $(this).css('opacity', '1');
                        $(this).find('.card-img-top').css('opacity', 1);

                        $.ajax({
                            url: '/ajax/iar/item/'+office+'/'+itemID,
                            type: 'get',
                            success: function (data) {
                                // console.log(data)
                                console.log(risID)
                                container.html('');
                                container.append('<h5>Item Selected</h5>');
                                container.append(''+
                                '<form action="/ris/item/enduser/store" method="post">'+
                                    '<input type="hidden" name="ris_id" value="'+risID+'">'+
                                    '<input type="hidden" name="iar_item_id" value="'+data.id+'">'+
                                    '<div class="form-group">'+
                                    '<label>Item</label>'+
                                    '<div class="font-weight-bold">'+
                                    data.title+
                                    '</div>'+
                                    '</div>'+

                                        '<div class="form-group">'+
                                            '<label>Quantity for RIS</label>'+
                                            '<div class="d-flex align-items-center w-50">'+
                                                // '<div class="col-1">'+
                                                '<span id="deduct-qty" class="btn btn-primary mr-1">-</span>'+
                                                // '</div>'+
                                                // '<div class="col-4">'+
                                                '<input type="number" id="request-qty" name="request_qty" class="form-control text-center" value="1">'+
                                                // '</div>'+
                                                // '<div class="col-1">'+
                                                '<span id="add-qty" class="btn btn-primary ml-1">+</span>'+
                                                // '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<button type="submit" onclick="return confirm(\'Are you sure you want to add this item?\')" class="btn btn-primary col-6">Add this item</button>'+
                                    '</form>'+
                                '');

                                qtyTicker($('#add-qty'), $('#deduct-qty'), $('#request-qty'), data.remaining_qty)
                            }//end of success
                        });

                        $(this).siblings().click(function () {
                            if (itemID != $(this).data('id')) {
                                $('div[data-id='+itemID+']').find('.card').removeClass('border-success');
                                $('div[data-id='+itemID+']').css('opacity', 0.5);
                                $('div[data-id='+itemID+']').data('clicked', false);
                            }
                        });
                    } );

                    $('div[id="item-thumbnail"]').mouseenter( function () {
                        $(this).css('opacity', '1');
                        $(this).css('transition', '1s');
                    } ).mouseleave( function () {
                        if (! $(this).data('clicked')) {
                            $(this).css('opacity', '0.7');
                            $(this).css('transition', '1s');
                        }
                    } );



                }
            });
        });
    });


}

function qtyTicker(add, deduct, target, qtyLimit)
{
    qtyLimit = parseInt(qtyLimit);
    add.click( function () {
        if ( target.val() > qtyLimit-1 ) {
            alert('Item quantity limit!');
            target.val( parseInt(target.val()) - 1 );
        }
        target.val(parseInt( target.val() ) + 1);
    });

    deduct.click( function () {
        if ( target.val() < 1 ) {
            alert('Quantity cannot be zero!');
            target.val(1);
        }
        target.val(parseInt( target.val() ) - 1);
    });
}
