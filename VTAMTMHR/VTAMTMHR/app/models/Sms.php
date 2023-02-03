<?php

class Sms {

    private $mobile = array();
    private $textmessage = null;

    public function sendSms($mobile = array(), $textmessage) {

        $this->mobile = $mobile;
        $this->textmessage = $textmessage;

		//Sms Report
		foreach($mobile as $mobile_no){
			$SmsReport = new SmsReport();
			$User = User::getSysUser();
			$SmsReport->orgID = $User->organisationId;
			$SmsReport->UserId = $User->userID;
			$SmsReport->Tel_No = ltrim($mobile_no, '0');
			$SmsReport->TextSend = $textmessage;			
			$SmsCharactors = strlen($textmessage);
			$SmsCount = 1;			
			//keep the message down to 160 characters
			//networks will charge you for every chunk of 153 characters that you send!
			if($SmsCharactors > 160){
				$SmsCount = ceil($SmsCharactors/153);
			}
			$SmsReport->SmsCount = $SmsCount;
			$SmsReport->save();
		}
		//Sms Report

        $soaprequest = new SoapProvider();
        return $soaprequest->makeRequest($this);
			
    }

    public function getMobile() {
        return $this->mobile;
    }

    public function setMobile($mobile) {
        $this->mobile = $mobile;
    }

    public function getTextmessage() {
        return $this->textmessage;
    }

    public function setTextmessage($textmessage) {
        $this->textmessage = $textmessage;
    }

}

class SoapProvider {

    private static $username = "icta";
    private static $password = "g0v5ms123";
    private static $department = "SkillUniCol";
    private $endpoint = "http://lankagate.gov.lk:9080/services/GovSMSMTHandlerProxy.GovSMSMTHandlerProxyHttpSoap11Endpoint/";
    private $soap_header;

    public function __construct() {

        $this->soap_header = '<govsms:authData xmlns:govsms="http://govsms.icta.lk/">
									<govsms:user>' . self::$username . '</govsms:user>
									<govsms:key>' . self::$password . '</govsms:key>
								</govsms:authData>';
    }

    public function getHeader() {

        return $this->soap_header;
    }

     public function makeRequest($request) {

        $sms_request = "";

        foreach ($request->getMobile() as $m) {

            $sms_request.= '<ns1:requestData>
                                <ns1:outSms>' . $request->getTextmessage() . '</ns1:outSms>
                                <ns1:recepient>94' . ltrim($m, '0') . '</ns1:recepient>
                                <ns1:depCode>' . self::$department . '</ns1:depCode>
                                <ns1:smscId />
                                <ns1:billable />
                            </ns1:requestData>';
        }

        $soap_request = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://schemas.icta.lk/xsd/kannel/handler/v1/">
						   <soapenv:Header>' . $this->getHeader() . '</soapenv:Header><soapenv:Body><ns1:SMSRequest xmlns:ns1="http://schemas.icta.lk/xsd/kannel/handler/v1/">' . $sms_request . '</ns1:SMSRequest></soapenv:Body></soapenv:Envelope>';


        return $this->execute($soap_request);
    }

    private function execute($soaprequest) {

        $headers = array("Content-type: text/xml;charset=\"utf-8\"", "Accept: text/xml", "Cache-Control: no-cache", "Pragma: no-cache", "Content-length: " . strlen($soaprequest));


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $soaprequest);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);


        $response = curl_exec($ch);
        curl_close($ch);


        //GovSMS delivery success.
        //Invalid Authentication Key


        return $response;
    }

}
