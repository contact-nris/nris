<div class="modal fade" id="multiple_states_popup" tabindex=" -1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content text-black">
            <div class="modal-header">
                <h3 class="modal-title">State List</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php foreach ($states_list as $key => $val) { ?>
                        <div class="col-4 mb-1 ">
                            <div class="form-check-inline">
                                <input class="form-check-input" type="checkbox" name="states_id[]" id="states_id_{{ $key }}" value="{{ $key }}">
                                <label class="cursor-pointer form-check-label" for="states_id_{{ $key }}">{{ $val->name }}</label>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="set-status">Save State</button>
                <button type=" button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="all_states_alert" tabindex=" -1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content text-black">
            <div class="modal-header">
                <h3 class="modal-title">Alert!</h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <p>NOTE: NRIS.COM OFFERING THIS SERVICE FOR CONVINIENCE OF OUR USERS TO POST AN AD IN ALL STATES IN UNITED STATES WITH A SINGLE CLICK , IF YOU DOESN NOT OBEY FAIR USE POLICY YOUR USER ACCEESS TO THIS WEBSITE WILL BE TERMINATED PERMENTLEY AND IP ADDRESS WILL BE TAGGED</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="set-all-status" onclick="$('#all_states_alert').modal('hide')">Agree</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#input-state").on('change', function() {
        $("#state_id").val('');

        switch (value = $(this).val().toLowerCase()) {
            case 'all':
                $("#all_states_alert").modal('show');
                break;
            case 'multiple':
                $("#multiple_states_popup").modal('show');
                break;
            default:
                $("#state_id").val(value);
                break;
        }
    });

    $("#set-status").on('click', function() {
        var states_id = [];
        $("input[name='states_id[]']:checked").each(function() {
            states_id.push($(this).val());
        });

        $("#state_id").val(states_id.join(','));
        $("#multiple_states_popup").modal('hide');
    });
</script>