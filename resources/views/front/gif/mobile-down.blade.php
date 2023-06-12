 <div class="home-top-display-ontab home-top-hide-desktop my-1">
                    <section class="customer-logos slider">
                        <?php 
$gif_data['left_right'] = array_merge($gif_data['Left'], $gif_data['Right']);

 $i=0;
                                        foreach($gif_data['left_right'] as $k1 => $v1) {

                                        ?>

                        <div class="slide">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <?php 
                                    $j=0;
                                        foreach($v1 as  $k2 => $v2) {
                                                   $v22 =  explode('@3&TdY*!fMKnN#nj=4_E@',$v2);
                                                      list($width, $height, $type, $attr)= getimagesize("https://nris.com/upload/us_ads/$v22[0]");
                                            if($width == 150 && $height == 100 || 1 ){
                                            ?>
                                    <div class="carousel-item <?php if($j==0) {echo 'active' ; } ?>">     
                                    <a href="<?=$v22[1]?>" title="<?=$v22['2'];?>" mode ="mobile-down" target="_blank">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai "
                                          src="https://nris.com/upload/us_ads/<?=$v22[0];?>"
                                            src1="https://admin.miindia.com//files/PandeGrocers-novi-miindia_150x100.jpg"
                                            alt="First slide">
                                        </a>
                                    </div>
                                    <?php }  $j++; } ?>
                                  <!--   <div class="carousel-item d-none">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai "
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="Second slide">
                                    </div>
                                    <div class="carousel-item d-none">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/mar22/dmc-madhuk_miindia_150x100.jpg"
                                            alt="Third slide">
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    <?php  $i++; }?>
                    
                    </section>
                </div>