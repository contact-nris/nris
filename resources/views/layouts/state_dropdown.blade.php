<div class="dropdown custom_drop mr-2 mt-2">
    <button class="btn btn-outline-light dropdown-toggle font-16" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ $state }}
    </button>
    <div class="dropdown-menu city_drop_down" id="dropdown-state">
        <input type=" text" class="form-control" placeholder="Search.." id="stateinput" onkeyup="filterFunction();" autocomplete="off">
        <?php if (request()->req_country) { ?>
            @foreach(\App\State::where('country_id', request()->req_country['id'] )->get() as $state)
            <a class="dropdown-item" href="{{ str_replace('__NAME__', $state->domain ,env('APP_URL_SLUG')) }}" id="state_{{$state->code}}">
                <label for="state_{{$state->code}}" style="cursor:pointer;">{{$state->name}}</label>
            </a>
            @endforeach
        <?php } else { ?>
            @foreach(\App\State::where('country_id',1)->get() as $state)
            <a class="dropdown-item" href="{{ str_replace('__NAME__', $state->domain ,env('APP_URL_SLUG')) }}" id="state_{{$state->code}}">
                <label for="state_{{$state->code}}" style="cursor:pointer;">{{$state->name}}</label>
            </a>
            @endforeach
        <?php } ?>
    </div>
</div>


@if (request()->req_state)    
    <a href="http://{{ request()->req_state['name'] }}.nris.com" class="align-items-center d-flex px-md-3 text-white text-center btn p-0 pr-2 hideOnMobile mt-2 home-top-hide-mobile" style="margin-top: 5.5px; background-color:grey;" > 
    <span class=" pl-md-1">
         <?php
              $text_instate_page = explode('nris.com', $_SERVER['REQUEST_URI']);  
         if(  $text_instate_page[0] == '/') {
    echo "   You are in" ;
    }else{
        echo "Back to ";
    }
   // print_R( $text_instate_page );
    ?>
    
        {{ request()->req_state['name'] }} Home Page</span></a>
@endif
