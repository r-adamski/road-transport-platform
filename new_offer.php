<div id='new_wrapper'>
<?php
include_once 'php/functions.php';

if(!($_SESSION['logged'] === true)){
    ?>
<div class="error_notify">
    Zaloguj lub zarejestruj się aby dodawać własne oferty!
</div>
<?php
}
else if(isset($_GET['type'])){
    if($_GET['type'] === 'parcel'){
?>  
    
    <form id='add_parcel_form'>
    <div class="form_wrapper">
    <div class="form_part" >
            <div class="title">Dodaj ładunek</div>
    <div class="input_wrapper">
    <span class="category_title">Kategoria: </span>
    <select name="category">
        <option value="furniture">Meble</option> 
        <option value="moving">Przeprowadzki</option>
        <option value="cars">Samochody</option>
        <option value="loads">Ładunki</option>
        <option value="boxes">Paczki</option>
        <option value="motocycles">Motocykle i skutery</option>
        <option value="other_vehicles">Pojazdy inne</option>
        <option value="special_care">Specjalnej ostrożności</option>
        <option value="other">Inne przesyłki</option>
    </select>
        <br><span id="cat_empty" class="error"></span>
    </div><br>

    <div class="input_wrapper">
        <span class="category_title">Tytuł przesyłki: </span>
        <input type="text" name="title" autocomplete="off">
        <br><span id="title_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Długość[cm]: </span>
        <input type="number" name="length" autocomplete="off">
        <br><span id="length_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Szerokość[cm]: </span>
        <input type="number" name="width" autocomplete="off">
        <br><span id="width_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Wysokość[cm]: </span>
        <input type="number" name="height" autocomplete="off">
        <br><span id="height_empty" class="error"></span>
    </div><br>
    
    <div class="input_wrapper">
        <span class="category_title">Waga[kg]: </span>
        <input type="number" name="weight" autocomplete="off">
        <br><span id="weight_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Liczba sztuk: </span>
        <input type="number" name="amount" autocomplete="off">
        <br><span id="amount_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper about_wrapper" >
        <span class="category_title">Opis: </span>
        <textarea name="about"></textarea>
        <br><span id="about_empty" class="error"></span>
    </div><br>
    </div>
        
        
        
    <div class="form_part">
    <div class="title">Nadanie</div>
    
    <div class="input_wrapper">
        <span class="category_title">Kraj: </span>
        <input type="text" name="country" autocomplete="off">
        <br><span id="country_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Województwo: </span>
        <input type="text" name="province" autocomplete="off">
        <br><span id="province_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Miasto: </span>
        <input id="city_from" type="text" name="city" autocomplete="off">
        <br><span id="city_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Kod pocztowy: </span>
        <input type="text" pattern="([0-9]{2}[\-]{1}[0-9]{3})" name="post_code" autocomplete="off">
        <br><span id="post_code_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Ulica: </span>
        <input type="text" name="street" autocomplete="off">
        <br><span id="street_empty" class="error"></span>
    </div><br>
      
    <div class="input_wrapper">
        <span class="category_title">Numer: </span>
        <input type="text" name="number" autocomplete="off">
        <br><span id="number_empty" class="error"></span>
    </div><br>
    
    <div class="input_wrapper">
        <span class="category_title">Termin od: </span>
        <input type="text" id="f_start_date" name="f_start_date" autocomplete="off">
        <br><span id="f_start_date_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Termin do: </span>
        <input type="text" id="f_end_date" name="f_end_date" autocomplete="off">
        <br><span id="f_end_date_empty" class="error"></span>
    </div><br>
        </div>
        
        
        
        
            <div class="form_part">
    <div class="title">Dostawa</div>
    
    <div class="input_wrapper">
        <span class="category_title">Kraj: </span>
        <input type="text" name="to_country"  autocomplete="off">
        <br><span id="to_country_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Województwo: </span>
        <input type="text" name="to_province" autocomplete="off">
        <br><span id="to_province_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Miasto: </span>
        <input type="text" name="to_city" autocomplete="off">
        <br><span id="to_city_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Kod pocztowy: </span>
        <input type="text" pattern="([0-9]{2}[\-]{1}[0-9]{3})" name="to_post_code" autocomplete="off">
        <br><span id="to_post_code_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Ulica: </span>
        <input type="text" name="to_street" autocomplete="off">
        <br><span id="to_street_empty" class="error"></span>
    </div><br>
      
    <div class="input_wrapper">
        <span class="category_title">Numer: </span>
        <input type="text" name="to_number" autocomplete="off">
        <br><span id="to_number_empty" class="error"></span>
    </div><br>
    
    <div class="input_wrapper">
        <span class="category_title">Termin od: </span>
        <input type="text" id="t_start_date" name="t_start_date" autocomplete="off">
        <br><span id="t_start_date_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Termin do: </span>
        <input type="text" id="t_end_date" name="t_end_date" autocomplete="off">
        <br><span id="t_end_date_empty" class="error"></span>
        <br><span id="parcel_date_error" class="error"></span>
    </div>
    </div>
    <div style="clear: both"></div>    
        
    <input class="fancy_button" id="add_parcel_button" type="submit" value="Dodaj">
        </div>
    </form>
    
    
    
<?php
    }
    else if($_GET['type'] === 'vehicle'){
?>
    
    <form id='add_vehicle_form'>
    <div class="form_wrapper">
    <div class="form_part" >
    <div class="title">Dodaj wolny pojazd</div>

    <div class="input_wrapper">
        <span class="category_title">Tytuł: </span>
        <input type="text" name="title" autocomplete="off">
        <br><span id="v_title_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Ładowność[kg]: </span>
        <input type="number" name="capacity" autocomplete="off">
        <br><span id="v_capacity_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Ilość palet: </span>
        <input type="number" name="pallets" autocomplete="off">
        <br><span id="v_pallets_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper about_wrapper" >
        <span class="category_title">Opis: </span>
        <textarea name="about"></textarea>
        <br><span id="v_about_empty" class="error"></span>
    </div><br>
        </div>
    
     <div class="form_part">
    <div class="title">Trasa od:</div>
    
    <div class="input_wrapper">
        <span class="category_title">Kraj: </span>
        <input type="text" name="country" autocomplete="off">
        <br><span id="v_country_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Województwo: </span>
        <input type="text" name="province" autocomplete="off">
        <br><span id="v_province_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Miasto: </span>
        <input id="city_from" type="text" name="city" autocomplete="off">
        <br><span id="v_city_empty" class="error"></span>
    </div><br>
         
         
    <div class="input_wrapper">
        <span class="category_title">Termin od: </span>
        <input type="text" id="v_f_start_date" name="f_start_date" autocomplete="off">
        <br><span id="v_f_start_date_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Termin do: </span>
        <input type="text" id="v_f_end_date" name="f_end_date" autocomplete="off">
        <br><span id="v_f_end_date_empty" class="error"></span>
    </div>
         
    </div>
        
     <div class="form_part">
    <div class="title">Trasa do:</div>
         
    <div class="input_wrapper">
        <span class="category_title">Kraj: </span>
        <input type="text" name="to_country" autocomplete="off">
        <br><span id="v_to_country_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Województwo: </span>
        <input type="text" name="to_province" autocomplete="off">
        <br><span id="v_to_province_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Miasto: </span>
        <input id="city_from" type="text" name="to_city" autocomplete="off">
        <br><span id="v_to_city_empty" class="error"></span>
    </div><br>     
         
    <div class="input_wrapper">
        <span class="category_title">Termin od: </span>
        <input type="text" id="v_t_start_date" name="t_start_date" autocomplete="off">
        <br><span id="v_t_start_date_empty" class="error"></span>
    </div><br>
        
    <div class="input_wrapper">
        <span class="category_title">Termin do: </span>
        <input type="text" id="v_t_end_date" name="t_end_date" autocomplete="off">
        <br><span id="v_t_end_date_empty" class="error"></span>
        <br><span id="vehicle_date_error" class="error"></span>
    </div>
         
    </div>
        
    <div style="clear: both"></div>  
    <input class="fancy_button" id="add_vehicle_button" type="submit" value="Dodaj">
        </div>
    </form>

<?php
    }
}
else{
?>
<div style="display: inline-block;">
    <div class="title">Co chciałbyś wystawić?</div>
    <div id='parcel_choose' class="choose">Ładunek</div>
    <div id='vehicle_choose' style="margin-left: 20px;" class="choose">Wolny pojazd</div>
    <div style="clear: both"></div>
</div>
<?php
}
?>
</div>