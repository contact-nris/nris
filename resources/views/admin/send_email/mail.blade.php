<div class="modal fade" id="newsMailModal" tabindex="-1" role="dialog" aria-labelledby="newsMailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content m-t-124">
            <div class="modal-header">
                <h5 class="modal-title" id="newsMailModalLabel">Newsletter Send Mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            	<h3 class="text-danger font-weight-normal">Total User: {{ $total_user }}</h3>

            	<div class="form-group">
                    <label class="control-label">Subject</label>
                    <input type="text" name="subject" id="mail_subject" autofocus="" class="form-control" value="">
                </div>

                <div class="form-group">
                    <label class="control-label">Mail Content</label>
                    <textarea name="content" id="mail_content" class="summernote-mail form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary send-mail">Send Mail</button>
            </div>
        </div>
    </div>

	<script type="text/javascript">
		apply_summernote(".summernote-mail");

		$("#newsMailModal .send-mail").click(function(){
			$this = $(this);
			
			var data  = new FormData($("#search-form")[0])
			data.append("subject", $("#mail_subject").val())
			data.append("content", $("#mail_content").val())

			$.ajax({
				url:'{{ route("newsletter.index") }}?mailsubmit=true',
				type:'POST',
				dataType:'json',
				data:data,
				processData: false,
            	contentType: false,
				beforeSend:function(){$this.btn("loading");},
				complete:function(){$this.btn("reset");},
				success:function(json){
					json_response(json,$("#newsMailModal"));

					if(json['success_message']){
						$("#newsMailModal").modal("hide")
					}
				},
			})
				
		})
	</script>
</div>
