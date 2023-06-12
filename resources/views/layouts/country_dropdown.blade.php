
<a href="http://{{ request()->req_country ? request()->req_country['domain'] : 'usa' }}.nris.com" class="align-items-center d-flex px-md-2 text-white pr-2" style="margin-top: 5.5px;">
<i class="flag flag-<?= request()->req_country ? request()->req_country['code'] : 'us' ?>"></i> 
<span class="hide_on_sm pl-md-1"> Home</span></a>


{{-- <a href="{{ request()->req_country ? str_replace('__NAME__', request()->req_country['domain'] ,env('APP_URL_SLUG')) : env('APP_URL') }}" class="align-items-center d-flex px-md-3 text-white pr-2" style="margin-top: 5.5px;">
    <i class="flag flag-<?= request()->req_country ? request()->req_country['code'] : 'us' ?>"></i> 
    <span class="hide_on_sm pl-md-1"> Home</span></a> --}}

<div class="dropdown custom_drop mr-2 mt-2">
    <button class="btn btn-outline-light dropdown-toggle font-16" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $con }}
    </button>
    <div class="dropdown-menu country_drop_down">
        <a class="dropdown-item" href="http://nris.com" attr-data="us">
            <i class="flag flag-us ?>"></i> 
            <label for="country_usa" style="cursor:pointer;">United States</label>
        </a>
        <a class="dropdown-item" href="http://canada.nris.com" attr-data="ca">
            <i class="flag flag-ca ?>"></i> 
            <label for="country_usa" style="cursor:pointer;">Canada</label>
        </a>
        <a href="http://australia.nris.com" class="dropdown-item" attr-data="au">
            <i class="flag flag-au ?>"></i> 
            <label style="cursor:pointer;">Australia</label>
        </a>
        <a href="http://uk.nris.com" class="dropdown-item" attr-data="gb">
            <i class="flag flag-gb ?>"></i>
            <label style="cursor:pointer;">United Kingdom</label>
        </a>
        <a href="http://newzealand.nris.com" class="dropdown-item" attr-data="nz">
            <i class="flag flag-nz ?>"></i>
            <label style="cursor:pointer;">New Zealand</label>
        </a>
    </div>
    
</div>


