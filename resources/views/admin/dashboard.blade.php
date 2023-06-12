@extends('layouts.admin')

@section('content')

<style type="text/css">
    .google-data-studio {
        position: relative;
        padding-bottom: 65.25%;
        padding-top: 30px;
        height: 0;
        overflow: hidden;
    }

    .google-data-studio iframe,
    .google-data-studio object,
    .google-data-studio embed {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Dashboard</h1>
            <div class="page-options">
                <div id="reportrange" class="bg-gray-lighter px-4 py-1 rounded ">
                    <i class="fa fa-calendar"></i>&nbsp;
                    <span></span> <i class="fa fa-caret-down"></i>
                </div>
                <input type="hidden" id='date_filter'>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="row row-cards">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-blue-dark text-white rounded avatar">
                                            <i class="fa fa-users"></i>
                                        </span>
                                    </div>
                                    <div class="col lh-1">
                                        <small class="text-muted">Total</small>
                                        <div class="font-weight-medium">
                                            <span class="total_user"></span> Web Users
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-green text-white rounded avatar">
                                            <i class="fa fa-credit-card"></i>
                                        </span>
                                    </div>
                                    <div class="col lh-1">
                                        <small class="text-muted">Total</small>
                                        <div class="font-weight-medium">
                                            <span class="total_nri_card"></span> NRI Card
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-azure text-white rounded avatar">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    </div>
                                    <div class="col lh-1">
                                        <small class="text-muted">Total</small>
                                        <div class="font-weight-medium">
                                            <span class="total_admin"></span> Web Admin
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <span class="bg-indigo text-white rounded avatar">
                                            <i class="fa fa-address-card"></i>
                                        </span>
                                    </div>
                                    <div class="col lh-1">
                                        <small class="text-muted">Total</small>
                                        <div class="font-weight-medium">
                                            <span class="total_home_advertise"></span> Home Advertisement
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Google Data</div>
                        <div class="card-options">
                            <button class="btn show-charts btn-primary" type="button">Show Data</button>
                        </div>
                    </div>
                    <div class="chart-data"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header ">
                        <div class="card-title">Famous Places</div>
                    </div>

                    <div class="card-table table-responsive">
                        <table class="table table-sm table-vcenter">

                            <tbody>
                                <tr>
                                    <td class="w-1"><span class="fa fa-bell" style="color: #8CB051;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Temples</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_temple">1</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-cutlery" style="color: #8CB051;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Restaurants</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_restaurant"></td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-shield" style="color: #8CB051;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Sports</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_sport"></td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-glass" style="color: #8CB051;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Pub/Party Places</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_pub"></td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-film" style="color: #8CB051;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Movie Theatres</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_theater"></td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-users" style="color: #8CB051;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Groceries</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_grocery"></td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-heart" style="color: #8CB051;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Casinos</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_casino"></td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-calendar" style="color: #8CB051;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Events</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_event"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-table table-responsive">
                        <table class="table table-sm table-vcenter">
                            <thead>
                                <tr>
                                    <th><span class="fa fa-map-marker" style="color: #337AB7;"></span> Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach (App\Country::all() as $key => $country) {?>
                                    <tr>
                                        <td>{{ $country->name }}</td>
                                        <td>{{ $country->state_count() }}</td>
                                        <td>{{ $country->state_city() }}</td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-sm-4">
                <div class="card">
                    {{-- <div class="card-header ">
                        <div class="card-title">Advertise</div>
                    </div> --}}

                    <div class="card-table table-responsive">
                        <table class="table table-sm table-vcenter">
                            <thead>
                                <tr>
                                    <th><i class="fe fe-alert-octagon fw" style="color: #FE9A11;"></i></th>
                                    <th>Free Ads</th>
                                    <th>Approvals</th>
                                    <th>Pending</th>
                                </tr>
                            </thead>
                             <tbody>
                                <tr>
                                    <td class="w-1"><span class="fa fa-car" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Auto</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($auto_app) }}</td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($auto_pen) }}</td>
                                </tr>
                                {{-- <tr>
                                    <td class="w-1"><span class="fa fa-briefcase" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Jobs</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($job_app) }}</td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($job_pen) }}</td>
                                </tr> --}}
                                <tr>
                                    <td class="w-1"><span class="fa fa-child" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Baby Sitting</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($babysitting_app) }}</td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($babysitting_pen) }}</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-heart" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">My Partner</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($mypartner_app) }}</td>
                                    <td class="text-nowrap text-center text-muted">{{ count($mypartner_pen) }}</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-home" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Real Estate</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($realestate_app) }}</td>
                                    <td class="text-nowrap text-center text-muted">{{ count($realestate_pen) }}</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-users" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Room Mates</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($roommate_app) }}</td>
                                    <td class="text-nowrap text-center text-muted">{{ count($roommate_pen) }}</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-truck" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Garage Sale</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($garagesale_app) }}</td>
                                    <td class="text-nowrap text-center text-muted">{{ count($garagesale_pen) }}</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-cogs" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Free Stuff</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($freestuff_app) }}</td>
                                    <td class="text-nowrap text-center text-muted">{{ count($freestuff_pen) }}</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-random" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Other</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($other_app) }}</td>
                                    <td class="text-nowrap text-center text-muted">{{ count($other_pen) }}</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-graduation-cap" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Education/Teaching</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($education_app) }}</td>
                                    <td class="text-nowrap text-center text-muted">{{ count($education_pen) }}</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-bolt" style="color: #FE9A11;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Electronics</div>
                                    </td>
                                    <td class="text-nowrap text-center text-muted ">{{ count($electronic_app) }}</td>
                                    <td class="text-nowrap text-center text-muted">{{ count($electronic_pen) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header ">
                        <div class="card-title">Other Details</div>
                    </div>

                    <div class="card-table table-responsive">
                        <table class="table table-sm table-vcenter">
                            <tbody>
                                <tr>
                                    <td class="w-1"><span class="fa fa-calendar" style="color: #DC3545;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">National Events</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_event">0</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-image" style="color: #DC3545;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">GIF Ads</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_home_advertise">0</td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-file" style="color: #DC3545;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Blog</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_blog"></td>
                                </tr>
                                <!--<tr>-->
                                <!--    <td class="w-1"><span class="fa fa-book" style="color: #DC3545;"></span></td>-->
                                <!--    <td class="td-truncate">-->
                                <!--        <div class="text-truncate">Forum</div>-->
                                <!--    </td>-->
                                <!--    <td class="text-nowrap text-muted "></td>-->
                                <!--</tr>-->
                                <tr>
                                    <td class="w-1"><span class="fa fa-book" style="color: #DC3545;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Nri's Talk</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_nritalk"></td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-list" style="color: #DC3545;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">News Videos</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_newsvideo"></td>
                                </tr>
                                <tr>
                                    <td class="w-1"><span class="fa fa-file" style="color: #DC3545;"></span></td>
                                    <td class="td-truncate">
                                        <div class="text-truncate">Businesses</div>
                                    </td>
                                    <td class="text-nowrap text-muted total_app_businesses"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .avatar i {
        vertical-align: baseline;
    }
</style>
<script>
    //apply_drp("#date_filter");
    $(function() {
        var start = moment();
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));

            $.ajax({
                type: "get",
                url: "{{ route('dashboard.get_count') }}",
                data: {
                    date_from: start.format('YYYY-MM-DD'),
                    date_to: end.format('YYYY-MM-DD')
                },
                dataType: "json",
                success: function(json) {
                    if (json) {
                        $.each(json, function(key, value) {
                            $("." + key).html(value);
                        });
                    }
                }
            });
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
               'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            }
        }, cb);

        cb(start, end);
    });

    $(".show-charts").click(function(){
        $(".chart-data").append(`<div class="card-body">
            <div class="google-data-studio">
                <iframe class="responsive-iframe" height="500" width="100%" src="https://datastudio.google.com/embed/reporting/368f271c-9d8f-47fe-aa4c-e746b3933af5/page/1M" frameborder="0" style="border:0;" allowfullscreen></iframe>
            </div>
        </div>`)

        $(this).remove();
    })
</script>


@endsection