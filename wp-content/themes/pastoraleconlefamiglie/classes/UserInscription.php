<?php

class UserInscription
{
    protected static ?UserInscription $instance = null;
    private $wpdb;
    private $search_value;
    private $filter_value;
    private $log_file_inscription;

    protected function __construct()
    {
        self::$instance = &$this;
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->log_file_inscription = LOG_PATH.'/log_file_import_csv.log';
        $this->search_value = isset($_REQUEST['s']) ? sanitize_text_field($_REQUEST['s']) : '';
        $this->filter_value = isset($_REQUEST['filter']) ? sanitize_text_field($_REQUEST['filter']) : '';
        add_action('wp_ajax_nopriv_add_inscription_user', [$this, 'addInscriptionUser']);
        add_action('wp_ajax_add_inscription_user', [$this, 'addInscriptionUser']);

        add_action('wp_ajax_edit_inscription_user', [$this, 'editInscriptionUser']);
        add_action('wp_ajax_nopriv_edit_inscription_user', [$this, 'editInscriptionUser']);
        add_action('admin_menu', [$this, 'addMenuPage']);
        add_action('wp_ajax_export_csv', [$this, 'exportCSV']);
        add_action('wp_ajax_export_accoglienza', [$this, 'exportHospitality']);
        add_action('wp_ajax_export_csv_children', [$this, 'exportCsvChildren']);

        add_action('wp_ajax_send_reminder_payment', [$this, 'sendReminderPayment']);
        add_action('wp_ajax_nopriv_send_reminder_payment', [$this, 'sendReminderPayment']);
    }

    public static function Instance(): UserInscription
    {
        return is_null(self::$instance) ? new UserInscription() : self::$instance;
    }

    public function addInscriptionUser()
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        // Add log inscription

        if (!empty($_POST['son']['@@NUM'])) {
            unset($_POST['son']['@@NUM']);
        }

        $_POST['person'][0]['referente'] = 1;
        if (!empty($_POST['referente']) && $_POST['referente'] == 2) {
            $_POST['person'][1]['referente'] = 1;
            $_POST['person'][0]['referente'] = 0;
        }
        unset($_POST['referente']);

        $data = [
            'person' => $_POST['person'],
            'isFirstCourse' => $_POST['isFirstCourse'] ?? 0,
            'know' => $_POST['know'] ?? 0,
            'yearsEngagement' => $_POST['yearsEngagement'] ?? 0,
            'yearsMarriage' => $_POST['yearsMarriage'] ?? 0,
            'isAttest' => $_POST['isAttest'] ?? 0,
            'isAcceptCondition' => $_POST['isAcceptCondition'] ?? 0,
            'typeInscription' => $_POST['typeInscription'] ?? '',
            'isReadInfoCourse' => $_POST['isReadInfoCourse'] ?? 0,
            'numberSons' => $_POST['numberSons'] ?? 0,
            'isAnimazione' => $_POST['isAnimazione'] ?? 0,
            'son' => $_POST['son'] ?? [],
            'numPerson' => $_POST['numPerson'] ?? 0,
            'note' => $_POST['note'] ?? '',
        ];
        $data = json_encode($data);

        $idCourse = $_POST['idCourse'];
        $idTypeCourse = $_POST['idTypeCourse'];
        $dateCourse = $_POST['dateCourse'];
        // LOG data person
        $log_handle_details = fopen($this->log_file_inscription, 'a');
        $this->insertLogInscription($log_handle_details, $_POST['person']);

        if (!empty($_POST['person'][0]['lastName']) && !empty($_POST['person'][0]['firstName']) && !empty($_POST['person'][0]['email'])) {
            $tablename = $this->wpdb->prefix.'inscription';
            $inscription = $this->wpdb->insert($tablename, [
                'dateCourse' => $dateCourse,
                'idCourse' => $idCourse,
                'idTypeCourse' => $idTypeCourse,
                'status' => 'new',
                // 'typeInscription' => $_POST['typeInscription'],
                'data' => $data,
            ]);
            $idInscription = $this->wpdb->insert_id;
            // Log ID inscription
            $dataIdInscription = 'inscription id : '.$idInscription;
            fwrite($log_handle_details, "$dataIdInscription\n");

            if ($inscription) {
                $getInscriptionUser = $this->getinscriptionById($idInscription);
                $inscription = $getInscriptionUser[0];

                // INVIO MAIL
                $this->sendMailInscription($inscription);

                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['error' => 'error insert user inscription']);
            }
        } else {
            echo json_encode(['error' => 'error insert user inscription']);
        }
        wp_die();
    }

    public function insertLogInscription($log_handle_details, $person)
    {
        $start_time = date('Y-m-d H:i:s');
        fwrite($log_handle_details, "Inscription created at $start_time\n");
        $dataUser = 'Cognome:'.$person[0]['lastName'].', Nome:'.$person[0]['firstName'].' email:'.$person[0]['email'];
        $dataUser2 = 'Cognome:'.$person[1]['lastName'].', Nome:'.$person[1]['firstName'].' email:'.$person[1]['email'];
        fwrite($log_handle_details, "$dataUser\n");
        if ($_POST['person'][1]) {
            $dataUser2 = 'User Cognome:'.$_POST['person'][1]['lastName'].', Nome:'.$_POST['person'][1]['firstName'].'email:'.$_POST['person'][1]['email'];
            fwrite($log_handle_details, "$dataUser2\n");
        }
    }

    public function sendMailInscription($inscription)
    {
        $templateName = 'mail-inscription-new';
        $subject = 'Grazie per la tua richiesta di iscrizione';

        ob_start();
        Mail::Instance()->getTemplate($templateName);
        $template = ob_get_contents();
        ob_end_clean();

        $template = str_replace('[SUBJECT]', $subject, $template);
        $template = str_replace('[NOME_CORSO]', $inscription->post_title, $template);
        $template = str_replace('[LINK]', $inscription->link_payment, $template);
        $template = str_replace('[ANCHOR_LINK]', $inscription->post_name, $template);
        $inscriptionData = json_decode($inscription->data, true);
        foreach ($inscriptionData['person'] as $person) {
            if (!empty($person['referente'])) {
                $to = $person['email'];
                $content_message = str_replace('[NOME]', $person['firstName'], $template);
                Mail::Instance()->sendMail($to, $subject, $content_message);
            }
        }
    }

    // EDIT STATUS INSCRIPTION
    public function editInscriptionUser()
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        global $wpdb;

        $idInscription = $_POST['idInscription'];
        $status = $_POST['status'];
        $page = $_POST['paged'];
        $tablename = $wpdb->prefix.'inscription';

        $update_query = "UPDATE $tablename SET  ";
        if ($status == 'waiting' && !empty($_POST['link_payment']) && $_POST['link_payment'] != '') {
            $update_query .= "status='$status', link_payment = '".$_POST['link_payment']."'";
        } else {
            $update_query .= "status='$status'";
        }
        $update_query .= ", update_date = now() WHERE id=$idInscription";

        $getInscriptionUser = $this->getinscriptionById($idInscription);

        if ($getInscriptionUser) {
            $userInscription = $wpdb->query($wpdb->prepare($update_query));

            $inscription = $getInscriptionUser[0];
            $inscriptionData = json_decode($inscription->data, true);

            $recap_iscrizione = '';
            // INVIO MAIL
            $templateName = 'mail-inscription-'.$status;
            if ($status == 'new') {
                $subject = 'Grazie per la tua richiesta di iscrizione';
            } elseif ($status == 'waiting') {
                $subject = 'Completa la tua iscrizione';
                $inscription->link_payment = (!empty($inscription->link_payment)) ? $inscription->link_payment : $_POST['link_payment'];

                $recap_iscrizione = '<br>
L’importo cumulativo è relativo alla prenotazione di:';
                foreach ($inscriptionData['person'] as $person) {
                    $recap_iscrizione .= '<br>'.$person['firstName'].' '.$person['lastName'];
                }
            } elseif ($status == 'success') {
                $subject = 'Grazie. La tua iscrizione è confermata';
            } elseif ($status == 'failed') {
                $subject = 'La tua richiesta di iscrizione è annullata';
            }

            ob_start();
            Mail::Instance()->getTemplate($templateName);
            $template = ob_get_contents();
            ob_end_clean();

            $template = str_replace('[SUBJECT]', $subject, $template);
            $template = str_replace('[NOME_CORSO]', $inscription->post_title, $template);
            $template = str_replace('[LINK]', $inscription->link_payment ?? $_POST['link_payment'], $template);
            $template = str_replace('[ANCHOR_LINK]', site_url('le-nostre-iniziative/#'.$inscription->post_name), $template);
            $template = str_replace('[RECAP_ISCRIZIONE]', $recap_iscrizione, $template);
            foreach ($inscriptionData['person'] as $person) {
                if (!empty($person['referente'])) {
                    $to = $person['email'];
                    // $to = "staccioli@a-piu.it";
                    $content_message = str_replace('[NOME]', $person['firstName'], $template);
                    Mail::Instance()->sendMail($to, $subject, $content_message);
                }
            }
        }

        if ($userInscription) {
            echo json_encode(['success' => true, 'redirect' => admin_url('admin.php?page=iscrizioni&paged='.$page)]);
        } else {
            echo json_encode(['error' => 'error insert test user']);
        }
        wp_die();
    }

    public function addMenuPage()
    {
        add_menu_page(
            __('Iscrizioni'),
            'Iscrizioni',
            'manage_options',
            'iscrizioni',
            [$this, 'listInscriptions'],
            'dashicons-groups',
            6
        );

        add_submenu_page(
            null,
            __('Detail Iscrizione'),
            __('Detail Iscrizione'),
            'manage_options',
            'detail_iscrizione',
            [$this, 'viewInscription']
        );
    }

    public function listInscriptions()
    {
        $table = new InscriptionsTable();
        $inscriptions = $this->getAllInsription();

        if (!empty($inscriptions)) {
            $data = $this->formatDatas($inscriptions);

            if (isset($_GET['action']) && $_GET['action'] == 'export_csv') {
                $this->exportCSV();
                exit;
            }
            if (isset($_GET['action']) && $_GET['action'] == 'export_accoglienza') {
                $this->exportHospitality();
                exit;
            }
            $table->data = $data;
            $table->prepare_items();
        }
        include __DIR__.'/../views/list_inscriptions.php';
    }

    public function viewInscription()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $paged = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
        $detailInscription = $this->getinscriptionById($id);
        include __DIR__.'/../views/view_inscription.php';
    }

    public function getAllInsription()
    {
        $sql = 'SELECT i.*, p.post_title, t.name FROM wp_inscription i JOIN wp_posts p ON (i.idCourse = p.ID) JOIN wp_terms t ON (i.idTypeCourse = t.term_id) ';
        $queryData = $this->filterSql();
        $sql .= $queryData['sql'];
        $sql .= ' ORDER BY i.id DESC, i.created_date DESC';

        // Fetch results
        return $this->wpdb->get_results($this->wpdb->prepare($sql, $queryData['params']));
    }

    public function filterSql(bool $isHospitality = false, bool $isChild = false)
    {
        $sql = ' ';
        $searchTerm = $this->search_value;
        if ($this->filter_value || $this->search_value || $isHospitality || $isChild) {
            $sql = ' WHERE ';
        }
        if ($this->filter_value) {
            $sql .= ' i.status = "'.$this->filter_value.'"';
        }
        if ($this->search_value) {
            if ($this->filter_value) {
                $sql .= ' AND ';
            }
            $sql .= '(
                    LOWER(p.post_title) LIKE LOWER(%s)
                    OR LOWER(i.dateCourse) LIKE LOWER (%s)
                    OR JSON_VALID(i.data) = 1 AND 
                      ( LOWER(JSON_UNQUOTE(JSON_EXTRACT(i.data, "$.person[0].firstName"))) LIKE  LOWER(%s)
                        OR LOWER(JSON_UNQUOTE(JSON_EXTRACT(i.data, "$.person[0].lastName"))) LIKE  LOWER(%s)
                        OR LOWER(JSON_UNQUOTE(JSON_EXTRACT(i.data, "$.person[1].firstName"))) LIKE  LOWER(%s)
                        OR LOWER(JSON_UNQUOTE(JSON_EXTRACT(i.data, "$.person[1].lastName"))) LIKE  LOWER(%s)
                        OR LOWER(JSON_UNQUOTE(JSON_EXTRACT(i.data, "$.person[0].email"))) LIKE  LOWER(%s)
                        OR LOWER(JSON_UNQUOTE(JSON_EXTRACT(i.data, "$.person[1].email"))) LIKE  LOWER(%s)
                        OR LOWER(JSON_UNQUOTE(JSON_EXTRACT(i.data, "$.person[0].email")))  LIKE LOWER(%s)
                        OR LOWER(JSON_UNQUOTE(JSON_EXTRACT(i.data, "$.typeInscription")))  LIKE  LOWER(%s)
                    )
            )';
            $params = [
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
                '%'.$searchTerm.'%',
            ];

            /*$sql .= '(
                p.post_title LIKE "%' . $this->search_value . '%"
                OR i.dateCourse LIKE "%' . $this->search_value . '%"
                OR JSON_VALID(i.data) = 1 AND
                (
                    OR LOWER(JSON_EXTRACT(i.data, "$.person[0].firstName")) LIKE LOWER("%' . $this->search_value . '%")
                    OR JSON_EXTRACT(i.data, "$.person[0].email") LIKE "%' . $this->search_value . '%"
                    OR LOWER(JSON_EXTRACT(i.data, "$.person[0].lastName")) LIKE LOWER("%' . $this->search_value . '%")
                    OR LOWER(JSON_EXTRACT(i.data, "$.person[1].firstName")) LIKE LOWER("%' . $this->search_value . '%")
                    OR JSON_EXTRACT(i.data, "$.person[1].email") LIKE "%' . $this->search_value . '%"
                    OR LOWER(JSON_EXTRACT(i.data, "$.person[1].lastName")) LIKE LOWER("%' . $this->search_value . '%")
                    OR LOWER(JSON_EXTRACT(i.data, "$.typeInscription"))  LIKE "%' . $this->search_value . '%"
                )
            )';*/
        }

        return [
            'sql' => $sql,
            'params' => $params,
        ];
        // return $sql;
    }

    public function getinscriptionById($id)
    {
        return $this->wpdb->get_results($this->wpdb->prepare("SELECT i.*, p.post_title, p.post_name, t.name FROM wp_inscription i JOIN wp_posts p ON (i.idCourse = p.ID) 
        JOIN wp_terms t ON (i.idTypeCourse = t.term_id) WHERE i.id=$id"));
    }

    public function delete_item($item_id)
    {
        return $this->wpdb->get_results($this->wpdb->prepare("DELETE FROM `wp_inscription` WHERE id =$item_id"));
    }

    public function formatDatas($inscriptions, $space = '<br>')
    {
        $csv = [];
        foreach ($inscriptions as $inscription) {
            $inscriptionData = json_decode($inscription->data, true);

            $row = [];
            $firstName2 = $inscriptionData['person'][1]['firstName'] ? $inscriptionData['person'][1]['firstName'] : '';
            $lastName2 = $inscriptionData['person'][1]['lastName'] ? $inscriptionData['person'][1]['lastName'] : '';
            $email2 = $inscriptionData['person'][1]['email'] ? $inscriptionData['person'][1]['email'] : '';
            $firstName2 = str_replace("\\'", "'", $firstName2);
            $lastName2 = str_replace("\\'", "'", $lastName2);

            $firstName1 = str_replace("\\'", "'", $inscriptionData['person'][0]['firstName']);
            $lastName1 = str_replace("\\'", "'", $inscriptionData['person'][0]['lastName']);
            $row['id'] = $inscription->id;
            $row['fullName'] = $firstName1.' '.$lastName1.$space.$firstName2.' '.$lastName2;
            $row['email'] = $inscriptionData['person'][0]['email'].$space.$email2;
            $row['typeInscription'] = $inscriptionData['typeInscription'];
            $row['course'] = $inscription->post_title;
            $row['typeCourse'] = $inscription->name;
            $row['status'] = $inscription->status;
            $row['dateCourse'] = $inscription->dateCourse;
            $row['created_date'] = $inscription->created_date;

            $csv[] = $row;
        }

        return $csv;
    }

    // EXPORT ALL INSCRIPTION
    public function exportCSV()
    {
        $inscriptions = $this->getAllInsription();
        $timestamp = date('Y-m-d_H-i');
        $filename = 'export-iscrizioni-pastorale-con-le-famiglie_'.$timestamp.'.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        $csv = $this->formatDataAllInscriptions($inscriptions, '  '); // method to retrieve the data

        $firstrows = ['Indice', 'ID Iscrizione',
            'Data Iscrizione', 'Stato Iscrizione', 'Tipo Corso', 'Corso', 'Data corso', 'Tipo Iscrizione',
            'Tipologia Anagrafica', 'Referente',
            'Cognome', 'Nome', 'Email', 'Telefono', 'Sesso', 'Data nascita', 'Comune di nascita', 'Provincia di residenza',
            'Età figlio', 'Sistemazione figlio',
            'Anni fidanzamento', 'Anni matrimonio', 'Conoscenza', 'Primo corso', 'Richiesta attestato', 'N.Figli',  'Richiesta Animazione', 'N.Partecipanti', 'Note'];

        // $firstrows = array_keys($csv[0] ?? []);
        $csv = [$firstrows, ...$csv];
        // echo '<pre>'.print_r($csv, true).'</pre>';
        // exit;
        $output = fopen('php://output', 'wb');
        // Write headers to CSV file.

        fwrite($output, "\xEF\xBB\xBF");
        foreach ($csv as $line) {
            fputcsv($output, $line, ',');
        }
        fclose($output);

        wp_die();
    }

    public function formatDataAllInscriptions($inscriptions, $space = '<br>')
    {
        $csv = [];
        /** @var int $index */
        $index = 1;

        $label_status = [
            'new' => 'DA LEGGERE',
            'waiting' => 'IN ATTESA',
            'success' => 'CONFERMATA',
            'failed' => 'ANNULLATA',
        ];

        foreach ($inscriptions as $inscription) {
            $inscriptionData = json_decode($inscription->data, true);
            // echo '<pre>'.print_r($inscriptionData, true).'</pre>';
            // exit;
            $header = $footer = [];

            $date = date_create($inscription->created_date);
            $created_date = date_format($date, 'd/m/Y H:i:s');

            $header['id'] = $inscription->id;
            $header['created_date'] = $created_date;
            $header['status'] = $label_status[$inscription->status];
            $header['typeCourse'] = $inscription->name;
            $header['course'] = $inscription->post_title;
            $header['dateCourse'] = $inscription->dateCourse;
            $header['typeInscription'] = $inscriptionData['typeInscription'];

            $footer['yearsEngagement'] = !empty($inscriptionData['yearsEngagement']) ? $inscriptionData['yearsEngagement'] : '';
            $footer['yearsMarriage'] = !empty($inscriptionData['yearsMarriage']) ? $inscriptionData['yearsMarriage'] : '';
            $footer['know'] = !empty($inscriptionData['know']) ? $inscriptionData['know'] : '';
            $footer['isFirstCourse'] = (!empty($inscriptionData['isFirstCourse'])) ? (($inscriptionData['isFirstCourse'] == 1) ? 'SI' : 'NO') : '';
            $footer['isAttest'] = (!empty($inscriptionData['isAttest'])) ? (($inscriptionData['isAttest'] == 1) ? 'SI' : 'NO') : '';
            $footer['numberSons'] = !empty($inscriptionData['numberSons']) ? $inscriptionData['numberSons'] : '';
            $footer['isAnimazione'] = (!empty($inscriptionData['isAnimazione'])) ? (($inscriptionData['isAnimazione'] == 1) ? 'SI' : 'NO') : '';
            $footer['numPerson'] = !empty($inscriptionData['numPerson']) ? $inscriptionData['numPerson'] : count($inscriptionData['person']);
            $footer['note'] = $inscriptionData['note'];

            foreach ($inscriptionData['person'] as $person) {
                $csv[$index]['index'] = $index;
                foreach ($header as $k => $v) {
                    $csv[$index][$k] = $v;
                }
                $csv[$index]['tipologia_anagrafica'] = 'Adulto';
                $csv[$index]['referente'] = (!empty($person['referente'])) ? 'SI' : '';
                $csv[$index]['lastName'] = $person['lastName'];
                $csv[$index]['firstName'] = $person['firstName'];
                $csv[$index]['email'] = $person['email'];
                $csv[$index]['phone'] = $person['phone'];
                $csv[$index]['gender'] = $person['gender'];
                $csv[$index]['birthdate'] = $person['birthdate'];
                $csv[$index]['birthplace'] = $person['comune'];
                $csv[$index]['citta'] = $person['citta'];
                $csv[$index]['yearsSon'] = '';
                $csv[$index]['accommodationSon'] = '';

                foreach ($footer as $k => $v) {
                    $csv[$index][$k] = $v;
                }
                ++$index;
            }

            foreach ($inscriptionData['son'] as $son) {
                $csv[$index]['index'] = $index;
                foreach ($header as $k => $v) {
                    $csv[$index][$k] = $v;
                }
                $csv[$index]['tipologia_anagrafica'] = 'Figlio';
                $csv[$index]['referente'] = '';
                $csv[$index]['lastName'] = $son['lastNameSon'] ?? '';
                $csv[$index]['firstName'] = $son['firstNameSon'] ?? '';
                $csv[$index]['email'] = '';
                $csv[$index]['phone'] = '';
                $csv[$index]['gender'] = '';
                $csv[$index]['birthdate'] = $son['birthdateSon'] ?? '';
                $csv[$index]['birthplace'] = $son['birthplaceSon'] ?? '';
                $csv[$index]['citta'] = $son['citySon'] ?? '';
                $csv[$index]['yearsSon'] = $son['yearsSon'] ?? '';
                $csv[$index]['accommodationSon'] = $son['accommodationSon'] ?? '';

                foreach ($footer as $k => $v) {
                    $csv[$index][$k] = $v;
                }
                ++$index;
            }
        }

        return $csv;
    }

    public function exportHospitality()
    {
        $inscriptions = $this->getAllInsriptionWithHospitality();
        $timestamp = date('Y-m-d_H-i');
        $filename = 'export-accoglienza-pastorale-con-le-famiglie_'.$timestamp.'.csv';

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        $csv = $this->formatDatasHospitality($inscriptions); // method to retrieve the data

        $firstrows = ['Cognome', 'Nome', 'Sesso', 'Data nascita', 'Città nascita', 'Stato nascita', 'Cittadinanza', 'Provincia di residenza', 'Stato residenza', 'Capogruppo',
            'CELL', 'MAIL', 'INDIRIZZO', 'NOTE'];

        $csv = [$firstrows, ...$csv];
        $output = fopen('php://output', 'wb');
        /*echo '<pre>'.print_r($csv, true).'</pre>';
        exit;*/
        // Write headers to CSV file.
        fwrite($output, "\xEF\xBB\xBF");
        foreach ($csv as $line) {
            fputcsv($output, $line, ',');
        }
        fclose($output);

        wp_die();
    }

    public function getAllInsriptionWithHospitality()
    {
        $sql = 'SELECT i.*, p.post_title, t.name 
            FROM wp_inscription i JOIN wp_posts p ON (i.idCourse = p.ID) JOIN wp_terms t ON (i.idTypeCourse = t.term_id)  ';

        $sqlFilter = $this->filterSql(true, false);
        $sql .= $sqlFilter['sql'];
        if (!empty($sqlFilter['sql']) && strlen($sqlFilter['sql']) > 7) { // there are something with WHERE in $sqlFilter
            $sql .= ' AND ';
        }

        $sql .= '( JSON_UNQUOTE(JSON_EXTRACT(data, "$.typeInscription")) IN ("Pacchetto completo", "Ascolto + Pasti"))';
        $sql .= ' ORDER BY i.id DESC';

        return $this->wpdb->get_results($this->wpdb->prepare($sql, $sqlFilter['params']));
    }

    public function formatDatasHospitality($inscriptions)
    {
        $csv = [];
        foreach ($inscriptions as $inscription) {
            $data = json_decode($inscription->data, true);
            foreach ($data['person'] as $person) {
                $personInfo = [
                    $person['lastName'],
                    $person['firstName'],
                    $person['gender'],
                    $person['birthdate'],
                    $person['comune'],
                    '',
                    '',
                    $person['citta'],
                    '',
                    '',
                    $person['phone'],
                    $person['email'],
                    '',
                    '',
                ];
                $csv[] = $personInfo;
            }
        }

        return $csv;
    }

    public function sendReminderPayment()
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);

        global $wpdb;

        $idInscription = $_POST['idInscription'];
        $tablename = $wpdb->prefix.'inscription';

        $getInscriptionUser = $this->getinscriptionById($idInscription);
        $inscription = $getInscriptionUser[0];
        $inscriptionData = json_decode($inscription->data, true);

        $subject = 'La tua iscrizione è in attesa di essere completata';

        $templateName = 'mail-reminder-payment';
        ob_start();
        Mail::Instance()->getTemplate($templateName);
        $template = ob_get_contents();
        ob_end_clean();

        $template = str_replace('[SUBJECT]', $subject, $template);
        $template = str_replace('[NOME_CORSO]', $inscription->post_title, $template);
        $template = str_replace('[LINK]', $inscription->link_payment, $template);
        foreach ($inscriptionData['person'] as $person) {
            if (!empty($person['referente'])) {
                $to = $person['email'];
                // $to = "staccioli@a-piu.it";
                $content_message = str_replace('[NOME]', $person['firstName'], $template);
                $sent = Mail::Instance()->sendMail($to, $subject, $content_message);
            }
        }

        if ($sent) {
            echo json_encode(['success' => true, 'redirect' => admin_url('admin.php?page=iscrizioni')]);
        } else {
            echo json_encode(['error' => 'error insert test user']);
        }
        wp_die();
    }

    public function exportCsvChildren()
    {
        $inscriptions = $this->getAllInsriptionChildren();
        $timestamp = date('Y-m-d_H-i');
        $filename = 'export-assicurazione-bambini-pastorale-con-le-famiglie_'.$timestamp.'.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $csv = $this->formatDatasChildren($inscriptions); // method to retrieve the data
        $firstrows = ['Nome corso', 'Data corso', 'Cognome', 'Nome', 'Codice fiscale', 'Luogo di nascita', 'Data di nascita', 'Indirizzo', 'Cap',
            'Provincia', 'Nominativo rif.', 'Cellulare rif.', 'Email rif.', 'Nominativo rif. aggiuntivo', 'Cellulare rif. aggiuntivo', 'Email rif. aggiuntivo'];
        $csv = [$firstrows, ...$csv];
        $output = fopen('php://output', 'wb');
        /*echo '<pre>'.print_r($csv, true).'</pre>';
        exit;*/
        // Write headers to CSV file.
        fwrite($output, "\xEF\xBB\xBF");
        foreach ($csv as $line) {
            fputcsv($output, $line, ',');
        }
        fclose($output);
        wp_die();
    }

    public function getAllInsriptionChildren()
    {
        $sql = 'SELECT i.*, p.post_title, t.name 
            FROM wp_inscription i JOIN wp_posts p ON (i.idCourse = p.ID) JOIN wp_terms t ON (i.idTypeCourse = t.term_id)';
        $sqlFilter = $this->filterSql(false, true);
        $sql .= $sqlFilter['sql'];
        if (!empty($sqlFilter['sql']) && strlen($sqlFilter['sql']) > 7) { // there are something with WHERE in $sqlFilter
            $sql .= ' AND ';
        }
        $sql .= ' ( JSON_EXTRACT(i.data, "$.isAnimazione") LIKE "%1%" )';

        $sql .= ' ORDER BY i.id DESC';

        return $this->wpdb->get_results($this->wpdb->prepare($sql, $sqlFilter['params']));
    }

    public function formatDatasChildren($inscriptions)
    {
        $csv = [];
        foreach ($inscriptions as $inscription) {
            $data = json_decode($inscription->data, true);
            foreach ($data['son'] as $child) {
                $childInfo = [
                    $inscription->post_title,
                    $inscription->dateCourse,
                    $child['lastNameSon'],
                    $child['firstNameSon'],
                    $child['CodiceFiscaleSon'],
                    $child['birthplaceSon'],
                    $child['birthdateSon'],
                    $child['addressSon'],
                    $child['capSon'],
                    $child['citySon'],
                    $data['person'][0]['firstName'].' '.$data['person'][0]['lastName'],
                    $data['person'][0]['phone'],
                    $data['person'][0]['email'],
                    $data['person'][1]['firstName'].' '.$data['person'][0]['lastName'],
                    $data['person'][1]['phone'],
                    $data['person'][1]['email'],
                ];
                $csv[] = $childInfo;
            }
        }

        return $csv;
    }

    public function getTypeCourseByIdCourse($idCourse)
    {
        $sql = "SELECT t.name AS term_name FROM wp_posts p INNER JOIN wp_term_relationships tr ON p.ID = tr.object_id INNER JOIN 
        wp_term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN wp_terms t ON tt.term_id = t.term_id WHERE p.id = $idCourse";

        return $this->wpdb->get_results($this->wpdb->prepare($sql));
    }
}
UserInscription::Instance();
