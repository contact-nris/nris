@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 heading-margin">
            <!-- active card button -->
            @if($card_no)
            <form method="post" action="{{ route('front.profile.card.active') }}" style="min-height: 400px;" id="form">
                @csrf
                <input type="hidden" name="code" value="{{ $card_no }}">
                <h4 class="mt-5">{{$text}}</h4>
                <button type="submit" class="btn btn-success btn-submit">Activate Card</button>
            </form>
            @else
            <div style="min-height: 400px;">
                <h3 class="mt-5">{{$text}}</h3>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection