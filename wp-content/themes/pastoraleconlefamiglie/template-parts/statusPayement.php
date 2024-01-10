<?php
/**
 * @var array $args
 */
$donationValue  = $args['data']['donationValue'];
$success        = $args['data']['success'];
$orderID           = $args['data']['orderID'];
$donation = Donation::Instance()->getDonation($orderID);
$donation = $donation[0];
$donationData = json_decode($donation->datas, true);
$fisrtName     = $donationData['firstName'];
$lastName      = $donationData['lastName'];
$email         = $donationData['email'];
$phone         = $donationData['phone'];
$importo     = $donation->donation .' €';
$paymentid =$donation->paymentid;

if(empty($donation->send_mail_date)) {
    Donation::Instance()->sendMailDonationSuccess($paymentid);
}
?>
<div id="status_message" class="py-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-sm-12 col-lg-8 mx-auto">
                <?php if($success):?>
                    <div class="title py-5 text-center">
                        <h3><?php echo get_field("titolo_completata")?></h3>
                        <div><?php echo get_field("testo_completata")?></div>
                    </div>
                    <div class="row justify-content-center text-center mb-5">
                        <div class="col-sm-6">
                            <h5>Dati donazione</h5>
                            <div class="col-cnt">
                                <div class="form-group">
                                    <label>NOME: </label>
                                    <span><?php echo $fisrtName; ?></span>
                                </div>

                                <div class="form-group">
                                    <label>COGNOME: </label>
                                    <span><?php echo $lastName; ?></span>
                                </div>

                                <div class="form-group">
                                    <label>EMAIL: </label>
                                    <span><?php echo $email; ?></span>
                                </div>

                                <div class="form-group">
                                    <label>TELEFONO: </label>
                                    <span><?php echo $phone; ?></span>
                                </div>
                                <div class="form-group">
                                    <label>IMPORTO DONAZIONE: </label>
                                    <span><?php echo $importo; ?> </span>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mt-5 text-center py-5">
                        <a href="<?php echo site_url('/le-nostre-iniziative');?>" class="btn btn-red">Scopri le nostre iniziative</a>
                    </div>
                <?php else:?>
                    <div class="title py-5">
                        <h3><?php echo get_field("titolo_annullata")?></h3>
                        <div><?php echo get_field("testo_annullata")?></div>
                    </div>
                    <div class="mt-4">
                        <a href="<?php echo site_url('/sostienici');?>" class="btn btn-red">TORNA ALLA DONAZIONE</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

