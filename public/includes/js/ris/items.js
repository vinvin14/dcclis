function risAddIarItem(category, office, container)
{
    $.ajax({
        url: '/ajax/ris/items/'+office+'/'+category,
        type: 'get',
        success: function (data) {
            data.forEach(function (index){
                container.append('' +
                                    '<div class="col-xs-12 col-md-4 col-lg-4 my-2" id="item-thumbnail" style="opacity:0.7 !important" data-id="'+index.id+'">' +
                                    '<div class="card" >' +
                                    '<img class="card-img-top" height="120px" src="/storage/utilities/no_jpg.jpg" alt="Card image cap">' +
                                    '<div class="card-body text-center">' +
                                    '<div class="font-weight-bold text-truncate" id="title" title="'+ index.title +'">'+ index.title +'</div>' +
                                    '<div class="font-weight-bold text-truncate price">₱<span id="price">'+ index.price +'</span></div>' +
                                    '<span id="qty" data-qty="'+ index.remaining_qty +'"></span>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>'
                );
            });
            $('div[id="item-thumbnail"]').click( function () {
                var itemID = $(this).data('id');
                $(this).data('clicked', true);
                $(this).find('.card').addClass('border-success');
                $(this).css('opacity', '1');
                $(this).find('.card-img-top').css('opacity', 1);

                $.ajax({
                    url: '/ajax/iar/item/'+itemID,
                    type: 'get',
                    success: function (data) {
                        console.log(data)
                    }
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
}
