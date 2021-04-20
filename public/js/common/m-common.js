$(function () {
   $('.menu-btn').click(function(e) {
       e.preventDefault();
       $('.aside').removeClass('hide');
       $('.aside-dim').removeClass('hide');
   });
   $('.btn-nav-close').click(function(e) {
       e.preventDefault();
       $('.aside').addClass('hide');
       $('.aside-dim').addClass('hide');
   })
});
