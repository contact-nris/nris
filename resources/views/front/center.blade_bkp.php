 <div class="row mx-lg-0" style="margin-top: 83px;">
            <div class="">
                <!-- sai left section hide it on state page -->
                <div class="hideOnMobile  home-top-hide-ontab">
                    <div width="100%">

      <?php $i=0;
                                        $left_side =1 ;
                                        foreach ($gif_data['Left'] as $k1 => $v1) {

                                        ?>

  
                        <div class="">
                                <div id="carouselExampleFade" class="carousel slide carousel-fade 
                                <?php 
                                if( $i>0) { echo 'mt-1';} ?>" data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                    <?php 



                                     $j=0;
                                        foreach ($v1 as  $k2 => $v2) {
                                            ?>
                                         <div class="carousel-item <?php if($j == 0) {echo "active";}?>">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="<?php //echo $v2?>https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg">
                                            </a>
                                        </div>
                                           

<?php $j++ ; } ?>
                                    </div>
                                </div>
                            </div>
                        
                          <?php  $i++;
                      }  unset($left_side);?>

                            <div class="d-none">
                           
                            <div id="carouselExampleFade" class="carousel slide carousel-fade mt-1"
                                    data-ride="carousel" data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div  class="d-none">
                                <div id="carouselExampleFade" class="carousel slide carousel-fade mt-1"
                                    data-ride="carousel" data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col px-lg-1" style="background-color: red;">
                <!-- sai krishna -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>
                <div class="home-top-display-ontab home-top-hide-desktop my-1">
                    <section class="customer-logos slider">
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                           <!--          @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image') -->
<div class="carousel-item active">
<img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfER6E7eLdkMsm6BG9GC8tIJT-daMb3yzXUVe0rqk&s"
alt="">
</div>
<div class="carousel-item">
<img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfER6E7eLdkMsm6BG9GC8tIJT-daMb3yzXUVe0rqk&s"
alt="">
</div>
<div class="carousel-item">
<img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRfER6E7eLdkMsm6BG9GC8tIJT-daMb3yzXUVe0rqk&s"
alt="">
</div>


                               
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                   
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                 
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                   
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                  
                                  
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                   
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                  
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                  
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                   >
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                            alt="">
                                    </div>
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                    @include('layouts/home_image')
                                   

                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                                    @include('layouts/gif_css_js')


           

                <!-- sai krishna top start -->
                <section class="hideOnMobile home-top-hide-ontab ">
                    <div class="">

                        <div class="justify-content-lg-between mx-lg-0 row flex-nowrap">
<?php 
$top_side = 1;

     foreach ($gif_data['Top'] as $k1 => $v1) {
        $i=0;

        ?>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                          <?php  $j=0; foreach ($v1 as $k2 => $v2) { ?> 
                                             @include('layouts/home_image')
                                             <?php $j++;} ?>
                                      <!--   <div class="carousel-item active">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>

                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width"
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        <?php } unset($top_side ); ?>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width"
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width"
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width"
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width"
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width"
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width"
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width "
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                        <div class="carousel-item">
                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-width"
                                                src="https://admin.miindia.com//files/miimages/banners/may19/beaumont_breast_health_for_life_136x60.gif"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                </section>
    <!-- sai krishna top end -->
                <div id="hero-area" style="position: relative;">

                    <div class="overlay "
                        style="background: #c9d1d3 url(https://nris.com/upload/country/152194054262639fda95ac05.12411768.jpg) center center;background-size:cover;height: 100%;            ">
                    </div>
                    <!--L width 85% U->left:15%;width:70%-->
                    <!--naveennaveen-->
                    <!--U start -->

                    <!--U end -->
                    <!--L end-->
                    <div class=" row ml-0 responsiveWidth2-sai">
                        <!--L ml-0 style="width:85%"-->
                        <div class="row col-10 mx-auto justify-content-center home-banner-height">
                            <div class="col-md-12 col-lg-9 col-xs-12 text-center px-0">
                                <div class="contents" style="padding-top:0px;">
                                    <p class="">EXPLORE IN USA</p>
                                    <h3 class="head-title mb-0">What's happening in your State?</h3>


                                    <div class="search-bar">
                                        <div class="search-inner">
                                            <form class="search-form" action="https://nris.com/home/search">
                                                <div class="form-group">
                                                    <input type="text" name="filter_name" class="form-control"
                                                        placeholder="What are you looking for?" required="">
                                                </div>
                                                <div class="form-group inputwithicon">
                                                    <div class="select">
                                                        <select required="">
                                                            <option value="">Select state</option>
                                                            <option value="7">Alaska</option>
                                                            <option value="9">Alabama</option>
                                                            <option value="14">Arkansas</option>
                                                            <option value="18">Arizona</option>
                                                            <option value="32">California</option>
                                                            <option value="45">Colorado</option>
                                                            <option value="48">Connecticut</option>
                                                            <option value="56">Delaware</option>
                                                            <option value="77">Florida</option>
                                                            <option value="80">Georgia</option>
                                                            <option value="93">Hawaii</option>
                                                            <option value="99">Iowa</option>
                                                            <option value="101">Idaho</option>
                                                            <option value="102">Illinois</option>
                                                            <option value="104">Indiana</option>
                                                            <option value="111">Kansas</option>
                                                            <option value="116">Kentucky</option>
                                                            <option value="117">Louisiana</option>
                                                            <option value="125">Massachusetts</option>
                                                            <option value="129">Maryland</option>
                                                            <option value="130">Maine</option>
                                                            <option value="133">Michigan</option>
                                                            <option value="136">Minnesota</option>
                                                            <option value="137">Missouri</option>
                                                            <option value="138">Mississippi</option>
                                                            <option value="140">Montana</option>
                                                            <option value="149">NorthCarolina</option>
                                                            <option value="150">NorthDakota</option>
                                                            <option value="151">Nebraska</option>
                                                            <option value="155">NewHampshire</option>
                                                            <option value="157">NewJersey</option>
                                                            <option value="162">NewMexico</option>
                                                            <option value="174">Nevada</option>
                                                            <option value="175">NewYork</option>
                                                            <option value="178">Ohio</option>
                                                            <option value="179">Oklahoma</option>
                                                            <option value="182">Oregon</option>
                                                            <option value="186">Pennsylvania</option>
                                                            <option value="193">RhodeIsland</option>
                                                            <option value="197">SouthCarolina</option>
                                                            <option value="198">SouthDakota</option>
                                                            <option value="210">Tennessee</option>
                                                            <option value="213">Texas</option>
                                                            <option value="214">Utah</option>
                                                            <option value="215">Virginia</option>
                                                            <option value="217">Vermont</option>
                                                            <option value="220">Washington</option>
                                                            <option value="222">Wisconsin</option>
                                                            <option value="229">WestVirginia</option>
                                                            <option value="230">Wyoming</option>
                                                        </select>
                                                    </div>
                                                    <i class="lni-menu"></i>
                                                </div>
                                                <button class="btn btn-common" type="submit"><i
                                                        class="fa fa-search"></i>
                                                    Search Now</button>
                                            </form>
                                        </div>
                                    </div>


                                </div>
                                <div class="d-block home_small_icon">
                                    <ul class="list-inline">
                                        <li class="list-inline-item">
                                            <a href="https://nris.com/restaurants" class="text-white">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" onerror="this.onerror=null;this.src=&#39;https://www.nris.com/stuff/images/default.png&#39;;"
                                                    src="./USA _ NRIs_files/restaurants_icon.png" alt="restaurants_icon"
                                                    class="" width="45">
                                                <span class="d-block">Restaurants</span>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="https://nris.com/temples" class="text-white">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" onerror="this.onerror=null;this.src=&#39;https://www.nris.com/stuff/images/default.png&#39;;"
                                                    src="./USA _ NRIs_files/temple_icon.png" alt="temple_icon" class=""
                                                    width="45">
                                                <span class="d-block">Temple</span>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="https://nris.com/pubs" class="text-white">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" onerror="this.onerror=null;this.src=&#39;https://www.nris.com/stuff/images/default.png&#39;;"
                                                    src="./USA _ NRIs_files/pub_icon.png" alt="pub_icon" class=""
                                                    width="45">
                                                <span class="d-block">Pubs</span>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="https://nris.com/casinos" class="text-white">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" onerror="this.onerror=null;this.src=&#39;https://www.nris.com/stuff/images/default.png&#39;;"
                                                    src="./USA _ NRIs_files/casinos_icon.png" alt="casinos_icon"
                                                    class="" width="45">
                                                <span class="d-block">Casino</span>
                                            </a>
                                        </li>
                                        <li class="list-inline-item dropdown">
                                            <a href="https://nris.com/#" class="dropdown-toggle text-white"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" onerror="this.onerror=null;this.src=&#39;https://www.nris.com/stuff/images/default.png&#39;;"
                                                    src="./USA _ NRIs_files/carpool_icon.png" alt="carpool_icon"
                                                    class="" width="45">
                                                <span class="d-block">Carpool</span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item"
                                                        href="https://nris.com/carpool/local">Local</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="https://nris.com/carpool/interstate">Interstate</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="https://nris.com/carpool/international">International</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="list-inline-item dropdown">
                                            <a href="https://nris.com/#" class="dropdown-toggle text-white"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" onerror="this.onerror=null;this.src=&#39;https://www.nris.com/stuff/images/default.png&#39;;"
                                                    src="./USA _ NRIs_files/jobs_icon.png" alt="jobs_icon" class=""
                                                    width="45">
                                                <span class="d-block">Jobs</span>
                                            </a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a class="dropdown-item"
                                                        href="https://nris.com/jobs/medical-jobs">Medical
                                                        Jobs</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="https://nris.com/jobs/accounting-clerical-jobs">Accounting/Clerical</a>
                                                </li>
                                                <li><a class="dropdown-item" href="https://nris.com/jobs/IT-jobs">IT
                                                        Jobs</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="https://nris.com/jobs/part-time-hourly-jobs">PartTime/
                                                        Hourly</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="https://nris.com/jobs/management-jobs">HR/Management
                                                        Jobs</a>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- sai side images slide  -->
                <div class="home-top-display-ontab home-top-hide-desktop my-1">
                    <section class="customer-logos slider">
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="slide ">
                            <div id="carouselExampleFade" class="carousel slide carousel-fade " data-ride="carousel"
                                data-interval="3000">
                                <div class="">
                                    <div class="carousel-item active">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class="img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                    <div class="carousel-item">
                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-l-top-sai"
                                            src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                            alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="">

                <div class="hideOnMobile home-left-width home-top-hide-ontab">
                    <div width="100%">
                        <div class="">
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel"
                                    data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade mt-1"
                                    data-ride="carousel" data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div id="carouselExampleFade" class="carousel slide carousel-fade mt-1"
                                    data-ride="carousel" data-interval="3000">
                                    <div class="">
                                        <div class="carousel-item active">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                        <div class="carousel-item">
                                            <a href="https://nris.com/">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" class=" img-fluid  home-left-width"
                                                    src="https://admin.miindia.com//files/miimages/banners/nov21/sujata-patel-miindia_150x100.jpg"
                                                    alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>}
