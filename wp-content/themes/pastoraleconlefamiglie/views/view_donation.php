<?php
$label_status = [
    'waiting' => "IN ATTESA",
    'success' => "COMPLETATA",
    'failed' => "FALLITA",
    'cancelled' => "ANNULLATA",
];

?>

<div class="view-inscription mt-5">
    <h4 class="wp-heading-inline mb-5">Dettaglio donazione</h4>

    <?php /*
    <a href="http://localhost/pastorale-con-le-famiglie/wp-admin/post-new.php" class="page-title-action">Esporta</a>
 */ ?>
    <hr class="wp-header-end" />

    <?php
    //print_r($detailInscription);
    if ($detailDonation):
        foreach ($detailDonation as $donation) :
            $donationData = json_decode($donation->datas, true);
            $id     = $donation->id;
            $fisrtName     = $donationData['firstName'];
            $lastName      = $donationData['lastName'];
            $email         = $donationData['email'];
            $phone         = $donationData['phone'];
            $importo     = $donation->donation .' €';
            $status        = $donation->status;
            $created_date = '';
            if($donation->created_at > 0) {
                $date = date_create($donation->created_at);
                $created_date = date_format($date, "d/m/Y H:i:s");
            }
            ?>

            <div class="panel-wrap">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="panel">
                            <div class="panel-body">
                                <div class="status mb-3">
                                    <span class="<?php echo $status;?>"><?php echo $label_status[$status];?></span>
                                </div>
                                <h2>Dettaglio Donazione #<?php echo $id; ?></h2>
                                <p>Data Donazione: <?php echo $created_date; ?></p>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h3>Dati anagrafici </h3>
                                        <div class="col-cnt">
                                            <div class="form-group">
                                                <label for="input1">NOME: </label>
                                                <span><?php echo $fisrtName; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="input1">COGNOME: </label>
                                                <span><?php echo $lastName; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="input2">EMAIL: </label>
                                                <span><?php echo $email; ?></span>
                                            </div>

                                            <div class="form-group">
                                                <label for="input3">TELEFONO: </label>
                                                <span><?php echo $phone; ?></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="input3">Importo donazione: </label>
                                                <span class="fw-bold fs-2"><?php echo $importo; ?> </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
    else:
        echo "Item not found";
    endif;
    ?>

</div>