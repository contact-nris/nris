   
                            <div class="homecard h-100">
                                <h2 class="section-title mb-0 p-0 mt-md-0  mt-2 mt-lg-0">Recent Ads</h2>
                                <button type="button" class="btn btn-success ads_btn ads_btn_free px-2 py-1">Create Free
                                    ad</button>
                                <div class="card-body pt-0">

                                    <ul class="nav nav-pills justify-content-around mb-1" id="pills-category"
                                        role="tablist">
                                        @foreach ($recent_ads as $key => $ad)
                                            <li class="nav-item text-black">
                                                <a class="anav-link font-16 <?= $key == 'recent' ? 'active' : '' ?>"
                                                    data-toggle="pill" href="#pills-cate-<?= $key ?>" role="tab"
                                                    aria-controls="ills-cate-<?= $key ?>"
                                                    aria-selected="true"><?= dashesToCamelCase($key, true) ?></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content" id="pills-category">
<style type="text/css">
    .recent-btns{
    background: var(--main-color);
    color: #fff;
    padding: 3px 3px;
    margin: 3px 0px;
    min-width: 80px;
    text-align: center;
  }

</style>

                                        <?php foreach ($recent_ads as $key => $ads) { ?>
                                        <div class="tab-pane fade <?= $key == 'recent' ? 'show active' : '' ?>"
                                            id="pills-cate-<?= $key ?>" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <?php foreach ($ads as $key => $ad) { ?>
                                            <div class="align-items-center border-bottom justify-content-between mx-0 row ">
  <a href="{{ route($ad['view_route'], $ad['slug']) }}" title="{{trim($ad['title'])}}" class="col-6 mb-0 text-black">{{  substr(trim($ad['title']), 0, 20) }}..</a>
  <div class="align-items-md-baseline col-6 justify-content-end mx-0 row">
    <span class="mr-md-1 hideOnMobile" style="font-size:11px">
        <?php if( isset($ad['city']) )  { $a = substr(get_city($ad['city']), 0, 10); if(strlen($a) > 0 ){ echo ucwords($a);  } }  ?><?php if(isset($ad['state'])){ echo ",";?>{{strtoupper(substr(trim($ad['state']), 0, 2))}}
 <?php } ?>
     
 </span>
    <span class="recent-btns">{{ dashesToCamelCase($ad['type'], true) }}</span>
  </div>
</div>
<?php } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            
                                   <script>
                        $(document).ready(function() {
                            $('.ads_btn_free').click(function(e) {
                                @if (!request()->req_state)
                                    $('#state-selection_ads').modal('show');
                                @else
                                    $('#exampleModalCenter_free').modal('show');
                                @endif
                            });

                            $('.ads_btn_pre').click(function(e) {
                                @if (!request()->req_state)
                                    $('#state-selection_ads').modal('show');
                                @else
                                    $('#exampleModalCenter_pre').modal('show');
                                @endif
                            });
                        });
                    </script>
                    
                     