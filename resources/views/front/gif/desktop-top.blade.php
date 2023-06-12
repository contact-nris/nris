<?php if(isset($_GET['test1'])) {

?>
<section  class="hideOnMobile home-top-hide-ontab">
                    <div class="">

                        <div class="justify-content-lg-between mx-lg-0 row flex-nowrap">

                                      <?php $i=0;
                                        foreach($gif_data['Top1'] as $k1 => $v1) {

                                        ?>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">

                                        <?php 
                                        $j=0;
                                        //echo "<pre>";
                                       // print_R($v1);
                                        foreach($v1 as  $k2 => $v2) {
                                              $v22 =  explode('@3&TdY*!fMKnN#nj=4_E@',$v2);
                                              list($width, $height, $type, $attr)= getimagesize("https://nris.com/upload/us_ads/$v22[0]");
                                               if(($width == 130) && ($height == 60) || 1 ){
                                            ?>
                                        <div class="carousel-item <?php if($j==0) {echo 'active' ; } ?>" mode="<?php echo $k1.'--'. $i. '---'. $j;?>"> 
                                                       <a href="<?=$v22[1]?>" title="<?=$v22['2'].'--w'. $width.'--h'. $height;?>" mode="desktop-top"> 
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"   class=" img-fluid home-l-top-width "
                                            src="https://nris.com/upload/us_ads/<?=$v22[0];?>"
                                                
                                                alt="First slide">
                                            </a>
                                        </div>
<?php }  $j++; } ?>
<!--nav-->
                                    </div>
                                </div>
                            </div>
<?php $i++; } ?>
                        </div>


                    </div>

                </section>
                <?php  } else{ 
               // print_R($_GET[]);
                ?>

<section  class="hideOnMobile home-top-hide-ontab d-none" >
                    <div class="">

                        <div class="justify-content-lg-between mx-lg-0 row flex-nowrap">

                                      <?php $i=0;
                                        foreach($gif_data['Top'] as $k1 => $v1) {
                                            
                                            if($k1 > 7 ){
                                                break;
                                            }

                                        ?>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">

                                        <?php 
                                        $j=0;
                                        foreach($v1 as  $k2 => $v2) {
                                              $v22 =  explode('@3&TdY*!fMKnN#nj=4_E@',$v2);
                                                list($width, $height, $type, $attr) = getimagesize("https://nris.com/upload/us_ads/$v22[0]");
                                                  if(($width == 130) && ($height == 60)  || 1 ){
                                            ?>
                                        <div class="carousel-item <?php if($j==0) {echo 'active' ; } ?>" mode="<?php echo $k1.'--'. $i. '---'. $j;?>"> 
                                                       <a href="<?=$v22[1]?>" title="<?=$v22['2'].'--w'. $width.'--h'. $height;?>" target="_blank">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                            src="https://nris.com/upload/us_ads/<?=$v22[0];?>"
                                                
                                                alt="First slide">
                                            </a>
                                        </div>
<?php }  $j++; } ?>
<!--nav-->
                                    </div>
                                </div>
                            </div>
<?php $i++; } ?>
                        </div>


                    </div>

                </section>
                
                <?php } ?>