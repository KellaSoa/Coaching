<?php
class Mail
{
    protected static ?Mail $instance = null;

    private $log_file_send_mail;
    protected function __construct()
    {
        self::$instance = &$this;
        $this->log_file_send_mail = LOG_PATH.'/log_file_send_mail.log';

    }

    public static function Instance(): Mail
    {
        return is_null(self::$instance) ? new Mail() : self::$instance;
    }

    public function sendMail($to, $subject, $message){
        $from = "web@pastoraleconlefamiglie.org";
        $fromName = "Pastorale con le Famiglie";

        $headers = array('From: '.$fromName.' <'.$from.'>', 'Content-Type: text/html; charset=UTF-8', 'Bcc: kella@a-piu.it,info@pastoraleconlefamiglie.org');
        $sent = wp_mail($to, $subject, $message, $headers);
        //LOG data person
        $log_handle_details = fopen($this->log_file_send_mail, 'a');
        $this->insertLogEmail($log_handle_details,$to, $subject,$sent);
        return $sent;
    }

    public function getTemplate($templateName){
        get_template_part("template-parts/email/".$templateName);
    }
    public function insertLogEmail($log_handle_details,$to, $subject,$sent){

        $start_time = date('Y-m-d H:i:s');
        fwrite($log_handle_details, "email send at $start_time\n");
        $dataEmail = " To:".$to.", Subject: ".$subject.",  Status: ".$sent ;
        fwrite($log_handle_details, "$dataEmail\n");
    }
}
Mail::Instance();