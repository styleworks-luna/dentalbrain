$(function() {
    //email box
    email_box('.email_box');
    
    //select menu
    var select_menu = $('.select-menu');

    if(select_menu.length > 0){
        select_menu.selectmenu();
    }
});
