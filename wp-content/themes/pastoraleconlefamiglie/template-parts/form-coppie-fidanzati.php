<?php
$richiesta_attestato_partecipazione = get_field("richiesta_attestato_di_partecipazione", $_GET['idCourse']);
?>
<div id="myCarousel" data-interval="false" class="carousel slide <?php if(!empty($_GET['idTypeCourse'])) echo 'form-type-'.$_GET['idTypeCourse']; ?> <?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-idcourse="<?php echo $_GET['idCourse']; ?>" data-slugtypecourse=" <?php echo $_GET['typeCourse']; ?>"  >
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="0"<?php }?> class="active">0</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="1"<?php }?>>1</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="2"<?php }?> >2</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="3"<?php }?> >3</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="4"<?php }?> >4</li>
        <?php if(!empty($richiesta_attestato_partecipazione)):?>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="5"<?php }?> >5</li>
        <?php endif;?>
    </ol>

    <div class="carousel-inner pb-5">
        <div id="step0" class="carousel-item active">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => 0]);?>
            <?php get_template_part("template-parts/form/step0-informativa-corso", 'step0', $args = ["typeCourse" => $_GET['typeCourse']]);?>
        </div>

        <div id="step1" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => 1]);?>
            <div class="form-container small">
                <?php get_template_part("template-parts/form/row-dati-userx2");?>

                <div class="row mt-5 mb-2">
                    <?php get_template_part("template-parts/form/col-input-anni-fidanzamento");?>
                    <?php get_template_part("template-parts/form/col-input-dati-corso-user");?>
                </div>

                <?php get_template_part("template-parts/form/div-campi-obbligatori");?>
                <div class="row mt-5">
                    <div class="col-sm-12 text-center">
                        <a class="btn btn-red btn-next btnNext" href="#myCarousel" role="button" data-slide="next">AVANTI</a>
                    </div>
                </div>
            </div>
            <a data-target="#myCarousel" data-slide-to="0" class="btn btn-redBgWhite link-back">Indietro</a>
        </div>

        <?php if(!empty($richiesta_attestato_partecipazione)):?>
        <div id="step2" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => 0]);?>
            <div class="form-container">
                <div class="row">
                    <div class="col-md-12 mb-4">
                        <div class="infoCourse py-3">
                            <img src="<?php echo esc_url(get_template_directory_uri().'/images/infoCourse.png'); ?>" alt="">
                            <p>Il <?php if (isset($_GET['idCourse'])) echo get_the_title($_GET['idCourse']);?> <strong>NON È UN CORSO PREMATRIMONIALE</strong>. Su richiesta scritta del vostro parroco, possiamo rilasciare un <strong>ATTESTATO DI PARTECIPAZIONE AL CORSO</strong>.</p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mt-2 rightAttest">
                            <div class="toggle-container">
                                <input type="checkbox" id="switchInfo" name="isAttest" data-toggle="toggle" value="1" /><label for="switchInfo">Toggle</label>
                            </div>
                            <label for="switchInfo">Desidero mi venga rilasciato l’attestato di partecipazione</label>
                        </div>
                        <div class="mt-3 ms-5 infoAttesta" style="display: none;">
                            <span>Ho compreso che per il rilascio del certificato è necessario:</span>
                            <ol class="mt-3 mb-3">
                                <li>Presentare all'arrivo la Richiesta scritta del parroco</li>
                                <li>Frequentare il corso dall'inizio alla fine</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center mt-5">
                        <a class="btn btn-red btn-next btnNext " href="#myCarousel" role="button" data-slide="next">AVANTI</a>
                    </div>
                </div>
            </div>
            <a data-target="#myCarousel" data-slide-to="1" class="btn btn-redBgWhite link-back">Indietro</a>
        </div>
        <?php endif;?>

        <div id="step3" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => 0]);?>
            <div class="form-container small bloc-card ">
                <?php get_template_part("template-parts/form/row-testo-tariffe-corso");?>
                <div class="row ">
                    <div class="col-md-4 card card-type-inscription " data-typecourse ="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-value="Pacchetto completo">
                        <div class="card-body">
                            <div class="titleCard">
                                <h4 class="card-title mb-3">Pacchetto completo</h4>
                            </div>
                            <p class="card-text mt-5">Alloggio<br>
                                +<br>
                                Pasti <br>
                                +<br>
                                Ascolto</p>
                        </div>
                        <div class="cnt-input text-center mt-5 mb-5 d-none">
                            <input type="radio" name="typeInscription" class="completo" value="Pacchetto completo" required/>
                        </div>
                    </div>
                    <div class="col-md-4 card card-type-inscription " data-typecourse ="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-value="Ascolto + Pasti">
                        <div class="card-body">
                            <div class="titleCard">
                                <h4 class="card-title mb-3">Ascolto + Pasti</h4>
                            </div>
                            <p class="card-text mt-5">Dovrete provvedere in autonomia alla ricerca di una
                                sistemazione</p>
                        </div>
                        <div class="cnt-input text-center mt-5 mb-5 d-none">
                            <input type="radio" name="typeInscription" class="pasti" value="Ascolto + Pasti">
                        </div>
                    </div>
                    <div class="col-md-4 card card-type-inscription " data-typecourse ="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-value="Solo ascolto">
                        <div class="card-body">
                            <div class="titleCard"> 
                                <h4 class="card-title mb-3">Solo ascolto</h4>
                            </div>
                            <p class="card-text mt-5">Dovrete provvedere in autonomia alla ricerca di una
                                sistemazione</p>
                        </div>
                        <div class="cnt-input text-center mt-5 mb-5 d-none">
                            <input type="radio" name="typeInscription" class="ascolto" value="Solo ascolto">
                        </div>
                    </div>

                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-sm-12 text-center mt-5">
                        <a class="btn btn-red btn-next btnNext" href="#myCarousel" role="button" data-slide="next">AVANTI</a>
                    </div>
                </div>

            </div>
            <a data-target="#myCarousel" data-slide-to="2" class="btn btn-redBgWhite link-back">Indietro</a>
        </div>

        <div id="step4" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => 1]);?>
            <div class="form-container small">

                <?php get_template_part("template-parts/form/row-dati-checkin", 'header-form');?>

                <?php get_template_part("template-parts/form/row-privacy-policy", 'header-form');?>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-red btn-next btnNext btn-send">INVIA</button>
                    </div>
                </div>
            </div>
            <a data-target="#myCarousel" data-slide-to="3" class="btn btn-redBgWhite link-back">Indietro</a>
        </div>

        <div id="step5" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => 0]);?>
            <?php get_template_part("template-parts/form/thanksPage");?>
            <div class="row mt-5">
                <div class="col-sm-12 text-center">
                    <a class="btn btn-red btn-next btnNext"  href="<?php echo site_url('/le-nostre-iniziative'); ?>">FINE</a>
                </div>
            </div>
        </div>
    </div>
</div>