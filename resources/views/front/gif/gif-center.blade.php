<!-- L -> 85 U -> 70--> <?php if (\Route::currentRouteName() == 'home' || \Route::currentRouteName() ==  'home.gifdata') { ?> 
    <div id="hero-area" style="position: relative;">
  <div class="overlay" style="background: #c9d1d3 url({{ str_replace(" ", "%20" , $bg_image )}}) center center;background-size:cover;height: 100%;
        <?php
              /* if($sd == 1){
               echo 'left:15%;width:70%;';
               }else{
               echo 'width:85%';
               }
               */
               ?>
            ">
  </div>
  <!--L width 85% U->left:15%;width:70%-->
  <!--naveennaveen-->

  <!--L end-->
  <div class=" row ml-0 responsiveWidth2-sai">
    <!--L ml-0 style="width:85%"-->
    <div class="row col-10 mx-auto justify-content-center home-banner-height">
      <div class="col-md-12 col-lg-9 col-xs-12 text-center px-0">
        <div class="contents" style="padding-top:0px;">
          <p class="">EXPLORE IN {{ $country_name }}</p>
          <h3 class="head-title mb-0">What's happening in your State?</h3>
          <style>
            /*.autocomplete {*/
            /*the container must be positioned relative:*/
            /*  position: relative;*/
            /*  display: inline-block;*/
            /*}*/
            /*.autocomplete-items {*/
            /*  position: absolute;*/
            /*  border: 1px solid #d4d4d4;*/
            /*  border-bottom: none;*/
            /*  border-top: none;*/
            /*  z-index: 99;*/
            /*position the autocomplete items to be the same width as the container:*/
            /*  top: 100%;*/
            /*  left: 0;*/
            /*  right: 0;*/
            /*}*/
            .autocomplete-items div {
              padding: 10px;
              cursor: pointer;
              background-color: #fff;
              border-bottom: 1px solid #d4d4d4;
              color: black;
            }

            .autocomplete-items div:hover {
              when hovering an item:
                background-color: #0a0a0a;
            }

            /*.autocomplete-active {*/
            /*when navigating through the items using the arrow keys:*/
            /*  background-color: DodgerBlue !important;*/
            /*  color: #ffffff;*/
            /*}*/
          </style>
          <div class="search-bar col-12">
            <div class="search-inner">
              <form autocomplete="off" class="search-form mb-0" action="{{ route('home.search') }}">
                <div class="form-group">
                  <div class="autocomplete" style="width:300px;">
                    <input type="text" name="filter_name" id="filter_name" class="form-control" placeholder="What are you looking for?" required>
                  </div>
                </div>
                <div class="form-group inputwithicon border">
                  <div class="select">
                    <select required>
                      <option value="">Select state</option> <?php foreach ($states as $key => $state) { ?> <option value="{{ $state->id }}">{{ $state->name }}</option> <?php } ?>
                    </select>
                  </div>
                  <i class="lni-menu"></i>
                </div>
                <button class="btn btn-common" type="submit">
                  <i class="fa fa-search"></i> Search Now </button>
              </form>
            </div>
          </div>
        </div>
        <div class="d-block home_small_icon">
          <ul class="list-inline font-16"> @if ($page_type == 'state') <li class="list-inline-item dropdown">
              <a href="" class="text-white">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/box_office_icon.png') }}" alt="box_office_icon" class="" width="45">
                <span class="d-block">Box Office</span>
              </a>
              <ul class="dropdown-menu" role="menu"> @foreach ($theater_category as $category) <li>
                  <a class="dropdown-item" href="{{ route('front.theaters.list', $category->slug) }}">{{ $category->type }}</a>
                </li> @endforeach </ul>
            </li> @endif @if ($page_type == 'state') <li class="list-inline-item dropdown">
              <a href="#" class="text-white" class="dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/restaurants_icon.png') }}" alt="restaurants_icon" class="" width="45">
                <span class="d-block">Restaurants</span>
              </a>
              <ul class="dropdown-menu" role="menu"> @foreach ($restaturant_category as $category) <li>
                  <a class="dropdown-item" href="{{ route('restaurants.index', $category->slug) }}">{{ $category->type . ' Restaurants' }}</a>
                </li> @endforeach </ul>
            </li>
            <li class="list-inline-item dropdown">
              <a href="#" class="text-white" class="dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/temple_icon.png') }}" alt="temple_icon" class="" width="45">
                <span class="d-block">Temple</span>
              </a>
              <ul class="dropdown-menu" role="menu"> @foreach ($temples_category as $category) <li>
                  <a class="dropdown-item" href="{{ route('front.temples', $category->slug) }}">{{ $category->type }}</a>
                </li> @endforeach </ul>
            </li>
            <li class="list-inline-item dropdown">
              <a href="#" class="text-white" class="dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/pub_icon.png') }}" alt="pub_icon" class="" width="45">
                <span class="d-block">Pubs</span>
              </a>
              <ul class="dropdown-menu" role="menu"> @foreach ($pubs_category as $category) <li>
                  <a class="dropdown-item" href="{{ route('front.pubs', $category->slug) }}">{{ $category->type }}</a>
                </li> @endforeach </ul>
            </li>
            <li class="list-inline-item dropdown">
              <a href="#" class="text-white" class="dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/casinos_icon.png') }}" alt="casinos_icon" class="" width="45">
                <span class="d-block">Casino</span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a class="dropdown-item" href="{{ route('casinos.index', 'top-rated') }}">Top Rated</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('casinos.index', $place_name . '-state') }}">{{ $place_name . ' casinos' }}
                  </a>
                </li>
              </ul>
            </li> @else <li class="list-inline-item">
              <a href="{{ route('restaurants.index') }}" class="text-white">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/restaurants_icon.png') }}" alt="restaurants_icon" class="" width="45">
                <span class="d-block">Restaurants</span>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="{{ route('front.temples') }}" class="text-white">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/temple_icon.png') }}" alt="temple_icon" class="" width="45">
                <span class="d-block">Temple</span>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="{{ route('front.pubs') }}" class="text-white">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/pub_icon.png') }}" alt="pub_icon" class="" width="45">
                <span class="d-block">Pubs</span>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="{{ route('casinos.index') }}" class="text-white">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/casinos_icon.png') }}" alt="casinos_icon" class="" width="45">
                <span class="d-block">Casino</span>
              </a>
            </li> @endif <li class="list-inline-item dropdown">
              <a href="#" class="dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/carpool_icon.png') }}" alt="carpool_icon" class="" width="45">
                <span class="d-block">Carpool</span>
              </a>
              <ul class="dropdown-menu" role="menu">
                <li>
                  <a class="dropdown-item" href="{{ route('front.carpool', 'local') }}">Local</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('front.carpool', 'interstate') }}">Interstate</a>
                </li>
                <li>
                  <a class="dropdown-item" href="{{ route('front.carpool', 'international') }}">International</a>
                </li>
              </ul>
            </li>
            <li class="list-inline-item dropdown">
              <a href="#" class="dropdown-toggle text-white" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/jobs_icon.png') }}" alt="jobs_icon" class="" width="45">
                <span class="d-block">Jobs</span>
              </a>
              <ul class="dropdown-menu" role="menu"> @foreach ($job_category as $category) <li>
                  <a class="dropdown-item" href="{{ route('job.index', $category->slug) }}">{{ $category->name }}</a>
                </li> @endforeach </ul>
            </li> @if ($page_type == 'state') <li class="list-inline-item">
              <a href="{{ route('front.grocieries.list') }}" class="text-white">
                <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="{{ assets_url('icon/groceries_icon.png') }}" alt="groceries_icon" class="" width="45">
                <span class="d-block">Groceries</span>
              </a>
            </li> @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
  .hororscope {
    bottom: 8px;
    position: absolute;
    right: 8px;
    width: 218px;
    font-size: 12px;
    /* padding-right: 10px; */
    color: #fff;
    background: #000000b8;
    border-color: #000000b8;
    padding: 8px;
    top: auto;
  }

  .dropup .dropdown-menu {
    background: rgba(0, 0, 0, .75);
    border: solid 1px #fff;
    border-radius: 0;
  }
  .autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
  color:black;
}
.autocomplete-items div:hover {
  when hovering an item:
  background-color: #0a0a0a;
}

</style>
<div class="btn-group dropup float-right d-none">
  <button type="button" class="hororscope dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> see your today's horosope </button>
  <ul class="cust_horoscope_drop dropdown-menu" x-placement="top-start" style="width:216px; position: absolute; transform: translate3d(1675px, -102px, 0px); top: 0px; left: 0px; will-change: transform;">
    <li id="header_horoscope">
      <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';" src="https://indiana.nris.com/stuff/images/aquarius_zodiac.png" style="height: 40px;" align="left">: <span>10</span>
    </li>
  </ul>
</div>

 <?php } ?>



                                        
<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/
var countries = <?php echo json_encode($search_new)?>
/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("filter_name"), countries);
</script>