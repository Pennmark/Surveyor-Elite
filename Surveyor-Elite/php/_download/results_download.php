<?php ob_start(); $date = new DateTime(); $date->format('Y-m-d H:i:s');
$temp = str_replace("php/_download/results_download.php","_library/published/results.zip",$_SERVER['PHP_SELF']);
header("Content-disposition: attachment; filename=results.zip");
header("Cache-Control: public, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 
header("Cache-Control: no-cache");
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-type: application/zip");
header("Content-Description: File Transfer");            
header("Content-Length: ". filesize( $_SERVER['DOCUMENT_ROOT'].$temp));
header("Last-Modified: ". $date->format('Y-m-d H:i:s') ." GMT"); 
ob_end_clean();
readfile(  $_SERVER['DOCUMENT_ROOT'].$temp );
flush(); ob_flush(); unset($temp);
?>