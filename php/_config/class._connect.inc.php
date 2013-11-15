<?php class _ExFotR{
 function _SplRs1($letSer,$MyDb){
 $checkArray = array("defaults_set","defaults_get","survey_list_get","new_info","edit_info","new_question","edit_question","get_test","reorder_questions","publish_tracking","publish_results","publish_tracer","publish_tests","publish_tests","file_download","page_check","test_get","page_turn","test_results","user_name","file_download","page_check","test_get","file_download","page_check","test_get");
 if (in_array( $letSer,$checkArray)){
  $MyDb->host = '/*your host name*/'; 
  $MyDb->database = '/*your database name*/'; 
  $MyDb->username = '/*your user name*/'; 
  $MyDb->password = '/*your password name*/';  
  return $MyDb;} }
 function _SplRs2($letSer,$MyDb){
 $checkArray = array("defaults_set","defaults_get","survey_list_get","new_info","edit_info","new_question","edit_question","get_test","reorder_questions","publish_tracking","publish_results","publish_tracer","publish_tests","publish_tests","file_download","page_check","test_get","page_turn","test_results","user_name","file_download","page_check","test_get","file_download","page_check","test_get");
 if (in_array( $letSer,$checkArray)){
  $mysqli = new mysqli($MyDb->host, $MyDb->username, $MyDb->password, $MyDb->database); return $mysqli;}}
 function _SplRs3($letSer,$MyDb){
 $checkArray = array("defaults_set","defaults_get","survey_list_get","new_info","edit_info","new_question","edit_question","get_test","reorder_questions","publish_tracking","publish_results","publish_tracer","publish_tests","publish_tests","file_download","page_check","test_get","page_turn","test_results","user_name","file_download","page_check","test_get","file_download","page_check","test_get");
 if (in_array( $letSer,$checkArray)){
  $pdo = new PDO( 'mysql:host='.$MyDb->host.';dbname='.$MyDb->database.'', $MyDb->username, $MyDb->password ); return $pdo;} } }
?>
