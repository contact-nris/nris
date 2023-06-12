<div id="business-hours">
    <h4>Business Hours</h4>

    <?php 
        $time = App\BusinessHour::firstOrNew(array(
            'model' => $model,
            'model_id' => (int)$model_id,
        ));

    ?>
   
    <div class="btn-group">
        <label class="form-control">
            <input type="checkbox" name="is24" id="is24" value="1" {{ $time->is24 ? 'checked' : '' }}> 24hour open
        </label>
    </div>

    <input type="hidden" name="business_hours_type" value="{{$model}}">
    <table class="table-striped">
        <tr>
            <th>Sun</th>
            <td><input type="text" value="{{ $time->sun_open }}" name="business_hours_sun_open" class="form-control time form-control-sm"></td>
            <td><input type="text" value="{{ $time->sun_close }}" name="business_hours_sun_close" class="form-control time form-control-sm"></td>
        </tr>
        <tr>
            <th>Mon</th>
            <td><input type="text" value="{{ $time->mon_open }}" name="business_hours_mon_open" class="form-control time form-control-sm"></td>
            <td><input type="text" value="{{ $time->mon_close }}" name="business_hours_mon_close" class="form-control time form-control-sm"></td>
        </tr>
        <tr>
            <th>Tue</th>
            <td><input type="text" value="{{ $time->tue_open }}" name="business_hours_tue_open" class="form-control time form-control-sm"></td>
            <td><input type="text" value="{{ $time->tue_close }}" name="business_hours_tue_close" class="form-control time form-control-sm"></td>
        </tr>
        <tr>
            <th>Wed</th>
            <td><input type="text" value="{{ $time->wed_open }}" name="business_hours_wed_open" class="form-control time form-control-sm"></td>
            <td><input type="text" value="{{ $time->wed_close }}" name="business_hours_wed_close" class="form-control time form-control-sm"></td>
        </tr>
        <tr>
            <th>Thu</th>
            <td><input type="text" value="{{ $time->thu_open }}" name="business_hours_thu_open" class="form-control time form-control-sm"></td>
            <td><input type="text" value="{{ $time->thu_close }}" name="business_hours_thu_close" class="form-control time form-control-sm"></td>
        </tr>
        <tr>
            <th>Fri</th>
            <td><input type="text" value="{{ $time->fri_open }}" name="business_hours_fri_open" class="form-control time form-control-sm"></td>
            <td><input type="text" value="{{ $time->fri_close }}" name="business_hours_fri_close" class="form-control time form-control-sm"></td>
        </tr>
        <tr>
            <th>Sat</th>
            <td><input type="text" value="{{ $time->sat_open }}" name="business_hours_sat_open" class="form-control time form-control-sm"></td>
            <td><input type="text" value="{{ $time->sat_close }}" name="business_hours_sat_close" class="form-control time form-control-sm"></td>
        </tr>
    </table>

    <script type="text/javascript" src="{{ url('timepicker/jquery.timepicker.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ url('timepicker/jquery.timepicker.min.css') }}">
    <script type="text/javascript">
        $('#business-hours .time').timepicker();
        $('#business-hours .time').focus(function(){
            $(this).attr("data-name",$(this).attr('name'))
            $(this).attr("name",(new Date).getTime())
        });
        $('#business-hours .time').blur(function(){
            $(this).attr("name",$(this).attr('data-name'))
        });

        //if is24 is checked hide the table
        $('#is24').change(function(){
            if($(this).is(':checked')){
                $('#business-hours table').hide();
            }else{
                $('#business-hours table').show();
            }
        }).change();
        
    </script>
</div>