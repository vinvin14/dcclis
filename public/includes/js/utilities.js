function windowMaxMin(trigger, target)
{
    $(trigger).click(function () {
        var status = $(this).data('status')

        if(status === 'max') 
        {
            $(this).find('i').removeClass('fas fa-minus')
            $(this).find('i').addClass('far fa-window-restore')
            $(this).data('status', 'min')
            $(target).hide(500)

        }
        else 
        {
            $(this).find('i').removeClass('far fa-window-restore')
            $(this).find('i').addClass('fas fa-minus')
            $(this).data('status', 'max')
            $(target).show(500)
        }
    })
}