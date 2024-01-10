<?php
/* Template Name: sostienici */
get_header();
$order_ID = NexiHPP::Instance()->generateMerchantOrderID();

if(isset($_GET['paymentid'])) {
    Donation::Instance()->updateStatus($_GET['paymentid'], 'cancelled');
}
$gallery_futuro = get_field('gallery_futuro');
$gallery_presente = get_field('gallery_presente');
?>
<?php get_template_part('template-parts/button-fixed-courses');?>
<div  class="main main-sostienici ">
    <div class="header">
        <div class="container">
            <img class="w-100 my-5" src="<?php echo get_theme_file_uri('images/Sostieni-la-nostra-opera-di-evangelizzazione-con-le-famiglie.svg'); ?>" alt="Sostieni la nostra opera di evangelizzazione con le famiglie" />
        </div>
    </div>
    <div class="description py-5" style="background-image: url(<?php echo get_field('image_description'); ?>)">
        <div class="container text-center py-5">
            <?php echo get_field('description'); ?>
        </div>
    </div>

    <div class="blocco-gallery">
        <div class="container">
            <div class="row my-5 align-items-center">
                <div class="col-sm-12 col-lg-4">
                    <h3><?php echo get_field('titolo_gallery_futuro'); ?></h3>
                    <h4 class="text-dark-red"><?php echo get_field('sottotitolo_gallery_futuro'); ?></h4>
                </div>
                <div class="col-sm-12 col-lg-8 line">
                    <div class="swiper-sostienici">
                        <div class="swiper-wrapper pt-3">
                            <!-- Slides -->
                            <?php foreach ($gallery_futuro as $key => $image) :?>
                                <div class="swiper-slide">
                                    <div class="image-container">
                                        <img class="d-block w-100 imgDocument img-fluid" src="<?php echo $image['url']; ?>">
                                        <div class="description"><?php echo $image['caption']; ?><?php echo $image['description']; ?></div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>

                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="blocco-gallery">
        <div class="container">
            <div class="row my-5 align-items-center">
                <div class="col-sm-12 col-lg-4">
                    <h3><?php echo get_field('titolo_gallery_presente'); ?></h3>
                    <h4 class="text-orange"><?php echo get_field('sottotitolo_gallery_presente'); ?></h4>
                </div>
                <div class="col-sm-12 col-lg-8 line">
                    <div class="swiper-sostienici">
                        <div class="swiper-wrapper pt-3">
                            <!-- Slides -->
                            <?php foreach ($gallery_presente as $key => $image) :?>
                                <div class="swiper-slide">
                                    <div class="image-container">
                                        <img class="d-block w-100 imgDocument img-fluid" src="<?php echo $image['url']; ?>">
                                        <div class="description"><?php echo $image['caption']; ?><?php echo $image['description']; ?></div>
                                    </div>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>

                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form" id="donation-form">
        <div class="text-center pt-5">
            <h3><?php echo get_field('titolo_form'); ?></h3>
            <div><?php echo get_field('testo_form'); ?></div>
        </div>
        <div class="container">
            <form action="" method="post" class="mt-5 mb-5" id="donation" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
                <div class="form-container">
                    <input type="hidden" name="action" value="add_donation">
                    <div class="row mt-5 mb-5">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstName1">Nome*</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Nome" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastName1">Cognome*</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Cognome" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email1">Email*</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone1">Telefono</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+00 000 000 00"/>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="form-group form-group-importo">
                                <label for="firstName2">Importo* </label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">€</span>
                                    </div>
                                    <input type="text" class="form-control" id="imposto" step="1" min="0" max="1000" name="imposto" aria-label="Importo" required />
                                </div>
                                <p id="errorAmount"></p>
                            </div>
                        </div>


                        <!--div class="form-group">
                            <label for="lastName2">Metono pagamento</label>
                            <select name="pagamento" id="pagamento" class="form-select">
                                <option value=""></option>
                                <option value="CARDS">CARDS</option>
                                <option value="GOOGLEPAY">GOOGLEPAY</option>
                                <option value="APPLYPAY">APPLYPAY</option>
                                <option value="BANCOMATPAY">BANCOMATPAY</option>
                                <option value="MYBANK">MYBANK</option>
                                <option value="GIROPAY">GIROPAY</option>
                                <option value="IDEAL">IDEAL</option>
                                <option value="BANCONTACT">BANCONTACT</option>
                                <option value="PAYPAL">PAYPAL</option>
                                <option value="PAYPAL_BNPL">PAYPAL_BNPL</option>
                            </select>
                        </div-->
                    </div>

                    <div class="row mt-5 mb-5">
                        <div class="col-sm-12 cnt-toggle">
                            <div class="toggle-container text-center isAcceptCondition">
                                <input type="checkbox" id="isAcceptCondition" name="isAcceptCondition" value="1" required /><label for="isAcceptCondition">Toggle</label>
                            </div>
                            <label for="isAcceptCondition">Ho letto e accetto l'<a href="<?php echo site_url("privacy-policy");?>" target="_blank">informativa sulla privacy</a></label>
                        </div>
                        <div class="error-message text-center fw-bold" id="error-message"></div>
                    </div>

                    <div class="row my-5">
                        <div class="col-sm-12 text-center">
                            <input type="hidden" name="orderID"  id="orderID" value="<?php echo $order_ID; ?>">
                            <button type="submit" class="btn btn-redBgWhite btn-send-donation">DONA ORA</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class="altro_modo py-5" style="background-image: url(<?php echo get_field('image_blocco_aggiuntivo_sostienici'); ?>)">
        <div class="container">
            <div class="text-center pt-5 my-5">
                <h3><?php echo get_field('titolo_blocco_aggiuntivo_sostienici'); ?></h3>
            </div>

        </div>
    </div>
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php echo get_field('testo_blocco_aggiuntivo_sostienici');?>
                </div>
            </div>

            <div class="text-center my-5">
                <a href="<?php echo site_url('/contatti');?>" type="submit" class="btn btn-orange">CONTATTACI</a>
            </div>
        </div>
    </div>

    <input type="hidden" class="statusPayement" value="<?php echo $_GET['status']; ?>">
    <?php //get_template_part('template-parts/banner-contatti'); ?>
</div>
<?php get_footer();