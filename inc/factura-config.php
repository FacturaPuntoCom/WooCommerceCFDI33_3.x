<?php

class FacturaConfig {

    static $apiUrl      = '';
    static $apiKey      = '';
	static $apiSecret   = '';
	static $serie       = '';
	static $dayOff      = '';
    static $title       = '';
    static $description = '';
    static $colorheader = '';
    static $colorfont   = '';
    static $uso   = '';
    static $sitax   = '';

    /**
     * Saving configuration in .conf file
     *
     */
    static function saveConf($settings){
      // $series = FacturaWrapper::check_serie();
      // $serie = false;
      // foreach( $series->data as $ser) {
      //   if($ser->SerieName == $settings['serie']){
      //     $serie = true;
      //   }
      // }
      //
      // if($serie == true){

        $configFile = fopen(dirname(__FILE__) .'/facturacom.conf', 'w') or die('Unable to open file!');
        //write apiKey
        fwrite($configFile, ApiHelper::strEncode($settings['apikey'])."\n");
        //write apiSecret
        fwrite($configFile, ApiHelper::strEncode($settings['apisecret'])."\n");
        //write serie
        fwrite($configFile, ApiHelper::strEncode($settings['serie'])."\n");
        //write dayoff
        fwrite($configFile, ApiHelper::strEncode($settings['dayoff'])."\n");
        //write apiurl
        fwrite($configFile, ApiHelper::strEncode($settings['apiurl'])."\n");
        //write title
        fwrite($configFile, ApiHelper::strEncode($settings['title'])."\n");
        //write description
        fwrite($configFile, ApiHelper::strEncode($settings['description'])."\n");
        //write colorheader
        fwrite($configFile, ApiHelper::strEncode($settings['colorheader'])."\n");
        //write colorfont
        fwrite($configFile, ApiHelper::strEncode($settings['colorfont'])."\n");
        //write emisor name
        fwrite($configFile, ApiHelper::strEncode($settings['emisor_name'])."\n");
        //write emisor rfc
        fwrite($configFile, ApiHelper::strEncode($settings['emisor_rfc'])."\n");
        //write emisor address1
        fwrite($configFile, ApiHelper::strEncode($settings['emisor_address1'])."\n");
        //write emisor address2
        fwrite($configFile, ApiHelper::strEncode($settings['emisor_address2'])."\n");
        //write emisor address3
        fwrite($configFile, ApiHelper::strEncode($settings['emisor_address3'])."\n");
        //write uso de cfdi
        fwrite($configFile, ApiHelper::strEncode($settings['UsoCFDI'])."\n");
        //write dayoff
        fwrite($configFile, ApiHelper::strEncode($settings['sitax'])."\n");
        fclose($configFile);

        // @TODO validate the file has been written successfully
        return true;
        // }
        // else {
        //   return false;
        // }

    }

    /**
     * Getting local vars to use globally
     *
     * @return Array
     */
    static function configEntity(){
        $configVars = self::getConf();
        // var_dump($configVars[13]);
        return array(
            'apikey'      => ApiHelper::strDecode($configVars[0]),
            'apisecret'   => ApiHelper::strDecode($configVars[1]),
            'serie'       => ApiHelper::strDecode($configVars[2]),
            'dayoff'      => ApiHelper::strDecode($configVars[3]),
            'apiurl'      => ApiHelper::strDecode($configVars[4]),
            'title'       => ApiHelper::strDecode($configVars[5]),
            'description' => ApiHelper::strDecode($configVars[6]),
            'colorheader' => ApiHelper::strDecode($configVars[7]),
            'colorfont' => ApiHelper::strDecode($configVars[8]),
            'emisor_name' => ApiHelper::strDecode($configVars[9]),
            'emisor_rfc' => ApiHelper::strDecode($configVars[10]),
            'emisor_address1' => ApiHelper::strDecode($configVars[11]),
            'emisor_address2' => ApiHelper::strDecode($configVars[12]),
            'emisor_address3' => ApiHelper::strDecode($configVars[13]),
            'UsoCFDI' => ApiHelper::strDecode($configVars[14]),
            'sitax' => ApiHelper::strDecode($configVars[15]),
        );
    }

    /**
     * Read configuration from .conf file
     *
     * @return Array
     */
     static function getConf(){
         $fp = @fopen(dirname(__FILE__) .'/facturacom.conf', 'r');

         //Add each line to an array
         if ($fp) {
            $configVars = explode("\n", fread($fp, filesize(dirname(__FILE__) .'/facturacom.conf')));
         }

         return $configVars;
     }

}
