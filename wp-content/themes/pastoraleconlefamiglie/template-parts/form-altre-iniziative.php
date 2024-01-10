<?php
$form_double = 0;
?>

<div id="myCarousel" data-interval="false" class="carousel slide <?php if(!empty($_GET['idTypeCourse'])) echo 'form-type-'.$_GET['idTypeCourse']; ?> <?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-idcourse="<?php echo $_GET['idCourse']; ?>" data-slugtypecourse=" <?php echo $_GET['typeCourse']; ?>"  >
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="0"<?php }?> class="active">0</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="1"<?php }?>>1</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="2"<?php }?>>2</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="3"<?php }?>>3</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="4"<?php }?>>4</li>
    </ol>
    <div class="carousel-inner pb-5">
        <div id="step0" class="carousel-item active">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => $form_double]);?>
            <?php get_template_part("template-parts/form/step0-informativa-corso", 'step0', $args = ["typeCourse" => $_GET['typeCourse']]);?>
        </div>

        <div id="step1" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => $form_double]);?>
            <div class="form-container small">
                <?php get_template_part("template-parts/form/row-dati-user");?>

                <div class="row mt-5 mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="numPerson">NUMERO PARTECIPANTI</label>
                            <select name="numPerson" id="numPerson" class="form-select" required>
                                <?php for($i=1;$i<11;$i++){?>
                                    <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <?php get_template_part("template-parts/form/col-input-anni-matrimonio");?>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea name="note" id="note" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <?php get_template_part("template-parts/form/div-campi-obbligatori");?>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <a class="btn btn-blue btn-next btnNext" href="#myCarousel" role="button" data-slide="next">AVANTI</a>
                    </div>
                </div>
            </div>
            <a data-target="#myCarousel" data-slide-to="0" class="btn btn-redBgWhite link-back">Indietro</a>
        </div>

        <div id="step2" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => $form_double]);?>
            <div class="form-container">
                <?php get_template_part("template-parts/form/row-quanti-figli");?>
                <div class="row">
                    <div class="col-sm-12 text-center mt-5">
                        <a class="btn btn-blue btn-next btnNext " href="#myCarousel" role="button" data-slide="next">AVANTI</a>
                    </div>
                </div>
            </div>
            <a data-target="#myCarousel" data-slide-to="1" class="btn btn-redBgWhite link-back">Indietro</a>
        </div>

        <div id="step4" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => $form_double]);?>
            <div class="form-container small">

                <?php get_template_part("template-parts/form/row-privacy-policy", 'header-form');?>

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-blue btn-next btnNext btn-send">INVIA</button>
                    </div>
                </div>
            </div>
            <a data-target="#myCarousel" data-slide-to="2" class="btn btn-redBgWhite link-back">Indietro</a>
        </div>

        <div id="step5" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => $form_double]);?>
            <?php get_template_part("template-parts/form/thanksPage");?>
            <div class="row mt-5">
                <div class="col-sm-12 text-center">
                    <a class="btn btn-blue btn-next btnNext"  href="<?php echo site_url('/le-nostre-iniziative'); ?>">FINE</a>
                </div>
            </div>
        </div>
    </div>
</div>