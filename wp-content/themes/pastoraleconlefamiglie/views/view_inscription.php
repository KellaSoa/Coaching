<?php
/**
* @var array $detailInscription
*/
?>
<div class="view-inscription mt-5">
    <h4 class="wp-heading-inline mb-5">Modifica iscrizione</h4>

    <hr class="wp-header-end" />
    <?php
     if ($detailInscription):
        foreach ($detailInscription as $inscription) :
            $inscriptionData = json_decode($inscription->data, true);
            $course = $inscription->post_title;
            $typeCourse = $inscription->name;
            $status = $inscription->state;
            $idTypeCourse = $inscription->idTypeCourse;

            $created_date = '';
            if($inscription->created_date > 0) {
                $date = date_create($inscription->created_date);
                $created_date = date_format($date, "d/m/Y H:i:s");

                $date = date_create($inscription->update_date);
                $update_date = date_format($date, "d/m/Y H:i:s");
            }
            $status = $inscription->status;

            $label_status = [
                'new' => "DA LEGGERE",
                'waiting' => "IN ATTESA",
                'success' => "CONFERMATA",
                'failed' => "ANNULLATA",
            ];

        ?>
        <div class="mb-3">
            <small>Ultimo aggiornamento: <?php echo $update_date;?></small>
        </div>
        <div class="panel-wrap">
            <div class="row">
                <div class="col-sm-8">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="status mb-3">
                                <span class="<?php echo $status;?>"><?php echo $label_status[$status];?></span>
                            </div>
                            <h2>Dettaglio Iscrizione #<?php echo $inscription->id;?></h2>
                            <p>Data Richiesta Iscrizione: <?php echo $created_date;?></p>
                            <div class="row">
                                <div class="col-12">
                                    <div class="col-cnt">
                                        <div class="form-group mb-3">
                                            <h3 class=""><?php echo $course; ?> (<?php echo $typeCourse; ?>)</h3>
                                        </div>
                                        <div class="form-group">
                                            <label for="input3">Data corso: </label>
                                            <span><?php echo $inscription->dateCourse;?></span>
                                        </div>

                                        <?php if(!empty($inscriptionData['typeInscription'])):?>
                                        <div class="form-group">
                                            <label for="input3">Tipo iscrizione: </label>
                                            <span><?php echo $inscriptionData['typeInscription'];?></span>
                                            <input type="hidden" name="typeInscription" value="<?php echo $inscriptionData['typeInscription'];?>" >
                                        </div>
                                        <?php endif;?>
                                    </div>

                                </div>
                                <div class="col-12"><hr /></div>
                                <div class="col-sm-6">
                                    <h3>Dati anagrafici <?php if(!empty($inscriptionData['person'][1]['email'])) echo 'Lui';?></h3>
                                    <div class="col-cnt">
                                        <div class="form-group">
                                            <label for="input1">NOME: </label>
                                            <span><?php echo $inscriptionData['person'][0]['firstName'];?></span>
                                            <input type="hidden" class="form-control"  id="firstName1" name="firstName1" placeholder="Nome" value="<?php echo $inscriptionData['person'][0]['firstName'];?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="input1">COGNOME: </label>
                                            <span><?php echo $inscriptionData['person'][0]['lastName'];?></span>
                                            <input type="hidden" class="form-control"  id="lastName1" name="lastName1" placeholder="Cognome" value="<?php echo $inscriptionData['person'][0]['lastName'];?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="input2">EMAIL: </label>
                                            <a href="mailto:<?php echo $inscriptionData['person'][0]['email'];?>" target="_blank"><?php echo $inscriptionData['person'][0]['email'];?></a>
                                            <input type="hidden" class="form-control"  id="email1" name="email1" placeholder="Email" value="<?php echo $inscriptionData['person'][0]['email'];?>">
                                        </div>

                                        <?php if(!empty($inscriptionData['person'][0]['phone'])):?>
                                        <div class="form-group">
                                            <label for="input3">TELEFONO: </label>
                                            <span><?php echo $inscriptionData['person'][0]['phone'];?></span>
                                            <input type="hidden" class="form-control" id="phone1" name="phone1" value="<?php echo $inscriptionData['person'][0]['phone'];?>">
                                        </div>
                                        <?php endif;?>
                                        <?php if(!empty($inscriptionData['person'][0]['gender'])):?>
                                            <div class="form-group">
                                                <label for="gender1">Sesso: </label>
                                                <span><?php echo $inscriptionData['person'][0]['gender'];?></span>
                                                <input type="hidden" class="form-control" id="gender1" name="gender1" value="<?php echo $inscriptionData['person'][0]['gender'];?>">
                                            </div>
                                        <?php endif;?>

                                        <?php if(!empty($inscriptionData['person'][0]['birthdate'])):?>
                                            <div class="form-group">
                                                <label for="birthdate1">Data di nascita: </label>
                                                <span><?php echo $inscriptionData['person'][0]['birthdate'];?></span>
                                                <input type="hidden" class="form-control" id="birthdate1" name="birthdate1" value="<?php echo $inscriptionData['person'][0]['birthdate'];?>">
                                            </div>
                                        <?php endif;?>

                                        <?php if(!empty($inscriptionData['person'][0]['comune'])):?>
                                            <div class="form-group">
                                                <label for="comune1">Comune di nascita: </label>
                                                <span><?php echo $inscriptionData['person'][0]['comune'];?></span>
                                                <input type="hidden" class="form-control" id="comune1" name="comune1" value="<?php echo $inscriptionData['person'][0]['commune'];?>">
                                            </div>
                                        <?php endif;?>

                                        <?php if(!empty($inscriptionData['person'][0]['citta'])):?>
                                            <div class="form-group">
                                                <label for="citta1">Provincia di residenza: </label>
                                                <span><?php echo $inscriptionData['person'][0]['citta'];?></span>
                                                <input type="hidden" class="form-control" id="citta1" name="citta1"  value="<?php echo $inscriptionData['person'][0]['citta'];?>">
                                            </div>
                                        <?php endif;?>
                                        <?php if(!empty($inscriptionData['person'][0]['regione'])):?>
                                            <div class="form-group">
                                                <label for="regione">Regione di residenza: </label>
                                                <span><?php echo $inscriptionData['person'][0]['regione'];?></span>
                                                <input type="hidden" class="form-control" id="regione" name="regione"  value="<?php echo $inscriptionData['person'][0]['regione'];?>">
                                            </div>
                                        <?php endif;?>

                                        <?php if(!empty($inscriptionData['person'][0]['referente'])):?>
                                        <div class="form-group">
                                            <label><strong>*REFERENTE ISCRIZIONE*</strong></label>
                                        </div>
                                        <?php endif;?>
                                    </div>
                                </div>

                                <?php if(!empty($inscriptionData['person'][1]['email'])):?>
                                <div class="col-sm-6">
                                    <h3>Dati anagrafici Lei</h3>

                                    <div class="col-cnt">
                                        <div class="form-group">
                                            <label for="input1">NOME: </label>
                                            <span><?php echo $inscriptionData['person'][1]['firstName'];?></span>
                                            <input type="hidden" class="form-control"  id="firstName2" name="firstName2" placeholder="Nome " value="<?php echo $inscriptionData['person'][1]['firstName'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="input1">COGNOME: </label>
                                            <span><?php echo $inscriptionData['person'][1]['lastName'];?></span>
                                            <input type="hidden" class="form-control"  id="lastName2" name="lastName2" placeholder=" Cognome" value="<?php echo $inscriptionData['person'][1]['lastName'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="input2">EMAIL: </label>
                                            <a href="mailto:<?php echo $inscriptionData['person'][1]['email'];?>" target="_blank"><?php echo $inscriptionData['person'][1]['email'];?></a>
                                            <input type="hidden" class="form-control"  id="email2" name="email2" placeholder="Email" value="<?php echo $inscriptionData['person'][1]['email'];?>">
                                        </div>
                                        <?php if(!empty($inscriptionData['person'][1]['phone'])):?>
                                            <div class="form-group">
                                                <label for="input3">TELEFONO: </label>
                                                <span><?php echo $inscriptionData['person'][1]['phone'];?></span>
                                                <input type="hidden" class="form-control" id="phone2" name="phone2" value="<?php echo $inscriptionData['person'][1]['phone'];?>">
                                            </div>
                                        <?php endif;?>


                                        <?php if(!empty($inscriptionData['person'][1]['gender'])):?>
                                            <div class="form-group">
                                                <label for="gender2">Sesso: </label>
                                                <span><?php echo $inscriptionData['person'][1]['gender'];?></span>
                                                <input type="hidden" class="form-control" id="gender2" name="gender2" value="<?php echo $inscriptionData['person'][1]['gender'];?>">
                                            </div>
                                        <?php endif;?>
                                        <?php if(!empty($inscriptionData['person'][1]['birthdate'])):?>
                                        <div class="form-group">
                                            <label for="birth2">Data di nascita: </label>
                                            <span><?php echo $inscriptionData['person'][1]['birthdate'];?></span>
                                            <input type="hidden" class="form-control" id="birth2" name="birth2" value="<?php echo $inscriptionData['person'][1]['birthdate'];?>">
                                        </div>
                                        <?php endif;?>

                                        <?php if(!empty($inscriptionData['person'][1]['comune'])):?>
                                        <div class="form-group">
                                            <label for="comune1">Comune di nascita: </label>
                                            <span><?php echo $inscriptionData['person'][1]['comune'];?></span>
                                            <input type="hidden" class="form-control" id="comune2" name="comune2" value="<?php echo $inscriptionData['person'][1]['comune'];?>">
                                        </div>
                                        <?php endif;?>
                                        <?php if(!empty($inscriptionData['person'][1]['citta'])):?>
                                        <div class="form-group">
                                            <label for="citta2">Provincia di residenza: </label>
                                            <span><?php echo $inscriptionData['person'][1]['citta'];?></span>
                                            <input type="hidden" class="form-control" id="citta2" name="citta2" value="<?php echo $inscriptionData['person'][1]['citta'];?>">
                                        </div>
                                        <?php endif;?>
                                        <?php if(!empty($inscriptionData['person'][1]['referente'])):?>
                                            <div class="form-group">
                                                <label><strong>*REFERENTE ISCRIZIONE*</strong></label>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <?php endif;?>
                                <div class="col-12"><hr /></div>
                                <div class="col-sm-12">
                                    <h3>Dati aggiuntivi</h3>
                                    <div class="col-cnt">
                                        <?php if(!empty($inscriptionData['yearsEngagement'])): ?>
                                        <div class="form-group">
                                            <label for="input4">ANNI DI FIDANZAMENTO:</label>
                                            <span><?php echo $inscriptionData['yearsEngagement']?></span>
                                        </div>
                                        <?php endif;?>
                                        <?php if(!empty($inscriptionData['yearsMarriage'])): ?>
                                            <div class="form-group">
                                                <label for="input4">ANNI DI MATRIMONIO:</label>
                                                <span><?php echo $inscriptionData['yearsMarriage']?></span>
                                            </div>
                                        <?php endif;?>

                                        <?php if(!empty($inscriptionData['know'])):?>
                                        <div class="form-group">
                                            <label for="input1">COME AVETE CONOSCIUTO IL CORSO: </label>
                                            <span><?php echo $inscriptionData['know'];?></span>
                                            <input type="hidden" name="know" id="know" value="<?php  echo $inscriptionData['know']; ?>">
                                        </div>
                                        <?php endif;?>
                                        <div class="form-group mt-2">
                                            <label for="input4">PRIMA ESPERIENZA CON NOI:</label>
                                            <span><?php echo $inscriptionData['isFirstCourse'] ? "SI" :"NO"; ?></span>
                                            <input type="hidden" id="isFirstCourse" name="isFirstCourse" value="<?php echo $inscriptionData['isFirstCourse']; ?>"/>
                                        </div>
                                        <?php if($idTypeCourse == 4): ?>
                                        <div class="form-group">
                                            <label for="input3">Attestato di partecipazione: </label>
                                            <span><?php echo $inscriptionData['isAttest'] ? "SI" : "NO";?></span>
                                            <input type="hidden" id="switchInfo" name="isAttest" value="<?php echo $inscriptionData['isAttest']; ?>" />
                                            <input type="hidden" id="isAcceptCondition" name="isAcceptCondition" value="<?php echo $inscriptionData['isAcceptCondition']; ?>" />
                                        </div>
                                        <?php endif;?>

                                        <?php if(!empty($inscriptionData['note'])):?>
                                            <div class="form-group">
                                                <label for="note">Note: </label>
                                                <span><?php echo $inscriptionData['note'];?></span>
                                                <input type="hidden" class="form-control" id="note" name="note"  value="<?php echo $inscriptionData['note'];?>">
                                            </div>
                                        <?php endif;?>
                                    </div>
                                </div>

                                <?php if($inscriptionData['numberSons']>0): ?>
                                    <div class="col-12"><hr /></div>
                                    <div class="col-sm-12">
                                        <h3>Dati Figli</h3>

                                        <div class="col-cnt">
                                            <div class="form-group">
                                                <label for="input4">NUMERO FIGLI:</label>
                                                <span><?php echo $inscriptionData['numberSons'];?></span>
                                            </div>
                                        </div>

                                        <div class="col-cnt">
                                            <div class="form-group">
                                                <label for="input4">ANIMAZIONE:</label>
                                                <span><?php echo (!empty($inscriptionData['isAnimazione'])) ? 'Richiesta' : 'Non richiesta';?></span>
                                            </div>
                                        </div>

                                        <?php if(!empty($inscriptionData['son'])):?>
                                        <div class="col-cnt row">
                                            <?php foreach ($inscriptionData['son'] as $k => $v):?>
                                                <div class="col-sm-6">
                                                    <h3>Dati figlio/a</h3>
                                                    <div class="col-cnt">
                                                        <?php if(!empty($inscriptionData['isAnimazione'])):?>
                                                        <div class="form-group">
                                                            <label for="firstNameSon">NOME: </label>
                                                            <span><?php echo $v['firstNameSon'];?></span>
                                                            <input type="hidden" class="form-control"  id="firstNameSon" name="firstNameSon" placeholder="Nome " value="<?php echo $v['firstNameSon'];?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="lastNameSon">COGNOME: </label>
                                                            <span><?php echo $v['lastNameSon'];?></span>
                                                            <input type="hidden" class="form-control"  id="lastNameSon" name="lastNameSon" placeholder=" Cognome" value="<?php echo $v['lastNameSon'];?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="CodiceFiscaleSon">Codice Fiscale: </label>
                                                            <span><?php echo $v['CodiceFiscaleSon'];?></span>
                                                            <input type="hidden" class="form-control"  id="CodiceFiscaleSon" name="CodiceFiscaleSon" placeholder="Email" value="<?php echo $v['CodiceFiscaleSon'];?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="birthplaceSon">Luogo di Nascita: </label>
                                                            <span><?php echo $v['birthplaceSon'];?></span>
                                                            <input type="hidden" class="form-control" id="birthplaceSon" name="birthplaceSon" value="<?php echo $v['birthplaceSon'];?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="birthdateSon">Data di nascita: </label>
                                                            <span><?php echo $v['birthdateSon'];?></span>
                                                            <input type="hidden" class="form-control" id="birthdateSon" name="birthdateSon" value="<?php echo $v['birthdateSon'];?>">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="addressSon">Indirizzo di residenza: </label>
                                                            <span><?php echo $v['addressSon'].', '.$v['capSon'].' - '.$v['citySon'];?></span>
                                                        </div>
                                                        <?php endif; ?>
                                                        <div class="form-group">
                                                            <label for="yearsSon">Età: </label>
                                                            <span><?php echo $v['yearsSon'];?></span>
                                                            <input type="hidden" class="form-control" id="yearsSon" name="yearsSon" value="<?php echo $v['yearsSon'];?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="accommodationSon">Sistemazione: </label>
                                                            <span><?php echo $v['accommodationSon'];?></span>
                                                            <input type="hidden" class="form-control" id="accommodationSon" name="accommodationSon" value="<?php echo $v['accommodationSon'];?>">
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php endforeach;  ?>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                <?php endif;?>



                            </div>
                        </div>
                    </div>
                </div>

                <?php if($status == 'new' || $status == 'waiting'):?>
                <div class="col-sm-4">
                    <div class="panel">
                        <div class="panel-header">
                            <h2>Operazioni iscrizione</h2>
                        </div>
                        <div class="panel-body">
                            <form method="post" id="form-edit-inscription" data-url="<?php echo admin_url('admin-ajax.php'); ?>" > <!-- Define your form action -->
                                <input type="hidden" name="action" value="edit_inscription_user" >
                                <input type="hidden" name="idInscription" value="<?php echo $inscription->id; ?>">
                                <input type="hidden" name="paged" value="<?php echo $paged; ?>">
                                <input type="hidden" id="status" name="status" value="">

                                <?php /*<div class="form-group">
                                    <label for="status">Stato Iscrizione</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="new" <?php if($status == 'new') echo 'selected'; ?>>DA LEGGERE</option>
                                        <option value="waiting" <?php if($status == 'waiting') echo 'selected'; ?>>IN ATTESA</option>
                                        <?php ?>
                                        <option value="success" <?php if($status == 'success') echo 'selected'; ?>>APPROVATA</option>
                                        <option value="failed" <?php if($status == 'failed') echo 'selected'; ?>>ANNULLATA</option>
                                    </select>
                                </div>*/?>

                                <?php if($status == 'new'):?>
                                <small>
                                    Se la richiesta di iscrizione è stata convalidata, inserire il link per il pagamento online da inviare all'utente e poi cliccare su INVIA RICHIESTA DI PAGAMENTO.
                                    L'iscrizione sarà aggiornata di stato e sarà inviata all'utente una mail contenente il link di pagamento.
                                </small>

                                <div class="form-group my-4">
                                    <label for="link_payment">Link Pagamento</label><br>
                                    <input type="text" id="link_payment" name="link_payment" class="form-control" value=""/>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-warning btn-send-edit" type="submit" data-status="waiting"> INVIA RICHIESTA DI PAGAMENTO</button>
                                </div>

                                <hr>
                                <?php endif; ?>
                                <small>Se il pagamento al corso è stato effettuato, confermare la richiesta di iscrizione. L'utente riceverà una mail di ringraziamento.</small>
                                <div class="mt-3">
                                    <button class="btn btn-success btn-send-edit " type="submit" data-status="success"> CONFERMA RICHIESTA ISCRIZIONE</button>
                                </div>
                                <?php if($status == 'waiting'):?>
                                    <hr>
                                    <small>
                                        Se non è stato ancora effettuato il pagamento, è possibile inviare nuovamente il link per il pagamento online di seguito riportato cliccando su INVIA MAIL SOLLECITO.
                                    </small>
                                    <br><br>
                                    <div class="form-group">
                                        <label>Link Pagamento</label><br>
                                        <small><?php echo $inscription->link_payment;?></small>
                                        <input type="hidden" id="link_payment" name="link_payment" class="form-control" value="<?php echo $inscription->link_payment;?>"/>
                                    </div>

                                    <div class="mt-4">
                                        <button id="send-reminder-payment" class="btn btn-info" data-action="send_reminder_payment" data-url="<?php echo admin_url('admin-ajax.php'); ?>" data-idinscription = <?php echo $inscription->id;?>>INVIA MAIL SOLLECITO</button>
                                    </div>
                                <?php endif; ?>
                                <hr>
                                <small>Altrimenti selezionare lo stato ANNULLATA per annullare la richiesta di iscrizione.</small>
                                <div class="mt-3">
                                    <button class="btn btn-danger btn-send-edit " type="submit" data-status="failed"> ANNULLA RICHIESTA ISCRIZIONE</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>


        <?php
        endforeach;
        else:
         echo "Item not found";
     endif;
    ?>

</div>