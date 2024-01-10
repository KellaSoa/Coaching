<div class="panel-target" id="testimo-<?php echo $slug; ?>">
    <div class="mt-3 Testimonianze">

        <h6 class="subtitle">Testimonianze</h6>
        <?php $testimonials= get_field('testimonianze', $idCourse);
        if($testimonials) :
            foreach($testimonials as $testimonial):?>
                <div class="details-testimo row">
                    <div class="col-12 col-md-8 infoPersonal">
                        <div class="titleNotice">
                            <span><?php echo $testimonial['nome']; ?></span>
                            <div class="star">
                                <div class="star-notice">
                                    <?php // Show number Star
                                    $numberStar = $testimonial['stelle'];
                                    $i = 0;
                                    while ($i < $numberStar) { ?>
                                        <div class="star-icon">&#9733;</div>
                                        <?php ++$i;
                                    }?>
                                </div>
                            </div>
                        </div>

                        <div>
                            <?php echo $testimonial['commento']; ?>
                        </div>
                    </div>
                    <div class="col-12 col-md-4 slideImage">
                        <div class="swiper swiper-testimo">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <?php
                                if ($testimonial['slides']) {
                                    foreach ($testimonial['slides'] as $image) { ?>
                                        <div class="swiper-slide">
                                            <img src="<?php echo $image['url']; ?>" alt="">
                                        </div>
                                    <?php }
                                    }?>
                            </div>
                            <!-- If we need pagination -->
                            <div class="swiper-pagination"></div>

                            <!-- If we need navigation buttons -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>

                            <!-- If we need scrollbar -->
                            <div class="swiper-scrollbar"></div>
                        </div>
                    </div>
                </div>
            <?php endforeach;
        endif;?>
    </div>
</div>
