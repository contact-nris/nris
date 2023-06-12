<?php foreach ($lists as $key => $list) { ?>
    <div class="col-lg-{{ 12 / $card_count }} col-md-{{ 12 / $card_count }} col-sm-2 d-flex align-items-stretch p-1">
        <div class="card m-0 w-100" style="border-radius:15px;">
        <div class="card-body">
            <h4 class='text-black h3 mb-0'>{{ $list->movie_name }} </h4>
            <?php if (is_array($list->rating_data) || is_object($list->rating_data)) {  ?>
                <?php $a = array_filter(array_column($list->rating_data, 0));
                $average = $a ? array_sum($a) / count($a) : 0;
                ?>
                <div class="star_parent">
                    <div class="Stars" style="--rating: {{ number_format((float)$average, 2) }};" aria-label="Rating of this product is 2.3 out of 5."></div>
                </div>
                <hr>
                <div>
                    <?php foreach ($list->rating_data as $key => $value) { ?>
                    <?php if($value[0] > 0 ){?>
                        <?php if (isset($rating_source[$key])) { ?>
                            <div class="d-flex justify-content-between mt-1">
                                <a href="{{ $value[1] }}">{{ $rating_source[$key]->source_name }}</a>
                                <p class="text-dark">{{ $value[0] }}</p>
                            </div>
                        <?php } ?>
                    <?php }  } ?>
                </div>
            <?php } else { ?>
                <div class="star_parent">
                    <div class="Stars" style="--rating: 0;" aria-label="Rating of this product is 2.3 out of 5."></div>
                </div>
                <hr>
            <?php } ?>
        </div>
            
        </div>
    </div>
<?php } ?>