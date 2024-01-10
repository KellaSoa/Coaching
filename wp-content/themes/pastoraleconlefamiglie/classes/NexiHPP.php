<?php

class NexiHPP
{

    protected static ?NexiHPP $instance = null;

    const BASE_URL = 'https://xpay.nexigroup.com/api/phoenix-0.0/psp/api/v1/';

    const TEST_URL = 'https://stg-ta.nexigroup.com/api/phoenix-0.0/psp/api/v1/';

    const HPP_ENDPOINT = 'orders/hpp';

    const ORDER_STATUS = 'orders/{order_id}';

    const ORDER_PREFIX = 'PCLF';

    protected string $cancelURL;

    protected array $operationResultsOK = [
        'AUTHORIZED',
        'EXECUTED'
    ];

    protected function __construct()
    {
        self::$instance = &$this;
        $this->cancelURL = site_url('sostienici#donation-form');

        add_action('wp_ajax_nopriv_nexi_hpp', [$this, 'nexiHPP']);
        add_action('wp_ajax_nexi_hpp', [$this, 'nexiHPP']);

    }

    public function getURL(): string
    {
        return NEXI_TEST_MODE ? self::TEST_URL : self::BASE_URL;
    }

    public function getAPIKey(): string
    {
        return NEXI_TEST_MODE ? NEXI_TEST_API_KEY : NEXI_PROD_API_KEY;
    }

    public static function Instance(): NexiHPP
    {
        return self::$instance ?? self::$instance = new NexiHPP();
    }

    /**
     * Create GUID (Globally Unique Identifier)
     * @return string
     */
    public function createGUID(): string
    {
        $guid = '';
        $namespace = rand(11111, 99999);
        $uid = uniqid('', true);
        $data = $namespace;
        $data .= $_SERVER['REQUEST_TIME'];
        $data .= $_SERVER['HTTP_USER_AGENT'];
        $data .= $_SERVER['REMOTE_ADDR'];
        $data .= $_SERVER['REMOTE_PORT'];
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash,  0,  8) . '-' .
            substr($hash,  8,  4) . '-' .
            substr($hash, 12,  4) . '-' .
            substr($hash, 16,  4) . '-' .
            substr($hash, 20, 12);
        return $guid;
    }

    public function nexiPayment(string $orderID, float $amount): string
    {
        // Forward request to the API
        $endpoint = $this->getURL() . self::HPP_ENDPOINT;

        $data = [
            'order' => [
                'orderId'   => $orderID,
                'amount'    => (string)$amount,
                'currency'  => 'EUR'
            ],
            'paymentSession' => [
                'actionType'    => 'PAY',
                'amount'        => (string)$amount,
                'language'      => 'ita',
                'resultUrl'     => site_url('payment/?orderID='.$orderID),
                'cancelUrl'     => $this->cancelURL
            ]
        ];

        return $this->makeRequest($endpoint, $data);
    }

    public function makeRequest($url, $data = []): string
    {
        $guid = $this->createGUID();
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'X-Api-Key: ' . $this->getAPIKey(),
            'Content-Type: application/json',
            'Correlation-Id: '.$guid,
        ];

        if(!empty($data)) {
            $data = json_encode($data, JSON_UNESCAPED_SLASHES);
            $content_length = strlen($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            $headers[] = 'Content-Length: '.$content_length;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if(!NEXI_CURL_SSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        }

        $response = curl_exec($ch);
        // Output API response
        if ($response === false) {
            // Check for cURL errors
            $error = curl_error($ch);
            $error = 'Nexi HPP cURL Error: ' . $error;
            error_log($error);
            $return = json_encode(['error' => $error]);
        } else {
            $return = $response;
        }
        curl_close($ch);
        return $return;
    }

    public function checkOrderStatus(string $orderID): bool
    {
        $endpoint = str_replace('{order_id}', $orderID, self::ORDER_STATUS);
        $url = $this->getURL() . $endpoint;
        $result = $this->makeRequest($url);
        $result = json_decode($result);
        $operation = $result->operations[0];
        return in_array($operation->operationResult, $this->operationResultsOK);
    }

    public function generateMerchantOrderID(): string
    {
        $unique_id = uniqid(); // Generate a unique ID

        // Generate a random alphanumeric string
        $random_string = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 10);

        // Combine components to form the order ID
        $order_id = self::ORDER_PREFIX .'_'. $unique_id . $random_string;

        // Truncate the order ID to a maximum length of 18 characters
        return substr($order_id, 0, 18);
    }

    public function nexiHPP()
    {
        header('Content-Type: application/json; charset=utf-8');
        $request_method = $_SERVER['REQUEST_METHOD'];

        if ($request_method !== 'POST') {
            http_response_code(405);
            wp_die();
        }

        $amount = intval($_POST['amount']) * 100;
        $orderID = $_POST["orderID"];
        echo NexiHPP::Instance()->nexiPayment($orderID, $amount);
        wp_die();
    }
}
NexiHPP::Instance();