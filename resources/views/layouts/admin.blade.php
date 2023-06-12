<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Language" content="en" />
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="theme-color" content="#4188c9">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="./favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />
    <?php
        $selected_country = country_id(true);
    ?> 

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $selected_country->name }} - {{ config('app.name', 'Laravel') }}</title>

    <?php
    $colors = array(
        1 => '#3A396B',
        2 => '#F60000',
        3 => '#F7C600',
        4 => '#000000',
        5 => '#002379',
    );
    ?>
    <style type="text/css">
        :root {
            --theme: <?= $selected_country->color ?>;
            --theme-dark: #295a9f;
        }

        /*.card-header{
            background-image: -webkit-linear-gradient( 30deg , <?= $colors[country_id()] ?> 20%, #ffffff 50%) !important;
         
            color: #fff;
            border-radius: 3px;
            top: -1px;
            left: -1px;
            position: relative;
        }
        .card{
            position: relative;
        }*/
        /*.footer {
            color: #fff;
            border-top: solid 5px <?= $colors[country_id()] ?> !important;
            ;

        }*/
    </style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

    <link href="<?= url('admin_assets/dashboard.css') ?>" rel="stylesheet" />
    <link href="<?= url('admin_assets/common.css') . '?v=' . time() ?>" rel="stylesheet" />

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link rel="stylesheet" type="text/css" href="{{ url('admin_assets/dp/jquery.datetimepicker.min.css') }}" />
    <script src="{{ url('admin_assets/dp/jquery.datetimepicker.full.min.js') }}"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script src="{{ url('notification/jquery.notify.js') }}"></script>
    <link href="{{ url('notification/jquery.notify.css') }}" rel="stylesheet">

    <script type="text/javascript" src="<?= url('admin_assets/common.js') . '?v=' . time() ?>"></script>

    <script type="text/javascript">
        (function($) {
            $.fn.btn = function(action) {
                var self = $(this);
                if (action == 'loading') {
                    $(self).addClass("btn-loading");
                }
                if (action == 'reset') {
                    $(self).removeClass("btn-loading");
                }
            }
        })(jQuery);

        var json_response = function(json, container) {
            $container = $(container);

            $container.find(".alert-dismissable").remove();
            $container.find(".is-invalid").removeClass('is-invalid');
            $container.find(".has-error").removeClass('has-error');

            if (json['errors']) {
                $.each(json['errors'], function(i, j) {
                    $ele = $container.find('[name="' + i + '"]');
                    if ($ele) {
                        $ele.addClass('is-invalid');
                        $ele.parents(".form-group").addClass("has-error");
                        $ele.after("<span class='text-danger alert-dismissable'>" + j + "</span>");
                    }
                })
            }

            if (json['location']) {
                window.location = json['location'];
            }

            if (json['success_message']) {
                $.notify({
                    position: 8,
                    type: 'success',
                    autoClose: true,
                    message: json['success_message']
                });
            }

            if (json['error_message']) {
                $.notify({
                    position: 8,
                    type: 'error',
                    autoClose: true,
                    message: json['error_message']
                });
            }

            if (json['reload']) {
                window.location.reload();
            }
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        var format = 'DD-M-YYYY';

        function apply_dp(ele) {
            $(ele).datepicker({
                dateFormat: 'yy-mm-dd'
            })
        }

        function apply_drp(ele) {
            $(ele).daterangepicker({
                opens: 'left',
                autoUpdateInput: false,
                ranges: {
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],

                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
                },
                locale: {
                    cancelLabel: 'Clear',
                    format: format
                }
            });

            $(ele).on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format(format) + ' - ' + picker.endDate.format(format));
                $(this).change();
            });

            $(ele).on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $(this).change();
            });
        }

        function fillCity(state_code, con, selected) {
            $this = $(con);
            if (state_code) {
                $.ajax({
                    url: '{{ route("get_city") }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        state_code: state_code
                    },
                    beforeSend: function() {
                        $(con).prop("disabled", true);
                    },
                    complete: function() {
                        $(con).prop("disabled", false);
                    },
                    success: function(json) {
                        var html = '<option value="">Choose City</option>';
                        $.each(json['lists'], function(i, j) {
                            html += `<option ${j.id == selected ? 'selected' : ''} value="${j.id}">${j.name}</option>`;
                        })
                        $(con).html(html)
                    },
                })
            } else {
                var html = '<option value="">Choose City</option>';
                $(con).html(html)
            }
        }

        function fillState(country_id, con, selected) {
            $this = $(con);
            if (country_id) {
                $.ajax({
                    url: '{{ route("front.get_state") }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        country_id: country_id
                    },
                    beforeSend: function() {
                        $(con).prop("disabled", true);
                    },
                    complete: function() {
                        $(con).prop("disabled", false);
                    },
                    success: function(json) {
                        var html = '<option value="">Choose State</option>';
                        $.each(json['lists'], function(i, j) {
                            html += `<option ${j.id == selected ? 'selected' : ''} value="${j.id}">${j.name}</option>`;
                        })
                        $(con).html(html)
                    },
                })
            } else {
                var html = '<option value="">Choose State</option>';
                $(con).html(html)
            }
        }
    </script>
    <?php $user = \Auth::user(); ?>
</head>

<body class="">
    <div class="page">
        <div class="flex-fill">
            <div class="header border-bottom py-2">
                <div class="">
                    <div class="d-flex align-items-center">
                        <a style="width: 235px;" class="header-brand" href="{{ route('dashboard') }}">
                            <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ url('logo.png') }}" style="height: 2.8rem;" class="header-brand-img d-inline-block" alt="tabler logo">
                        </a>
                        <div class="container">
                            <div class="d-flex justify-content-between ml-auto order-lg-2 align-items-center">
                                <div>
                                    <h3 class="m-0 text-primary" style="line-height: 1"> <i class="flag flag-<?= $selected_country->code ?>"></i> {{ $selected_country->name }}</h3>
                                </div>
                                <div>
                                    <a href="{{ route('pending-appro.index') }}" class="btn btn-outline-dark"> Activation Awaiting - {{ count_data() }}</a>
                                </div>
                                <div class="dropdown">
                                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                        <span class="avatar" style=""></span>
                                        <span class="ml-2 d-none d-lg-block">
                                            <span class="text-default">{{ $user->name }}</span>
                                            <small class="text-muted d-block mt-1">{{ $user->role }}</small>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a href="{{ route('profilesetting.form') }}" class="dropdown-item"><i class="dropdown-icon fe fe-user"></i> Profile</a>
                                        <a href="{{ route('admin.logout') }}" class="dropdown-item"><i class="dropdown-icon fe fe-log-out"></i> Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" id="button-menu" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                            <span class="header-toggler-icon"></span>
                        </a>
                    </div>
                </div>
            </div>

            <nav id="column-left">
                <a class="header-brand" href="{{ route('dashboard') }}">
                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ url('logo-'. $selected_country->code .'.png') }}" class="header-brand-img d-inline-block" alt="tabler logo">
                </a>
                <div id="navigation">
                    <?php
                    $selected_country = country_id();
                    $country = \App\Country::all();
                    ?>
                    <select onchange="window.location.href=this.value" class="form-control">
                        <?php foreach ($country as $key => $value) { ?>
                            <option <?= $selected_country == $value->id ? 'selected' : '' ?> value="{{ route("change_state",$value->id) }}"><?= $value->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <ul id="menu">
                    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard fw"></i> Dashboard</a> </li>
                    <li><a href="{{ route('pending-appro.index') }}"><i class="fe fe-alert-octagon fw"></i> Pending Ad approvals</a> </li>
                    <li><a href="{{ route('home_advertisement.index') }}"><i class="fa fa-photo fw"></i> GIF Advertisements</a></li>
                    <li><a href="#locations1" data-toggle="collapse" class="parent collapsed"><i class="fa fa-map-marker fw"></i> Locations</a>
                        <ul id="locations1" class="collapse">
                            <li><a href="{{ route('country.index') }}">Country</a></li>
                            <li><a href="{{ route('state.index') }}">State</a></li>
                            <li><a href="{{ route('city.index') }}">City</a></li>
                        </ul>
                    </li>

                    <li><a href="#student_stalk" data-toggle="collapse" class="parent collapsed"><i class="fa fa-graduation-cap fw"></i> &nbsp;Student Talk</a>
                        <ul id="student_stalk" class="collapse">
                            <li><a href="{{ route('studenttalk_topic.index') }}">Student_Talk Topic</a></li>
                        </ul>
                    </li>

                    <li><a href="#FamousPlaces" data-toggle="collapse" class="parent collapsed"><i class="fa fa-heart-o fw"></i> Famous Places</a>
                        <ul id="FamousPlaces" class="collapse">
                            <li><a href="{{ route('famous_temples.index') }}">Temples</a></li>
                            <li><a href="{{ route('famous_restaurant.index') }}">Restaurant</a></li>
                            <li><a href="{{ route('famous_grocery.index') }}">Grocery</a></li>
                            <li><a href="{{ route('famous_sports.index') }}">Sports</a></li>
                            <li><a href="{{ route('famous_pubs.index') }}">Pubs</a></li>
                            <li><a href="{{ route('famous_casinos.index') }}">Casinos</a></li>
                            <li><a href="{{ route('famous_theaters.index') }}">Theaters</a></li>
                            <li><a href="{{ route('famous_advertisements.index') }}">Advertisements</a></li>
                            <li><a href="{{ route('famous_desipage.index') }}">Desi Page</a></li>
                            <li><a href="{{ route('famous_event.index') }}">Events</a></li>
                            <li><a href="{{ route('famous_batche.index') }}">Batches</a></li>
                            <li><a href="{{ route('famous_studenttal.index') }}"> Student's Talk</a></li>
                           
                        </ul>
                    </li>


                    <li><a href="#menuVideo" data-toggle="collapse" class="parent collapsed"><i class="fe fe-video fw"></i> &nbsp;Videos</a>
                        <ul id="menuVideo" class="collapse">
                            <li><a href="{{ route('video.index') }}">Manage Videos</a></li>
                            <li><a href="{{ route('video_category.index') }}">Video Category</a></li>
                            <li><a href="{{ route('video_language.index') }}">Video Language</a></li>
                        </ul>
                    </li>

                    <li><a href="#menuBlog" data-toggle="collapse" class="parent collapsed"><i class="fe fe-file fw"></i> Blogs</a>
                        <ul id="menuBlog" class="collapse">
                            <li><a href="{{ route('blog.index') }}">Manage Blog</a></li>
                            <li><a href="{{ route('blog_category.index') }}">Blog Category</a></li>
                        </ul>
                    </li>
                    <!-- <li><a href="/admin/freestuff-classified" ><i class="fa fa-random"></i> Free Stuff</a>-->
                       
                    <!--</li>-->
                    

                    <li><a href="#menuFreeAdCategory" data-toggle="collapse" class="parent collapsed"><i class="fe fe-file-text fw"></i> Free Ads Category</a>
                        <ul id="menuFreeAdCategory" class="collapse">
                            <li><a href="{{ route('automake.index') }}">Autos</a></li>

                            <li><a href="{{ route('baby_sitting_category.index') }}">Baby Sitting Category</a></li>
                            <li><a href="{{ route('education_teaching_category.index') }}">Education & Teaching</a></li>
                            <li><a href="{{ route('electronic_category.index') }}">Electronics Category</a></li>
                            <li><a href="{{ route('job_category.index') }}">Job Category</a></li>
                            <li><a href="{{ route('theaters_type.index') }}">Theaters Type</a></li>
                            <li><a href="{{ route('mypartner_category.index') }}">My Partner Category</a></li>
                            <li><a href="{{ route('realestate_category.index') }}">Realestate Category</a></li>
                            <li><a href="{{ route('room_mate_category.index') }}">Room Mate Category</a></li>
                            <li><a href="{{ route('garagesale_category.index') }}">Garagesale Category</a></li>

                            
                            
                        </ul>
                    </li>

                    <li><a href="#menuFreeAd" data-toggle="collapse" class="parent collapsed"><i class="fe fe-alert-octagon fw"></i> Free Ads</a>
                        <ul id="menuFreeAd" class="collapse">
                            <li><a href="{{ route('auto_classified.index') }}">Auto Classified</a></li>
                            <li><a href="{{ route('babysitting_classified.index') }}">Baby Sitting</a></li>
                            <li><a href="{{ route('educationteaching_classified.index') }}">Education & Teaching</a></li>
                            <li><a href="{{ route('electronics_classifieds.index') }}">Electronics Classifieds</a></li>
                            <li><a href="{{ route('mypartner_classifieds.index') }}">Desi Meet</a></li>
                            <li><a href="{{ route('jobs_classifieds.index') }}">Jobs Classifieds</a></li>
                            <li><a href="{{ route('realestate_classifieds.index') }}">Real Estate Classifieds</a></li>
                            <li><a href="{{ route('roommate_classifieds.index') }}">Room Mate Classifieds</a></li>
                            <li><a href="{{ route('garagesale_classifieds.index') }}">Garage Sale Classifieds</a></li>
                            <li><a href="{{ route('freestuff_classifieds.index') }}">Free Stuff Classifieds</a></li>
                            <li><a href="{{ route('other_classifieds.index') }}">Other Classifieds</a></li>
                            <li><a href="{{ route('advertisement_classified.index') }}">Advertisement With Us</a></li>
                        </ul>
                    </li>

                    <li><a href="#menuHomeSettings" data-toggle="collapse" class="parent collapsed"><i class="fe fe-home fw"></i> Home Page</a>
                        <ul id="menuHomeSettings" class="collapse">
                            <li><a href="{{ route('slider.index') }}">Slider</a></li>
                            <li><a href="{{ route('national_events.index') }}">National Events</a></li>
                            <li><a href="{{ route('national_batches.index') }}">Traning and Placements</a></li>

                        </ul>
                    </li>

                    <li><a href="#menuUser" data-toggle="collapse" class="parent collapsed"><i class="fe fe-users fw"></i> User</a>
                        <ul id="menuUser" class="collapse">
                            <li><a href="{{ route('user.index') }}">Web User</a></li>
                            <li><a href="{{ route('admin.index') }}">Admin User</a></li>
                            <li><a href="{{ route('nricard.index') }}">NRI Card</a></li>
                            <li><a href="{{ route('send-email.index') }}">Newsletter Email</a></li>
                        </ul>
                    </li>

                    <li><a href="#menuForum" data-toggle="collapse" class="parent collapsed"><i class="fe fe-folder fw"></i> Forums</a>
                        <ul id="menuForum" class="collapse">
                            <li><a href="{{ route('forum.index') }}">Manage Forum</a></li>
                            <li><a href="{{ route('forum_reply.index') }}">Forum Reply</a></li>
                            <li><a href="{{ route('forum_category.index') }}">Forum Category</a></li>
                        </ul>
                    </li>

                    <li><a href="#menuNRITalk" data-toggle="collapse" class="parent collapsed"><i class="fe fe-file fw"></i> NRI's Talk</a>
                        <ul id="menuNRITalk" class="collapse">
                            <li><a href="{{ route('nritalk.index') }}">Manage Threads</a></li>
                            <li><a href="{{ route('nrireply.index') }}">Manage Replies</a></li>
                        </ul>
                    </li>
                    <!--<li><a href="#menuBusi" data-toggle="collapse" class="parent collapsed"><i class="fe fe-bold fw"></i> Businesses </a>-->
                    <!--    <ul id="menuBusi" class="collapse">-->
                    <!--        <li><a href="{{ route('businesses.index') }}">Manage Businesses</a></li>-->
                    <!--        <li><a href="{{ route('businessess_category.index') }}">Businesses Category</a></li>-->
                    <!--    </ul>-->
                    <!--</li>-->
                    <li><a href="#menuRat" data-toggle="collapse" class="parent collapsed"><i class="fe fe-airplay fw"></i> Movie Rating </a>
                        <ul id="menuRat" class="collapse">
                            <li><a href="{{ route('ratingsource.index') }}">Rating Source</a></li>
                            <li><a href="{{ route('movies_external_rating.index') }}">External Ratings</a></li>
                        </ul>
                    </li>
                    <li><a href="#menuNews" data-toggle="collapse" class="parent collapsed"><i class="fe fe-video fw"></i> News Videos </a>
                        <ul id="menuNews" class="collapse">
                            <li><a href="{{ route('newsvideo.index') }}">Manage News Videos</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="#menuDesi" data-toggle="collapse" class="parent collapsed"><i class="fe fe-film fw"></i> Desi Movies </a>
                        <ul id="menuDesi" class="collapse">
                            <li><a href="{{ route('famous_citymovie.index') }}">Manage Desi Movies</a></li>
                        </ul>
                    </li>  
                </ul>
            </nav>

            <div id="content">
                <div class="container">
                    @if(session()->has('success'))
                    <div class="alert mt-3 alert-icon alert-success card-alert">
                        <i class="fa fa-check-circle mr-2" aria-hidden="true"></i> {{ session()->get('success') }}
                    </div>
                    @endif

                    @if(session()->has('error'))
                    <div class="alert mt-3 alert-icon alert-danger card-alert">
                        <i class="fe fe-alert-triangle mr-2" aria-hidden="true"></i> {{ session()->get('error') }}
                    </div>
                    @endif
                </div>

                @yield('content')
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row align-items-center flex-row-reverse">
                    <div class="col-auto ml-lg-auto">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <!-- <ul class="list-inline list-inline-dots mb-0">
                                    <li class="list-inline-item"><a href="./docs/index.html">Documentation</a></li>
                                    <li class="list-inline-item"><a href="./faq.html">FAQ</a></li>
                                </ul> -->
                            </div>
                            <div class="col-auto">
                                <!-- <a href="https://github.com/tabler/tabler" class="btn btn-outline-primary btn-sm">Source code</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
                        Copyright © 2019 All rights reserved.
                    </div>
                </div>
            </div>
        </footer>

        <script type="text/javascript">
            $(".confirm-link").click(function(event) {
                if (!confirm("Are you sure")) {
                    event.preventDefault();
                    event.stopPropagation();
                }
            })
            $('#button-menu').on('click', function(e) {
                e.preventDefault();
                $('#column-left').toggleClass('active');
            })

            $('#menu a[href]').on('click', function() {
                sessionStorage.setItem('menu', $(this).attr('href'));
            });
            if (!sessionStorage.getItem('menu')) {
                $('#menu #dashboard').addClass('active');
            } else {
                $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parent().addClass('active');
            }

            $(window).resize(function() {
                $("#column-left").height($(document).height())
            })
            $("#column-left").height($(document).height())

            $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li > a').removeClass('collapsed');
            $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('ul').addClass('show');
            $('#menu a[href=\'' + sessionStorage.getItem('menu') + '\']').parents('li').addClass('active');


            function apply_summernote(ele) {
                $(ele).summernote({
                    height: 250,
                })
            }

            apply_summernote(".summernote");
         var a =   $('#navigation').find('select.form-control option:selected').val().split('/')[5];
         
         
         var shoeArray = {
             'usa' :  1 ,
              'canada' :  2 ,
              'australia' :  3 ,
                'uk' :  4 ,
                 'newzealand' :  5 ,
               };
        
                
function getObjectKey(obj, value) {
  return Object.keys(obj).find(key => obj[key] === value);
}

                  
                  
                  $(".btn-outline-warning").each(function() {
  $(this).attr('href', $(this).attr('href').replace("nris.com",  getObjectKey(shoeArray, parseInt(a)) +".nris.com"));
});

	$('*').on('keyup', function() { // Listen for keyup events on all input elements
				var input = $(this).val(); // Get the current value of the input
				if(/[ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿ]/.test(input)) { // Test if the input contains any Spanish letters
				alert(' Spanish letters not allowed ')
			title = input.replace(/[ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõö÷øùúûüýþÿ]/g, ''); // Remove Spanish letters
			$(this).val(title); 
				}
			});
			
        </script>
    </div>
</body>

</html>