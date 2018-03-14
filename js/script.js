$(document).ready(function() {    
    
    //show comments
    $('.zip').click(function(){
        var shown = false;
        var is_shown = this.classList[1];
        if(is_shown == 'shown'){
            shown = true;
        }
        
        var parent = $(this).parent();
        
        if(shown){
            parent.animate({height: '21px'}, 200);
            $(this).removeClass('shown').addClass('hidden');
            var arrows = $(this).find('.arrow');
            arrows.html('&#8681;&#8681;&#8681;');
        }
        else{
            parent.animate({height: parent.get(0).scrollHeight}, 200);
            $(this).removeClass('hidden').addClass('shown');
            var arrows = $(this).find('.arrow');
            arrows.html('&#8679;&#8679;&#8679;');
        } 
    });
    
    //show all offers
    $('#show_all').click(function(){ 
        insertParam('opinions', 'all'); 
    });
    
    //parcel click
    $('.table_wrapper .table table .light_up').click(function(){
        window.location = $(this).data('href');
    });
    
    
    //date picker
    $('#t_end_date').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#t_start_date').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#f_end_date').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#f_start_date').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#offer_date_f').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#offer_date_t').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#v_f_start_date').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#v_f_end_date').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#v_t_start_date').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#v_t_end_date').datetimepicker({format: 'Y-m-d H:i:s'});
    
  $('#vehicle_offer_date_f').datetimepicker({format: 'Y-m-d H:i:s'});
    $('#vehicle_offer_date_t').datetimepicker({format: 'Y-m-d H:i:s'});
    
    
    //new offer types
    $('#parcel_choose').click(function(){
       insertParam('type', 'parcel'); 
    });
    
    $('#vehicle_choose').click(function(){
       insertParam('type', 'vehicle'); 
    });
    
    
    //pages
    $('#before1, #before2').click(function(){
        var curr = getCurrPage();
        curr--;
        if(curr < 1) curr=1;
        insertParam('page', curr);
    });
    
    $('#next1, #next2').click(function(){
        var curr = getCurrPage();
        curr++;
        insertParam('page', curr);
    });
    
    //categories
        //main
    $('#chbox_free_loads_m, #chbox_free_loads').change(function(){
        insertParam('category','loads');
    });
    
    $('#chbox_vehicles_m, #chbox_vehicles').change(function(){
        insertParam('category','vehicles');
    });
        //parcel types
    $('#chbox_furniture_m, #chbox_furniture').change(function(){
        if($(this).is(':checked')){
            insertParam('furniture','1');
        }
        else{
             insertParam('furniture','0');
        }
    });
    $('#chbox_moving_m, #chbox_moving').change(function(){
        if($(this).is(':checked')){
            insertParam('moving','1');
        }
        else{
             insertParam('moving','0');
        }
    });
    $('#chbox_cars_m, #chbox_cars').change(function(){
        if($(this).is(':checked')){
            insertParam('cars','1');
        }
        else{
             insertParam('cars','0');
        }
    });
    $('#chbox_loads_m, #chbox_loads').change(function(){
        if($(this).is(':checked')){
            insertParam('loads','1');
        }
        else{
             insertParam('loads','0');
        }
    });
    $('#chbox_boxes_m, #chbox_boxes').change(function(){
        if($(this).is(':checked')){
            insertParam('boxes','1');
        }
        else{
             insertParam('boxes','0');
        }
    });
    $('#chbox_motocycles_m, #chbox_motocycles').change(function(){
        if($(this).is(':checked')){
            insertParam('motocycles','1');
        }
        else{
             insertParam('motocycles','0');
        }
    });
    $('#chbox_other_vehicles_m, #chbox_other_vehicles').change(function(){
        if($(this).is(':checked')){
            insertParam('other_vehicles','1');
        }
        else{
             insertParam('other_vehicles','0');
        }
    });
    $('#chbox_care_m, #chbox_care').change(function(){
        if($(this).is(':checked')){
            insertParam('special_care','1');
        }
        else{
             insertParam('special_care','0');
        }
    });
    $('#chbox_other_m, #chbox_other').change(function(){
        if($(this).is(':checked')){
            insertParam('other','1');
        }
        else{
             insertParam('other','0');
        }
    });
    //weight
    $('#weight_min_m, #weight_min').change(function(){
        insertParam('weight_min', $(this).val());
    });
    $('#weight_max_m, #weight_max').change(function(){
        insertParam('weight_max', $(this).val());
    });
    
    //menu
    
    var menu_shown = false;
    $('#mobile_menu').click(function(){
        if(menu_shown == false){
            $('#apk_menu').animate({right: '0'}, 500);
            menu_shown = true;
        }
        else{
            $('#apk_menu').animate({right: '-320px'}, 500);
            menu_shown = false;
        }
    });
    
    $('#categories_open').click(function(){
        if(menu_shown == false){
            $('#apk_menu').animate({right: '0'}, 500);
            menu_shown = true;
        }
        else{
            $('#apk_menu').animate({right: '-320px'}, 500);
            menu_shown = false;
        }
    });
    
    //new offer
    var offer_show = false;
    $('#new_offer_button').click(function(){
       if(offer_show == false){
           $('#popup_bg').fadeIn(250);
           $('#offer_popup').fadeIn(250);
           offer_show = true;
       } 
    });
    
    
    //new comment
    var comment_show = false;
    $('.new_comment').click(function(){
        var offer_id = $(this).attr('class').split(' ')[2];
        $('#comment_offer_id').val(offer_id);
       if(comment_show == false){
           $('#popup_bg').fadeIn(250);
           $('#comment_popup').fadeIn(250);
           comment_show = true;
       } 
    });
    
        //edit comment
    var comment_edit_show = false;
    $('.edit').click(function(){
        var offer_id = $(this).attr('class').split(' ')[1];
        $('#comment_id').val(offer_id);
        $content = $(this).children();        $('#comment_edit_placeholder').html($content.val());
        
       if(comment_show == false){
           $('#popup_bg').fadeIn(250);
           $('#comment_edit_popup').fadeIn(250);
           comment_edit_show = true;
       } 
    });
    
    
     //new vehicle offer
    var vehicle_offer_show = false;
    $('#new_vehicle_offer_button').click(function(){
       if(vehicle_offer_show == false){
           $('#popup_bg').fadeIn(250);
           $('#vehicle_offer_popup').fadeIn(250);
           vehicle_offer_show = true;
       } 
    });
    
    
    //register
    
    var register_show = false;
    $('#register').click(function(){
        if(register_show == false){
            $('#popup_bg').fadeIn(250);
            $('#register_popup').fadeIn(250);
            register_show = true;
        }
    });
    
    $('#register_m').click(function(){
        if(register_show == false){
            $('#popup_bg').fadeIn(250);
            $('#register_popup').fadeIn(250);
            register_show = true;
            
            if(menu_shown == true){
                $('#apk_menu').animate({right: '-320'}, 50);
                menu_shown = false;
            }
            
        }
    });
    
     //login
    
    var login_show = false;
    $('#login').click(function(){
       if(login_show == false){
           $('#popup_bg').fadeIn(250);
           $('#login_popup').fadeIn(250);
           login_show = true;
           
           
           if(menu_shown == true){
               $('#apk_menu').animate({right: '-320'}, 50);
               menu_shown = false;
           }
           
       }
    });
    
    $('#login_m').click(function(){
        if(login_show == false){
            $('#popup_bg').fadeIn(250);
            $('#login_popup').fadeIn(250);
            login_show = true;
            
            if(menu_shown == true){
                $('#apk_menu').animate({right: '-320'}, 50);
                menu_shown = false;
            }
            
        }
    });
    
    //settings
    
    var settings_show = false;
    $('#settings').click(function(){
       if(settings_show == false){
           $('#popup_bg').fadeIn(250);
           $('#settings_popup').fadeIn(250);
           settings_show = true;
           
           
           if(menu_shown == true){
               $('#apk_menu').animate({right: '-320'}, 50);
               menu_shown = false;
           }
           
       }
    });
    
    $('#settings_m').click(function(){
        if(settings_show == false){
            $('#popup_bg').fadeIn(250);
            $('#settings_popup').fadeIn(250);
            settings_show = true;
            
            if(menu_shown == true){
                $('#apk_menu').animate({right: '-320'}, 50);
                menu_shown = false;
            }
            
        }
    });
    
    
    //close pop_ups
    $('#popup_bg').click(function(e){
        if(e.target !== this)return;
        
        $('#popup_bg').fadeOut(200);
        $('#register_popup').fadeOut(200);
        login_show = false;
        $('#login_popup').fadeOut(200);
        register_show = false;
        $('#settings_popup').fadeOut(200);
        settings_show = false;
        $('#offer_popup').fadeOut(200);
        offer_show = false;
        $('#vehicle_offer_popup').fadeOut(200);
        vehicle_offer_show = false;
        $('#comment_popup').fadeOut(200);
        comment_show = false;
        $('#comment_edit_popup').fadeOut(200);
        comment_edit_show = false;
        
    });
    
    $('#register_popup .close').click(function(){
        $('#register_popup').fadeOut(200);
        $('#popup_bg').fadeOut(200);
        register_show = false;
    });
    
    $('#login_popup .close').click(function(){
        $('#login_popup').fadeOut(200);
        $('#popup_bg').fadeOut(200);
        login_show = false;
    });
    
    $('#settings_popup .close').click(function(){
        $('#settings_popup').fadeOut(200);
        $('#popup_bg').fadeOut(200);
        settings_show = false;
    });
    
    $('#offer_popup .close').click(function(){
        $('#offer_popup').fadeOut(200);
        $('#popup_bg').fadeOut(200);
        offer_show = false;
    });
    
    $('#vehicle_offer_popup .close').click(function(){
        $('#vehicle_offer_popup').fadeOut(200);
        $('#popup_bg').fadeOut(200);
        vehicle_offer_show = false;
    });
    
    $('#comment_popup .close').click(function(){
        $('#comment_popup').fadeOut(200);
        $('#popup_bg').fadeOut(200);
        comment_show = false;
    });
    
    $('#comment_edit_popup .close').click(function(){
        $('#comment_edit_popup').fadeOut(200);
        $('#popup_bg').fadeOut(200);
        comment_edit_show = false;
    });
        
});

function insertParam(key, value){
    key = encodeURI(key); value = encodeURI(value);

    var kvp = document.location.search.substr(1).split('&');

    var i=kvp.length; var x; while(i--) 
    {
        x = kvp[i].split('=');

        if (x[0]==key)
        {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }

    if(i<0) {kvp[kvp.length] = [key,value].join('=');}

    //this will reload the page, it's likely better to store this until finished
    document.location.search = kvp.join('&'); 
}

function getCurrPage(){
    var key = encodeURI('page');
    var kvp = document.location.search.substr(1).split('&');
    
    var i=kvp.length; var x; while(i--) 
    {
        x = kvp[i].split('=');

        if (x[0]=='page')
        {
            return x[1];
        }
    }
    return 1;
}


