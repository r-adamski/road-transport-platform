<div id="profile_info">
<?php
    include_once "php/functions.php";
    
    if(isset($_GET['profile'])){
        $profile_id = $_GET['profile'];
        
        $profile = getProfile($profile_id);
        if($profile == null){
            echo "<div class='title'>Nie znaleziono profilu!</div>";
        }
        else{
            
            $positive = $profile->getPositive();
            $neutral = $profile->getNeutral();
            $negative = $profile->getNegative();
            
            $all = $positive + $neutral + $negative;
            if($all == 0){
                $all = 1;
            }
            
            $positive_per = round((($positive / $all) * 100));
            $neutral_per = round((($neutral / $all) * 100));
            $negative_per = round((($negative / $all) * 100));
            
            $opinions = getLastOpinions($profile_id);
            if(isset($_GET['opinions'])){
                if($_GET['opinions'] === "all"){
                    $opinions = getAllOpinions($profile_id);
                }
            }
            
         ?>
            
    <div class="wrapper">
    <div class="left">
    <div class="head">
        
        <img style="float: left;" src="images/avatar.png" />
        
        <div style="float: left;">
            <span class="name"><?php echo $profile->getName(); ?></span><br>
            <span class="register_date">Data rejestracji: <?php echo date('d.m.Y', $profile->getRegister_date()); ?></span>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div class="option">Zasięg: <span><?php echo $profile->getScope_delivery(); ?></span></div>
    <div class="option">Metody płatności: <span><?php echo $profile->getPayment_methods(); ?></span></div>
    <div class="option">Faktury: <span><?php if($profile->getInvoices() == 1){echo "Tak";}else{echo "Nie";} ?></span></div>
    <!--<div class="option">Nazwa firmy: <span><?php //echo $profile->getCompany_name(); ?></span></div>-->
<!--    <div class="option">Nip: <span><?php /*echo $profile->getNip();*/ ?></span></div>-->
    <div class="option">Wystawione przesyłki: <span><?php echo getUserParcelsAmount($profile_id); ?></span></div>
    <div class="option">Wygrane oferty: <span><?php echo getWonOffersAmount($profile_id); ?></span></div>
    <div class="option">Wszystkie oferty: <span><?php echo getAllOffersAmount($profile_id); ?></span></div>
    <div class="option">Ilość komentarzy: <span><?php echo getAllCommentsAmount($profile_id); ?></span></div>
        </div>
        <div class="right">
            <div class="title">Opinie:</div>
            <div><span class="positive">Pozytywne: <span><?php echo $positive; ?>(<?php echo $positive_per; ?>%)</span></span></div>
        <div><span class="neutral">Neutralne: <span><?php echo $neutral; ?>(<?php echo $neutral_per; ?>%)</span></span></div>
        <div><span class="negative">Negatywne: <span><?php echo $negative; ?>(<?php echo $negative_per; ?>%)</span></span></div>
        </div>
        <div style="clear: both"></div>
        
        <div class="opinions">
            <table cellpadding="0" cellspacing="0">
                <?php if(count($opinions) > 0){ ?>
            <tr class="head">
                <th>Rodzaj</th>    
                <th>Data</th>
                <th>Opinia</th>
            </tr>
                
                <?php
                foreach($opinions as $opinion){
                    ?>
                <tr class="<?php if($opinion->getType() === "positive"){
                        echo "positive";
                    } else if($opinion->getType() === "neutral"){
                        echo "neutral";
                    } else{
                        echo "negative";
                    } ?>">
                    <td><?php echo $opinion->getType(); ?></td>
                    <td><?php echo date('d.m.Y', $opinion->getAdd_date()); ?></td>
                    <td><?php echo $opinion->getOpinion(); ?></td>
                </tr>
                    
                
                    <?php
                }
                }?>
            </table>
            <?php if(!isset($_GET['opinions'])){?>
            <span id="show_all">Pokaż wszystkie</span>
            <?php } ?>
        </div>
        
    </div>
            

            
            
        <?php
        } 
        
    }
    else{
        echo "<div class='title'>Nie znaleziono profilu!</div>";
    }
?>
</div>