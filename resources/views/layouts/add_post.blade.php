  <div class="col-lg-4 col-md-6 col-xs-12">
                <aside class="details-sidebar">
                    <div class="widget card">
                        <h4 class="widget-title card-header">Ad Posted By</h4>
                        <div class="agent-inner card-body">
                            <div class="agent-title">
                                <div class="agent-photo">
                                    <!-- <div class="avatar"></div> -->
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="<?php
                                            if(!isset($list->contact_name)){
                                                $list->contact_name = 'Admin';
                                            }
                                            if(!strlen($list->contact_name) > 0 ){ 
                                                $list->contact_name = 'U N';
                                            }
                                        $img =     explode(' ', $list->contact_name);
                                        if(!isset($img[1])){
                                            $img[1] = substr($img[0],1,1);
                                            if(!strlen($img[1])){
                                               $img[1] =$img[0];
                                            }
                                        }
                        echo    $more_add_image =   userPhoto(array('profile_photo' => '','first_name' => $img[0] ,
                            'last_name' =>  $img[1]))
                             ?>

                            "alt="">
                                </div>


                                <div class="agent-details">
                                    <h3><a href="#">{{$list->contact_name}}</a></h3>
                                   <?php if($list->contact_number){?>
                                    <span><i class="lni-phone-handset"></i>{{$list->contact_number}}</span>
                                <?php } ?>
                                </div>
                            </div>

                            <div class="map-container p-0 mt-3 ">

                                <?php
                                if(isset($list->iframe) ||  1){

                                if ($list['use_address_on_map'] && $list['address'] != "") {
                                    $address = $list['address'];
                                } else {
                                    $address = $list['city'] . ', United States';
                                }
                                ?>

                                <iframe width="100%"   height="250" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=<?= config('app.map_key') ?>&q=<?= urlencode($address) ?>" allowfullscreen>
                                </iframe>

                            <?php  } ?>

                            <?php if(isset($list->new_form) &&  0){?>
                                <br>
                                <br>
                            <input type="text" class="form-control" placeholder="Your Email">
                            <input type="text" class="form-control" placeholder="Your Phone">
                            <p>I'm interested in this 
                                <!-- property  -->
                            <!-- [ID 123456] -->
                             and I'd like to know more details.</p>
                            <button class="btn btn-common fullwidth mt-4">Send Message</button>

                           <?php } ?>
        <?php if(isset($list->hours)){?>
                                <br>
                                <br>
                              <div id="business-hours">
                                    @include('layouts.business_hour',array('model' => $list->add_model, 'model_id' => (int)$list->id ))
                                </div>

                           <?php } ?>




                            </div>
                        </div>
                    </div>

<?php if(isset($list->more_ads) && 0 ){?>

                    <div class="widget card">
                        <h4 class="widget-title">More Ads From Seller</h4>
                        <ul class="posts-list">
                            <li>
                                <div class="widget-thumb">
                                    <a href=""><img
                                            src="<?php echo $more_add_image;?>"
                                            alt=""></a>
                                </div>
                                <div class="widget-content">
                                    <h4><a target ="_blank" href="{{ route($list->view, $list->slug) }}">
                                        <?php echo $list->more_ads_title?>
                                            
                                        </a></h4>
                                    <div class="meta-tag">
                                        <span>
                                            <a href="{{ $list->href }}" target="_blank"><i class="lni-user"></i> {{$list->contact_name}}</a>
                                        </span>
                                        <span>
                                            <a href="#"><i class="lni-map-marker"></i>  {{$list->city_name}}</a>
                                        </span>
                                        <span>
                                            <a href="#"><i class="lni-tag"></i> {{ $list->cat_name}}</a>
                                        </span>
                                    </div>
                                    <?php if($list->more_ads_amount) {?>
                                    <h4 class="price">${{ $list->more_ads_amount}}</h4>
                                <?php } ?>
                                
                                </div>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                    </div>
                <?php } ?>

</aside>
</div>