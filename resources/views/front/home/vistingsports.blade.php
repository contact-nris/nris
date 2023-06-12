
    <div class="bg-white border mx-0 px-2 col-lg-12">
         <div class="col-lg-12 row">
                       <h2 class="section-title mb-0 p-0 mr-lg-3">Visiting Spots</h2>
                        <div class="mt-2">
                     
                           <ul class="d-flex justify-content-center justify-content-lg-start mb-1 nav nav-pills"
                                    id="pills-tab-visiting" role="tablist">
                                <?php foreach ($visiting_sports as $key => $value) { ?>
                                <li class="nav-item">
                                    <a class="nav-link  font-16 <?= $key == 'restaurant' ? 'active' : '' ?>"
                                        id="pills-{{ $key }}-tab" data-toggle="pill"
                                        href="#pills-{{ $key }}" role="tab"
                                        aria-controls="pills-{{ $key }}" aria-selected="true">
                                        <?= ucfirst($key) ?></a>
                                </li>
                                <?php } ?>
                            </ul>
                        </div>
                         </div>

                        <div class="tab-content" id="pills-visitng_sports">
                            <?php foreach ($visiting_sports as $key => $value) { ?>
                            <div class="tab-pane fade <?= $key == 'restaurant' ? 'show active' : '' ?>"
                                id="pills-{{ $key }}" role="tabpanel"
                                aria-labelledby="pills-{{ $key }}-tab">
                                <div class="row genral px-2">
                                    <?php 
                                    if(count($value))
                                    {
                                        foreach ($value as $key => $visit_sport) 
                                        { 
                                    ?>
                                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 px-1">
                                        <div class="video-item-wrapper">
                                            <div class="video-item-img-visiting">
                                                <a href="{{ $visit_sport->slug_with_path }}">
                                                   
                                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $visit_sport->image_url }}"
                                                        alt="{{ $visit_sport->title }}" class="same_width_wrapper">
                                                    {{-- <span class="like-count">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </span> --}}
                                                    <div class="video_text">
                                                        <h4 class='mb-0 text-white'>{{ $visit_sport->title }}</h4>
                                                        <p class='text-white'>{{ $visit_sport->city_name }},
                                                            {{ $visit_sport->state_name }}
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } 
                                    }
                                    else { ?>
                                    <div class="col-md-12 pb-3">
                                        <div class="border-danger rounded border py-3">
                                            <p class="font-italic text-center">Data not found</p>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                    </div>