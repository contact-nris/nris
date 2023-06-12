@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Countries List</h1>
            <div class="page-options">
                 <a href="{{ route('country.form') }}" class="btn btn-sm btn-outline-primary">Add New</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Country Details</h3>
                    </div>
                    <table class="table card-table table-sm table-hover">
                        <thead>
                            <tr>
                                <th width="90px">#</th>
                                <th width="10px"></th>
                                <th>Name</th>
                                <th width="10px">Color</th>
                                <th width="150px" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td class="text-left">{{ $list->id }}</td>
                                    <td><i class="flag flag-<?=$list->code?>"></i></td>
                                    <td class="text-left">{{ $list->name }}</td>
                                    <td class="text-left">
                                        <label class="colorbox" style="background-color:{{$list->color}} ;">
                                          &nbsp;
                                        </label>
                                    </td>

                                    <td class="text-right">
                                           <a class="btn btn-outline-warning btn-sm"target="_blank" href="https://{{$list->domain}}.nris.com"><i class="fe fe-eye"></i></a>
                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('country.form',[$list->id]) }}"><i class="fe fe-edit"></i></a>
                                        <!-- <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('country.delete',$list->id) }}"><i class="fe fe-trash"></i></a> -->
                                        <a class="btn btn-outline-danger btn-sm" onclick="delete_cou({{ $list->id }})" href="javascript:void(0)" ><i class="fe fe-trash"></i></a>
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
<div class="modal fade" id="user_pass_con" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content m-t-124">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button id="close">
          &times;
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('country.delete')}}" method="post">
          <div class="form-group">
            <label for="" class="col-form-label">Enter Password : </label>
            <input type="password" class="form-control" name="use_password">
          </div>
          <input type="hidden" name="del_val" />
          <button class="btn btn-primary">submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function delete_cou($id){
        $('#user_pass_con').modal('show');
        $('input[name="del_val"]').val($id)
    }

    $('#close').click(function () {
        $('#user_pass_con').modal('hide');
    });
</script>
@endsection
