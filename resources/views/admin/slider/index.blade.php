@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Sliders List</h1>
            <div class="page-options">
                 <a href="{{ route('slider.form') }}" class="btn btn-sm btn-outline-primary">Add New</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Slider Details</h3>
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
                                <th width="150px" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td class="text-left">{{ $list->id }}</td>
                                    <td class="text-left">{{ $list->name }}</td>

                                    <td class="text-right">
                                         <!--<a class="btn btn-outline-warning btn-sm"target="_blank" href="{{ route('front.grocieries.view',$list->id) }}"><i class="fe fe-eye"></i></a>-->

                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('slider.form',[$list->id]) }}"><i class="fe fe-edit"></i></a>
                                        <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('slider.delete',$list->id) }}"><i class="fe fe-trash"></i></a>
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

@endsection
