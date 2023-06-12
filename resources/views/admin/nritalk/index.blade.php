@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">NRI Talk List</h1>
            <div class="page-options">
                <a href="{{ route('nritalk.form') }}" class="btn btn-sm btn-outline-primary">Add New</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">NRI Talk Details</h3>
                    </div>
                    <table class="table card-table table-sm table-hover">
                        <thead>
                            <tr>
                                <th width="90px">#</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>State</th>
                                <th>Status</th>
                                <th width="150px" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                            <tr>
                                <td class="text-left">{{ $list->id }}</td>
                                <td class="text-left">{{ $list->title }}</td>
                                <td class="text-left"><a target="_blank" href="{{ route('user.form',$list->user_id) }}">{{ $list->username }}</a></td>
                                <td class="text-left">{{ $list->state_code }}</td>
                                <td class="text-left">
                                    <!-- {!! status_text($list->status) !!} -->
                                    <button data-id='<?=$list->id?>' data-name="status" class="btn toggle-btn btn-<?=$list->status ? 'success' : 'danger'?> btn-sm" type="button">
                                        <?=$list->status ? 'Active' : 'InActive'?>
                                    </button>
                                </td>

                                <td class="text-right">
                                     <a class="btn btn-outline-warning btn-sm"target="_blank" href="{{ route('front.nris.view',[$list->slug]) }}"><i class="fe fe-eye"></i></a>

                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('nritalk.form',[$list->id]) }}"><i class="fe fe-edit"></i></a>
                                    <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('nritalk.delete',$list->id) }}"><i class="fe fe-trash"></i></a>
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

<script>
    // nritalk.change_type
    $(".toggle-btn").click(function() {
        $this = $(this);
        $.ajax({
            url: '{{ route("nritalk.change_type") }}',
            type: 'POST',
            dataType: 'json',
            data: {
                id: $this.attr('data-id'),
                name: $this.attr('data-name'),
            },
            beforeSend: function() {
                $this.btn("loading");
            },
            complete: function() {
                $this.btn("reset");
            },
            success: function(json) {
                json_response(json);

                $this.removeClass('btn-success');
                $this.removeClass('btn-danger');

                if (json['success']) {
                    $this.addClass('btn-success');
                    $this.text(json['btn_text']);
                } else {
                    $this.addClass('btn-danger');
                    $this.text(json['btn_text']);
                }
            },
        })
    })
</script>

@endsection