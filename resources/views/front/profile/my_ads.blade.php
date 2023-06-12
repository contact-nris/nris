@extends('layouts.front',$meta_tags)

@section('content')

    <div class="container m-t-124">
        <div class="row">
            @include('front.profile.header')

            <div class="col-lg-12 col-md-12 page-content mt-4">
                <div class="card">
                    <div class="card-body">
                        <table class="table-bordered table-hover table text-black">
                            <thead class="thead-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Views</th>
                                    <th>Ads Bid</th>
                                    <th>Ad Enabled/Disabled</th>
                                    <th style="width:150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($search_data))
                                    @foreach ($search_data as $val)
                                        <tr>
                                            <td>
                                                <a href="{{ route($val['view_route'], $val['slug']) }}">
                                                    {{ $val['title'] }}
                                                </a>
                                            </td>
                                            <td>{{ dashesToCamelCase($val['type'], true) }}</td>
                                            <td>{{ $val['total_views'] }}</td>
                                            <td>
                                                @if (!empty($val['amt']))
                                                    {{ $val['amt'] }}
                                                @else
                                                    {{ 'N/A' }}
                                                @endif
                                            </td>
                                            <td>
                                                <?php if ($val['display_status'] == 1) {?>
                                                <a href="javascript:void(0)" class="text-success">Enabled</a>
                                                <?php } else {?>
                                                <a href="javascript:void(0)" class="text-danger">Disabled</a>
                                                <?php }?>
                                            </td>
                                            <td class="d-flex">
                                                @if ($val['isPayed'] == 'N' && empty($val['payment_id']))
                                                    @if ($val['post_type'] == '2')
                                                        <a href="{{ route('preadbuy.startPayment', ['ad_id' => base64_encode($val['id']), 'model' => base64_encode($val['table_model'])]) }}"
                                                            class="btn btn-outline-secondary w-100 text-black">Paid
                                                            5$</a>&nbsp;&nbsp;
                                                    @else
                                                        <span class="text-center py-2 w-100 text-black">Free
                                                            Ad</span>&nbsp;&nbsp;
                                                    @endif
                                                @else
                                                    @if ($val['post_type'] == '2')
                                                        <a href="javascript:void(0)"
                                                            class="text-success w-100 text-center">payment
                                                            complete</a>&nbsp;&nbsp;
                                                    @endif
                                                @endif
                                                {{-- {{ $val['isPayed'] }} --}}
                                                <a href="{{ route($val['edit_route'], ['update_ad', base64_encode($val['id'])]) }}"
                                                    class="btn btn-outline-info"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                                <a href="{{ route($val['delete_route'], base64_encode($val['id'])) }}"
                                                    onclick="return confirm('Are you sure?')"
                                                    class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <h3>You don't have any ads yet.</h3>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="text-muted m-0"><strong>Total <span>{{ $search_data->total() }}</span> entries</strong>
                        </p>
                        {{ $search_data->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
