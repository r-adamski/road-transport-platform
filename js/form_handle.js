var error = [];
//register
error['name_empty'] = "Musisz wypełnić to pole!";
error['email_empty'] = "Musisz wypełnić to pole!";
error['phone_empty'] = "Musisz wypełnić to pole!";
error['pass_empty'] = "Musisz wypełnić to pole!";
error['pass1_empty'] = "Musisz wypełnić to pole!";
error['rules_empty'] = "Musisz wypełnić to pole!";

error['email_used'] = "Podany adres E-mail jest zajęty!";
error['phone_used'] = "Podany numer jest już zajęty!";
error['pass_match'] = "Podane hasła nie są identyczne!";
error['pass_correct'] = "Hasło musi mieć od 6 do 16 znaków!";
//login
error['wrong_pass'] = "Niepoprawne hasło lub e-mail!";

//settings
error['nip_used'] = "Podany numer Nip jest już zajęty!";

//add parcel
error['general_empty'] = "Musisz wypełnić to pole!";
error['date_error'] = "Niepoprawnie podane daty!";


$(document).ready(function() {
    
$('#add_vehicle_form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    
    $.post('php/add_vehicle.php', form.serializeArray())
    .done(function(data){
        
    var reload = true;
        
    //validate
    if(data['title_empty']){
        $('#v_title_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_title_empty').text("");
     }
    if(data['capacity_empty']){
        $('#v_capacity_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_capacity_empty').text("");
     }
    if(data['pallets_empty']){
        $('#v_pallets_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_pallets_empty').text("");
     }
    if(data['about_empty']){
        $('#v_about_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_about_empty').text("");
     }
    if(data['country_empty']){
        $('#v_country_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_country_empty').text("");
     }
    if(data['province_empty']){
        $('#v_province_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_province_empty').text("");
     }
    if(data['city_empty']){
        $('#v_city_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_city_empty').text("");
     }
    if(data['f_start_date']){
  $('#v_f_start_date_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_f_start_date_empty').text("");
     }
    if(data['f_end_date']){
        $('#v_f_end_date_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_f_end_date_empty').text("");
     }
    if(data['to_country_empty']){
        $('#v_to_country_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_to_country_empty').text("");
     }
    if(data['to_province_empty']){
        $('#v_to_province_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_to_province_empty').text("");
     }
    if(data['to_city_empty']){
        $('#v_to_city_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_to_city_empty').text("");
     }
    if(data['t_start_date']){
      $('#v_t_start_date_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_t_start_date_empty').text("");
     }
    if(data['t_end_date']){
        $('#v_t_end_date_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#v_t_end_date_empty').text("");
     }
    if(data['date_error']){
        $('#vehicle_date_error').text(error['date_error']);
        reload = false;
      }else{
         $('#vehicle_date_error').text("");
     }
        
    if(reload){
        var id = data['vehicle_id'];
        window.location = '?id=7&vehicle='+id;
        //location.reload();
    }
        
    });
    
});
    
$('#offer_form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    
    $.post('php/add_offer.php', form.serializeArray())
    .done(function(data){
        
    var reload = true;
    if(data['price_empty']){
        $('#offer_price_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#offer_price_empty').text("");
     }
    if(data['time_empty']){
        $('#offer_time_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#offer_time_empty').text("");
     }
    if(data['type_empty']){
        $('#offer_type_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#offer_type_empty').text("");
     }
    if(data['load_f_empty']){
        $('#offer_date_f_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#offer_date_f_empty').text("");
     }
    if(data['load_t_empty']){
        $('#offer_date_t_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#offer_date_t_empty').text("");
     }
        if(data['date_error']){
            $('#offer_date_error').text(error['date_error']);
            reload = false;
        }
        else{
            $('#offer_date_error').text("");
        }
        
    if(reload){
        location.reload();
    }

    });
    
});
    

$('#comment_form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    
    $.post('php/add_comment.php', form.serializeArray())
    .done(function(data){
        
    var reload = true;
    if(data['comment_empty']){
        $('#comment_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#comment_empty').text("");
     }
        
    if(reload){
        location.reload();
    }

    });
    
});
    
    
$('#comment_edit_form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    
    $.post('php/edit_comment.php', form.serializeArray())
    .done(function(data){
        
    var reload = true;
    if(data['comment_empty']){
        $('#comment_edit_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#comment_empty').text("");
     }
        
    if(reload){
        location.reload();
    }

    });
    
});
    

$('#vehicle_offer_form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    
    $.post('php/add_vehicle_offer.php', form.serializeArray())
    .done(function(data){
        
    var reload = true;
    if(data['price_empty']){
        $('#vehicle_offer_price_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#vehicle_offer_price_empty').text("");
     }
     if(data['weight_empty']){
        $('#vehicle_offer_weight_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#vehicle_offer_weight_empty').text("");
     }
     if(data['length_empty']){
        $('#vehicle_offer_length_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#vehicle_offer_length_empty').text("");
     }
    if(data['height_empty']){
        $('#vehicle_offer_height_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#vehicle_offer_height_empty').text("");
     }
    if(data['width_empty']){
        $('#vehicle_offer_width_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#vehicle_offer_width_empty').text("");
     }
    if(data['load_f_empty']){
        $('#vehicle_offer_date_f_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#vehicle_offer_date_f_empty').text("");
     }
    if(data['load_t_empty']){
        $('#vehicle_offer_date_t_empty').text(error['general_empty']);
        reload = false;
      }else{
         $('#vehicle_offer_date_t_empty').text("");
     }
        
        
    if(reload){
        location.reload();
    }

    });
    
});
    
    
    
$('#add_parcel_form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    
    $.post('php/add_parcel.php', form.serializeArray())
    .done(function(data){
        
        var reload = true;
        if(data['cat_empty']){
            $('#cat_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#cat_empty').text("");
        }
        if(data['title_empty']){
            $('#title_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#title_empty').text("");
        }
        if(data['length_empty']){
            $('#length_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#length_empty').text("");
        }
        if(data['width_empty']){
            $('#width_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#width_empty').text("");
        }
        if(data['height_empty']){
            $('#height_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#height_empty').text("");
        }
        if(data['weight_empty']){
            $('#weight_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#weight_empty').text("");
        }
        if(data['amount_empty']){
            $('#amount_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#amount_empty').text("");
        }
        if(data['about_empty']){
            $('#about_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#about_empty').text("");
        }
        if(data['country_empty']){
            $('#country_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#country_empty').text("");
        }
        if(data['province_empty']){
            $('#province_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#province_empty').text("");
        }
        if(data['city_empty']){
            $('#city_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#city_empty').text("");
        }
        if(data['post_code_empty']){
            $('#post_code_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#post_code_empty').text("");
        }
        if(data['street_empty']){
            $('#street_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#street_empty').text("");
        }
        if(data['number_empty']){
            $('#number_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#number_empty').text("");
        }
        if(data['f_start_date_empty']){
            $('#f_start_date_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#f_start_date_empty').text("");
        }
        if(data['f_end_date_empty']){
            $('#f_end_date_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#f_end_date_empty').text("");
        }
        if(data['to_country_empty']){
            $('#to_country_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#to_country_empty').text("");
        }
        if(data['to_province_empty']){
            $('#to_province_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#to_province_empty').text("");
        }
        if(data['to_city_empty']){
            $('#to_city_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#to_city_empty').text("");
        }
        if(data['to_post_code_empty']){
            $('#to_post_code_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#to_post_code_empty').text("");
        }
        if(data['to_street_empty']){
            $('#to_street_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#to_street_empty').text("");
        }
        if(data['to_number_empty']){
            $('#to_number_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#to_number_empty').text("");
        }
        if(data['t_start_date_empty']){
            $('#t_start_date_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#t_start_date_empty').text("");
        }
        if(data['t_end_date_empty']){
            $('#t_end_date_empty').text(error['general_empty']);
            reload = false;
        }else{
            $('#t_end_date_empty').text("");
        }
        if(data['date_error']){
            $('#parcel_date_error').text(error['date_error']);
            reload = false;
        }else{
            $('#parcel_date_error').text("");
        }
        
        
        if(reload){
            var id = data['parcel_id'];
            window.location = '?id=5&parcel='+id;
            
            //location.reload();
        }
        
        
    });
    
});
    
$('#register_form').submit(function(e){
    e.preventDefault();
    var form = $(this);

    
    $.post("php/register.php", form.serializeArray())
    .done(function(data){
        
        var reload = true;
        //validate
        if(data['name_empty']){
            $('#name_empty').text(error['name_empty']);
            reload = false;
        }else{
            $('#name_empty').text("");
        }
        if(data['email_empty']){
            $('#email_empty').text(error['email_empty']);
            reload = false;
        }else{
            $('#email_empty').text("");
        }
        if(data['phone_empty']){
            $('#phone_empty').text(error['phone_empty']);
            reload = false;
        }else{
            $('#phone_empty').text("");
        }
        if(data['pass_empty']){
            $('#pass_empty').text(error['pass_empty']);
            reload = false;
        }else{
            $('#pass_empty').text("");
        }
        if(data['pass1_empty']){
            $('#pass1_empty').text(error['pass1_empty']);
            reload = false;
        }else{
            $('#pass1_empty').text("");
        }
        if(data['rules_empty']){
            $('#rules_empty').text(error['rules_empty']);
            reload = false;
        }else{
            $('#rules_empty').text("");
        }
        if(data['email_used']){
            $('#email_used').text(error['email_used']);
            reload = false;
        }else{
            $('#email_used').text("");
        }
        if(data['phone_used']){
            $('#phone_used').text(error['phone_used']);
            reload = false;
        }else{
            $('#phone_used').text("");
        }
        if(!data['pass_match']){
            $('#pass_match').text(error['pass_match']);
            reload = false;
        }else{
            $('#pass_match').text("");
        }
        if(!data['pass_correct']){
            $('#pass_correct').text(error['pass_correct']);
            reload = false;
        }else{
            $('#pass_correct').text("");
        }
        //validate end
        
        if(reload){
            location.reload();
        }
        
        
    });
});

    
    
$('#login_form').submit(function(e){
    e.preventDefault();
    var form = $(this);
    
    $.post("php/login.php", form.serializeArray())
    .done(function(data){
        
        var reload = true;
        //validate
        if(data['email_empty']){
            $('#email_empty_login').text(error['email_empty']);
            reload = false;
        }else{
            $('#email_empty_login').text("");
        }
        if(data['pass_empty']){
            $('#empty_pass').text(error['pass_empty']);
            reload = false;
        }else{
            $('#empty_pass').text("");
        }
        if(!data['pass_correct']){
            $('#wrong_pass').text(error['wrong_pass']);
            reload = false;
        }else{
            $('#wrong_pass').text("");
        }
        
        if(reload){
            location.reload();
        }
        
    });
    
});
    
    
$('#settings_form').submit(function(e){
    e.preventDefault();
    var $form = $(this);
    
    $.post("php/settings.php", $form.serializeArray())
    .done(function(data){
        
        var reload = true;
        //email
        if(data['email_used']){
            $('#s_email_used').text(error['email_used']);
            reload = false;
        }
        else{
            $('#s_email_used').text('');
        }
        //phone
        if(data['phone_used']){
            $('#s_phone_used').text(error['phone_used']);
            reload = false;
        }
        else{
            $('#s_phone_used').text('');
        }
        //nip
        if(data['nip_used']){
            $('#s_nip_used').text(error['nip_used']);
            reload = false;
        }
        else{
            $('#s_nip_used').text('');
        }
        //pass
        if(!data['pass_match']){
            $('#s_pass_match').text(error['pass_match']);
            reload = false;
        }
        else{
            $('#s_pass_match').text('');
        }
        
        if(!data['pass_correct']){
            $('#s_pass_correct').text(error['pass_correct']);
            reload = false;
        }
        else{
            $('#s_pass_correct').text('');
        }
        
        
        
        if(reload){
            location.reload();
        }
        
    });
    
});
    
    
    
    
});