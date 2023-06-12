<div class="col-lg-2 d-md-block d-none ">
            <div class="hideOnMobile">

                <div class="">
                    <div width="100%" height="440px">
                        <div id="data-slider" class="">
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
                            <div class="my-1">
                                <section class="customer-logos slider">
                                    <?php

// print_r($adv);
                                     $i=0;
                               foreach($adv['Right'] as $k1 => $v1) {

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
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid education-left-vertical "
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
                                    $('.customer-logos').slick({
                                        slidesToShow: 16,
                                        slidesToScroll: 1,
                                        autoplay: true,
                                        autoplaySpeed: 1500,
                                        arrows: false,
                                        dots: false,
                                        pauseOnHover: false,
                                        vertical: true,
                                        responsive: [
                                            {
                                                breakpoint: 1400,
                                                settings: {
                                                    slidesToShow: 9
                                                }
                                            },
                                            {
                                                breakpoint: 1300,
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

                            <style>
                                /* Slider */

                                .slick-slide {
                                    margin: 0px 5px;
                                }

                                .slick-slide img {
                                    width: 100%;
                                }

                                .slick-slider {
                                    position: relative;
                                    display: block;
                                    box-sizing: border-box;
                                    -webkit-user-select: none;
                                    -moz-user-select: none;
                                    -ms-user-select: none;
                                    user-select: none;
                                    -webkit-touch-callout: none;
                                    -khtml-user-select: none;
                                    -ms-touch-action: pan-y;
                                    touch-action: pan-y;
                                    -webkit-tap-highlight-color: transparent;
                                }

                                .slick-list {
                                    position: relative;
                                    display: block;
                                    overflow: hidden;
                                    margin: 0;
                                    padding: 0;
                                }

                                .slick-list:focus {
                                    outline: none;
                                }

                                .slick-list.dragging {
                                    cursor: pointer;
                                    cursor: hand;
                                }

                                .slick-slider .slick-track,
                                .slick-slider .slick-list {
                                    -webkit-transform: translate3d(0, 0, 0);
                                    -moz-transform: translate3d(0, 0, 0);
                                    -ms-transform: translate3d(0, 0, 0);
                                    -o-transform: translate3d(0, 0, 0);
                                    transform: translate3d(0, 0, 0);
                                }

                                .slick-track {
                                    position: relative;
                                    top: 0;
                                    left: 0;
                                    display: block;
                                }

                                .slick-track:before,
                                .slick-track:after {
                                    display: table;
                                    content: '';
                                }

                                .slick-track:after {
                                    clear: both;
                                }

                                .slick-loading .slick-track {
                                    visibility: hidden;
                                }

                                .slick-slide {
                                    display: none;
                                    float: left;
                                    height: 100%;
                                    min-height: 1px;
                                }

                                [dir='rtl'] .slick-slide {
                                    float: right;
                                }

                                .slick-slide img {
                                    display: block;
                                }

                                .slick-slide.slick-loading img {
                                    display: none;
                                }

                                .slick-slide.dragging img {
                                    pointer-events: none;
                                }

                                .slick-initialized .slick-slide {
                                    display: block;
                                }

                                .slick-loading .slick-slide {
                                    visibility: hidden;
                                }

                                .slick-vertical .slick-slide {
                                    display: block;
                                    height: auto;
                                    border: 1px solid transparent;
                                }

                                .slick-arrow.slick-hidden {
                                    display: none;
                                }
                            </style>


                        </div>
                    </div>
                </div>
            </div>
        </div>