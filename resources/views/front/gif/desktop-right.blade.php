      <div class="hideOnMobile home-top-hide-ontab" style="width:10%">

                    <div  class="hideOnMobile  home-top-hide-ontab">
                        <div width="100%">
                            <div class="">
                                 <?php $i=0;
                                            $left_side =1 ;
                                            foreach($gif_data['Right'] as $k1 => $v1) {

                                            ?>


                                <div>
                                    <div id="carouselExampleFade" class="carousel slide carousel-fade <?php if($i>0) {echo "mt-1" ; } ?>" data-ride="carousel"
                                        data-interval="3000">
                                        <div class="">
                                              <?php 
                                         $j=0;
                                            foreach($v1 as  $k2 => $v2) {

                                                  $v22 =  explode('@3&TdY*!fMKnN#nj=4_E@',$v2);
                                                list($width, $height, $type, $attr)= getimagesize("https://nris.com/upload/us_ads/$v22[0]");
                                                 if($width == 150 && $height == 100 || 1  ){
                                                ?>

                                            <div class="carousel-item <?php if($j==0) {echo 'active' ; } ?>">
                                                     <a href="<?=$v22[1]?>" title="<?=$v22['2'].'--w'. $width.'--h'. $height;?>" mode="desktop-right"  target="_blank">
                                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="  gif-image-width "  src="https://nris.com/upload/us_ads/<?=$v22[0]?>"
                                                        src1="https://cdn.gokommerce.com/miindia/R5RF6D2A_dr-siraj-baig-miindia_150x100.jpg"
                                                        alt="First slide">
                                                </a>
                                            </div>
                                              <?php }  $j++; } ?>
                                  
                                        </div>
                                    </div>
                                </div>
                             
                                  <?php 
                            $i++;
                        } ?>
                            </div>
                        </div>

                    </div>
                </div>