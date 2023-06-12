    <?php
        $time = App\BusinessHour::where(array('model' => $model, 'model_id' => (int)$model_id))->get()->first();

        if($time){
            $time_array = $time->toArray();
            $today = strtolower(date('D'));
            $strtotime = strtolower(date('Y-m-d h:ia'));

            $current_time_open = ($time_array[$today.'_open']) ? date('Y-m-d ').$time_array[$today.'_open'] : false;
            $current_time_close = ($time_array[$today.'_close']) ? date('Y-m-d ').$time_array[$today.'_close'] : false;

            $open_status = 'close';
            if($current_time_open && $current_time_close){
                if($strtotime >= strtotime($current_time_open) && $strtotime <= strtotime($current_time_close))
                {
                    $open_status = 'open';
                }
            }
             
            /*foreach ($time->toArray() as $k => $val) {
                if (strpos($k, $today) !== false) {
                    if ($val &&  (strpos($k, 'open') !== false) && $current_time >= date("H:i", strtotime($val))) {
                        $current_time_open = true;
                        $today_time_open = date("h:i:a", strtotime($val));
                    } else if ($val && (strpos($k, 'close') !== false)) {
                        $today_time_close = date("h:i:a", strtotime($val));
                        if ($current_time >= date("H:i", strtotime($val))) {
                            $current_time_close = true;
                        }
                    }
                    break;
                }
            }*/
    ?>

    <hr>
    
    @if($time->is24)
        <span class="business-open-hour text-black">Open: <b class="text-success"> 24/7</b></span>
    @else
    <h4 class="d-inline-block">Hours : </h4>

    @if($current_time_open && $current_time_close)
        <span class="business-time-status">Closed</span>
        <script type="text/javascript">
            var open_time = new Date("{{date('Y-m-d h:i a', strtotime($current_time_open))}}")
            var close_time = new Date("{{date('Y-m-d h:i a', strtotime($current_time_close))}}")
            var current = new Date()

            if(current >= open_time && current <= close_time){
                $(".business-time-status").html("Open");
                $(".business-time-status").addClass("text-success");
            }
        </script>
    @endif

    <table class="table table-borderless table-sm time-table text-black">
        <tbody>

            <tr>
                <td>Sunday</td>
                <td>{{ ($time->sun_open && $time->sun_close) ? $time->sun_open .' - '.  $time->sun_close : 'Closed' }}</td>
            </tr>
            <tr>
                <td>Monday</td>
                <td>{{ ($time->mon_open && $time->mon_close) ? $time->mon_open .' - '.  $time->mon_close : 'Closed' }}</td>
            </tr>
            <tr>
                <td>Tuesday</td>
                <td>{{ ($time->tue_open && $time->tue_close) ? $time->tue_open .' - '.  $time->tue_close : 'Closed' }}</td>
            </tr>
            <tr>
                <td>Wednesday</td>
                <td>{{ ($time->wed_open && $time->wed_close) ? $time->wed_open .' - '.  $time->wed_close : 'Closed' }}</td>
            </tr>
            <tr>
                <td>Thursday</td>
                <td>{{ ($time->thu_open && $time->thu_close) ? $time->thu_open .' - '.  $time->thu_close : 'Closed' }}</td>
            </tr>
            <tr>
                <td>Friday</td>
                <td>{{ ($time->fri_open && $time->fri_close) ? $time->fri_open .' - '.  $time->fri_close : 'Closed' }}</td>
            </tr>
            <tr>
                <td>Saturday</td>
                <td>{{ ($time->sat_open && $time->sat_close) ? $time->sat_open .' - '.  $time->sat_close : 'Closed' }}</td>
            </tr>

        </tbody>
    </table>
    @endif
    <?php } ?>
