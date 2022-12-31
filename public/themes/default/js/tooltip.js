jQuery(document).ready(function(){
    $("[data-toggle=tooltip]").tooltip({ placement: 'top'});
    $('.bi-clipboard-plus').click(function(){
        $(this).removeClass('bi-clipboard-plus').addClass('bi-check');
        setTimeout(function(){
            $('.bi-check').removeClass('bi-check').addClass('bi-clipboard-plus');
        },2000);
    })
});