<div id="accept_parcel_offer">
<?php
include_once "php/functions.php";
if(isset($_GET['offer'])){
    $offer = getOffer($_GET['offer']);
    if($offer != null){
        if($_SESSION['logged']){
            if($_SESSION['id'] == getParcel($offer->getFor_id())->getAuthor()){
    ?>    
    <div class="title">Akceptacja oferty:</div>
    <div class="info">SpeedMTrans pobiera  10% prowizji od akceptacji oferty. Po  uiszczeniu opłaty otrzymasz dane kontaktowe do przewoźnika na swój adres email. Dalszy przebieg transakcji nie jest kontrolowany przez nasz serwis nie ponosimy odpowiedzialności za dalsze rozliczenia między Tobą i przewoźnikiem.</div>
    <br>
    <div class="offer_wrapper">
       <div class="title">Cena: <?php echo $offer->getPrice(); ?>zł</div>
        <hr>
        <div class="info">
            <b>Przewoźnik: </b> <a href="?id=6&profile=<?php echo $offer->GetAuthor(); ?>"><span class="show_profile"><?php echo getUserNameWithOpinions($offer->GetAuthor()); ?></span></a>
        </div>
        <div class="info">
            <b>Dodano: </b> <?php echo gmdate('d.m.Y H:i', $offer->getAdd_date());?>
        </div>
        <div class="info">
            <b>Załadunek: </b> <?php echo date('d.m.Y', $offer->getLoading_f()); ?> - <?php echo date('d.m.Y', $offer->getLoading_t()); ?>
        </div>
        <div class="info">
            <b>Czas transportu: </b> <?php echo $offer->getTransport_time(); ?>
        </div>
        <div class="info">
            <b>Sposób transportu: </b> <?php echo $offer->getTransport_type(); ?>
        </div>
        <div class="info">
            <b>Opis oferty: </b> <?php echo $offer->getAbout(); ?>
        </div>
</div><br>
    
    <form id="p24_form" action="php/payment.php" method="post">
        <input name="type" value="parcel" hidden/>
        <input name="id" value="<?php echo $_GET['offer']; ?>" hidden/>
    <input type="submit" value="Akceptuj i zapłać" id="akceptuj" class="fancy_button"/>
	</form>
    
    
    
    
    
    
   <?php
            }
            else{
                echo "<div class='title'>Niemozesz zaakceptowac nie swojej oferty!</div>";
            }
        }
        else{
            echo "<div class='title'>Zaloguj się!</div>";
        }
    }
    else{
        echo "<div class='title'>Nie znaleziono oferty!</div>";
    }
}
?>
</div>