               <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label class="control-label"> Meta Title ( 50–60 characters ) </label>
                    <textarea name="meta_title" required class="form-control" maxlength = "60">{{ $metainfo->meta_title }}</textarea>
                  </div>
                </div>
                <div class="col">
                  <div class="form-group">
                    <label class="control-label"> Meta description ( 150-160 characters )</label>
                <textarea name="meta_description" required class="form-control" maxlength ="160">{{  $metainfo->meta_description }}</textarea>
                  </div>
                </div>  
                <div class="col">
                  <div class="form-group">
                    <label class="control-label">Meta Keywords ( 10 keywords )</label>
                  <textarea name="meta_keywords" required class="form-control" maxlength="200" >{{ $metainfo->meta_keywords }}</textarea>
                  </div>
                </div>
              </div>