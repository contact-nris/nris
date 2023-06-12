<div class="body_comment">

    <div class="row">
        <ul id="list_comment" class="col-md-12">
            <?php foreach ($comments as $key => $cmnt) {  ?>
                
                <li class="box_result row">
                    <div class="avatar_comment col-auto">
                      <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  
                      src="<?= userPhoto(array(
                            'profile_photo' => $cmnt->profile_photo ? $cmnt->profile_photo : '',
                            'first_name' => $cmnt->first_name,
                            'last_name' => $cmnt->last_name,
                      )) ?>" alt="">
                    </div>
                    <div class="result_comment col">
                        <h4>{{$cmnt->user}}</h4>
                        <p>{{$cmnt->comment}}</p>
                        <div class="tools_comment">
                            <a class="replay btn-comment-reply" href="javascript:void(0)">Reply</a> | 
                            <span>{{ date_with_month($cmnt->created_at) }}</span>
                        </div>
                        <div class="replay-form">
                            <form class="comment-form" action="{{ route($route,$cmnt->id) }}">
                                @csrf
                                <input type="hidden" name="model_id" value="{{ $model_id }}">
                                <input type="hidden" name="current_url" value="{{  Request::url() }}">
                                <div class="form-group mb-1">
                                    <label>Reply</label>
                                    <textarea name="comment" class="form-control"></textarea>
                                </div>

                                <div class="text-right">
                                    <button class="btn btn-submit btn-dark" type="submit">Submit Reply</button>
                                </div>
                            </form>
                        </div>
                        <ul class="child_replay">
                            @foreach($cmnt->child as $child)
                                <li class="box_reply row">
                                    <div class="avatar_comment col-auto">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  src="<?= userPhoto(array(
                            'profile_photo' => $child->profile_photo ? $cmnt->profile_photo : '',
                            'first_name' => $child->first_name,
                            'last_name' => $child->last_name,
                      )) ?>" alt="">
                                    </div>
                                    <div class="result_comment col">
                                        <h4>{{ $child->user }}</h4>
                                        <p>{{ $child->comment}}</p>
                                        <div class="tools_comment">
                                            <span>{{ date_with_month( $child->created_at) }}</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>

<div class="pagination-bar pagination justify-content-end">
    {{ $comments->appends(request()->except('page'))->links('front.pagination') }}
</div>

<style type="text/css">
    .replay-form{
        display: none;
    }
    #fbcomment{
      background:#fff;
      border: 1px solid #dddfe2;
      border-radius: 3px;
      color: #4b4f56;
      padding:50px;
      color: #000;
    }
    .header_comment{
        font-size: 14px;
        overflow: hidden;
        border-bottom: 1px solid #e9ebee;
        line-height: 25px;
        margin-bottom: 24px;
        padding: 10px 0;
    }
    .sort_title{
      color: #4b4f56;
    }
    .sort_by{
      background-color: #f5f6f7;
      color: #4b4f56;
      line-height: 22px;
      cursor: pointer;
      vertical-align: top;
      font-size: 12px;
      font-weight: bold;
      vertical-align: middle;
      padding: 4px;
      justify-content: center;
      border-radius: 2px;
      border: 1px solid #ccd0d5;
    }
    .count_comment{
      font-weight: 600;
    }
    .body_comment{
        padding: 0 8px;
        font-size: 14px;
        display: block;
        line-height: 25px;
        word-break: break-word;
        color: #000;
    }
    .avatar_comment{
      display: block;
      width: 64px !important;
    }
    .avatar_comment img{
      height: 45px;
      width: 45px;
    }
    .replay-form {
        background: #eee;
        padding: 11px 18px;
        margin-top: 10px;
        border-radius: 5px;
    }
    .box_comment{
        display: block;
        position: relative;
        line-height: 1.358;
        word-break: break-word;
        border: 1px solid #d3d6db;
        word-wrap: break-word;
        background: #fff;
        box-sizing: border-box;
        cursor: text;
        font-family: Helvetica, Arial, sans-serif;
        font-size: 16px;
        padding: 0;
    }
    .box_comment textarea{
        min-height: 40px;
        padding: 12px 8px;
        width: 100%;
        border: none;
        resize: none;
    }
    .box_comment textarea:focus{
      outline: none !important;
    }
    .box_comment .box_post{
        border-top: 1px solid #d3d6db;
        background: #f5f6f7;
        padding: 8px;
        display: block;
        overflow: hidden;
    }
    .box_comment label{
      display: inline-block;
      vertical-align: middle;
      font-size: 11px;
      color: #90949c;
      line-height: 22px;
    }
    .box_comment button{
      margin-left:8px;
      background-color: #4267b2;
      border: 1px solid #4267b2;
      color: #fff;
      text-decoration: none;
      line-height: 22px;
      border-radius: 2px;
      font-size: 14px;
      font-weight: bold;
      position: relative;
      text-align: center;
    }
    .box_comment button:hover{
      background-color: #29487d;
      border-color: #29487d;
    }
    .box_comment .cancel{
        margin-left:8px;
        background-color: #f5f6f7;
        color: #4b4f56;
        text-decoration: none;
        line-height: 22px;
        border-radius: 2px;
        font-size: 14px;
        font-weight: bold;
        position: relative;
        text-align: center;
      border-color: #ccd0d5;
    }
    .box_comment .cancel:hover{
        background-color: #d0d0d0;
        border-color: #ccd0d5;
    }
    .box_comment img{
      height:16px;
      width:16px;
    }
    .box_result{
      margin-top: 24px;
    }
    .box_result .result_comment h4{
      font-weight: 600;
      white-space: nowrap;
      color: var(--main-color);
      cursor: pointer;
      text-decoration: none;
      font-size: 14px;
      line-height: 1.358;
      margin:0;
    }
    .box_result .result_comment{
      display:block;
      overflow:hidden;
      line-height: 1;
    }
    .child_replay{
        border-left: 1px dotted #d3d6db;
        margin-top: 12px;
        list-style: none;
        padding:0 0 0 8px
    }
    .reply_comment{
        margin:12px 0;
    }
    .box_result .result_comment p{
      margin: 4px 0;
      text-align:justify;
    }
    .box_result .result_comment .tools_comment{
      font-size: 12px;
      line-height: 1.358;
    }
    .box_result .result_comment .tools_comment a{
      color: var(--main-colorf);
      cursor: pointer;
      text-decoration: none;
    }
    .box_result .result_comment .tools_comment span{
      color: #90949c;
    }
    .body_comment .show_more{
      background: #3578e5;
      border: none;
      box-sizing: border-box;
      color: #fff;
      font-size: 14px;
      margin-top: 24px;
      padding: 12px;
      text-shadow: none;
      width: 100%;
      font-weight:bold;
      position: relative;
      text-align: center;
      vertical-align: middle;
      border-radius: 2px;
    }
    /*.replay-form{
        display: none;
    }
    .comment-list li {
        border-bottom: solid 1px #ddd;
        padding: 10px 9px;
    }

    .comment-list li .avatar {
        border-radius: 50%;
        border: solid 1px #ddd;
    }*/
</style>

<script type="text/javascript">
$(".btn-comment-reply").click(function() {
    $(this).parents("li").find(".replay-form").toggle()
});
$(".comment-form").submit(function() {
    $this = $(this);
    $.ajax({
        url: $this.attr("action"),
        type: 'POST',
        dataType: 'json',
        data: new FormData($this[0]),
        processData: false,
        contentType: false,
        beforeSend: function() {
            $this.find(".btn-submit").btn("loading");
        },
        complete: function() {
            $this.find(".btn-submit").btn("reset");
        },
        success: function(json) {
            json_response(json, $this);
        },
    })

    return false;
})
</script>