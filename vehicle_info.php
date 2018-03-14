<div id="offer_info">
<?php
    include_once "php/functions.php";
    $vehicle_id = -1;
    if(isset($_GET['vehicle'])){
        $vehicle_id = $_GET['vehicle'];
    }
    
    $vehicle = getVehicle($vehicle_id);
    if($vehicle == null){
        echo "<div class='title'>Nie znaleziono oferty!</div>";
    }
else{
?>


<div class="content_wrapper">
    <div class="left">
        <div class="title"><?php echo $vehicle->getTitle();?></div>
        <hr>
        <div class="route_wrapper">
            <b>Z: </b> <span id="loc_start"><?php echo $vehicle->getLoc_start()->getCity(); ?>, <?php echo $vehicle->getLoc_start()->getCountry(); ?></span>
            <img src="images/arrow.png" />
            <b>D: </b> <span id="loc_end"><?php echo $vehicle->getLoc_end()->getCity(); ?>, <?php echo $vehicle->getLoc_end()->getCountry(); ?></span>
        </div>
        <div class="info">
            <b>Ładowność: </b> <?php echo $vehicle->getCapacity(); ?>t
        </div>
        <div class="info">
            <b>Ilość palet: </b> <?php echo $vehicle->getPallets(); ?>
        </div>     
        <div class="info">
            <b>Opis: </b> <?php echo $vehicle->getAbout(); ?>
        </div>
        
        <div class="time_wrapper">
            <div class="time">
                <div><b>Start: </b></div>
                <b>Od </b><?php echo gmdate("d.m.Y H.i", $vehicle->getFrom_start_date()); ?><br>
                <b>Do </b><?php echo gmdate("d.m.Y H.i", $vehicle->getFrom_end_date()); ?><br>
            </div>
            <img src="images/arrow.png" />
            <div class="time">
                <div><b>Dojazd: </b></div>
                <b>Od </b><?php echo gmdate("d.m.Y H.i", $vehicle->getTo_start_date()); ?><br>
                <b>Do </b><?php echo gmdate("d.m.Y H.i", $vehicle->getTo_end_date()); ?><br>
            </div>
            <div style="clear: both"></div>  
            
        </div>
        
        <div style="margin-top: 60px" class="info_plus">
            <b>Zleceniodawca: </b> <a href="?id=6&profile=<?php echo $vehicle->getAuthor(); ?>"><span class="show_profile" style="color: darkslateblue;"><?php echo getUserNameWithOpinions($vehicle->GetAuthor()); ?></span></a>
        </div>
        <div class="info_plus">
            <b>Dodano: </b> <?php echo gmdate("d.m.Y H.i", $vehicle->getAdd_date()); ?>
        </div>
        
    </div>
    <div class="right">
        <!--<iframe width="100%" height="400" frameborder="0"
            src="https://www.google.com/maps/embed/v1/directions?origin=place_id:ChIJAZ-GmmbMHkcR_NPqiCq-8HI&destination=place_id:ChIJOfarlrfCuEcRnSytpBHhAGo&key=AIzaSyBGvDd3iDJRkoGNpzwV5pBZnRzQAN8iZEk" allowfullscreen></iframe>-->
        
        <div id="map"></div>
        
        <script>
$(document).ready(function() { 
   initMap(); 
});
            
            
var directionsDisplay;
var directionsService;
var map;


function initMap(){
  directionsService = new google.maps.DirectionsService();
  directionsDisplay = new google.maps.DirectionsRenderer();
  map = new google.maps.Map(document.getElementById('map'));
  directionsDisplay.setMap(map);
    calcRoute();
}

function calcRoute() {
  var start = document.getElementById('loc_start').innerHTML;
  var end = document.getElementById('loc_end').innerHTML;
  var request = {
    origin: start,
    destination: end,
    travelMode: 'DRIVING'
  };
  directionsService.route(request, function(result, status) {
    if (status == 'OK') {
      directionsDisplay.setDirections(result);
    }
  });
}
        </script>
            <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo $maps_api; ?>">
    </script>
    </div>
    <div style="clear: both"></div>
</div>


<?php
     $offers = getVehicleOffersFor($vehicle_id);
     if(count($offers) == 0){
          echo "<div class='title'>Nikt się jeszcze nie zgłosił!</div>";
     }
     else{
         foreach($offers as $offer){
         
         
?>
    
<div class="content_wrapper offer_wrapper">
    <div class="left">
       <div class="title">Cena: <?php echo $offer->getPrice(); ?>zł</div>
        <hr>
        <div class="info">
            <b>Użytkownik: </b> <a href="?id=6&profile=<?php echo $offer->GetAuthor(); ?>"><span class="show_profile"><?php echo getUserNameWithOpinions($offer->GetAuthor()); ?></span></a>
        </div>
        <div class="info">
            <b>Dodano: </b> <?php echo gmdate('d.m.Y H:i', $offer->getAdd_date());?>
        </div>
        <div class="info">
            <b>Załadunek: </b> <?php echo date('d.m.Y', $offer->getLoading_f()); ?> - <?php echo date('d.m.Y', $offer->getLoading_t()); ?>
        </div>
        <div class="info">
            <b>Waga[kg]: </b> <?php echo $offer->getWeight(); ?>
        </div>
        <div class="info">
            <b>Wymiary[cm]: </b> <?php echo $offer->getLength(); ?>x<?php echo $offer->getWidth(); ?>x<?php echo $offer->getHeight(); ?>
        </div>
        
    </div>
    <div class="right">
        <a href="?id=9&offer=<?php echo $offer->getId(); ?>"><div class="fancy_button" id="id_oferty">Zaakceptuj ofertę</div></a>
        <div class="info">
            <b>Opis oferty: </b> <?php echo $offer->getAbout(); ?>
        </div>
    </div>
    <div style="clear: both"></div>
</div>
<?php 
//comments for offer    
    $comments = getCommentsOffersFor('vehicle', $offer->getId());
    $amount = count($comments);
?>
    <div class="comments_wrapper">
        <div class="zip hidden">
            <span class="title">Komentarze(<?php echo $amount; ?>)</span>
            <span class="arrow">&#8681;&#8681;&#8681;</span>
            <div style="clear: both"></div>
        </div>
        <?php foreach($comments as $comment){ 
        if(!($comment->getContent() === "")){ ?>
        
        <div class="comment">
            <a href="?id=6&profile=<?php echo $comment->GetAuthor(); ?>">
            <span class="author show_profile"><?php echo getUserNameWithOpinions(
        $comment->GetAuthor()); ?></span></a>
            <span class="date"><?php echo date('d.m.Y H:i', $comment->getAdd_date());?></span>
            <div class="clear: both"></div>
            <span class="content"><?php echo $comment->getContent(); ?></span>
        </div>
        
        <?php }} ?>
        <div class="fancy_button new_comment <?php echo $offer->getId(); ?>" >Dodaj komentarz</div>
        
        
        
    </div>
<?php
         }
     }
?>
    
    
    
        <div class="fancy_button" id="new_vehicle_offer_button">Dodaj ofertę</div>


<?php
}
    
?>
</div>