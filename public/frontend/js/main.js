
$('.lange-drop').click(function() {
  $('.drop-lange-select').slideToggle("slow"); 
  $('.notification-all').hide("slow");
  $('.category-lst').hide("slow");  
});

$('.notification-btn').click(function() {
  $('.notification-all').slideToggle("slow"); 
  $('.drop-lange-select').hide("slow");
  $('.category-lst').hide("slow"); 
});
$('.category-tile').click(function() {
  $('.category-lst').slideToggle("slow"); 
  $('.drop-lange-select').hide("slow");
  $('.notification-all').hide("slow"); 
});
$('.category-tile-inner').click(function() {
  $('.category-2nd').slideToggle("slow"); 
});


// $(window).scroll(function() {
//     if ($(document).scrollTop() > 50) {
//         $('.header').addClass('affix');
//         // console.log("OK");
//     } else {
//         $('.header').removeClass('affix');
//     }
// });
$('.navTrigger').click(function () {
    $(this).toggleClass('active');
    console.log("Clicked menu");
    $("#mainListDiv").toggleClass("show_list");
    $("#mainListDiv").fadeIn();

});
$('.menu-show-mn').click(function () {
  $('.menu-ul').toggleClass('show-mnu');
});