<style>
    .list-inline-item img {
        width: 45px;
    }

    ul>.list-inline-item:not(:last-child) {
        margin-right: 1.5rem;
        text-align: center;
    }

</style>

<div class="d-block home_small_icon">
    <ul class="list-inline text-lg-right py-1">
        @if ($page_type == 'state')
            <li class="list-inline-item dropdown">
                <a href="" class="text-white">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/box_office_icon.png') }}" alt="box_office_icon"
                        class="">
                    <span class="d-block">Box Office</span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    @foreach ($theater_category as $category)
                        <li><a class="dropdown-item"
                                href="{{ route('front.theaters.list', $category->slug) }}">{{ $category->type }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif
        @if ($page_type == 'state')
            <li class="list-inline-item dropdown">
                <a href="#" class="text-white" class="dropdown-toggle text-white" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/restaurants_icon.png') }}" alt="restaurants_icon"
                        class="">
                    <span class="d-block">Restaurants</span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    @foreach ($restaturant_category as $category)
                        <li><a class="dropdown-item"
                                href="{{ route('restaurants.index', $category->slug) }}">{{ $category->type . ' Restaurants' }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="list-inline-item dropdown">
                <a href="#" class="text-white" class="dropdown-toggle text-white" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/temple_icon.png') }}" alt="temple_icon" class="">
                    <span class="d-block">Temple</span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    @foreach ($temples_category as $category)
                        <li><a class="dropdown-item"
                                href="{{ route('front.temples', $category->slug) }}">{{ $category->type }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="list-inline-item dropdown">
                <a href="#" class="text-white" class="dropdown-toggle text-white" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/pub_icon.png') }}" alt="pub_icon" cl>
                    <span class="d-block">Pubs</span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    @foreach ($pubs_category as $category)
                        <li><a class="dropdown-item"
                                href="{{ route('front.pubs', $category->slug) }}">{{ $category->type }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li class="list-inline-item dropdown">
                <a href="#" class="text-white" class="dropdown-toggle text-white" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/casinos_icon.png') }}" alt="casinos_icon" class="">
                    <span class="d-block">Casino</span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a class="dropdown-item" href="{{ route('casinos.index', 'top-rated') }}">Top
                            Rated</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('casinos.index', $place_name . '-state') }}">{{ $place_name . ' casinos' }}
                        </a></li>
                </ul>
            </li>
        @else
            <li class="list-inline-item">
                <a href="{{ route('restaurants.index') }}" class="text-white">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/restaurants_icon.png') }}" alt="restaurants_icon"
                        class="">
                    <span class="d-block">Restaurants</span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('front.temples') }}" class="text-white">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/temple_icon.png') }}" alt="temple_icon" class="">
                    <span class="d-block">Temple</span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('front.pubs') }}" class="text-white">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/pub_icon.png') }}" alt="pub_icon" cl>
                    <span class="d-block">Pubs</span>
                </a>
            </li>
            <li class="list-inline-item">
                <a href="{{ route('casinos.index') }}" class="text-white">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/casinos_icon.png') }}" alt="casinos_icon" class="">
                    <span class="d-block pr-1">Casino</span>
                </a>
            </li>
        @endif
        <li class="list-inline-item dropdown">
            <a href="#" class="dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/carpool_icon.png') }}" alt="carpool_icon" class="">
                <span class="d-block">Carpool</span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a class="dropdown-item" href="{{ route('front.carpool', 'local') }}">Local</a></li>
                <li><a class="dropdown-item" href="{{ route('front.carpool', 'interstate') }}">Interstate</a>
                </li>
                <li><a class="dropdown-item" href="{{ route('front.carpool', 'international') }}">International</a>
                </li>
            </ul>
        </li>
        <li class="list-inline-item dropdown">
            <a href="#" class="dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/jobs_icon.png') }}" alt="jobs_icon" cl>
                <span class="d-block">Jobs</span>
            </a>
            <ul class="dropdown-menu" role="menu">
                @foreach ($job_category as $category)
                    <li><a class="dropdown-item"
                            href="{{ route('job.index', $category->slug) }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </li>
        @if ($page_type == 'state')
            <li class="list-inline-item">
                <a href="{{ route('front.grocieries.list') }}" class="text-white">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ assets_url('icon/groceries_icon.png') }}" alt="groceries_icon"
                        class="">
                    <span class="d-block">Groceries</span>
                </a>
            </li>
        @endif
    </ul>
</div>
