<div class="like-container <?= (isset($likeModel) && $likeModel) ? ($likeModel->status == '1' ? 'liked' : ($likeModel->status == '-1' ?'': 'disliked')) : '' ?>">
    <form class="like-form" action="{{ route('front.like_dislike', $model_id) }}">
        @csrf

        <input type="hidden" name="model" value="{{ $model }}">
        <a class="btn btn-like p-0" ><img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('like.png') }}" alt=""></a><span class="liked-count"><?= isset($likeTotal) ? $likeTotal[1] : '' ?></span>
        <a class="btn btn-dislike p-0" ><img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="{{ asset('dislike.png') }}" alt=""></a><span class="dislike-count"><?= isset($likeTotal) ? $likeTotal[0] : '' ?></span>
    </form>
</div>

<script type="text/javascript">
    $(".like-form .btn").click(function() {
        $this = $(this);
        $form = $this.parents('.like-form')

        var formData = new FormData($form[0]);
        formData.append('status', $this.hasClass("btn-like"));

        $.ajax({
            url: $form.attr("action"),
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $this.btn("loading");
            },
            complete: function() {
                $this.btn("reset");
            },
            success: function(json) {
                json_response(json, $this);

                $form.parents('.like-container').removeClass('liked')
                $form.parents('.like-container').removeClass('disliked')

                if (json.status == '1') {
                    $form.parents('.like-container').addClass('liked');
                } else if (json.status == '0') {
                    $form.parents('.like-container').addClass('disliked');
                }

                $form.find('.liked-count').html(json.totals[1])
                $form.find('.dislike-count').html(json.totals[0])
            },
        })

        return false;
    })
</script>