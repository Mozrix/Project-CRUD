$(document).ready(function(){

$(".block").Onover(function(){
    $(this).toggleClass('active');
    $(".price").removeClass('active');
    $(".active .price").addClass('active');
});

});