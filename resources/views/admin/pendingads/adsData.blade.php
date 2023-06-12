@extends('layouts.admin')

@section('content')
    <div class="my-md-5 my-3">
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Pending Ads List</h1>
                <div class="page-options">

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <h3 class="card-title">Pending Ads Details</h3>
                        </div> --}}
                        {{-- <div class="bg-light card-body filter">
                            <form>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <input type="text" name="filter_name" autofocus="" placeholder="Serach By Name"
                                            class="form-control">
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-primary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div> --}}
                        <table class="card-table table-sm table-hover table">
                            <thead>
                                <tr>
                                    <th width="90px">#</th>
                                    <th>Title</th>
                                    <th>Ads Type</th>
                                    <th>created_at</th>
                                    <th width="300px" class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
if (isset($_GET['test'])) {
	echo '<pre>';
	print_r($union);
	echo '</pre>';die;
}
;
?>
                                @foreach ($union as $list)
                                    <tr valign="middle">
                                        <td class="text-left">{{ $list->id }}</td>
                                        <td class="text-left">{{ $list->title }}</td>
                                        <td class="text-left">{{ $list->ad_type }}</td>
                                        <td class="text-left">{{ $list->created_at }}</td>
                                        <td class="text-right">
                                            <div>
                                                <button data-id='<?=$list->id?>'
                                                    data-url='<?=$list->ad_type?>-change-type' data-name="display_status"
                                                    class="btn toggle-btn btn-<?=$list->display_status ? 'success' : 'secondary'?> btn-sm"
                                                    type="button">
                                                    <?=$list->display_status ? 'Deactivate Ad' : 'Make activate'?>
                                                </button>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ url('admin/' . $list->ad_type, ['id' => $list->id]) }}"><i
                                                        class="fe fe-eye"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <p class="text-muted m-0">Total <span>{{ $union->total() }}</span> Pending Ads</p>
                            {{ $union->appends(request()->except('page'))->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".toggle-btn").click(function() {
                $this = $(this);
                $.ajax({
                    url: $this.attr('data-url'),
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
        });
    </script>
@endsection
