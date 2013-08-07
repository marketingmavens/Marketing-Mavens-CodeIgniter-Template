<?php

require(FCPATH . APPPATH . 'third_party/infusionsoft/isdk.php');

class Infusion extends iSDK {

  var $client;
  var $key = 'API_KEY';
  var $app = 'INFUSION_APP_NAME';
  var $debug = 'on';




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
   * @param array $data
   * @return array|object mixed
   */

  private function array_to_object($data)
  {
    return json_decode (json_encode ($data), FALSE);
  }


  /***
   *
   * Default Search for data from Infusionsoft
   *
   * @param string $table
   * @param array $query
   * @param bool $force_all
   * @return array|bool|object
   */

  function get($table = 'Contact',$query = array(),$force_all = FALSE)
  {
    $page = 0;
    $data = array();
    $finished = FALSE;
    while(!$finished):
      $results = $this->dsQuery($table,1000,$page++,$query,$this->fields($table));
      if(!is_array($results)) return FALSE;
      $data = array_merge($data,$results);
      if(sizeof($results) < 1000) $finished = TRUE;;
    endwhile;

    if(sizeof($data) == 1 && $force_all != TRUE)
      return $this->array_to_object($data[0]);

    return $this->array_to_object($data);

  }


  /***
   * @param string $table
   * @param array $query
   * @param string $order_by
   * @param bool $asc
   * @param bool $force_all
   * @return array|bool|object
   */

  function get_order_by($table = 'Contact',$query = array(),$order_by = 'Id',$asc = TRUE,$force_all = FALSE)
  {
    $page = 0;
    $data = array();
    $finished = FALSE;
    while(!$finished):
      $results = $this->dsQueryOrderBy($table,1000,$page++,$query,$this->fields($table),$order_by,$asc);
      if(!is_array($results)) return FALSE;
      $data = array_merge($data,$results);
      if(sizeof($results) < 1000) $finished = TRUE;;
    endwhile;

    if(sizeof($data) == 1 && $force_all != TRUE)
      return $this->array_to_object($data[0]);

    return $this->array_to_object($data);

  }



  /***
   *
   * Pass either array or contact Id
   *
   * Searches for Contact returns the first
   * one if it finds more then one
   *
   * @param int|array $query
   * @return bool|mixed|object
   */

  function get_contact($query)
  {
    if(is_array($query)):
      $results = $this->get('Contact',$query);
      if(is_object($results))
        return $results;
      elseif(is_array($results))
        return $results[0];
      else
        return FALSE;
    elseif(is_int($query)) :
      $results = $this->loadCon($query,$this->fields('Contact'));
      if(is_array($results))
        return array_to_object($results);
    endif;
    return FALSE;
  }








  /***
   *
   * Get All the custom fields for a
   * particular field / table type
   *
   * @param string $type
   * @param bool $list
   * @return array|bool
   */


  private function custom_fields($type = 'Contact',$list = TRUE)
  {

    switch($type){
      case 'Contact':
        $form_id = -1;
        break;
      case 'Affiliate':
      case 'Referral Partner':
        $form_id = -3;
        break;
      case 'Opportunity':
      case 'Lead':
        $form_id = -4;
        break;
      case 'Task':
      case 'Note':
      case 'Apt':
      case 'Appointment':
        $form_id = -5;
        break;
      case 'Company':
        $form_id = -6;
        break;
      case 'Order':
        $form_id = -9;
        break;
      default :
        $form_id = -1;
        break;
    }


    $fields = $this->dsQuery('DataFormField',200,0,array('FormId' => $form_id),array('Name','Label'));

    if(!is_array($fields)):
      return FALSE;
    endif;

    if($list === TRUE):
      $list = array();
      foreach($fields as $f):
        array_push($list,'_' . $f['Name']);
      endforeach;
      return $list;
    endif;

    return $fields;
  }






  function fields($type = 'Contact')
  {
    switch($type){
      case 'ActionSequence':
      $fields = array(
        'Id' => 'Integer',
        'TemplateName' => 'String',
        'VisibleToTheseUsers' => 'String'
      );
      break;

      case 'Affiliate':
      $fields = array(
        'Id' => 'Integer',
        'ContactId' => 'Integer',
        'ParentId' => 'Integer',
        'LeadAmt' => 'Double' ,
        'LeadPercent' => 'Double',
        'SaleAmt' => 'Double',
        'SalePercent' => 'Double',
        'PayoutType' => 'Integer',
        'DefCommissionType' => 'Integer',
        'Status' => 'Integer',
        'AffName' => 'String',
        'Password' => 'String',
        'AffCode' => 'String',
        'NotifyLead' => 'Integer',
        'NotifySale' => 'Integer',
        'LeadCookieFor' => 'Integer',
      );
      break;

      case 'Campaign':
      $fields = array(
        'Id' => 'Integer',
        'Name' => 'String',
        'Status' => 'String',

      );
      break;

      case 'Campaignee':
      $fields = array(
         'CampaignId' => 'Integer',
         'Status' => 'Enum',
         'Campaign' => 'String',
         'ContactId' => 'Integer',
        );
        break;

      case 'CampaignStep':
      $fields = array(
         'Id' => 'Integer',
         'CampaignId' => 'Integer',
         'TemplateId' => 'Integer',
         'StepStatus' => 'String',
         'StepTitle' => 'String',
      );
      break;

      case 'CCharge':
      $fields = array(
         'Id' => 'Integer',
         'CCId' => 'Integer',
         'PaymentId' => 'String',
         'MerchantId' => 'String',
         'OrderNum' => 'String',
         'RefNum' => 'String',
         'ApprCode' => 'String',
         'Amt' => 'Double',
      );
      break;

      case 'Company':
      $fields = array(
         'Address1Type' => 'String',
         'Address2Street1' => 'String',
         'Address2Street2' => 'String',
         'Address2Type' => 'String' ,
         'Address3Street1' => 'String',
         'Address3Street2' => 'String',
         'Address3Type' => 'String',
         'Anniversary' => 'Date',
         'AssistantName' => 'String',
         'AssistantPhone' => 'String',
         'BillingInformation' => 'String',
         'Birthday' => 'Date',
         'City' => 'String',
         'City2' => 'String',
         'City3' => 'String',
         'Company' => 'String',
         'AccountId' => 'Integer',
         'CompanyID' => 'Integer',
         'ContactNotes' => 'String' ,
         'ContactType' => 'String',
         'Country' => 'String',
         'Country2' => 'String',
         'Country3' => 'String',
         'CreatedBy' => 'Integer',
         'DateCreated' => 'DateTime',
         'Email' => 'String',
         'EmailAddress2' => 'String',
         'EmailAddress3' => 'String',
         'Fax1' => 'String',
         'Fax1Type' => 'String',
         'Fax2' => 'String',
         'Fax2Type' => 'String',
         'FirstName' => 'String',
         'Groups' => 'String' ,
         'Id' => 'Integer',
         'JobTitle' => 'String',
         'LastName' => 'String',
         'LastUpdated' => 'DateTime',
         'LastUpdatedBy' => 'Integer',
         'MiddleName' => 'String',
         'Nickname' => 'String',
         'OwnerID' => 'Integer',
         'Password' => 'String',
         'Phone1' => 'String',
         'Phone1Ext' => 'String',
         'Phone1Type' => 'String',
         'Phone2' => 'String',
         'Phone2Ext' => 'String',
         'Phone2Type' => 'String' ,
         'Phone3' => 'String',
         'Phone3Ext' => 'String',
         'Phone3Type' => 'String',
         'Phone4' => 'String',
         'Phone4Ext' => 'String',
         'Phone4Type' => 'String',
         'Phone5' => 'String',
         'Phone5Ext' => 'String',
         'Phone5Type' => 'String',
         'PostalCode' => 'String',
         'PostalCode2' => 'String',
         'PostalCode3' => 'String',
         'ReferralCode' => 'String',
         'SpouseName' => 'String',
         'State' => 'String' ,
         'State2' => 'String',
         'State3' => 'String',
         'StreetAddress1' => 'String',
         'StreetAddress2' => 'String',
         'Suffix' => 'String',
         'Title' => 'String',
         'Username' => 'String',
         'Validated' => 'String',
         'Website' => 'String',
         'ZipFour1' => 'String',
         'ZipFour2' => 'String',
         'ZipFour3' => 'String',
      );
      break;

      case 'Contact':




        $fields = array(
         'Address1Type' => 'String',
         'Address2Street1' => 'String',
         'Address2Street2' => 'String',
         'Address2Type' => 'String' ,
         'Address3Street1' => 'String',
         'Address3Street2' => 'String',
         'Address3Type' => 'String',
         'Anniversary' => 'Date',
         'AssistantName' => 'String',
         'AssistantPhone' => 'String',
         'BillingInformation' => 'String',
         'Birthday' => 'Date',
         'City' => 'String',
         'City2' => 'String',
         'City3' => 'String',
         'Company' => 'String',
         'AccountId' => 'Integer',
         'CompanyID' => 'Integer',
         'ContactNotes' => 'String' ,
         'ContactType' => 'String',
         'Country' => 'String',
         'Country2' => 'String',
         'Country3' => 'String',
         'CreatedBy' => 'Integer',
         'DateCreated' => 'DateTime',
         'Email' => 'String',
         'EmailAddress2' => 'String',
         'EmailAddress3' => 'String',
         'Fax1' => 'String',
         'Fax1Type' => 'String',
         'Fax2' => 'String',
         'Fax2Type' => 'String',
         'FirstName' => 'String',
         'Groups' => 'String' ,
         'Id' => 'Integer',
         'JobTitle' => 'String',
         'LastName' => 'String',
         'LastUpdated' => 'DateTime',
         'LastUpdatedBy' => 'Integer',
         'Leadsource' => 'String',
         'LeadSourceId' => 'Integer',
         'MiddleName' => 'String',
         'Nickname' => 'String',
         'OwnerID' => 'Integer',
         'Password' => 'String',
         'Phone1' => 'String',
         'Phone1Ext' => 'String',
         'Phone1Type' => 'String',
         'Phone2' => 'String',
         'Phone2Ext' => 'String',
         'Phone2Type' => 'String' ,
         'Phone3' => 'String',
         'Phone3Ext' => 'String',
         'Phone3Type' => 'String',
         'Phone4' => 'String',
         'Phone4Ext' => 'String',
         'Phone4Type' => 'String',
         'Phone5' => 'String',
         'Phone5Ext' => 'String',
         'Phone5Type' => 'String',
         'PostalCode' => 'String',
         'PostalCode2' => 'String',
         'PostalCode3' => 'String',
         'ReferralCode' => 'String',
         'SpouseName' => 'String',
         'State' => 'String' ,
         'State2' => 'String',
         'State3' => 'String',
         'StreetAddress1' => 'String',
         'StreetAddress2' => 'String',
         'Suffix' => 'String',
         'Title' => 'String',
         'Username' => 'String',
         'Validated' => 'String',
         'Website' => 'String',
         'ZipFour1' => 'String',
         'ZipFour2' => 'String',
         'ZipFour3' => 'String',
      );

      break;

      case 'ContactAction':
      $fields = array(
         'Id' => 'Integer',
         'ContactId' => 'Integer',
         'OpportunityId' => 'Integer',
         'ActionType' => 'String',
         'ActionDescription' => 'String',
         'CreationDate' => 'DateTime' ,
         'CreationNotes' => 'String',
         'CompletionDate' => 'DateTime',
         'ActionDate' => 'DateTime',
         'EndDate' => 'DateTime',
         'PopupDate' => 'DateTime',
         'UserID' => 'Integer',
         'Accepted' => 'Integer',
         'CreatedBy' => 'Integer',
         'LastUpdated' => 'DateTime',
         'LastUpdatedBy' => 'Integer',
         'Priority' => 'Integer',
         'IsAppointment' => 'Integer',

      );
      break;

      case 'ContactGroup':
      $fields = array(
         'Id' => 'Integer',
         'GroupName' => 'String',
         'GroupCategoryId' => 'Integer',
         'GroupDescription' => 'String',

      );
      break;

      case 'ContactGroupAssign':
      $fields = array(
         'GroupId' => 'Integer',
         'ContactGroup' => 'String',
         'DateCreated' => 'DateTime',
         'ContactId' => 'Integer' ,
         'Contact.Address1Type' => 'String',
         'Contact.Address2Street1' => 'String',
         'Contact.Address2Street2' => 'String',
         'Contact.Address2Type' => 'String',
         'Contact.Address3Street1' => 'String',
         'Contact.Address3Street2' => 'String',
         'Contact.Address3Type' => 'String',
         'Contact.Anniversary' => 'Date',
         'Contact.AssistantName' => 'String',
         'Contact.AssistantPhone' => 'String',
         'Contact.BillingInformation' => 'String',
         'Contact.Birthday' => 'String',
         'Contact.City' => 'String',
         'Contact.City2' => 'String',
         'Contact.City3' => 'String' ,
         'Contact.Company' => 'String',
         'Contact.CompanyID' => 'Integer',
         'Contact.ContactNotes' => 'String',
         'Contact.ContactType' => 'String',
         'Contact.Country' => 'String',
         'Contact.Country2' => 'String',
         'Contact.Country3' => 'String',
         'Contact.CreatedBy' => 'Integer',
         'Contact.CustomDate1' => 'DateTime',
         'Contact.CustomDate2' => 'DateTime',
         'Contact.CustomDate3' => 'DateTime',
         'Contact.CustomDate4' => 'DateTime',
         'Contact.CustomDate5' => 'DateTime',
         'Contact.CustomDbl1' => 'Double',
         'Contact.CustomDbl2' => 'Double' ,
         'Contact.CustomDbl3' => 'Double',
         'Contact.CustomDbl4' => 'Double',
         'Contact.CustomDbl5' => 'Double',
         'Contact.CustomField1' => 'String',
         'Contact.CustomField10' => 'String',
         'Contact.CustomField2' => 'String',
         'Contact.CustomField3' => 'String',
         'Contact.CustomField4' => 'String',
         'Contact.CustomField5' => 'String',
         'Contact.CustomField6' => 'String',
         'Contact.CustomField7' => 'String',
         'Contact.CustomField8' => 'String',
         'Contact.CustomField9' => 'String',
         'Contact.DateCreated' => 'DateTime',
         'Contact.Email' => 'String',
         'Contact.EmailAddress2' => 'String',
         'Contact.EmailAddress3' => 'String' ,
         'Contact.Fax1' => 'String',
         'Contact.Fax1Type' => 'String',
         'Contact.Fax2' => 'String',
         'Contact.Fax2Type' => 'String',
         'Contact.FirstName' => 'String',
         'Contact.Groups' => 'String',
         'Contact.HTMLSignature' => 'String',
         'Contact.Id' => 'Integer',
         'Contact.JobTitle' => 'String',
         'Contact.LastName' => 'String',
         'Contact.LastUpdated' => 'String',
         'Contact.LastUpdatedBy' => 'String',
         'Contact.Leadsource' => 'String',
         'Contact.MiddleName' => 'String',
         'Contact.Nickname' => 'String' ,
         'Contact.OwnerID' => 'Integer',
         'Contact.Phone1' => 'String',
         'Contact.Phone1Ext' => 'String',
         'Contact.Phone1Type' => 'String',
         'Contact.Phone2' => 'String',
         'Contact.Phone2Ext' => 'String',
         'Contact.Phone2Type' => 'String',
         'Contact.Phone3' => 'String',
         'Contact.Phone3Ext' => 'String',
         'Contact.Phone3Type' => 'String',
         'Contact.Phone4' => 'String',
         'Contact.Phone4Ext' => 'String',
         'Contact.Phone4Type' => 'String',
         'Contact.Phone5' => 'String',
         'Contact.Phone5Ext' => 'String',
         'Contact.Phone5Type' => 'String',
         'Contact.PostalCode' => 'String',
         'Contact.PostalCode2' => 'String',
         'Contact.PostalCode3' => 'String',
         'Contact.ReferralCode' => 'String',
         'Contact.Signature' => 'String',
         'Contact.SpouseName' => 'String',
         'Contact.State' => 'String',
         'Contact.State2' => 'String' ,
         'Contact.State3' => 'String',
         'Contact.StreetAddress1' => 'String',
         'Contact.StreetAddress2' => 'String',
         'Contact.Suffix' => 'String',
         'Contact.Title' => 'String',
         'Contact.Website' => 'String',
         'Contact.ZipFour1' => 'String',
         'Contact.ZipFour2' => 'String',
         'Contact.ZipFour3' => 'String',

      );
      break;

      case 'ContactGroupCategory':
      $fields = array(
         'CategoryName' => 'String',
         'CategoryDescription' => 'String',

      );
      break;

      case 'CProgram':
      $fields = array(
         'Id' => 'Integer',
         'ProgramName' => 'String',
         'DefaultPrice' => 'Double',
         'DefaultCycle' => 'String' ,
         'DefaultFrequency' => 'Integer',
         'Sku' => 'String',
         'ShortDescription' => 'String',
         'BillingType' => 'String',
         'Description' => 'String',
         'HideInStore' => 'Integer',
         'Status' => 'Integer',
         'Active' => 'Boolean',
         'LargeImage' => 'Blob',
         'Taxable' => 'Integer',
         'Family' => 'String',
         'ProductId' => 'Integer',

      );
      break;

      case 'CreditCard':
      $fields = array(
         'Id' => 'Integer',
         'ContactId' => 'Integer',
         'BillName' => 'String',
         'FirstName' => 'String' ,
         'LastName' => 'String',
         'PhoneNumber' => 'String',
         'Email' => 'String',
         'BillAddress1' => 'String',
         'BillAddress2' => 'String',
         'BillCity' => 'String',
         'BillState' => 'String',
         'BillZip' => 'String',
         'BillCountry' => 'String',
         'ShipFirstName' => 'String',
         'ShipMiddleName' => 'String',
         'ShipLastName' => 'String',
         'ShipCompanyName' => 'String',
         'ShipPhoneNumber' => 'String',
         'ShipAddress1' => 'String' ,
         'ShipAddress2' => 'String',
         'ShipCity' => 'String',
         'ShipState' => 'String',
         'ShipZip' => 'String',
         'ShipCountry' => 'String',
         'ShipName' => 'String',
         'NameOnCard' => 'String',
         'CardNumber' => 'String',
         'Last4' => 'String',
         'ExpirationMonth' => 'String',
         'ExpirationYear' => 'String',
         'CVV2' => 'String',
         'Status' => 'Integer',
         'CardType' => 'String',
         'StartDateMonth' => 'String' ,
         'StartDateYear' => 'String',
         'MaestroIssueNumber' => 'String',

      );
      break;

      case 'DataFormField':
      $fields = array(
         'DataType' => 'Integer',

      );
      break;

      case 'DataFormTab':
      $fields = array(
         'Id' => 'Integer' ,
         'FormId' => 'Integer',
         'TabName' => 'String',

      );
      break;

      case 'DataFromGroup':
      $fields = array(
         'Id' => 'Integer' ,
         'TabId' => 'Integer',
         'Name' => 'String',

      );
      break;

      case 'Expense':
      $fields = array(
         'Id' => 'Integer' ,
         'ContactId' => 'Integer',
         'ExpenseType' => 'Enum',
         'TypeId' => 'Integer' ,
         'ExpenseAmt' => 'Double',
         'DateIncurred' => 'DateTime',

      );
      break;

      case 'GroupAssign':
      $fields = array(
         'Id' => 'Integer',
         'UserId' => 'Integer' ,
         'GroupId' => 'Integer',
         'Admin' => 'Integer',

      );
      break;

      case 'Invoice':
      $fields = array(
         'Id' => 'Integer',
         'ContactId' => 'Integer',
         'JobId' => 'Integer',
         'DateCreated' => 'DateTime',
         'InvoiceTotal' => 'Double',
         'TotalPaid' => 'Double',
         'TotalDue' => 'Double' ,
         'PayStatus' => 'Integer',
         'CreditStatus' => 'Integer',
         'RefundStatus' => 'Integer',
         'PayPlanStatus' => 'Integer',
         //'AffiliateId' => 'Integer',
         //'LeadAffiliateId' => 'Integer',
         //'PromoCode' => 'String',
         'InvoiceType' => 'String',
         'Description' => 'String',
         'ProductSold' => 'String',
         //'Synced' => 'Integer',


      );
      break;

      case 'InvoiceItem':
      $fields = array(
         'Id' => 'Integer',
         'InvoiceId' => 'Integer',
         'OrderItemId' => 'Integer',
         'InvoiceAmt' => 'Double',
         'Discount' => 'Double',
         'DateCreated' => 'DateTime',
         'Description' => 'String',
         'CommissionStatus' => 'Integer',

      );
      break;

      case 'InvoicePayment':
      $fields = array(
         'Id' => 'Integer',
         'InvoiceId' => 'Integer',
         'Amt' => 'Double',
         'PayDate' => 'Date',
         'PayStatus' => 'String',
         'PaymentId' => 'Integer',
         //'SkipCommission' => 'Integer',

      );
      break;

      case 'Job':
      $fields = array(
         'Id' => 'Integer',
         'JobTitle' => 'String' ,
         'ContactId' => 'Integer',
         'StartDate' => 'Date',
         'DueDate' => 'Date',
         'JobNotes' => 'String',
         'ProductId' => 'Integer',
         'JobStatus' => 'String',
         'DateCreated' => 'DateTime',
         'JobRecurringId' => 'Integer',
         'OrderType' => 'String',
         'OrderStatus' => 'Integer',
         /*'ShipFirstName' => 'String',
         'ShipMiddleName' => 'String',
         'ShipLastName' => 'String',
         'ShipCompany' => 'String',
         'ShipPhone' => 'String' ,
         'ShipStreet1' => 'String',
         'ShipStreet2' => 'String',
         'ShipCity' => 'String',
         'ShipState' => 'String',
         'ShipZip' => 'String',
         'ShipCountry' => 'String',*/

      );
      break;

      case 'JobRecurringInstance':
      $fields = array(
         'Id' => 'Integer',
         'RecurringId' => 'Integer',
         'InvoiceItemId' => 'Integer' ,
         'Status' => 'Integer',
         'AutoCharge' => 'Integer',
         'StartDate' => 'Date',
         'EndDate' => 'Date',
         'DateCreated' => 'DateTime',
         'Description' => 'String',

      );
      break;

      case 'Lead':
      $fields = array(
         'Id' => 'Integer',
         'OpportunityTitle' => 'String' ,
         'ContactID' => 'Integer',
         'AffiliateId' => 'Integer',
         'UserID' => 'Integer',
         'StageID' => 'Integer',
         'StatusID' => 'Integer',
         'Leadsource' => 'String',
         'Objection' => 'String',
         'ProjectedRevenueLow' => 'Double',
         'ProjectedRevenueHigh' => 'Double',
         'OpportunityNotes' => 'String',
         'DateCreated' => 'DateTime',
         'LastUpdated' => 'DateTime',
         'LastUpdatedBy' => 'Integer',
         'CreatedBy' => 'Integer',
         'EstimatedCloseDate' => 'DateTime' ,
         'NextActionDate' => 'DateTime',
         'NextActionNotes' => 'String',

      );
      break;

      case 'LeadSource':
      $fields = array(
         'Id' => 'Integer',
         'Name' => 'String',
         'Description' => 'String',
         'StartDate' => 'Date',
         'EndDate' => 'Date',
         'CostPerLead' => 'String',
         'Vendor' => 'String',
         'Medium' => 'String',
         'Message' => 'String',
         'LeadSourceCategoryId' => 'Integer',
         'Status' => 'String',

      );
      break;

      case 'LeadSourceCategory':
      $fields = array(
         'Id' => 'Integer',
         'Name' => 'String',
         'Description' => 'String',

      );
      break;

      case 'LeadSourceExpense':
      $fields = array(
         'Id' => 'Integer',
         'LeadSourceRecurringExpenseId' => 'Integer',
         'LeadSourceId' => 'Integer',
         'Title' => 'String',
         'Notes' => 'String',
         'Amount' => 'Double',
         'DateIncurred' => 'DateTime',

      );
      break;

      case 'LeadSourceRecurringExpense':
      $fields = array(
         'Id' => 'Integer',
         'LeadSourceId' => 'Integer',
         'Title' => 'String',
         'Notes' => 'String',
         'Amount' => 'Double',
         'StartDate' => 'DateTime',
         'EndDate' => 'DateTime',
         'NextExpenseDate' => 'DateTime',

      );
      break;

      case 'OrderItem':
      $fields = array(
         'Id' => 'Integer',
         'OrderId' => 'Integer',
         'ProductId' => 'Integer',
         'SubscriptionPlanId' => 'Integer',
         'ItemName' => 'Double',
         'Qty' => 'Integer',
         'CPU' => 'Double',
         'PPU' => 'Double',
         'ItemDescription' => 'String',
         'ItemType' => 'Integer',
         'Notes' => 'String',

      );
      break;

      case 'Payment':
      $fields = array(
         'Id' => 'Integer',
         'PayDate' => 'Date',
         //'UserId' => 'Integer',
         'PayAmt' => 'Double',
         'PayType' => 'String',
         'ContactId' => 'Integer',
         'PayNote' => 'String',
         'InvoiceId' => 'Integer',
         'RefundId' => 'Integer',
         //'ChargeId' => 'Integer',
         //'Commission' => 'Integer',
         //'Synced' => 'Integer',

      );
      break;

      case 'PayPlan':
      $fields = array(
         'Id' => 'Integer',
         'InvoiceId' => 'Integer',
         'DateDue' => 'Date',
         'AmtDue' => 'Double',
         'Type' => 'Integer',
         'InitDate' => 'Date',
         'StartDate' => 'Date',
         'FirstPayAmt' => 'Double',

      );
      break;

      case 'PayPlanItem':
      $fields = array(
         'Id' => 'Integer',
         'PayPlanId' => 'Integer',
         'DateDue' => 'Date',
         'AmtDue' => 'Double',
         'Status' => 'Integer',
         'AmtPaid' => 'Double',

      );
      break;

      case 'Product':
      $fields = array(
         'Id' => 'Integer',
         'ProductName' => 'String',
         'ProductPrice' => 'Double' ,
         'Sku' => 'String',
         'ShortDescription' => 'String',
         'Taxable' => 'Integer',
         'CountryTaxable' => 'Integer',
         'StateTaxable' => 'Integer',
         'CityTaxable' => 'Integer',
         'Weight' => 'Double',
         'IsPackage' => 'Integer',
         'NeedsDigitalDelivery' => 'Integer',
         'Description' => 'String',
         'HideInStore' => 'Integer',
         'Status' => 'Integer',
         'TopHTML' => 'String',
         'BottomHTML' => 'String',
         'ShippingTime' => 'String' ,
         'LargeImage' => 'Blob',
         'InventoryNotifiee' => 'String',
         'InventoryLimit' => 'Integer',
         'Shippable' => 'Integer',

      );
      break;

      case 'ProductCategory':
      $fields = array(
         'Id' => 'Integer' ,
         'CategoryDisplayName' => 'String',
         'CategoryImage' => 'Blob',
         'CategoryOrder' => 'Integer',
         'ParentId' => 'Integer',

      );
      break;

      case 'ProductCategoryAssign':
      $fields = array(
         'Id' => 'Integer',
         'ProductId' => 'Integer',
         'ProductCategoryId' => 'Integer',

      );
      break;

      case 'ProductInterest':
      $fields = array(
         'Id' => 'Integer',
         'ObjectId' => 'Integer',
         'ObjType' => 'String',
         'ProductId' => 'Integer',
         'ProductType' => 'String',
         'Qty' => 'Integer',
         'DiscountPercent' => 'Integer',

      );
      break;

      case 'ProductInterestBundle':
      $fields = array(
         'Id' => 'Integer',
         'BundleName' => 'String',
         'Description' => 'String',

      );
      break;

      case 'RecurringOrder':
      $fields = array(
         'Id' => 'Integer',
         'ContactId' => 'Integer' ,
         'OriginatingOrderId' => 'Integer',
         'ProgramId' => 'Integer',
         'SubscriptionPlanId' => 'Integer',
         'ProductId' => 'Integer',
         'StartDate' => 'Date',
         'EndDate' => 'Date',
         'LastBillDate' => 'Date',
         'NextBillDate' => 'Date',
         'PaidThruDate' => 'Date',
         'BillingCycle' => 'String',
         'Frequency' => 'Integer',
         'BillingAmt' => 'Double',
         'Status' => 'String',
         'ReasonStopped' => 'String',
         'AutoCharge' => 'Integer' ,
         'CC1' => 'Integer',
         'CC2' => 'Integer',
         'NumDaysBetweenRetry' => 'Integer',
         'MaxRetry' => 'Integer',
         'MerchantAccountId' => 'Integer',
         'AffiliateId' => 'Integer',
         'PromoCode' => 'Integer',
         'LeadAffiliateId' => 'Integer',
         'Qty' => 'Integer',

      );
      break;

      case 'Referral':
      $fields = array(
         'Id' => 'Integer',
         'ContactId' => 'Integer',
         'AffiliateId' => 'Integer',
         'DateSet' => 'Date',
         'DateExpires' => 'Date',
         'IPAddress' => 'String',
         'Source' => 'String',
         'Info' => 'String',
         'Type' => 'Integer',

      );
      break;

      case 'Stage':
      $fields = array(
         'Id' => 'Integer',
         'StageName' => 'String',
         'StageOrder' => 'Integer',
         'TargetNumDays' => 'Integer',

      );
      break;

      case 'StageMove':
      $fields = array(
         'Id' => 'Long',
         'OpportunityId' => 'Long',
         'MoveDate' => 'DateTime',
         'MoveToStage' => 'Long',
         'MoveFromStage' => 'Long',
         'PrevStageMoveDate' => 'DateTime',
         'CreatedBy' => 'Long',
         'DateCreated' => 'DateTime',
         'UserId' => 'Long',

      );
      break;

      case 'SubscriptionPlan':
      $fields = array(
         'Id' => 'Integer',
         'ProductId' => 'Integer',
         'Cycle' => 'String',
         'Frequency' => 'Integer',
         'PreAuthorizeAmount' => 'Double',
         'Prorate' => 'Boolean',
         'Active' => 'Boolean',
         'PlanPrice' => 'Double',

      );
      break;

      case 'Template':
      $fields = array(
         'Id' => 'Integer',
         'PieceType' => 'String',
         'PieceTitle' => 'String',
         'Categories' => 'String',

      );
      break;

      case 'User':
      $fields = array(
         'EmailAddress3' => 'String',
         'FirstName' => 'String',
         'HTMLSignature' => 'String' ,
         'Id' => 'Integer',
         'LastName' => 'String',
         'MiddleName' => 'String',
         'Nickname' => 'String',
         'Phone1' => 'String',
         'Phone1Ext' => 'String',
         'Phone1Type' => 'String',
         'Phone2' => 'String',
         'Phone2Ext' => 'String',
         'Phone2Type' => 'String',
         'PostalCode' => 'String',
         'Signature' => 'String',
         'SpouseName' => 'String',
         'State' => 'String',
         'StreetAddress1' => 'String' ,
         'StreetAddress2' => 'String',
         'Suffix' => 'String',
         'Title' => 'String',
         'ZipFour1' => 'String',

      );
      break;

      case 'UserGroup':
      $fields = array(
         'Id' => 'Integer',
         'Name' => 'String',
         'OwnerId' => 'Integer',

      );
      break;

      default :
        $fields = array(
          'Id'
        );
 	  }


    $list = array();
    foreach($fields as $k => $type):
      array_push($list,$k);
    endforeach;
    return $list;

  }


}