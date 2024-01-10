

<div id="myCarousel" data-interval="false" class="carousel slide <?php if(!empty($_GET['idTypeCourse'])) echo 'form-type-'.$_GET['idTypeCourse']; ?> <?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-idcourse="<?php echo $_GET['idCourse']; ?>" data-slugtypecourse=" <?php echo $_GET['typeCourse']; ?>"  >
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="0"<?php }?>  class="active">0</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="1"<?php }?> >1</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="2"<?php }?> >2</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="3"<?php }?> >3</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="4"<?php }?> >4</li>
        <li data-target="#myCarousel" <?php if(!is_production()){?>data-slide-to="5"<?php }?> >5</li>
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
                    <?php get_template_part("template-parts/form/col-input-anni-matrimonio");?>
                    <?php get_template_part("template-parts/form/col-input-dati-corso-user");?>
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

        <div id="step2" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item ">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => 0]);?>
            <div class="form-container">
                 <?php get_template_part("template-parts/form/row-quanti-figli");?>

                <div class="row-figli my-5" style="display: none;">
                    <div class="row">
                        <div class="col-sm-12 cnt-toggle cnt-toggle-animazione">
                            <div class="toggle-container">
                                <input type="checkbox" id="switchAnimazione" name="isAnimazione" data-toggle="toggle" value="1" data-show-id="row-animazione"/><label for="switchAnimazione">Toggle</label>
                            </div>
                            <label for="switchAnimazione">Desideriamo usufruire del servizio di animazione</label>
                        </div>
                        <div class="col-sm-12">
                                <small>
                                    Per aiutarvi a custodire l’ascolto e i momenti di coppia, è previsto - per i bambini sopra i due anni - un servizio di animazione.
                                <br/>
                                    L’animazione sarà curata dai ragazzi dell’Associazione Attiva ASD e tutte le attività sono coperte da assicurazione stipulata con il CSI (Centro Sportivo Italiano).
                            <br/>
                            <b>Per i fini assicurativi, vi chiediamo di compilare dei dati aggiuntivi.</b>
                                    <br/>
                                    Al vostro arrivo troverete il modulo già compilato da firmare.

                            <br/>

                                Per l’assicurazione e i costi di animazione non vi è chiesta una quota fissa. Alla fine del corso, ciascuno di voi, potrà lasciare la propria offerta secondo le vostre possibilità.
                            </small>
                        </div>


                    </div>

                    <div id="row-animazione" class="d-none mt-5">
                        <div class="col-sm-12 mb-3">
                            <div class="h6">Compila i seguenti campi per consentirci di attivare l'assicurazione.</div>
                        </div>
                    </div>

                    <div id="modulo-figli">

                    </div>

                    <div class="row-mockup-figli" style="display: none;">
                        <div class="row row-dati-figli">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="yearsSon">Età al momento del corso*</label>
                                    <select name="son[@@NUM][yearsSon]" id="yearsSon" class="form-select">
                                        <option value="" selected>Seleziona l’età al momento del corso</option>
                                        <?php for($i=1;$i<21;$i++){?>
                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="accommodationSon">Sistemazione*</label>
                                    <select name="son[@@NUM][accommodationSon]" id="accommodationSon" class="form-select">
                                        <option value="" selected>Seleziona una sistemazione</option>
                                        <option value="Nessuna">Nessuna</option>
                                        <option value="Culla">Culla (salvo disponibilità)</option>
                                        <option value="Letto Singolo">Letto Singolo</option>
                                        <option value="Letto Singolo con sponda">Letto Singolo con sponda (salvo disponibilità)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php get_template_part("template-parts/form/div-campi-obbligatori");?>

                </div>

                <div class="row-mockup-figli-animazione" style="display: none">
                    <div class="row row-dati-figli-animazione" >
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >NOME*</label>
                                <input type="text" class="form-control"  name="son[@@NUM][firstNameSon]" placeholder="Nome" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >COGNOME*</label>
                                <input type="text" class="form-control"  name="son[@@NUM][lastNameSon]" placeholder="Cognome" required />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >CODICE FISCALE*</label>
                                <input type="text" class="form-control"  name="son[@@NUM][CodiceFiscaleSon]" placeholder="Codice Fiscale" required />
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label >LUOGO DI NASCITA*</label>
                                <input type="text" class="form-control "  name="son[@@NUM][birthplaceSon]" placeholder="Luogo di nascita" required/>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label >Data di nascita*</label>
                                <input type="date" class="form-control birth"  name="son[@@NUM][birthdateSon]" placeholder="gg/mm/aaaa" required>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-12">
                            <div class="h7">Indirizzo di residenza</div>
                        </div>
                        <div class="col-md-4 col-lg-3">
                            <div class="form-group">
                                <label >Indirizzo*</label>
                                <input type="text" class="form-control"  name="son[@@NUM][addressSon]" placeholder="Indirizzo" required/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label >CAP*</label>
                                <input type="text" class="form-control"  maxlength="5" name="son[@@NUM][capSon]" placeholder="CAP" required/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label >Provincia*</label>
                                <select class="form-control"  name="son[@@NUM][citySon]" required>
                                    <?php get_template_part("template-parts/form/option-select-province");?>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 text-center mt-5">
                        <a class="btn btn-blue btn-next btnNext " href="#myCarousel" role="button" data-slide="next">AVANTI</a>
                    </div>
                </div>
            </div>
            <a data-target="#myCarousel" data-slide-to="1" class="btn btn-redBgWhite link-back">Indietro</a>
        </div>

        <div id="step3" class="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?> carousel-item">
            <?php get_template_part("template-parts/form/header-form", 'header-form', $args = ["form_double" => 0]);?>

            <div class="form-container small bloc-card ">
                <?php get_template_part("template-parts/form/row-testo-tariffe-corso");?>

                <div class="row ">
                    <div class="col-md-4 card card-type-inscription" data-typecourse ="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-value="Pacchetto completo">
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
                            <input type="radio" name="typeInscription" value="Pacchetto completo" required/>
                        </div>
                    </div>
                    <div class="col-md-4 card card-type-inscription" data-typecourse ="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-value="Ascolto + Pasti">
                        <div class="card-body">
                            <div class="titleCard">
                                <h4 class="card-title mb-3">Ascolto + Pasti</h4>
                            </div>
                            <p class="card-text mt-5">Dovrete provvedere in autonomia alla ricerca di una sistemazione</p>
                        </div>
                        <div class="cnt-input text-center mt-5 mb-5 d-none">
                            <input type="radio" name="typeInscription" value="Ascolto + Pasti">
                        </div>
                    </div>
                    <div class="col-md-4 card card-type-inscription " data-typecourse ="<?php if (isset($_GET['typeCourse'])) echo sanitize_text_field($_GET['typeCourse']); ?>" data-value="Solo ascolto">
                        <div class="card-body">
                            <div class="titleCard">
                                <h4 class="card-title mb-3">Solo ascolto</h4>
                            </div>
                            <p class="card-text mt-5">Dovrete provvedere in autonomia alla ricerca di una sistemazione</p>
                        </div>
                        <div class="cnt-input text-center mt-5 mb-5 d-none">
                            <input type="radio" name="typeInscription" value="Solo ascolto">
                        </div>
                    </div>

                </div>
                <div class="row mt-5 pt-5">
                    <div class="col-sm-12 text-center mt-5">
                        <a class="btn btn-blue btn-next btnNext" href="#myCarousel" role="button" data-slide="next">AVANTI</a>
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
                        <button type="submit" class="btn btn-blue btn-next btnNext btn-send">INVIA</button>
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
                    <a class="btn btn-blue btn-next btnNext"  href="<?php echo site_url('/le-nostre-iniziative'); ?>">FINE</a>
                </div>
            </div>
        </div>
    </div>
</div>