@extends('layouts.admin')

@section('content')

<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Student's Talk Topic List</h1>
            {{-- <div class="page-options">
                 <a href="{{ route('famous_studenttal.form') }}" class="btn btn-sm btn-outline-primary">Add New</a>
            </div> --}}
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Student's Talk Topic List</h3>
                    </div>
                    <div class="filter bg-light card-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-3">
                                    <input type="text" name="filter_name" autofocus="" placeholder="Serach By Title" class="form-control" value="{{ old_get('filter_name') }}">
                                </div>
                                <div class="col-sm-3">
                                    <select type="text" name="state_code"class="form-control">
                                        <option value="">Filter By State</option>
                                        <?php foreach (states() as $key => $state) {?>
                                            <option <?=$state->code == old_get('state_code') ? 'selected' : ''?> value="<?=$state->code?>"><?=$state->name?></option>
                                        <?php }?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select type="text" name="topic_type"class="form-control">
                                        <option value="">Filter By Topics</option>
                                            <option <?='Accommodation' == old_get('topic_type') ? 'selected' : ''?> value="Accommodation">Accommodation</option>
                                            <option <?='CampusJobs' == old_get('topic_type') ? 'selected' : ''?> value="CampusJobs">Campus Jobs</option>
                                            <option <?='AssignmentHelp' == old_get('topic_type') ? 'selected' : ''?> value="AssignmentHelp">Assignment Help</option>
                                            <option <?='OtherTopics' == old_get('topic_type') ? 'selected' : ''?> value="OtherTopics">Other Topics</option>
                                    </select>
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
                                {{-- <th width="90px">#</th> --}}
                                <th>University</th>
                                <th>Title</th>
                                <th>State</th>
                                <th>Topics Type</th>
                                <th width="150px" class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accommodation as $list)
                                <tr>
                                    {{-- <td class="text-left">{{ $list->id }}</td> --}}
                                    <td class="text-left">{{ $list->university }}</td>
                                    <td class="text-left">{{ $list->title }}</td>
                                    <td class="text-left">{{ $list->state_code }}</td>
                                    <td class="text-left">{{ $list->type }} </td>

                                    <td class="text-right">
                                        {{--  <!--<a class="btn btn-outline-warning btn-sm"target="_blank" href="{{ route('front.grocieries.view',$list->id) }}"><i class="fe fe-eye"></i></a>-->

                                        <a class="btn btn-outline-primary btn-sm" href="{{ route('famous_studenttal.form',[$list->id]) }}"><i class="fe fe-edit"></i></a> --}}
                                        <a class="btn btn-outline-danger confirm-link btn-sm" href="{{ route('studenttalk_topic.delete',$list->id) }}"><i class="fe fe-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <p class="m-0 text-muted">Total <span>{{ $accommodation->total() }}</span> entries</p>
                        {{ $accommodation->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
