$('.date').hide();
$('.justify').hide();
$("#opcoes").on('change', function(e){
    if($(this).val() != '5'){
        $('.justify').hide();
        $('.date').show();
    }else{
        $('.date').hide();
        $('.justify').show();
    }
});

$('.justificar').bind('click', function(){
    $('.date').hide();
    $('.justify').hide();
    var id = ($(this).attr('value'));
    $('#id').attr('value', id);
});
