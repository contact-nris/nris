<div class="like-container <?= (isset($user_like_status)) ? ($user_like_status == '1' ? 'liked' : ($user_like_status == '-1' ? '' : 'disliked')) : '' ?>">

    <form class="like-form-list" action="{{ route('front.like_dislike', $model_id) }}">

        @csrf

        <input type="hidden" name="model" value="{{ $model }}">

        <a href="javascript:void(0)" class="btn btn-like  {{ isset($display) ? $display : "p-0" }}" ><img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('like.png') }}" alt=""> <span class="d-inline-block"><?= isset($like_count) ? $like_count : '' ?></span></a>

        <a href="javascript:void(0)" class="btn btn-dislike  {{ isset($display) ? $display." pl-sm-2" : "pl-2" }}" ><img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('dislike.png') }}" alt=""> <span class="d-inline-block"><?= isset($dislike_count) ? $dislike_count : '' ?></span></a>

    </form>

</div>