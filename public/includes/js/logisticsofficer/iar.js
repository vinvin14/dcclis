function addIarItem()
{
    var itemsContainer = $('#items');
    var addIarItemModal = new bootstrap.Modal(document.getElementById('add-iar-item-modal'), {
        keyboard: false
      })
     var itemDetails = $('#iar-item-details');

            $('#iar-item-trigger').click(function () {
                
                var iarId = $(this).data('id');
                addIarItemModal.show();
                // $('#add-iar-item-modal').modal({backdrop: 'static', keyboard: false});
                $('#item-category').on('input',function () {
                    var category = $(this).val();
                    axios.get('/axios/items?category='+category)
                    .then(function (response) {
                        var data = response.data;

                        data.forEach( function (index) {
                            itemsContainer.html('');
                            itemsContainer.append(interfaceAddIarItem(index));

                            $('div[id="item-thumbnail"]').click( function () {
                                var itemID = $(this).data('id');

                                axios.get('/axios/items?id='+ itemID)
                                .then(function (response) {
                                    itemDetails.html('');
                                    itemDetails.append('' +
                                        '<form action="/logisticsofficer/iar/item" method="post">' +
                                            '<h4>Item Selected</h4>' +
                                            '<input type="hidden" id="item-id" name="item_id" value="'+ itemID +'">' +
                                            '<input type="hidden" name="iar_id" value="'+ iarId +'">' +
                                            '<div class="mb-3">'+
                                                '<label class="fw-bold">Title</label>' +
                                                '<div>'+ response.data.title +'</div>' +
                                            '</div>' +
                                            '<div class="mb-3">'+
                                                '<label class="fw-bold">Specifications</label>' +
                                                '<textarea class="form-control" readonly="true">'+ response.data.specifications +'</textarea>' +
                                            '</div>' +
                                            '<div class="mb-3">' +
                                                '<label class="fw-bold">Quantity</label>' +
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
                                            '<div class="mb-3">' +
                                                '<label class="fw-bold">Price (in Php)</label>' +
                                                '<input type="number" class="form-control" step="0.001" id="price" min="1" name="price" required>' +
                                            '</div>' +
                                            '<div class="mb-3">' +
                                                '<label class="fw-bold">Office/Section</label>' +
                                                '<select id="office" name="receiving_office" class="form-select" required="true">' +
                                                    '<option></option>' +
                                                '</select>' +
                                            '</div>' +
                                            '<button type="submit" class="btn btn-primary btn-block">Add Item</button>' +
                                        '</form>'
                                    );
                                    createDropdownForOffices($('#office'));
                                    qtyTicker($('#add-qty'), $('#deduct-qty'), $('input[id="beginning_qty"]'))
                                })
                                .catch (function (error) {
                                    console.log(error)
                                });
                                // console.log(itemID)
                                $(this).data('clicked', true);
                                $(this).find('.card').addClass('border-success');
                                $(this).css('opacity', '1');
                                $(this).find('.card-img-top').css('opacity', 1);

                                $(this).siblings().click(function () {
                                    if (itemID != $(this).data('id')) {
                                        $('div[data-id='+itemID+']').find('.card').removeClass('border-success');
                                        $('div[data-id='+itemID+']').css('opacity', 0.5);
                                        $('div[data-id='+itemID+']').data('clicked', false);
                                    }
                                });
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
                    })
                    .catch (function (error) {
                        itemsContainer.html(error.response.data);
                    });
                })
            })
}
function updateIarItem()
{
    var modal = bootstrap.Modal.getOrCreateInstance($('#update-iar-item-modal'), {keyboard: false});
    $('a[id="update-iar-item"]').click(function () {
        var iarItemId = $(this).data('id');

        modal.show();
        
        axios.get('/axios/iar/item?id='+ iarItemId)
        .then(function (response) {
            console.log(response);
            data = response.data;
            $('#item-title').text(data.item.title);
            $('#office').val(data.receiving_office);
            $('#current-qty').val(data.current_qty);
            $('#price').val(data.price);

            qtyTicker($('span[id="add-qty"]'), $('span[id="deduct-qty"]'), $('input[id="current-qty"]'))

            $('#change-title-trigger').click(function () {
                var container = $('#new-title-container');
                $('#new-title').show();
                $("#new-item-title").keyup(delay(function() {
                    var keyword = $(this).val();
                    container.show();

                    if (keyword === '') {
                        container.hide();
                    }
                    axios.get('/axios/items?keyword='+keyword)
                    .then(function (response) {
                        data = response.data;
                        container.html('');
                        // container.append('<span class="text-danger cursor m-2" id="close-show-items"><i class="fas fa-times pt-1 pr-1"></i></span>');

                        data.forEach(function ( index ){
                            container.append('<div id="new-item" style="cursor:pointer; opacity:.5" data-id="'+ index.id +'" class="border-bottom p-2">'+ index.title +'</div>');
                            $('div[id="new-item"]').mouseenter( function () {
                                $(this).css('opacity', '1');
                                $(this).css('transition', '1s');
                            }).mouseleave( function () {
                                $(this).css('opacity', '.5');
                                $(this).css('transition', '1s');
                            });
                            $("#new-item-title").on("keyup", function() {
                                var value = $(this).val().toLowerCase();
                                container.find('div[id="new-item"]').filter(function() {
                                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                });

                            });
                            $('div[id="new-item"]').click( function () {
                                $('#new-item-title').val($(this).text());
                                $('#new-item-title').data('id', $(this).data('id'));
                                container.hide();
                            });
                        });
                        $('#close-show-items').click(function () {
                            container.hide();
                        });
                    });
                }, 400));
            });

            $('#new-item-title-close').click(function () {
                $('#new-title').hide();
            });
        });

        $('button[id="iar-item-update-submit"]').click(function () {
            var itemTitle = $('#new-item-title').data('id');
            var currentQty = $('#current-qty').val();
            var price = $('#price').val();
            var office = $('#office').val();

            Swal.fire({
                imageUrl: '/storage/images/loading/1.gif',
                // imageHeight: 1500,
                imageAlt: 'A tall image',
                showConfirmButton: false,
            });
            console.log(office)
            axios.put('/axios/iar/item/'+ iarItemId, {
                'current_qty' : currentQty,
                'item_id' : itemTitle,
                'price' : price,
                'receiving_office' : office
            })
            .then(function (response) {
                Swal.fire({
                    title: 'Success!',
                    text: response.data,
                    icon: 'success',
                    showConfirmButton: false
                    // confirmButtonText: 'Cool'
                  })

                setTimeout(function(){
                    location.reload();
                }, 1500);


            })
            .catch(function (error) {
                console.log(error.response.data)
                Swal.fire({
                    title: 'An Error Occured!',
                    text: error.response.data,
                    icon: 'error',
                    showConfirmButton: false
                    // confirmButtonText: 'Cool'
                  })
            });
        });
    });
}
function qtyTicker(add, deduct, target)
{

    add.click( function () {
        target.val(Number( target.val() ) + 1);
        console.log(target.val());
    });

    deduct.click( function () {
        console.log(target.val())
        if ( target.val() < 2 ) {
            Swal.fire({
                title: 'Error!',
                text: 'Quantity cannot be zero!',
                icon: 'error',
                confirmButtonText: 'Cool'
            })
            // alert('Quantity cannot be zero!');
            target.val(1);
            return false;
        }
        target.val(parseInt( target.val() ) - 1);
    });

    target.on('blur', function () {
        if ($(this).val() < 0)
        {
            Swal.fire({
                title: 'Error!',
                text: 'Quantity cannot be lower than 1',
                icon: 'error',
                confirmButtonText: 'Cool'
            })
            // alert('Quantity cannot be lower than 1');
            target.val(1);
        }
    });
}

