function interfaceAddIarItem(index)
{
    return '' +
    '<div class="col-xs-12 col-md-4 col-lg-4 my-2" id="item-thumbnail" data-id="'+ index.id +'" style="opacity:0.7 !important">'+
        '<div class="card">'+
            '<img class="card-img-top" height="120px" src="/storage/utilities/no_jpg.jpg" alt="Card image cap">' +
            '<div class="card-body text-center">'+
                '<div class="font-weight-bold text-truncate">'+ index.title +'</div>' +
                // '<div><textarea class="form-control" readonly="true">'+index.specification+'</textarea></div>' +
            '</div>' +
        '</div>' +
    '</div>'  

    
}

function qtyTicker(add, deduct, target)
{
    add.click( function () {
        target.val(parseInt( target.val() ) + 1);
    });

    deduct.click( function () {
        if ( target.val() < 2 ) {
            alert('Quantity cannot be zero!');
            target.val(1);
            return false;
        }
        target.val(parseInt( target.val() ) - 1);
    });
}