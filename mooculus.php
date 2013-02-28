<?php

$options['host'] = "localhost"; 
$options['port'] = 5984;
$options['user'] = "nairv";
$options['pass'] = "nairv";
$arr = array();
if(isset($_POST['eventtype'])){
  $eventtypevar = $_POST['eventtype'];
  $id = $_POST['id'];
}

$secretkey = "moomoo";
$date = date_create();
//echo date_timestamp_get($date) . "<br>" ;
$db = "/mooculus";
$docid = md5($secretkey . $id . $secretkey . date_timestamp_get($date));
$url = $db . "/" . $docid;


if($eventtypevar == "mouse")
{
  $startvar = $_POST['start'];
  $endvar = $_POST['end'];
  echo "Event type: " . $eventtypevar ."<br> ";
  echo "Start coordinate: " . $startvar ."<br> ";
  echo "End coordinate: " . $endvar ."<br> ";
  echo "ID: " . $id . "<br>";
  $arr['_id'] = "$docid";
  $arr['id'] = $id;
  $arr['eventtype'] = $eventtypevar;
  $arr['start'] = $startvar;
  $arr['end'] = $endvar;
}
elseif($eventtypevar == "keyboard")
{
  $oldvar = $_POST['old'];
  $newvar = $_POST['new'];
  $arr['_id'] = "$docid";
  $arr['id'] = $id;
  $arr['eventtype'] = $eventtypevar;
  $arr['old'] = $oldvar;
  $arr['new'] = $newvar;  
  echo "Event type: " . $eventtypevar ."<br> ";
  echo "Old value: " . $oldvar ."<br> ";
  echo "New value: " . $newvar ."<br> ";
  echo "ID: " . $id . "<br>";
}



//$arr = array('_id' => "$docid" , 'id'=>$id , 'eventtype'=> $eventtypevar , 'start' => $startvar , 'end' => $endvar);

$couch = new CouchDBCon($options); 

// See if we can make a connection
//$resp = $couch->send("GET", "/");
//var_dump($resp); // response: string(46) "{"couchdb": "Welcome", "version": "0.7.0a553"}"

// Get a list of all databases in CouchDb 
$resp = $couch->send("GET", "/_all_dbs"); 
echo $resp ."<br>";

//$resp = $couch->createdb($db);
//echo $resp . "<br>";
 //var_dump($resp); // string(17) "["test_suite_db"]" 

 // Create a new database "test"
 /*$resp = $couch->send("PUT", "/test"); 
 var_dump($resp); // string(12) "{"ok":true}" 
 
 // Get all documents in that database
 $resp = $couch->send("GET", "/test/_all_docs"); 
 var_dump($resp); // string(27) "{"total_rows":0,"rows":[]}" 

*/
 // Create a new document in the database test with the id 123 and some data
 //$resp = $couch->send("PUT", "/test/123", '{"_id":"123","data":"Foo"}'); 
 //var_dump($resp); // string(42) "{"ok":true,"id":"123","rev":"2039697587"}" 

 $resp = $couch->createDocument($url , $arr);
  echo $resp . "<br>";

 // Get all documents in test again, seing doc 123 there
 $resp = $couch->getallDocs($db);
 echo $resp . "<br>";
 //var_dump($resp); // string(91) "{"total_rows":1,"offset":0,"rows":[{"id":"123","key":"123","value":{"rev":"2039697587"}}]}" 
 //$resp = $couch->deletedb($db);
 //var_dump($resp);
 // Get back document with the id 123
// $resp = $couch->send("GET", "/test/123"); 
 //var_dump($resp); // string(47) "{"_id":"123","_rev":"2039697587","data":"Foo"}" 

 // Delete our "test" database
 //$resp = $couch->send("DELETE", "/test/"); 
 //var_dump($resp); // string(12) "{"ok":true}"

 class CouchDBCon {
    function CouchDBCon($options) {
       foreach($options AS $key => $value) {
          $this->$key = $value;
       }
    } 
   
   function send($method, $url, $post_data = NULL) {
      $s = fsockopen($this->host, $this->port, $errno, $errstr); 
      if(!$s) {
         echo "$errno: $errstr\n"; 
         return false;
      } 

      $request = "$method $url HTTP/1.0\r\nHost: $this->host\r\n"; 

      if ($this->user) {
         $request .= "Authorization: Basic ".base64_encode("$this->user:$this->pass")."\r\n"; 
      }

      if($post_data) {
         $request .= "Content-Length: ".strlen($post_data)."\r\n\r\n"; 
         $request .= "$post_data\r\n";
      } 
      else {
         $request .= "\r\n";
      }

      fwrite($s, $request); 
      $response = ""; 

      while(!feof($s)) {
         $response .= fgets($s);
      }

      list($this->headers, $this->body) = explode("\r\n\r\n", $response); 
      return $this->body;
   }

   function deletedb($url){
      $resp = $this->send("DELETE", $url);
      return $resp;
   }

   function createdb($url){
      $resp = $this->send("PUT", $url);
      return $resp;
   }

   function getallDocs($url){
      $resp = $this->send("GET" , $url . "/_all_docs");
      return $resp;
   }

   function createDocument($url , $arr)
   {
      
      $resp = $this->send("PUT", $url , json_encode($arr));
      return $resp;
   }

}
?>