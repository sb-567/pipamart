$('.dot:nth-child(1)').click(function(){
  $(this).parent().find('.inside').animate({
    'width' : '22%'
  }, 500);
});
$('.dot:nth-child(2)').click(function(){
  $(this).parent().find('.inside').animate({
    'width' : '42%'
  }, 500);
});
$('.dot:nth-child(3)').click(function(){
  $(this).parent().find('.inside').animate({
    'width' : '62%'
  }, 500);
});
$('.dot:nth-child(4)').click(function(){
  $(this).parent().find('.inside').animate({
    'width' : '100%'
  }, 500);
});

$('.modal').unwrap();
// $('.modal').hide();
$('.modal').addClass('nobox');
$('.dot').click(function(){
  var modal = $(this).attr('id');
  $(this).parent().parent().find('article.nobox').hide()
  $(this).parent().parent().find('article.nobox.' + modal).fadeIn(200);
});
