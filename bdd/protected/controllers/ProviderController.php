<?php
include 'logic/ProviderLogic.php';
class ProviderController extends CController
{
	public $defaultAction='goToIndex';

        public function actionGoToIndex() {
            $this->render('index',array());
        }
        public function actionMedia()
	{
            //Disable timeout
            set_time_limit(0);

            $l = new ProviderLogic();
            $xmlFile = "provider/media.xml";
            $fh = fopen($xmlFile, 'w') or die("can't open file");

            //Write the XML header
            $header = '<?xml version="1.0" encoding="ISO-8859-1"?>';
            $header2 = '<Media>';
            fwrite($fh, $header."\n");
            fwrite($fh, $header2."\n");

            $spList = $l->performSQLMedia();
            foreach($spList['list'] as $n=>$ar) {
                $xml = $xml.$ar['xml'];
            }

            //Escape all special characters
            $xml = ereg_replace("&", "&amp;", $xml);
            $xml = ereg_replace('"', "&quot;", $xml);
            $xml = ereg_replace("'", "&apos;", $xml);
            
            //Write to file
            fwrite($fh, $xml);

            //Write the XML footer
            $footer = '</Media>';
            fwrite($fh, $footer."\n");

            fclose($fh);

            //Re-enable timeout
            set_time_limit(30);
	}

        public function actionReference()
	{
            //Disable timeout
            set_time_limit(0);

            $l = new ProviderLogic();

            $xmlFile = "provider/reference.xml";
            $fh = fopen($xmlFile, 'w') or die("can't open file");

            //Write the XML header
            $header = '<?xml version="1.0" encoding="ISO-8859-1"?>';
            $header2 = '<References>';
            fwrite($fh, $header."\n");
            fwrite($fh, $header2."\n");

            $spList = $l->performSQLRef();
            foreach($spList['list'] as $n=>$ar) {
                $xml = $xml.$ar['xml'];
            }

            //Escape all special characters
            $xml = ereg_replace("&", "&amp;", $xml);
            $xml = ereg_replace('"', "&quot;", $xml);
            $xml = ereg_replace("'", "&apos;", $xml);
            
            //Write to file
            fwrite($fh, $xml);

            //Write the XML footer
            $footer = '</References>';
            fwrite($fh, $footer."\n");

            fclose($fh);

            //Re-enable timeout
            set_time_limit(30);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		//Metodo localizado dentro da classe WebbeeController em protected/components/
		return WebbeeController::controlAccess();
	}
}
