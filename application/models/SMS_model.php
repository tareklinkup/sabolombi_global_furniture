<?php
class SMS_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->getSettings();
    }

    private $smsEnabled = "false";
    private $apiKey = "";
    private $url = "";
    private $bulkUrl = "";
    private $senderId = "";
    private $smsType = "";
    private $senderName = "";
    private $senderPhone = "";

    private function getSmsFooter()
    {
        return "\n\nThank you,\n{$this->senderName}\nPhone: {$this->senderPhone}";
    }

    public function getSettings()
    {
        $query = $this->db->query("select * from tbl_sms_settings");
        if ($query->num_rows() == 0) {
            $this->smsEnabled = 'false';
            return;
        }

        $settings = $query->row();
        $this->smsEnabled = $settings->sms_enabled;
        $this->apiKey = $settings->api_key;
        $this->url = $settings->url;
        $this->bulkUrl = $settings->bulk_url;
        $this->smsType = $settings->sms_type;
        $this->senderId = $settings->sender_id;
        $this->senderName = $settings->sender_name;
        $this->senderPhone = $settings->sender_phone;
    }

    public function sendSms($recipient, $message)
    {
        if ($this->smsEnabled == 'false') {
            return false;
        }
        $recipient = trim($recipient);
        // $smsText = urldecode($message) . $this->getSmsFooter();
        // $smsText = urldecode($message);
        $smsText = $message;


        $postData = array(
            "Is_Unicode" => true,
            "Message" => $smsText,
            "ApiKey" => $this->apiKey,
            "ClientId" => 'be89e7d1-016c-43a9-a495-bc8714f8de34',
            "SenderId" => $this->senderId,
            "MobileNumbers" => "88{$recipient}",
            'SenderId' => 'GLOBAL',
            'Content-Type' => 'text/html; charset=utf-8'
        );

        $ch = curl_init();

        $url = $this->url;
        $data = http_build_query($postData);
        $getUrl = $url . "?" . $data;

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_URL, $getUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 80);
        $response = curl_exec($ch);

        curl_close($ch);

        // $ch = curl_init($this->url);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($ch);

        return $response;

        // if ($this->smsEnabled == 'false') {
        //     return false;
        // }
        // $recipient = trim($recipient);
        // $smsText = urldecode($message) . $this->getSmsFooter();

        // $postData = array(
        //     "api_key" => $this->apiKey,
        //     "type" => $this->smsType,
        //     "senderid" => $this->senderId,
        //     "msg" => $smsText,
        //     "contacts" => "88{$recipient}",
        //     "Is_Unicode" => true,
        // );

        // $ch = curl_init($this->url);
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $result = curl_exec($ch);

        // return $result;
    }

    public function sendBulkSms($recipients, $message)
    {
        if ($this->smsEnabled == 'false') {
            return false;
        }
        $smsText = urldecode($message);

        $messages = array_map(function ($recipient) use ($smsText) {
            $recipient = trim($recipient);
            return array(
                'to' => "88{$recipient}",
                'message' => $smsText
            );
        }, $recipients);

        $postData = array(
            "api_key" => $this->apiKey,
            "type" => $this->smsType,
            "senderid" => $this->senderId,
            "messages" => json_encode($messages)
        );

        $ch = curl_init($this->bulkUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        return $result;
    }
}
