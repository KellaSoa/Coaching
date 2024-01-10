<?php
class Donation
{
    protected static ?Donation $instance = null;
    private $wpdb;
    private $search_value;
    private $filter_value;
    protected function __construct()
    {
        self::$instance = &$this;
        global $wpdb;
        $this->wpdb = $wpdb;
        add_action('wp_ajax_nopriv_add_donation', [$this, 'addDonation']);
        add_action('wp_ajax_add_donation', [$this, 'addDonation']);
        add_action('admin_menu', [$this, 'addMenuPage']);
        $this->search_value = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';
        $this->filter_value = isset($_REQUEST['filter']) ? sanitize_text_field($_REQUEST['filter']) : '';
    }

    public static function Instance(): Donation
    {
        return is_null(self::$instance) ? new Donation() : self::$instance;
    }

    public function addDonation(){
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        $data = [
            'firstName' => $_POST['firstName'],
            'lastName'  => $_POST['lastName'],
            'email'     => $_POST['email'],
            'phone'     => $_POST['phone'],
        ];
        $donation           = $_POST['imposto'];
        $datas              = json_encode($data);
        //data API
        $hostedPage         = $_POST['hostedPage'];
        $securityToken      = $_POST['securityToken'];
        $hostedPageData     = explode('=',$hostedPage);
        $paymentid          = $hostedPageData[1];
        //wp_donation
        global $wpdb;
        $tablename = $wpdb->prefix.'donation';
        $insert = $wpdb->insert($tablename, [
            'orderId'       => $_POST['orderID'],
            'donation'      => $donation,
            'paymentid'     => $paymentid,
            'securityToken' => $securityToken,
            'datas'         => $datas,
            'status'        => 'waiting'
        ]);
        if ($insert) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'error insert donation']);
        }
        wp_die();
    }

    public function getDonation($idOrder)
    {
        $table_name = $this->wpdb->prefix . 'donation';
        $sql = "SELECT * FROM $table_name WHERE orderId= '$idOrder'";
        return $this->wpdb->get_results($this->wpdb->prepare($sql));
    }

    public function updateStatus($orderID,$status){
        $table_name = $this->wpdb->prefix . 'donation';
        $sql = "UPDATE $table_name SET status='$status' WHERE orderId= '$orderID'";
        $this->wpdb->query($this->wpdb->prepare($sql));

    }

    public function statusPaymentTemplate(bool $success, string $orderID, string $donationAmount)
    {
        //update status
        $status = $success ? "success" : "failed";
        $this->updateStatus($orderID,$status);
        $donation = $this->getDonation($orderID);
        $paymentid =$donation[0]->paymentid;
        if($status == 'success'){
            $this->sendMailDonationSuccess($paymentid);
        }

        // Include the template part statusPayement
        get_template_part( 'template-parts/statusPayement', null,
            array(
                'data'  => array(
                    'donationValue' => $donationAmount,
                    'success'        => $success,
                    'orderID'        => $orderID,
                )
            )
        );
    }

    public function sendMailDonationSuccess($paymentid){
        $detailDonation = $this->getDonationByPaymentId($paymentid);
        if(empty($detailDonation[0]->send_mail_date)) {
            $donationData = json_decode($detailDonation[0]->datas, true);

            //INVIO MAIL
            $templateName = "mail-donation";
            $subject = "Grazie per la tua donazione";

            ob_start();
            Mail::Instance()->getTemplate($templateName);
            $template = ob_get_contents();
            ob_end_clean();

            $template = str_replace("[SUBJECT]", $subject, $template);
            $content_message = str_replace("[NOME]", $donationData['firstName'], $template);
            $to = $donationData['email'];
            $sent = Mail::Instance()->sendMail($to, $subject, $content_message);
            if ($sent) {
                $table_name = $this->wpdb->prefix . 'donation';
                $paymentid = sanitize_text_field($paymentid);
                $this->wpdb->query($this->wpdb->prepare("UPDATE $table_name SET send_mail_date = now() WHERE paymentid= $paymentid"));
            }
            return $sent;
        }
        return false;

    }

    //BACK END DONATION
    public function addMenuPage()
    {
        add_menu_page(
            __('Donazioni'),
            'Donazioni',
            'manage_options',
            'sostienici',
           [$this, 'listDonations'],
            'dashicons-heart',
            6
        );

        add_submenu_page(
            null,
            __('Detail Sostienici'),
            __('Detail Sostienici'),
            'manage_options',
            'detail_sostienici',
           [$this, 'viewDonation']
        );
    }
    public function listDonations()
    {
        $table = new DonationsTable();
        $donations = $this->getAllDonations();
        if(!empty($donations)){
            $data = $this->formatDatas($donations);
            $table->data = $data;
            $table->prepare_items();
        }
        include __DIR__.'/../views/list_donations.php';
    }
    public function viewDonation()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $detailDonation = $this->getDonationById($id);
        include __DIR__.'/../views/view_donation.php';
    }
    public function getAllDonations()
    {
        $sql = 'SELECT * FROM wp_donation ';
        if($this->filter_value || $this->search_value)
            $sql.= ' WHERE ';
        if($this->filter_value)
            $sql.= ' status = "'.$this->filter_value.'"';
        if($this->search_value) {
            if ($this->filter_value)
                $sql .= ' AND ';
            $sql .= ' ( JSON_EXTRACT(datas, "$.firstName") LIKE "%' . $this->search_value . '%" OR JSON_EXTRACT(datas, "$.email") LIKE "%' . $this->search_value . '%" OR JSON_EXTRACT(datas, "$.lastName") LIKE "%' . $this->search_value . '%" ) ';
        }
        $sql.= ' ORDER BY id DESC';
        return $this->wpdb->get_results($this->wpdb->prepare($sql));
    }
    public function formatDatas($donations)
    {
        $csv = [];
        foreach ($donations as $donation) {
            $donationData = json_decode($donation->datas, true);
            $row = [];
            $row['id'] = $donation->id;
            $row['orderID'] = $donation->orderId;
            $row['fullName'] = $donationData['firstName'] . ' ' . $donationData['lastName'];
            $row['email'] = $donationData['email'];
            $row['phone'] = $donationData['phone'];
            $row['status'] = $donation->status;
            $row['donation'] = $donation->donation . ' €';
            $row['created_date'] = $donation->created_at;

            $csv[] = $row;
        }
        return $csv;
    }

    public function delete_item($item_id)
    {
        return $this->wpdb->get_results($this->wpdb->prepare("DELETE FROM `wp_donation` WHERE id =$item_id"));
    }
    public  function getDonationById($id){
        return $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM wp_donation WHERE id=$id"));
    }
    public  function getDonationByPaymentId($paymentid){
        return $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM wp_donation WHERE paymentid=$paymentid"));
    }
}
Donation::Instance();