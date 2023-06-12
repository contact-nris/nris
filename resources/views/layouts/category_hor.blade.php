<div class=" d-lg-none d-md-block d-block ">
        <div class="">

            <div class="">
                <div width="100%" height="440px">
                    <div id="data-slider" class="">
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
                        <div class="my-1">
                            <section class="horizontal slider">
                               <?php
// print_r($adv);
// exit;
                                 $i=0;
                                 // $adv['Top'] 
                               foreach($adv['Top'] as $k1 => $v1) {

                                        ?>

                        <div class="slide">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <?php 
                                    $j=0;
                                        foreach($v1 as  $k2 => $v2) {
                                                   $v22 =  explode('@3&TdY*!fMKnN#nj=4_E@',$v2);
                                            ?>
                                    <div class="carousel-item <?php if($j==0) {echo 'active' ; } ?>">  <a href="<?=$v22[1]?>" title="<?=$v22[2]?>">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid education-left-vertical"
                                          src="https://nris.com/upload/us_ads/<?=$v22[0];?>"
                                            src1="https://admin.miindia.com//files/PandeGrocers-novi-miindia_150x100.jpg"
                                            alt="First slide">
                                        </a>
                                    </div>
                                    <?php $j++; } ?>
                                 
                                </div>
                            </div>
                        </div>
                    <?php  $i++; }?>
                                
                            </section>
                        </div>

                        <script>
                            $(document).ready(function () {
                                $('.horizontal').slick({
                                    slidesToShow: 6,
                                    slidesToScroll: 1,
                                    autoplay: true,
                                    autoplaySpeed: 1500,
                                    arrows: false,
                                    dots: false,
                                    pauseOnHover: false,
                                    vertical: false,
                                    responsive: [
                                        {
                                            breakpoint: 1400,
                                            settings: {
                                                slidesToShow: 9
                                            }
                                        },
                                        {
                                            breakpoint: 1179,
                                            settings: {
                                                slidesToShow: 8
                                            }
                                        }, {
                                            breakpoint: 768,
                                            settings: {
                                                slidesToShow: 5
                                            }
                                        }, {
                                            breakpoint: 520,
                                            settings: {
                                                slidesToShow: 4
                                            }
                                        }]
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>