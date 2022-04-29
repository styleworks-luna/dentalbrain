$(function() {

    // ie check
    var agent = navigator.userAgent.toLowerCase();

    if ( (navigator.appName == 'Netscape' && navigator.userAgent.search('Trident') != -1) || (agent.indexOf("msie") != -1) ) {
        console.log(1);
        $('.ie-popup').css('display', 'block');
    }

   $('.close').click(function(e) {
       e.preventDefault();
       $('.ie-popup').css('display', 'none');
   });
});
