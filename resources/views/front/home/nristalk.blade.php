   <div class="recent-ads border bg-white ">
                                <h2 class="section-title mb-0 p-0 mt-2 mt-lg-0">{{ request()->req_state ? 'Hot List' : 'NRIS Talk' }}
                                </h2>
                                @if (request()->req_state)
                                    <h4 class="text-capitalize h2 text-danger text-center"> just for $5 premium visibility
                                        Here</h4>
                                @endif
                                <button type="button" class="btn btn-danger ads_btn ads_btn_pre px-2 py-1 font-16">
                                    <?php  if($sd == 1){echo "Create NRIS Talk"; }else{echo "Create premium add";}?>
                                    
                                    </button>
                                <div class="homecard h-80 border-0">
                                    <div class="card-body pt-0">
                                        <?php 
                                            if (!request()->req_state) { ?>
                                        <ul class="list text-black_a">
                                            <?php
                                                foreach ($nri_talks as $key => $nri_talk) { ?>
                                            <li><a title="{{trim($nri_talk->title)}}" href="{{ route('front.nris.view', $nri_talk->slug) }}"
                                                    class="font-weight-bold font-16"><?= 
                                                     substr(trim($nri_talk->title), 0, 50)
                                                      ?>..</a>
                                                <div class="mt-1 text-black">
                                                    Like : {{ count($nri_talk->like_nris) }} |
                                                    Comment : {{ count($nri_talk->comments) }}
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <?php } else { ?>
                                        <ul class="col-12 recent_popular text-black_a">
                                            <?php foreach ($hotlist as $key => $value) { ?>
                                            @if ($value['payment_id'] !== null)
                                                <li>
                                                    <a href="{{ route($value['view_route'], $value['slug']) }}"
                                                        style="overflow: hidden;" class="font-weight-bold">
                                                        {{ $value['title'] }} </a>
                                                    <span
                                                        style="background-color: {{ $value['color'] !== '' ? $value['color'] : '#14274E' }}; ">
                                                        {{ dashesToCamelCase($value['type'] == 'desi_date' ? 'Desi Meet' : $value['type'], true) }}</span>
                                                </li>
                                            @endif
                                            <?php } ?>
                                        </ul>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>