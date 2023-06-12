
                    <div class="h-100">
                        <div class="homecard h-100">
                            @if (request()->req_state)
                                <h2 class="section-title mb-0 p-0">Desi movies</h2>
                                <div class="card-body pt-0">
                                    <ul class="nav nav-pills justify-content-center mb-3" id="pills-category"
                                        role="tablist">
                                        <?php foreach ($movie_city as $key => $cate) { ?>
                                        <li class="nav-item">
                                            <a class="anav-link font-16 <?= $key == 0 ? 'active' : '' ?>" data-toggle="pill"
                                                href="#pills-cate-<?= $cate->citys_id ?>" role="tab"
                                                aria-controls="ills-cate-<?= $cate->citys_id ?>"
                                                aria-selected="true"><?= $cate->city_name ?></a>&nbsp;&nbsp; | &nbsp;&nbsp;
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tab-content" id="pills-category">
                                        <?php if (count($movie_city)) {  ?>
                                        <?php foreach ($movie_city as $key => $cate) { ?>
                                        <div class="tab-pane fade <?= $key == 0 ? 'show active' : '' ?>"
                                            id="pills-cate-<?= $cate->citys_id ?>" role="tabpanel"
                                            aria-labelledby="pills-home-tab">
                                            <div class="row px-3">
                                                <div class="desi_movies-card w-100">
                                                    <img
                                                        src="{{ asset('upload/city_movies/' . $desi_movies_img->image) }}" />
                                                    <div class="col-12 p-0">
                                                        <ul class="movies_title">
                                                            <?php foreach ($desi_movies[$cate->citys_id] as $key => $event) { ?>
                                                            <a href="{{ route('desi_movies.view', $event->slug) }}">
                                                                <li class="movies_name">{{ $event->name }}</li>
                                                            </a>
                                                            <li class="movies-date">
                                                                @if ($event->sdate !== '0000-00-00' && $event->edate !== '0000-00-00')
                                                                    {{ date('d M', strtotime($event->sdate)) }} -
                                                                    {{ date('d M, Y', strtotime($event->edate)) }}
                                                                @else
                                                                    {{ 'N/A - N/A' }}
                                                                @endif
                                                            </li>
                                                            <hr class="my-0">
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                    <div class="col-12 px-0 pt-2 text-right">
                                                        <a
                                                            href="{{ route('desi_movies.index') }}"style="
                                                                    font-size: medium;
                                                                ">View
                                                            More
                                                            >></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                        <?php } else { ?>
                                        <div class="row px-3">
                                            <div class="desi_movies-card w-100 text-center">
                                                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('upload/city_movies/default_img.png') }}"
                                                    class="w-auto" />
                                                <div class="col-12 bg-secondary mt-3 py-2 text-center text-white"
                                                    style="
                                                    font-size: 25px;
                                                ">
                                                    No Movies
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            @else
                                <h2 class="section-title mb-0 p-0 ">
                                    {{ request()->req_state ? request()->req_state['code'] . ' Event' : 'National Events' }}
                                </h2>
                                <div class="card-body pt-0">
                                    <ul class="nav nav-pills justify-content-between mx-2" id="pills-category"
                                        role="tablist">
                                        <?php foreach ($national_category as $key => $cate) { ?>
                                        <li class="nav-item">
                                            <a class="anav-link font-16 <?= $key == 0 ? 'active' : '' ?>" data-toggle="pill"
                                                href="#pills-cate-<?= $cate->id ?>" role="tab"
                                                aria-controls="ills-cate-<?= $cate->id ?>"
                                                aria-selected="true"><?= $cate->name ?></a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tab-content" id="pills-category">
                                        <?php foreach ($national_category as $key => $cate) { ?>
                                        <div class="tab-pane fade <?= $key == 0 ? 'show active' : '' ?>"
                                            id="pills-cate-<?= $cate->id ?>" role="tabpanel"
                                            aria-labelledby="pills-home-tab">
                                            <?php if (count($national_events[$cate->id])) { ?>
                                            <div class="row mx-0">
                                                <?php foreach ($national_events[$cate->id] as $key => $event) { ?>
                                                <div class="col-sm-4 px-1">
                                                    <div class="event-card">
                                                        <a href="{{ route('event.view', $event->slug) }}">
                                                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ $event->image_url }}" />
                                                            <div class="info">
                                                                <span>{{ $event->title }}</span>
                                                                <div><i class="fa fa-eye"></i>
                                                                    {{ $event->total_views }}
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <div class="col-12 px-0 text-right">
                                                    <a href="{{ route('event.index', base64_encode($cate->name)) }}">View
                                                        More
                                                        >></a>
                                                </div>
                                            </div>
                                            <?php } else {
                                                ?>
                                            <div class="row">
                                                <?php for ($i=1;$i<=9;$i++) { ?>
                                                <div class="col-sm-4 px-1">
                                                    <div class="event-card">
                                                        <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  class="h-50 w-75 mx-3 my-1"
                                                            src="https://www.nris.com/stuff/images/home_logo_icon.png"
                                                            alt="">
                                                        <p class="font-italic pt-3 text-center">No current event check back
                                                            soon
                                                        </p>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                            <?php  
                                            } ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
      