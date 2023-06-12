@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title"> Subscribe Newsletter List</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Subscribe Newsletter Details</h3>
                    </div>
                    <div class="filter bg-light card-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="filter_name" autofocus="" placeholder="Serach By Name" class="form-control" value="{{ old_get('filter_name') }}">
                                </div>
                                <div class="col-sm-3">
                                    <button class="btn btn-primary" type="submit">Search</button>
                                    <button class="btn btn-dark news-send-mail" type="button">Send Mail</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <table class="table card-table table-sm table-hover">
                        <thead>
                            <tr>
                                <th width="90px">#</th>
                                <th>Email ID</th>
                                <th width="300px" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                            <tr valign="middle">
                                <td class="text-left">{{ $list->id }}</td>
                                <td class="text-left">{{ $list->email }} </td>
                                <td class="text-right">
                                    <div>
                                        <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('send-email.delete',$list->id) }}"><i class="fe fe-trash"></i></a>
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
    $(".news-send-mail").click(function(){
        $("#newsMailModal").remove()

        $this = $(this);
        $.ajax({
            url:'{{ route("newsletter.index") }}?mailinit=true',
            type:'GET',
            dataType:'json',
            data:$("#search-form").serialize(),
            beforeSend:function(){$this.btn("loading");},
            complete:function(){$this.btn("reset");},
            success:function(json){
                if(json['html']){
                    $('body').append(json['html']);
                    $("#newsMailModal").modal("show")
                }
            },
        })

    })
</script>

@endsection