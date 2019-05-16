  <?php
  /**
   * WalletProcessor file contains a class that formulates post data and posts
   * it to the appropriate Wallet
   *
   * PHP VERSION 5.3.6
   *
   * @category  C2B Post
   * @package   C2BPostScripts
   * @author    Daniel Mbugua <daniel.mbugua@cellulant.com>
   * @copyright 2013 Cellulant Ltd
   * @license   Proprietory License
   * @link      http://www.cellulant.com
   */
  require_once __DIR__ . '/../../lib/Config.php';
  require_once __DIR__ . '/../../lib/logger/BeepLogger.php';
  require_once __DIR__ . '/../../lib/CoreUtils.php';
  require_once __DIR__ . '/../../lib/Encryption.php';
  include_once __DIR__ . '/../../lib/IXR_Library.php';

  /**
   * WalletProcessor class formulates post data and posts it to the appropriate Wallet
   *
   * @category  C2B Post
   * @package   C2BPostScripts
   * @author    Daniel Mbugua <daniel.mbugua@cellulant.com>
   * @copyright 2013 Cellulant Ltd
   * @license   Proprietory License
   * @link      http://www.cellulant.com
   */
  class GazProcessor
  {
      /**
       * Log class instance. 
       *
       * @var object
       */
      private $log;
     // private $RemobiUrl='http://192.168.41.6/api/REMOBIAPIS/InsertPayment.php?';
        private $RemobiUrl='https://fcsexternalservice.azurewebsites.net/topup?';
       /**
       * Class constructor
       */
      public function __construct()
      {
          $this->log = new BeepLogger();

      }


  function postValidationRequestToHUB($fields,$authorization) {

          $fields_string = null;  
          $ch = curl_init();
  //set the url, number of POST vars, POST data
          curl_setopt($ch, CURLOPT_URL,$this->RemobiUrl);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
          // curl_setopt($ch, CURLOPT_POST, count($fields));
          curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

          curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  'Authorization:'.$authorization,
                  'Content-type:application/json'
                           
      ));

  //execute post
          $result = curl_exec($ch);
  //close connection
          curl_close($ch);

          
          return $result;

      }
      

   


     public function processRecord(PaymentHandler $data)
      {
         

          $this->log->info(Config::INFO, $data->beepTransactionID, "This the "
                . "request i received for processing "
                . $this->log->printArray($data));


          $status['beepTransactionID'] = (int) $data->beepTransactionID;
          $status['payerTransactionID'] = $data->payerTransactionID;
          

          $payload = json_decode($data->paymentExtraData, true);



    $authorization =  $payload['authorization'];
          $cardmask =  $payload['cardmask'];
          $transactioncode = $status['beepTransactionID'];
          $amount = $payload['amount'];

  // error_message

      $params = array(            
              
              "cardmask"=>$cardmask,
              "transactioncode"=>$transactioncode,  
              "amount"=>$amount 

          );


        $response= $this->postValidationRequestToHUB(json_encode($params),$authorization);
        $responsedata = json_decode($response);

       

        $response_data = json_decode($response);
        
        $error_code = $response_data->error->error_code;

      

              
      
             
            if($error_code == 200){

                $message  = $response_data->Message;
                $transactionRef  = $response_data->TransactionalRef;

                 $status['statusCode']   = Config::PUSH_STATUS_PAYMENT_ACCEPTED ;
                 $status['statusDescription'] = $message." ! ". $transactionRef;
               //$responsedata->Message;
               // $responsedata->TransactionalRef;
          
              }
              else{
                 
                 $error_message = $response_data->error->error_message;
                 $status['statusCode']   = Config:: PUSH_STATUS_PAYMENT_REJECTED ;
                $status['statusDescription'] =  $error_message;
                //$responsedata->error->error_message;
                
          
              }




          return $status;

   
      }
      




  }

