<!------------>
    <div class="" style="width: 15%;float: right;">
            <div class="">
                
                <div class="">
                    <div width="100%" height="440px">
                        <div id="data-slider" class="">
                        <?php foreach($adv as $k => $v){ ?>            
                             <div class="item mb-1">
                                <a href="http://www.tana.org/" target="_blanck">
                                    <img  onerror="this.onerror=null;this.src='https://nris.com/stuff/images/default.png';"  height="127px" width="100%" src="<?= $v->image_url?>" alt="">
                                </a>
                            </div>
                            <?php  } ?>
                            
                            
                            
                       </div>
                    </div>
                </div>
            </div>
        </div>
    <!------------>