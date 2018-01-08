<?php

class WrapperApi{

    /**
     * Execute curl call to Factura.com's API
     *
     * @param String $url
     * @param String $request
     * @param Array $params
     * @return Object
     */
    static function callCurl($url, $request, $params = null){

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $request);

        if(!isset($params)){
            $params = 'no data';
        }

        $configEntity = FacturaConfig::configEntity();

        if($request == 'POST'){
            $dataString = json_encode($params);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length:' . strlen($dataString),
                'F-PLUGIN: b2b0f61828f85dedb83c08e6d07cf71ce964a99c',
                'F-API-KEY:' . $configEntity['apikey'],
                'F-SECRET-KEY:' . $configEntity['apisecret']
            ));
        }else{
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'F-PLUGIN: b2b0f61828f85dedb83c08e6d07cf71ce964a99c',
                'F-API-KEY:' . $configEntity['apikey'],
                'F-SECRET-KEY:' . $configEntity['apisecret']
            ));
        }

        //Curl Logs
        $fp = fopen(dirname(__FILE__) . '/logs/errorlog.txt', 'a')
                    or die('can not open log file');
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_STDERR, $fp);

        try{
            $data = curl_exec($ch);
            curl_close($ch);
        }catch(Exception $e){
            print('Exception occured: ' . $e->getMessage());
        }

        //Api Logs
        $apiLogFile = dirname(__FILE__) . '/logs/apilog.txt';
        $fh = fopen($apiLogFile, 'a')
                    or die('can not open log file');
        $logRow = '[' . date('d-m-Y h:s:i') . '] api_url: ' . $url
                        . ' | api_request: ' . $request
                        . ' | api_params: ' . json_encode($params)
                        . ' | config_vars: ' . json_encode($configEntity)
                        . ' | api_response: ' . $data . "\n";
        fwrite($fh, $logRow);
        fclose($fh);

        //return array
        return json_decode($data);
    }

}
