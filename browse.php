    <div class="table_wrapper">
        <div class="categories">
            <div class="title">Kategorie</div>
            
            <input type="checkbox" id="chbox_free_loads_m" class="chbox" 
            <?php if(!isset($_GET['category'])){
                echo 'checked';
            } 
            else if($_GET['category'] === 'loads'){
                echo 'checked';      
            }?> 
                   
                      
            ></input>
            <label class="category" for="chbox_free_loads_m">Ładunki</label>
            <br>
            
            <input type="checkbox" id="chbox_vehicles_m" class="chbox"             <?php
                   if(isset($_GET['category'])){
                       if($_GET['category'] === 'vehicles'){
                        echo 'checked';
                       }
                   }
                ?>
            >
            <label class="category" for="chbox_vehicles_m">Wolne pojazdy</label>
            <br>
            
            <hr class="yellow_line" />
            
            <input type="checkbox" id="chbox_furniture_m" class="chbox"
                <?php
                   if(isSelected('furniture')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_furniture_m">Meble</label>
            <br>
            
            <input type="checkbox" id="chbox_moving_m" class="chbox"
                <?php
                   if(isSelected('moving')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_moving_m">Przeprowadzki</label>
            <br>
            
            <input type="checkbox" id="chbox_cars_m" class="chbox"
                <?php
                   if(isSelected('cars')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_cars_m">Samochody</label>
            <br>
            
            <input type="checkbox" id="chbox_loads_m" class="chbox"
                <?php
                   if(isSelected('loads')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_loads_m">Ładunki</label>
            <br>
            
            <input type="checkbox" id="chbox_boxes_m" class="chbox"
                <?php
                   if(isSelected('boxes')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_boxes_m">Paczki</label>
            <br>
            
            <input type="checkbox" id="chbox_motocycles_m" class="chbox"
                <?php
                   if(isSelected('motocycles')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_motocycles_m">Motocykle i skutery</label>
            <br>
            
            <input type="checkbox" id="chbox_other_vehicles_m" class="chbox"
                <?php
                   if(isSelected('other_vehicles')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_other_vehicles_m">Pojazdy inne</label>
            <br>
            
            <input type="checkbox" id="chbox_care_m" class="chbox"
                <?php
                   if(isSelected('special_care')) echo 'checked';
                ?>
                   >
            <label class="category" for="chbox_care_m">Specjalnej ostrożności</label>
            <br>
            
            <input type="checkbox" id="chbox_other_m" class="chbox"
                <?php
                   if(isSelected('other')) echo 'checked';
                ?>>
            <label class="category" for="chbox_other_m">Inne przesyłki</label>
            <br>
            
            <hr class="yellow_line" />
            
            <div class="text_about">Waga [Kg]</div>
                <span class="text">Od:</span>
                <input value="<?php 
                if(isset($_GET['weight_min'])){
                    $val = $_GET['weight_min'];
                    echo $val;
                }
                ?>"
                 type="number" id="weight_min_m" class="input weight"><br>
                <span class="text">Do:</span>
                <input value="<?php 
                if(isset($_GET['weight_max'])){
                    $val = $_GET['weight_max'];
                    echo $val;
                }
                ?>" type="number" class="input weight" id="weight_max_m">
            
            
        </div>    
        
        <?php
        
        $category = 'parcels';
        if(isset($_GET['category'])){
            if($_GET['category'] === 'vehicles'){
                $category = 'vehicles';
            }
        }

//loads categories
        $cat = array();
        $cat['furniture'] = getCategory('furniture');
        $cat['moving'] = getCategory('moving');
        $cat['cars'] = getCategory('cars');
        $cat['loads'] = getCategory('loads');
        $cat['boxes'] = getCategory('boxes');
        $cat['motocycles'] = getCategory('motocycles');
        $cat['other_vehicles'] = getCategory('other_vehicles');
        $cat['special_care'] = getCategory('special_care');
        $cat['other'] = getCategory('other');
        $cat['weight_min'] = -1;
        $cat['weight_max'] = -1;
        if(isset($_GET['weight_min'])){
            if(!($_GET['weight_min'] === '')){
                $cat['weight_min'] = $_GET['weight_min'];
            }
        }
        if(isset($_GET['weight_max'])){
            if(!($_GET['weight_max'] === '')){
                $cat['weight_max'] = $_GET['weight_max'];
            }
        }

//curr page
        if(!isset($_GET['page'])){
            $_GET['page'] = 1;
        }
        $curr_page = $_GET['page'];        
        
//max pages
        $parcels_amount = getParcelsAmount($cat['furniture'], $cat['moving'], $cat['cars'], $cat['loads'], $cat['boxes'], $cat['motocycles'], $cat['other_vehicles'], $cat['special_care'], $cat['other'], $cat['weight_min'], $cat['weight_max']);

        $pages = ceil($parcels_amount / $items_per_site);
        
        if($category === 'vehicles'){
                $vehicles_amount = getVehiclesAmount();
                $pages = ceil($vehicles_amount / $items_per_site);
        }
        
//load items
        $offset = ($items_per_site * $curr_page) - $items_per_site;
        
        if($category === 'parcels'){
            $items = getParcels($items_per_site, $offset, $cat['furniture'], $cat['moving'], $cat['cars'], $cat['loads'], $cat['boxes'], $cat['motocycles'], $cat['other_vehicles'], $cat['special_care'], $cat['other'], $cat['weight_min'], $cat['weight_max']);
        }
        else{
            $items = getVehicles($items_per_site, $offset);
        }
        

        ?>
        
        <div class="table">
            <div class="nav_wrapper">
                <div class="categories_apk button" id="categories_open">
                    Kategorie    
                </div>
                <span id="before1" <?php if($curr_page > 1){echo "style='display: inline-block;'"; } ?> class="before">&lt;</span>
                <span class="table_curr"><?php echo $curr_page; ?></span>
                <span class="from">z</span>
                <span class="table_all"><?php echo $pages; ?></span>
                <span id="next1" <?php if($curr_page == $pages){echo "style='display: none;'"; } ?> class="next">&gt;</span>
            </div>
            
            <table cellpadding="0" cellspacing="0">
                <?php if(count($items) > 0){ ?>
                <tr>
                    <th>Trasa</th>
                    <th>Opis</th>
                    <th>Dodano</th>
                    <th>Oferty</th>
                </tr>
                
                <?php
                }
        //show items
                //parcels
                if(count($items) == 0){
                    echo "Brak przedmiotów do wyświetlenia!";
                 }
                if($category === 'parcels'){
                    
                    foreach($items as $item){
                        
                        $id = $item->getId();
                        $from = $item->getLoc_start();
                        $to = $item->getLoc_end();
                        $type = $item->getCategory();
                        $weight = $item->getWeight();
                        $length = $item->getLength();
                        $width = $item->getWidth();
                        $height = $item->getHeight();
                        $add_time = $item->getAdd_date();
                        $offers = 0;
                        
                        ?>
                <tr class="light_up" data-href="?id=5&parcel=<?php echo $id; ?>">
                    <td class="route">
                        <img src="<?php
                        switch($type){
                            case "furniture":
                                echo "images/furniture.png";
                                break;
                            case "moving":
                                echo "images/moving.png";
                                break;
                            case "cars":
                                echo "images/car.png";
                                break;
                            case "loads":
                                echo "images/box.png";
                                break;
                            case "boxes":
                                echo "images/box.png";
                                break;
                            case "motocycles":
                                echo "images/motocycle.png";
                                break;
                            case "other_vehicles":
                                echo "images/other_vehicles.png";
                                break;
                            case "special_care":
                                echo "images/special_care.png";
                                break;
                            case "other":
                                echo "images/other.png";
                                break;
                        }
                        
                        ?>" />    
                        <div class="loc">
                            <div class="overwrapper"><span class="title">Z:</span><?php echo $from->getCity(); ?>, <?php echo $from->getCountry(); ?></div><br>
                            <div class="overwrapper"><span class="title">D:</span> <?php echo $to->getCity(); ?>, <?php echo $to->getCountry(); ?> </div>
                        </div>
                        <div style="clear: both"></div>
                    </td>
                    <td class="desc">
                        
                        <span class="title">Rodzaj:</span> <?php 
                        
                        switch($type){
                            case "furniture":
                                echo "Meble";
                                break;
                            case "moving":
                                echo "Przeprowadzki";
                                break;
                            case "cars":
                                echo "Samochody";
                                break;
                            case "loads":
                                echo "Ładunki";
                                break;
                            case "boxes":
                                echo "Paczki";
                                break;
                            case "motocycles":
                                echo "Motocykle";
                                break;
                            case "other_vehicles":
                                echo "Pojazdy";
                                break;
                            case "special_care":
                                echo "Specjalnej ostrożności";
                                break;
                            case "other":
                                echo "Inne";
                                break;
                        }
                        
                        
                        ?> <br> 
                        <span class="title">Waga:</span> <?php echo $weight; ?>kg <br>
                        <span class="title">Wymiary:</span> <?php echo $width; ?>x<?php echo $height; ?>x<?php echo $length; ?>cm
                    
                    </td>
                    
                    <td class="date"><?php echo date('d-m-Y', $add_time); ?> <br> <?php echo date('H:i', $add_time); ?></td>
                    <td class="offer"><?php echo getOffersAmountFor($id); ?></td>
                </tr>
                        <?php
                        
                    }
                    
                    
                }
                //vehicles
                else{
                    foreach($items as $item){
                        $id = $item->getId();
                        $capacity = $item->getCapacity();
                        $pallets = $item->getPallets();
                        $add_date = $item->getAdd_date();
                        $from = $item->getLoc_start();
                        $to = $item->getLoc_end();
                        
                        ?>
                
                    <tr class="light_up" data-href="?id=7&vehicle=<?php echo $id; ?>">
                    <td class="route">
                        <img src="images/car.png" />    
                        <div class="loc">
                            <span class="title">Z:</span> <?php echo $from->getCity(); ?>, <?php echo $from->getCountry(); ?><br>
                            <span class="title">D:</span> <?php echo $to->getCity(); ?>, <?php echo $to->getCountry(); ?>
                        </div>
                        <div style="clear: both"></div>
                    </td>
                    <td class="desc">
                        
                        <span class="title">Ładowność:</span> <?php echo $capacity; ?> t<br> 
                        <span class="title">Ilość palet:</span> <?php echo $pallets; ?> <br>
                    
                    </td>
                    
                    <td class="date"><?php echo date('d-m-Y', $add_date); ?> <br> <?php echo date('H:i', $add_date); ?></td>
                    <td class="offer"><?php echo getVehicleOffersAmountFor($id); ?></td>
                </tr>
                
                    <?php
                        
                    }
                }
                ?>
                
                
            </table>
                        
            <div class="nav_wrapper">
                <span id="before2" <?php if($curr_page > 1){echo "style='display: inline-block;'"; } ?> class="before">&lt;</span>
                <span class="table_curr"><?php echo $curr_page; ?></span>
                <span class="from">z</span>
                <span class="table_all"><?php echo $pages; ?></span>
                <span id="next2" <?php if($curr_page == $pages){echo "style='display: none;'"; } ?> class="next">&gt;</span>
            </div>
            
        </div>
        <div style="clear: both"></div>
    </div>