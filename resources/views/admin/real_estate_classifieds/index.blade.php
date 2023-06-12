@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Real Estate Classifieds List</h1>
            <div class="page-options">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Real Estate Classifieds Details</h3>
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
                                <th>Title</th>
                                <th>Category</th>
                                <th>Contact Name</th>
                                <th>Contact Number</th>
                                <th>Contact Email</th>
                                <th width="100px">State</th>

                                <th width="300px" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                            <tr valign="middle">
                                <td class="text-left">{{ $list->id }}</td>
                                <td class="text-left">{{ $list->title }} </td>
                                <td class="text-left">{{ $list->category_name }} </td>
                                <td class="text-left">{{ $list->contact_name }} </td>
                                <td class="text-left">{{ $list->contact_number }} </td>
                                <td class="text-left">{{ $list->contact_email }} </td>
                                <td class="text-left">
                                    <div class="bword">{{ $list->states}}</div>
                                </td>

                                <td class="text-right">
                                    <div>
                                        <button data-id='<?=$list->id?>' data-name="display_status" class="btn toggle-btn btn-<?=$list->display_status ? 'success' : 'secondary'?> btn-sm" type="button">
                                            <?=$list->display_status ? 'Activate' : 'Deactivate'?>
                                        </button>
                                        <button data-id='<?=$list->id?>' data-name="isPayed" class="btn toggle-btn btn-<?=$list->isPayed == 'Y' ? 'success' : 'secondary'?> btn-sm" type="button">
                                            <?=$list->isPayed == 'Y' ? 'Make Free' : 'Make Premium'?>
                                        </button>
                                         <a class="btn btn-outline-warning btn-sm"target="_blank" href="{{ route('realestate.view',$list->slug) }}"><i class="fe fe-eye"></i></a>

                                        <a class="btn btn-primary btn-sm" href="{{ route('realestate_classifieds.view',$list->id) }}"><i class="fe fe-eye"></i></a>
                                        <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('realestate_classifieds.delete',$list->id) }}"><i class="fe fe-trash"></i></a>

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
    $(".toggle-btn").click(function() {
        $this = $(this);
        $.ajax({
            url: '{{ route("realestate_classifieds.change_type") }}',
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
                $this.removeClass('btn-secondary');

                if (json['success']) {
                    $this.addClass('btn-success');
                    $this.text(json['btn_text']);
                } else {
                    $this.addClass('btn-secondary');
                    $this.text(json['btn_text']);
                }
            },
        })
    })
</script>

@endsection