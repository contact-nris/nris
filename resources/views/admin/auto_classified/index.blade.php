@extends('layouts.admin')

@section('content')
    <div class="my-md-5 my-3">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Auto Classified List</h1>
                <div class="page-options">

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Auto Classified Details</h3>
                        </div>
                        <div class="bg-light card-body filter">
                            <form>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="text" name="filter_name" autofocus="" placeholder="Serach By Name"
                                            class="form-control" value="{{ old_get('filter_name') }}">
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="card-table table-sm table-hover table">
                            <thead>
                                <tr>
                                    <th width="90px">#</th>
                                    <th>Title</th>
                                    <th>Make</th>
                                    <th>Model</th>
                                    <th>Condition</th>
                                    <th>Year</th>
                                    <th>State</th>
                                    <th width="300px" class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lists as $list)
                                    <tr valign="middle">
                                        <td class="text-left">{{ $list->id }}</td>
                                        <td class="text-left">{{ $list->title }} </td>
                                        <td class="text-left">{{ $list->auto_makes_name }} </td>
                                        <td class="text-left">{{ $list->model_name }} </td>
                                        <td class="text-left">{{ $list->auto_condition }} </td>
                                        <td class="text-left">{{ $list->year }} </td>
                                        <td class="text-left">{{ $list->states_name }} </td>

                                        <td class="text-right">
                                            <div>
                                                <button data-id='<?=$list->id?>' data-name="display_status"
                                                    class="btn toggle-btn btn-<?=$list->display_status ? 'success' : 'secondary'?> btn-sm"
                                                    type="button">
                                                    <?=$list->display_status ? 'Activate ' : 'Deactivate '?>
                                                </button>
                                                <button data-id='<?=$list->id?>' data-name="isPayed"
                                                    class="btn toggle-btn btn-<?=$list->isPayed == 'Y' ? 'success' : 'secondary'?> btn-sm"
                                                    type="button">
                                                    <?=$list->isPayed == 'Y' ? 'Make Free' : 'Make Premium'?>
                                                </button>
                                                 <a class="btn btn-outline-warning btn-sm"target="_blank" href="{{ route('auto.view',$list->id) }}"><i class="fe fe-eye"></i></a>
                                         <a class="btn btn-primary btn-sm" href="{{ route('auto_classified.view',['id' => $list->id]) }}"><i class="fe fe-eye"></i></a>
                                                <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('auto_classified.view',['id' => $list->id]) }}"><i
                                                        class="fe fe-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <p class="text-muted m-0">Total <span>{{ $lists->total() }}</span> entries</p>
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
                url: '{{ route('auto_classified.change_type') }}',
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
