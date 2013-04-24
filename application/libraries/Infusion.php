<?php

require(FCPATH . APPPATH . 'third_party/isdk.php');

class Infusion extends iSDK {

  var $client;
  var $key = '111';
  var $app = 'appname';
  var $debug = 'on';

  /***
   * Connect to Infusionsoft Application
   */
  public function __construct()
  {
    $this->client = new xmlrpc_client("https://{$this->app}.infusionsoft.com/api/xmlrpc");
    $this->client->return_type = 'phpvals';
    $this->client->setSSLVerifyPeer(FALSE);
  }

  /***
   * Connect to another Infusionsoft, based on app name and api key
   * @param string $app
   * @param string $key
   */
  public function connect($app,$key)
  {
    $this->app = $app;
    $this->key = $key;
    $this->client = new xmlrpc_client("https://{$this->app}.infusionsoft.com/api/xmlrpc");
    $this->client->return_type = 'phpvals';
    $this->client->setSSLVerifyPeer(FALSE);
  }

  /***
   * Private Function for converting Array into objects.
   * For multi dimensional arrays, it will take the Id
   * of the element and use it as the key for the object
   *
   * Ex:
   * stdClass Object
   * (
   *    id_4 => stdClass Object
   *      (
   *        [Email] => abc.com
   *      )
   * )
   *
   * @param $array
   * @return stdClass
   */

  private function to_object($array) {
    $obj = new stdClass();
    foreach ($array as $key => $val) {
      if(is_array($val)):
        if(isset($val['Id'])):
          $id = 'id_' . $val['Id'];
        else :
          $id = '_' . $key;
        endif;
        $obj->$id = $this->to_object($val);
      else :
        $obj->$key = $val;
      endif;
    }
    return $obj;
  }





}