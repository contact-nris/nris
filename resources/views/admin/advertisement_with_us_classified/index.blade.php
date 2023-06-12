@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Advertisement Classifieds List</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Advertisement Classifieds Details</h3>
                    </div>
                    <div class="filter bg-light card-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="filter_name" autofocus="" placeholder="Serach By Name" class="form-control" value="{{ old_get('filter_name') }}">
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table card-table table-sm table-hover">
                        <thead>
                            <tr>
                                <th width="90px">#</th>
                                <th>Name</th>
                                <th>Business</th>
                                <th>Email Id</th>
                                <th>Web Site</th>
                                <th>Contact No</th>
                                <th width="250px" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr valign="middle">
                                    <td class="text-left">{{ $list->id }}</td>
                                    <td class="text-left">{{ $list->fname }} </td>
                                    <td class="text-left">{{ $list->business }} </td>
                                    <td class="text-left">{{ $list->email }} </td>
                                    <td class="text-left">{{ $list->website }} </td>
                                    <td class="text-left">{{ $list->phone }} </td>

                                    <td class="text-right">
                                        <div>
                                             <!--<a class="btn btn-outline-warning btn-sm"target="_blank" href="{{ route('front.grocieries.view',$list->id) }}"><i class="fe fe-eye"></i></a>-->

                                        <a class="btn btn-primary btn-sm" href="{{ route('advertisement_classified.view',$list->id) }}"><i class="fe fe-eye"></i></a>
                                            <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('advertisement_classified.delete',$list->id) }}"><i class="fe fe-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="m-0 text-muted">Total <span>{{ $lists->total() }}</span> entries</p>
                        {{ $lists->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".toggle-primium").click(function(){
        $this = $(this);
        $.ajax({
            url:'{{ route("advertisement_classified.change_type") }}',
            type:'POST',
            dataType:'json',
            data:{id:$this.attr('data-id')},
            beforeSend:function(){$this.btn("loading");},
            complete:function(){$this.btn("reset");},
            success:function(json){
                json_response(json);

                $this.removeClass('btn-success');
                $this.removeClass('btn-secondary');

                if(json['isPayed'] == 'Y'){
                    $this.addClass('btn-success');
                    $this.text('Make Free');
                } else {
                    $this.addClass('btn-secondary');
                    $this.text('Make Premium');
                }
            },
        })
    })
</script>

@endsection
