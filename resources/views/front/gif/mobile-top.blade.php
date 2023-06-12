 <div class="home-top-display-ontab my-1">
     <!--home-top-hide-desktop -->
                    <section class="customer-logos slider">

                           <?php $i=0;
                                        foreach($gif_data['Top'] as $k1 => $v1) {

                                        ?>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                     <?php 
                                        $j=0;
                                        foreach($v1 as  $k2 => $v2) {
                                      $v22 =  explode('@3&TdY*!fMKnN#nj=4_E@',$v2);
                                         list($width, $height, $type, $attr)= getimagesize("https://nris.com/upload/us_ads/$v22[0]");
                                               if($width == 130 && $height == 60  || 1 ){

                                            ?>

                                    <div class="carousel-item <?php if($j == 0) {echo "active";}?>">
                                            <a href="<?=$v22[1]?>" title="<?=$v22['2'];?>" mode="mobile-top" target="_blank">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai "
                                         src="https://nris.com/upload/us_ads/<?=$v22[0];?>"
                                            src2="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                            src3="https://cdn.gokommerce.com/miindia/R5RF6D2A_dr-siraj-baig-miindia_150x100.jpg"
                                            alt="mobile top"></a>
                                    </div><?php }  $j++ ; } ?>

                         
                                </div>
                            </div>
                        </div>
                        <?php $i++; } ?>

                      
                    </section>
                </div>