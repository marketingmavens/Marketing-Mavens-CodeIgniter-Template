<?php

require(FCPATH . APPPATH . 'third_party/infusionsoft/isdk.php');

class Infusion extends iSDK {

  var $client;
  var $key = '111';
  var $app = 'appname';
  var $debug = 'on';


  var $contact_fields = array(
    'Id', 'FirstName', 'LastName', 'Company', 'Email', 'Phone1', 'LastUpdated',
    'StreetAddress1', 'StreetAddress2', 'City', 'PostalCode', 'State', 'Country',
    'Address2Street1', 'Address2Street2', 'City2', 'PostalCode2', 'State2', 'Country2',
    'Password', 'Groups',
  );
  var $lead_fields = array(
    'Id','ContactID','OpportunityTitle','StageID','EstimatedCloseDate','Objection',
  );

  var $productinterest_fields = array(
    'Id','ObjectId','ObjType','ProductId','ProductType','Qty','DiscountPercent'
  );



  /***
   * Connect to Infusionsoft Application
   */
  public function __construct()
  {
    $this->cfgCon($this->app,$this->key);
  }

  /***
   * Connect to another Infusionsoft, based on app name and api key
   * @param string $app
   * @param string $key
   */
  public function connect($app,$key)
  {
    $this->cfgCon($app,$key);
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

  private function array_to_object($data)
  {
    return json_decode (json_encode ($data), FALSE);
  }


  function get($table,$query,$force_all = FALSE)
  {
    $page = 0;
    $fields = strtolower($table) . '_fields';
    $data = array();
    $finished = FALSE;
    while(!$finished):
      $results = $this->dsQuery($table,1000,$page++,$query,$this->$fields);
      if(!is_array($results)) return FALSE;
      $data = array_merge($data,$results);
      if(sizeof($results) < 1000) $finished = TRUE;;
    endwhile;

    if(sizeof($data) == 1 && $force_all != TRUE)
      return $this->array_to_object($data[0]);

    return $this->array_to_object($data);

  }





}