@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Blog List</h1>
            <div class="page-options">
                 <a href="{{ route('blog.form') }}" class="btn btn-sm btn-outline-primary">Add New</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Blog Details</h3>
                    </div>
                    <table class="table card-table table-sm table-hover">
                        <thead>
                            <tr>
                                <th width="90px">#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Visibility</th>
                                <th>Status</th>
                                <th width="150px" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lists as $list)
                                <tr>
                                    <td class="text-left">{{ $list->id }}</td>
                                    <td class="text-left">{{ $list->title }}</td>
                                    <td class="text-left">{{ $list->category_name }}</td>
                                    <td class="text-left">{{ $list->visibility }}</td>
                                    <td class="text-left">{!! status_text($list->status) !!} </td>

                                    <td class="text-right">
                                         <a class="btn btn-outline-warning btn-sm"target="_blank" href="{{ route('front.blog.view',$list->id) }}"><i class="fe fe-eye"></i></a>

                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('blog.form',[$list->id]) }}"><i class="fe fe-edit"></i></a>
                                        <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('blog.delete',$list->id) }}"><i class="fe fe-trash"></i></a>
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
