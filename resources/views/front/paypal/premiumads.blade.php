<?php 
    if(config('paypal.test_mode') == "1"){
        $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    } else {
        $url = 'https://www.paypal.com/cgi-bin/webscr';
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Payment</title>
</head>
    <body onLoad="document.forms[0].submit();">
        <form method="post"  action="{{$url}}" name="paypal_auto_form">
            <input type="hidden" name="business" value="{{config('paypal.bussiness')}}" />
            <input type="hidden" name="rm" value="2" />
            <input type="hidden" name="cmd" value="_xclick" />
            <input type="hidden" name="currency_code" value="USD" />
            <input type="hidden" name="quantity" value="1" />
            <input type="hidden" name="return" value="{{ route('preadbuy.return') }}" />
            <input type="hidden" name="cancel_return" value="{{ route('preadbuy.cancel_return') }}" />
            <input type="hidden" name="notify_url" value="{{ route('adsbuy.notify_url',['id' => $id,'model' => $model]) }}" />
            <input type="hidden" name="item_name" value="{{ $model }} Premium Ads" />
            <input type="hidden" name="custom" value="{{ auth()->user()->id }}" />
            <input type="hidden" name="item_number" value="{{ $item->id }}" />
            <input type="hidden" name="amount" value="5" />
            <input type="submit" value="Click here if you&#039;re not automatically redirected..." />
        </form>
    </body>
</html>