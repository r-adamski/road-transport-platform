<?php
//    print phpinfo();

	session_start();
	include_once "php/functions.php";
    
    if(!isset($_SESSION['logged'])){
        $_SESSION['logged'] = false;
    }
    
    if(isset($_GET['logout'])){
        $_SESSION['logged'] = false;
        Header('Location: '.$_SERVER['PHP_SELF']);
    }
    
    
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    else{
        $id=0;
        $_GET['id'] = 0;
    } 

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title>SpeedMTrans</title>
    
    <!-- meta -->
	<meta charset="utf-8" />
	<meta name="description" content="SpeedMTrans - Giełda transportowa!"/>
	<meta name="keywords"  content="" />
    <meta name="author" content="Rafał Adamski">
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
    
    <!-- script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/form_handle.js"></script>
    <script src="js/jquery.datetimepicker.full.min.js"></script>
    
    <!-- link -->
    <link rel="stylesheet" href="css/style.css"><!-- basic Main css -->
    <link rel="stylesheet" href="css/pop_ups.css"><!-- pop_ups css -->
    <link rel="stylesheet" href="css/sub_sites.css"><!-- sub_sites css-->
    <link rel="stylesheet" href="css/jquery.datetimepicker.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700&subset=latin-ext" rel="stylesheet">
    
</head>
    
<body>
    <div style="position: relative; min-height: calc(100% - 250px);">
    <!-- pop_ups -->
    
    <div id="popup_bg">
        
        <!-- email confirm -->
        <?php 
        if(isset($_SESSION['id'])){
        if(!isEmailConfirmed($_SESSION['id']) && $_SESSION['logged']){?>
            <script>alert("Potwierdź swój adres email!");</script>
        <?php }} ?>
        
        <!-- register -->
            <div class="popup" id="register_popup">
                <img src="images/close.png" class="close" />
                <div class="title">Dołącz do nas!</div>
                
                <form Id="register_form">
                    <span class="input_about">Imię i Nazwisko</span>
                    <input name="name" type="text" placeholder="Adam Kowalski">
                        <span id="name_empty" class="error"></span>
                    <span class="input_about">Email</span>
                    <input name="email" type="email" placeholder="abc@gmail.com">
                        <span id="email_empty" class="error"></span>
                        <span id="email_used" class="error"></span>
                    <span class="input_about">Nr telefonu</span>
                    <input name="phone" type="number" placeholder="123 123 123">
                        <span id="phone_empty" class="error"></span>
                        <span id="phone_used" class="error"></span>
                    <span class="input_about">Hasło</span>
                    <input name="pass" type="password" placeholder="********">
                        <span id="pass_empty" class="error"></span>
                        <span id="pass_correct" class="error"></span>
                    <span class="input_about">Powtórz hasło</span>
                    <input name="pass_again" type="password" placeholder="********">
                        <span id="pass1_empty" class="error"></span>
                        <span id="pass_match" class="error"></span>
                    
                    <span class="input_about">Formy płatności&#42;</span>
                    <input name="payment" type="text" placeholder="przelew, paypal etc.">
                    <span class="input_about">Zasięg&#42;</span>
                    <input name="range" type="text" placeholder="Warszawa i okolice do 50km">
                    <span class="input_about">Nip&#42;</span>
                    <input name="nip" type="text" placeholder="1234 1324 1234 1234 1234">
                    <span class="input_about">Nazwa firmy&#42;</span>
                    <input name="company_name" type="text" placeholder="SpeedMTrans">
                    
                    <div class="wrapper">
                        <input id="terms_accept" class="chbox" name="rules" type="checkbox">
                        <label class="category" style="color: white; font-size: 13px" for="terms_accept">
                            Akceptuje <u>regulamin</u> i ble ble costam jeszcze</label>
                    </div>
                        <span id="rules_empty" class="error"></span>
                    * - pole nieobowiązkowe<br>
                    <input name="register" id="register_button" type="submit" value="Zarejestruj">
                    
                </form>
                
            </div>
    
        
        <!-- login -->
        <div class="popup" id="login_popup">
            <img src="images/close.png" class="close" />
            
            <div class="title">Zaloguj się!</div>
            
            <form Id="login_form">
                <span class="input_about">Email</span>
                <input name="email" type="email" placeholder="abc@gmail.com">
                <span id="email_empty_login" class="error"></span>
                <span class="input_about">Hasło</span>
                <input name="pass" type="password" placeholder="********">
                <span id="empty_pass" class="error"></span>
                <span id="wrong_pass" class="error"></span>
                
                <span class="lost_pass">Nie pamiętam hasła</span>
                
                <input name="login" id="login_button" type="submit" value="Zaloguj">
                
            </form>
            
        </div>
        
        
        <!-- add comment -->
        <div class="popup" id="comment_popup">
            <img src="images/close.png" class="close" />
            <?php if($_SESSION['logged'] == true){ ?>
            <div class="title">Dodaj komentarz!</div>
            
            <form id="comment_form">
                
                <input name="offer_id" id="comment_offer_id" value="" type="hidden">
                
                <input name="offer_type" value="<?php if(isset($_GET['parcel'])){ echo "parcel"; } else { echo "vehicle";}?>" type="hidden">
                
                <span class="input_about comment_fix">Komentarz:</span>
                <textarea name="comment"></textarea>
                <span id="comment_empty" class="error"></span>
                
                <input name="add" id="comment_add_button" type="submit" value="Dodaj">
                
            </form>
            <?php } else{ ?>
                <div class="title">Zaloguj się aby dodać komentarz!</div>
            <?php } ?>
            
        </div>
        
        <!-- edit comment -->
        <div class="popup" id="comment_edit_popup">
            <img src="images/close.png" class="close" />
            <?php if($_SESSION['logged'] == true){ ?>
            <div class="title">Edytuj komentarz!</div>
            
            <form id="comment_edit_form">
                
                <input name="comment_id" id="comment_id" value="" type="hidden">
                
                <span class="input_about comment_fix">Komentarz:</span>
                <textarea id="comment_edit_placeholder" name="comment"></textarea>
                <span id="comment_edit_empty" class="error"></span>
                
                <input name="add" id="comment_edit_button" type="submit" value="Zapisz">
                
            </form>
            <?php } else{ ?>
                <div class="title">Zaloguj się aby edytować komentarz!</div>
            <?php } ?>
            
        </div>
        
        <!-- add offer -->
        <div class="popup" id="offer_popup">
            <img src="images/close.png" class="close" />
            <?php if($_SESSION['logged'] == true){ ?>
            <div class="title">Dodaj ofertę!</div>
            
            <form id="offer_form">
                <?php if($_GET['id'] == 5){?>
                <input name="parcel_id" value="<?php echo $_GET['parcel']; ?>" type="hidden">
                <?php } ?>
                
                <span class="input_about">Cena(pln)</span>
                <input name="price" type="number">
                <span id="offer_price_empty" class="error"></span>
                
                <span class="input_about">Czas transportu</span>
                <input name="transport_time" type="text">
                <span id="offer_time_empty" class="error"></span>
                
                <span class="input_about">Sposób transportu</span>
                <input name="transport_type" type="text">
                <span id="offer_type_empty" class="error"></span>
            
                <span class="input_about">Załadunek od</span>
                <input id="offer_date_f" name="date_f" type="text">
                <span id="offer_date_f_empty" class="error"></span>
                
                <span class="input_about">Załadunek do</span>
                <input id="offer_date_t" name="date_t" type="text">
                <span id="offer_date_t_empty" class="error"></span>
                <span id="offer_date_error" class="error"></span>
                
                <span class="input_about about_fix">Opis</span>
                <textarea name="about"></textarea>
                <span id="offer_about_empty" class="error"></span>
                
                <input name="add" id="add_button" type="submit" value="Dodaj">
                
            </form>
            <?php } else{ ?>
                <div class="title">Zaloguj się aby dodać ofertę!</div>
            <?php } ?>
            
        </div>
        
        <!-- add vehicle offer -->
        <div class="popup" id="vehicle_offer_popup">
            <img src="images/close.png" class="close" />
            
            <div class="title">Dodaj ofertę!</div>
            
            <form id="vehicle_offer_form">
                <?php if($_GET['id'] == 7){?>
                <input name="vehicle_id" value="<?php echo $_GET['vehicle']; ?>" type="hidden">
                <?php } ?>
                
                <span class="input_about">Cena(pln)</span>
                <input name="price" type="number">
                <span id="vehicle_offer_price_empty" class="error"></span>
                
                <span class="input_about">Waga[kg]</span>
                <input name="weight" type="number">
                <span id="vehicle_offer_weight_empty" class="error"></span>
                
                <span class="input_about">Długosc[m]</span>
                <input name="length" type="number">
                <span id="vehicle_offer_length_empty" class="error"></span>
                
                <span class="input_about">Wysokość[m]</span>
                <input name="height" type="number">
                <span id="vehicle_offer_height_empty" class="error"></span>
                
                <span class="input_about">Szerokość[m]</span>
                <input name="width" type="number">
                <span id="vehicle_offer_width_empty" class="error"></span>
            
                <span class="input_about">Załadunek od</span>
                <input id="vehicle_offer_date_f" name="date_f" type="text">
                <span id="vehicle_offer_date_f_empty" class="error"></span>
                
                <span class="input_about">Załadunek do</span>
                <input id="vehicle_offer_date_t" name="date_t" type="text">
                <span id="vehicle_offer_date_t_empty" class="error"></span>
                
                <span class="input_about about_fix">Opis</span>
                <textarea name="about"></textarea>
                <span id="vehicle_offer_about_empty" class="error"></span>
                
                <input name="add" id="add_button" type="submit" value="Dodaj">
                
            </form>
            
        </div>
        
        <!-- edit profile -->
        <?php if($_SESSION['logged']){?>
        <div class="popup" id="settings_popup">
            <img src="images/close.png" class="close" />
            
            <div class="title">Ustawienia profilu</div>
            
            <form Id="settings_form">
            <span class="input_about">Imię i nazwisko</span>
            <input name="name" type="text" placeholder="<?php
                    $name = getName($_SESSION['id']);  
                    if($name === ""){ echo "Imię i Nazwisko";}
                    else{ echo $name;}
                ?>
            ">
                <!--<span class="error">Blebleble</span>-->
            <span class="input_about">Email</span>
            <input name="email" type="email" placeholder="<?php
                    $email = getEmail($_SESSION['id']);  
                    if($email === ""){ echo "Adres email";}
                    else{ echo $email;}
                ?> 
            ">
            <span id="s_email_used" class="error"></span>
                <!--<span class="error">Blebleble</span>-->
            <span class="input_about">Nr telefonu</span>
            <input name="tel" type="number" placeholder="<?php
                    $tel = getTel($_SESSION['id']);  
                    if($tel === ""){ echo "Numer telefonu";}
                    else{ echo $tel;}
                ?>
            ">
            <span id="s_pgone_used" class="error"></span>
                <!--<span class="error">Blebleble</span>-->
            <span class="input_about">Nowe hasło</span>
            <input name="new_pass" type="password" placeholder="Nowe hasło">
                <span id="s_pass_correct" class="error"></span>
                <!--<span class="error">Blebleble</span>-->
                <span class="input_about">Powtórz nowe hasło</span>
            <input name="new_pass_repeat" type="password" placeholder="Powtórz nowe hasło">
                <span id="s_pass_match" class="error"></span>
                <!--<span class="error">Blebleble</span>-->
            
            <!-- for drivers -->
            <span class="for_drivers"><span>&gt;</span> Dla kierowców</span>
                <span class="input_about">Formy płatności</span>
            <input name="payments" type="text" placeholder="<?php
                    $payment = getPayment($_SESSION['id']);  
                    if($payment === ""){ echo "Formy płatności";}
                    else{ echo $payment;}
                ?>">
                <!--<span class="error">Blebleble</span>-->
                <span class="input_about">Zasięg</span>
            <input name="range" type="text" placeholder="<?php
                    $scope = getScope($_SESSION['id']);  
                    if($scope === ""){ echo "Zasięg";}
                    else{ echo $scope;}
                ?>">
                <!--<span class="error">Blebleble</span>-->
                <span class="input_about">Nip</span>
            <input name="nip" type="text" placeholder="<?php
                    $nip = getNip($_SESSION['id']);  
                    if($nip === ""){ echo "Nip";}
                    else{ echo $nip;}
                ?>">
                <span id="s_nip_used" class="error"></span>
                <!--<span class="error">Blebleble</span>-->
                <span class="input_about">Nazwa firmy</span>
            <input name="company" type="text" placeholder="<?php
                    $company = getCompany($_SESSION['id']);  
                    if($company === ""){ echo "Nazwa firmy";}
                    else{ echo $company;}
                ?>">
                <!--<span class="error">Blebleble</span>-->
            
            <div class="invoice">
                <span>Faktury:</span> 
                <input name="invoice" type="checkbox" id="chbox_invoice" class="chbox" 
                       <?php
                       $invoices = giveInvoices($_SESSION['id']);
                       if($invoices){echo "checked";}
                       ?>
                       >
                <label class="category" for="chbox_invoice"></label>
            </div>
            
            
            <input name="save" id="save_button" type="submit" value="Zapisz">
                
            </form>
            
        </div>
        <?php }?>
    </div>
    
    
    <!-- header -->
    <div id="header">
        <div class="container">
            <img class="logo" src="images/Logo.png" />
            
            <!-- normal view -->
            <div class="dropdown">
                <a href="s"><img class="language" src="images/flag-pl.png" /></a>
                <div class="dropdown-content">
                    <a href="#"><img class="language-content" src="images/flag-eng.png" /></a>
                </div>
            </div>
            <!-- not logged -->
            <?php 
            if($_SESSION['logged'] == false){
            ?>
                <div id="login" class="button login">Zaloguj się</div>
                <div id="register" class="button register">Zarejestruj się</div
            <?php
            }
            else{
            ?>
            <!-- logged -->
            
            <a class="logout" href="?logout"><span>Wyloguj</span></a>
            <!--<img class="messages" src="images/messages.png" />-->
            <img id="settings" class="settings" src="images/settings.png" />
                    <span class="welcome">Witaj, <a href="?id=6&profile=<?php echo $_SESSION['id']; ?>"><span class="show_profile" ><?php echo getName($_SESSION['id']); ?></span></a></span>
            <img class="avatar" src="images/avatar.png" />
            <div class="to_disable" style="clear: both" ></div>
            <?php
            }
            ?>
                
            
            <!-- mobile -->
            <img id="mobile_menu" src="images/mobile_menu.png" />
            
            <div id="apk_menu">
                <!-- not logged -->
                <div class="dropdown_apk">
                    <a href="s"><img class="language" src="images/flag-pl.png" /></a>
                    <div class="dropdown-content">
                        <a href="#"><img class="language-content" src="images/flag-eng.png" /></a>
                    </div>
                 </div>
                
                <!-- not logged -->
                <?php 
                    if($_SESSION['logged'] == false){
                ?>
                <div id="login_m" class="button login_apk">Zaloguj się</div>
                <div id="register_m" class="button register_apk">Zarejestruj się</div>
                <?php
                    }
                    else{
                ?>
                <!-- logged -->
                
                <a class="logout_m" href="#"><span>Wyloguj</span></a>
                <img class="messages_m" src="images/messages.png" />
                <img id="settings_m" class="settings_m" src="images/settings.png" />
                <img class="avatar_m" src="images/avatar.png" />
                <?php
                    }
                ?>
                
                <div style="clear: both"></div>
                
                
                
                <div class="menu">
                <ul>
                    <a href="?id=0"><li>Strona główna</li></a>
                    <a href="?id=1"><li>Przeglądaj oferty</li></a>
                    <a href="?id=2"><li>Wystaw ofertę</li></a>
                    <a href="?id=3"><li>Pomoc</li></a>
                    <div style="clear: both"></div>
                </ul>
                </div>
                
                
            <div class="categories_apk_wrapper">
            
            <input type="checkbox" id="chbox_free_loads" class="chbox"
                   <?php if(!isset($_GET['category'])){
                echo 'checked';
            } 
            else if($_GET['category'] === 'loads'){
                echo 'checked';      
            }?> 
                   >
            <label class="category" for="chbox_free_loads">Ładunki</label>
            <br>
            
            <input type="checkbox" id="chbox_vehicles" class="chbox"
                   <?php
                   if(isset($_GET['category'])){
                       if($_GET['category'] === 'vehicles'){
                        echo 'checked';
                       }
                   }
                ?>
                   >
            <label class="category" for="chbox_vehicles">Wolne pojazdy</label>
            <br>
            
            <hr/>
            
            <input type="checkbox" id="chbox_furniture" class="chbox"
                   <?php
                   if(isSelected('furniture')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_furniture">Meble</label>
            <br>
            
            <input type="checkbox" id="chbox_moving" class="chbox"
                   <?php
                   if(isSelected('moving')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_moving">Przeprowadzki</label>
            <br>
            
            <input type="checkbox" id="chbox_cars" class="chbox"
                   <?php
                   if(isSelected('cars')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_cars">Samochody</label>
            <br>
            
            <input type="checkbox" id="chbox_loads" class="chbox"
                   <?php
                   if(isSelected('loads')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_loads">Ładunki</label>
            <br>
            
            <input type="checkbox" id="chbox_boxes" class="chbox"
                   <?php
                   if(isSelected('boxes')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_boxes">Paczki</label>
            <br>
            
            <input type="checkbox" id="chbox_motocycles" class="chbox"
                   <?php
                   if(isSelected('motocycles')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_motocycles">Motocykle i skutery</label>
            <br>
            
            <input type="checkbox" id="chbox_other_vehicles" class="chbox"
                   <?php
                   if(isSelected('other_vehicles')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_other_vehicles">Pojazdy inne</label>
            <br>
            
            <input type="checkbox" id="chbox_care" class="chbox"
                   <?php
                   if(isSelected('special_care')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_care">Specjalnej ostrożności</label>
            <br>
            
            <input type="checkbox" id="chbox_other" class="chbox"
                   <?php
                   if(isSelected('other')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_other">Inne przesyłki</label>
            <br>
            
                            
            <hr/>
            
            <div class="text_about">Waga [Kg]</div>
                <span class="text_apk">Od:</span>
                <input value="<?php 
                if(isset($_GET['weight_min'])){
                    $val = $_GET['weight_min'];
                    echo $val;
                }
                ?>" type="number" class="input weight" id="weight_min" /><br>
                <span class="text_apk">Do:</span>
                <input value="<?php 
                if(isset($_GET['weight_max'])){
                    $val = $_GET['weight_max'];
                    echo $val;
                }
                ?>" type="number" class="input weight" id="weight_max" />
            
            
        </div>
                
                
                <!-- logged -->
                
            </div>
            
            
            <div class="clear"></div>
        </div>
    </div>
     <!-- menu -->
    <div class="menu_wrapper">
            <ul>
                <a href="?id=0"><li>Strona główna</li></a>
                <a href="?id=1"><li>Przeglądaj oferty</li></a>
                <a href="?id=2"><li>Wystaw ofertę</li></a>
                <a href="?id=3"><li>Pomoc</li></a>
                <div style="clear: both"></div>
            </ul>
    </div>
    
    <!-- subsites -->
    
    <?php
    
    
switch($id) {
  case 0:
    include "home.php";
    break;
  case 1:
    include "browse.php";
    break; 
  case 2:
    include "new_offer.php";
    break; 
  case 3:
    include "faq.php";
    break; 
  case 4:
    include "about.php";
    break;
  case 5:
    include "parcel_info.php";
    break;
  case 6:
    include "profile.php";
    break;
  case 7:
    include "vehicle_info.php";
    break;
case 8:
    include "accept_parcel_offer.php";
    break;
case 9:
    include "accept_vehicle_offer.php";
    break;
}
        
    ?>
    
    
    <!-- footer -->
    <div id="footer">
        <div class="wrapper">
            <div class="left">
                <img src="images/Logo.png" /><br>
                <a href="https://pbs.twimg.com/profile_images/608171437644521472/IKJvTdBN.jpg" target="_blank"><span class="menu">Regulamin</span></a>
                <a href="?id=3"><span class="menu">Pomoc</span></a>
                <a href="?id=4"><span class="menu">O nas</span></a>
            </div>
            <div class="left center kontakt">
                <span class="title">Kontakt</span><br>
                    123-123-123<br>
                    abcde@mtrans.com
            </div>
            <div class="left community center">
                Społeczność<br>
                <a href="#" target="_blank"><img class="social_ico" src="images/facebook.png" /></a>
                <a href="#" target="_blank"><img class="social_ico" src="images/instagram.png" /></a>
                <a href="#" target="_blank"><img class="social_ico" src="images/twitter.png" /></a>
            </div>
            <div style="clear: both"></div>
            <div class="dev">&copy; Copyright 2017 SpeedMTrans | Developed by Rafał Adamski</div>
        </div>
    </div>
        </div>
</body>
</html>