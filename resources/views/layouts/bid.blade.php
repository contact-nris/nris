<div class="comment-box bg-white">
        <h2>Bid Bargain</h2>
    <div class="">
        <form action="{{route('ads_bid.submit')}}" method="post" id="formBio">
            @csrf
            <div class="row">
                <div class="col-12 col-md-4">
                    <input type="text" name="amount" placeholder="Bid $ Amount" class="form-control form-control-lg">
                </div>
                <div class="col-12 col-md-6 mb-md-0 mb-3">
                    <input type="text" name="comment" placeholder="Message" class="form-control form-control-lg">
                </div>
                <input type="hidden" name="model_name" value="{{ $model_name }}">
                <input type="hidden" name="model_id" value="{{ $model_id }}">

                <div class="col-12 col-md-2">
                    <button type="submit" class="btn btn-common mt-md-0 float-right mt-3">Post Bid
                    </button>
                </div>
            </div>
        </form>
        @php 
            $bids = App\ads_bid::where('model_name',$model_name)->where('model_id',$model_id)->paginate(8);
        @endphp
        <table class="table-bordered mt-3 table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Bid Amount</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                @if (count($bids))                    
                    @foreach($bids as $val_bids)
                        <tr>
                            <td>{{ $val_bids['id'] }}</td>
                            <td>{{ $val_bids['amount'] }}</td>
                            <td>{{ $val_bids['comment'] }}</td>
                        </tr>
                    @endforeach
                @else
                <tr class="text-center text-danger">
                    <td colspan="3">*Data Not Found*</td>
                </tr>    
                @endif
            </tbody>
        </table>
        <div class="pagination-bar pagination justify-content-end">
            {{ $bids->appends(request()->except('page'))->links('front.pagination') }}
        </div>
    </div>
</div>

<script>
    $("#formBio").submit(function() {
        $this = $(this);
        $.ajax({
            url: $this.attr("action"),
            type: 'POST',
            dataType: 'json',
            data: new FormData($this[0]),
            processData: false,
            contentType: false,
            beforeSend: function() {
                $this.find(".btn-common").btn("loading");
            },
            complete: function() {
                $this.find(".btn-common").btn("reset");
            },
            success: function(json) {
                json_response(json, $this);
            },
        })

        return false;
    })
</script>