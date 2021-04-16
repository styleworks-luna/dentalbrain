$(function () {
   $('.menu-btn').click(function(e) {
       e.preventDefault();
       $('.aside').removeClass('hide');
       $('.dim').removeClass('hide');
   });
   $('.btn-nav-close').click(function(e) {
       e.preventDefault();
       $('.aside').addClass('hide');
       $('.dim').addClass('hide');
   })
});
