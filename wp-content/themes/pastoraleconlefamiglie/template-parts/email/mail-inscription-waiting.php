<?php
$testo1 =
"Gentile [NOME],<br>
ti confermiamo l’iscrizione al corso <strong>[NOME_CORSO]</strong>.
<br>
Per finalizzare la prenotazione, è necessario effettuare il pagamento almeno 15gg prima dell’inizio del corso.
<br>
[RECAP_ISCRIZIONE]
<br><br>
Puoi procedere al pagamento cliccando qui:<br>
";

$testo2 = "N.B. Come da informativa, ti ricordiamo che l'importo non è rimborsabile. Nel caso di cancellazione, potrà essere riutilizzato entro un anno per un altro corso.
<br><br>
Appena riceveremo il pagamento, ti verrà inviata una conferma.";

$testo_bottone = "Effettua il pagamento";
?>
<?php get_template_part("template-parts/email/header");?>

<center>
    <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
        <tr>
            <td align="center" valign="top" id="bodyCell">
                <!-- BEGIN TEMPLATE // -->
                <!--[if (gte mso 9)|(IE)]>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                    <tr>
                        <td align="center" valign="top" width="600" style="width:600px;">
                <![endif]-->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer">
                    <tr>
                        <td valign="top" id="templatePreheader"></td>
                    </tr>
                    <tr>
                        <td valign="top" id="templateHeader"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width:100%;">
                                <tbody class="mcnImageBlockOuter">
                                <tr>
                                    <td valign="top" style="padding:9px" class="mcnImageBlockInner">
                                        <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%;">
                                            <tbody><tr>
                                                <td class="mcnImageContent" valign="top" style="padding-right: 9px; padding-left: 9px; padding-top: 0; padding-bottom: 0; text-align:center;">

                                                    <a href="https://pastoraleconlefamiglie.org" title="" class="" target="_blank">
                                                        <img align="middle" alt="" src="https://mcusercontent.com/e77e70eacea53fe12f8b54101/images/e323b65d-1b62-f23d-ca7b-3fc84c4fe116.png" width="186.12" style="max-width:3558px; padding-bottom: 0; display: inline !important; vertical-align: bottom;" class="mcnRetinaImage">
                                                    </a>

                                                </td>
                                            </tr>
                                            </tbody></table>
                                    </td>
                                </tr>
                                </tbody>
                            </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                        <!--[if mso]>
                                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                            <tr>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                            <tbody><tr>

                                                <td valign="top" class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;">


                                                </td>
                                            </tr>
                                            </tbody></table>
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        </tr>
                                        </table>
                                        <![endif]-->
                                    </td>
                                </tr>
                                </tbody>
                            </table></td>
                    </tr>
                    <tr>
                        <td valign="top" id="templateBody"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                        <!--[if mso]>
                                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                            <tr>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                            <tbody><tr>

                                                <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; line-height: 150%;">

                                                    <div>
                                                        <div>
                                                            <?php echo $testo1;?>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            </tbody></table>
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        </tr>
                                        </table>
                                        <![endif]-->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <?php get_template_part("template-parts/email/bottone-mail", null, $args = ["testo_bottone" => $testo_bottone]);?>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                        <!--[if mso]>
                                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                            <tr>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                            <tbody><tr>

                                                <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; line-height: 150%;">
                                                    <?php echo $testo2;?>
                                                </td>
                                            </tr>
                                            </tbody></table>
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        </tr>
                                        </table>
                                        <![endif]-->
                                    </td>
                                </tr>
                                </tbody>
                            </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width:100%;">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td valign="top" class="mcnTextBlockInner" style="padding-top:9px;">
                                        <!--[if mso]>
                                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                            <tr>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
                                            <tbody><tr>

                                                <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; line-height: 150%;">

                                                    <div>
                                                        <div>
                                                            <em>I frati della fraternità “San Giovanni Paolo II”</em>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                            </tbody></table>
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        </tr>
                                        </table>
                                        <![endif]-->
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="mcnTextBlock" style="min-width:100%;" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tbody class="mcnTextBlockOuter">
                                <tr>
                                    <td class="mcnTextBlockInner" style="padding-top:9px;" valign="top">
                                        <!--[if mso]>
                                        <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                                            <tr>
                                        <![endif]-->

                                        <!--[if mso]>
                                        <td valign="top" width="600" style="width:600px;">
                                        <![endif]-->
                                        <table style="max-width:100%; min-width:100%;" class="mcnTextContentContainer" width="100%" cellspacing="0" cellpadding="0" border="0" align="left">
                                            <tbody><tr>

                                                <td class="mcnTextContent" style="padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:18px;" valign="top">


                                                </td>
                                            </tr>
                                            </tbody></table>
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->

                                        <!--[if mso]>
                                        </tr>
                                        </table>
                                        <![endif]-->
                                    </td>
                                </tr>
                                </tbody>
                            </table></td>
                    </tr>
                    <?php get_template_part("template-parts/email/footer");?>
                </table>
                <!--[if (gte mso 9)|(IE)]>
                </td>
                </tr>
                </table>
                <![endif]-->
                <!-- // END TEMPLATE -->
            </td>
        </tr>
    </table>
</center>

<?php get_template_part("template-parts/email/bottom");?>
