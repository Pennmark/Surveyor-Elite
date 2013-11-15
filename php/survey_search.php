<?php  /* This page is a PHP file for Surveyor Elite copyright 2013, Mark Bazzone.  SurveyorElite.com */
	$date = new DateTime();
	if(isset($_GET['action'])){  $action=$_GET['action'];  }
	if(isset($_GET['index'])){  $index=$_GET['index'];  }
	if(isset($_GET['additional'])){  $additional=$_GET['additional'];  }
	if(isset($_GET['submission'])){  $submission=$_GET['submission'];  }
	if(isset($_GET['results'])){  $results=$_GET['results'];  }
	if(isset($_GET['UiD'])){  $userId=$_GET['UiD'];  } 
	$html=''; $temp= array(); 
	switch ($action) {
		case "page_check":{	 
			ob_start();
			require_once('/_config/class._connect.inc.php'); 
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
			$buildOBJ = array();		
			$sql = 'SELECT `id`, `form_type`, `info_titles`, `survey_name`, `survey_title`, `overview`, `user_level`, `time_length`, `timer`, `results`, `purpose`, `author`, `release_date`, `closing`, `closing_link`, `user_name`, `info_image`, `image_comment` FROM `survey_info` WHERE `page_name`="'. $index.'" && `status`="active" ; ';
			$statement = $pdo->query( $sql );
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){							
				foreach($row as $key=>$val){
				if($val==NULL || $val=="0:00"){ $val= "NULL";}
					$buildOBJ[$index][$key][ $row['id'] ] =  $val ; }  }
			if( !isset($buildOBJ[$index]['id']) ){
				$buildOBJ[$index]['no_page']="no_page"; } 
			$sql2 = 'SELECT * FROM `survey_defaults` WHERE `status`="active" ORDER BY `default_name` ;';
			$statement2 = $pdo->query( $sql2 );
			while($row = $statement2->fetch(PDO::FETCH_ASSOC)){							
				foreach($row as $key=>$val){
				if($val==NULL){ $val= "NULL";}
					if($key != "status_update"){ $buildOBJ['survey_defaults'][$key][ $row['id'] ] =  $val ; }  }  }
			if( !isset($buildOBJ['survey_defaults']['id']) ){
				$buildOBJ['survey_defaults']['no_defaults']="no_defaults"; } 
			$buildOBJ['user']['browser'] = $_SERVER['HTTP_USER_AGENT'];
			$buildOBJ['user']['ip'] = $_SERVER['REMOTE_ADDR'] ;	
			$buildOBJ['user']['port'] = $_SERVER['REMOTE_PORT'] ;	
			if( isset( $buildOBJ['user']['ip'] ) && isset( $buildOBJ['user']['browser'] ) ){
				$date = new DateTime();
				$temp['Pepper'] = "_SuRvEyElItE_".$date->format('Y-m-d H:i:s');
				$temp['Salt'] = hash('sha512', crypt('sha512', $buildOBJ['user']['ip'] ).$temp['Pepper'] );
				$buildOBJ['user']['id'] = $temp['Salt'] ; } 
			$sql3 = "INSERT INTO `_survery_tcr` (`user`, `user_id`, `user_info`, `survey_info`)
					VALUES ( '".$buildOBJ['user']['ip']."' , '".$buildOBJ['user']['id']."' , 'BSR|=| ". $buildOBJ['user']['browser'] ." |_-_|PRT|=| ". $buildOBJ['user']['port'] ."' , 'LDG|_-_|' ) " ;
			$statement3 = $pdo->query( $sql3 );
			$result = $statement3->fetch(PDO::FETCH_ASSOC);
			unset($buildOBJ['user']['browser']); unset($buildOBJ['user']['ip']); unset($buildOBJ['user']['port']);	 
			ob_end_clean();
			echo   $index .' |_:_| '. json_encode($buildOBJ[$index]) .' |_-_| survey_defaults |_:_| '. json_encode($buildOBJ['survey_defaults']) .' |_-_| user |_:_| '. json_encode($buildOBJ['user']); 
			unset( $buildOBJ );unset( $temp );unset( $date );	unset( $buildOBJ,$mysqli,$pdo,$MyDb);
			flush(); break;} 
		case "test_get":{ 
			ob_start();
			require_once('/_config/class._connect.inc.php'); 
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $buildOBJ['test_get']='';				
			$sql = 'SELECT `id`, `question`, `choices`, `answer`, `comment`, `image`, `question_order`, `type` FROM `survey` WHERE `test_id`="'. $index.'" && `status`="active" ORDER BY question_order; ';
			$statement = $pdo->query( $sql );
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){							
				foreach($row as $key=>$val){
				$tempVal3='';
				if($val==NULL){ $val= "NULL";}
					if($key=='answer' && $val !="NULL"){
						$tempVal = strpos($val, '|=|');
						if($tempVal==false){ $tempVal3 =  hash("sha224",$val);  }
						if($tempVal==true){
						$tempVal2 = explode("|=|", $val);
						foreach($tempVal2 as $key1=>$val1){
							if( $val1 != ''){ if($tempVal3==''){ $tempVal3 =   hash("sha224",$val1); } else{ $tempVal3 .=   ', '. hash("sha224",$val1) ; } 	}  } }
						$val = $tempVal3; }
					$buildOBJ['test_get'] .=	$key ."|-|".$val."|_:_|" ;  }
				$buildOBJ['test_get'] .="|_-_|"; }
			if( !isset($buildOBJ['test_get']) || $buildOBJ['test_get']== ''){
				$buildOBJ['test_get']="no_page"; } 
			$sql2 = 'SELECT * FROM `_survery_tcr` WHERE `user_id`="'. $userId .'" ;';
			$statement2 = $pdo->query( $sql2 );
			while($row = $statement2->fetch(PDO::FETCH_ASSOC)){	 $tempUserInfo = $row['survey_info'] . $additional ."|_-_|";	 }		
			$sql3 = " UPDATE `_survery_tcr` SET `survey_info`='".$tempUserInfo."',`updated`='". $date->format('Y-m-d H:i:s')."' WHERE `user_id`='". $userId ."' ; " ;
			$result = $pdo->exec( $sql3 ); 
			ob_end_clean();
			echo json_encode($buildOBJ['test_get']); 
			unset( $buildOBJ );	unset( $tempUserInfo);	unset( $buildOBJ,$mysqli,$pdo,$MyDb);
			flush(); break;} 
		case "page_turn":{
			ob_start(); 
			require_once('/_config/class._connect.inc.php'); 
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $buildOBJ['page_turn']=''; 	
			$sql1 = "SELECT `user_name` FROM `_survery_tcr` WHERE `user_id` = '". $userId."' Limit 1;";  
			$statement1 = $pdo->query( $sql1 );
			$row1 = $statement1->fetch(PDO::FETCH_ASSOC);	
			$sql = 'SELECT  * FROM `survey_results` WHERE `user_id`="'. $userId .'"  && `test_name`="'. $index.'" ;';
			$statement = $pdo->query( $sql );
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){	
				$buildOBJ['page_turn'] ="|_-_|";						
				$tempSubmission = $row["answers_submitted"] ."|_-_|". $submission ;} 
			if( !isset($buildOBJ['page_turn']) || $buildOBJ['page_turn']== ''){
				$buildOBJ['page_turn']="no_page"; 				
				$sql4 = "INSERT INTO `survey_results`(`test_name`, `answers_submitted`, `user_id`, `updated`,`user_name`)
				VALUES ( '".$index."' , '".$submission."' , '". $userId."' , '". $date->format('Y-m-d H:i:s')."', '".$row1['user_name']."' ) ;" ;  
			 	$result4 = $pdo->exec( $sql4 );  	}
			else{  	$sql4 = "UPDATE `survey_results` SET `answers_submitted`='".$tempSubmission."' ,
				`updated`='". $date->format('Y-m-d H:i:s')."' WHERE `user_id`='". $userId."' && `test_name`='". $index."' ; "; 
				$result4 = $pdo->exec( $sql4 );  }
				$tempVal2 =''; $tempVal = explode("|=|", $submission);
						foreach($tempVal as $key=>$val){
							if( $val != ''){ $val = str_replace("_aPe_", "'", $val);
								$val = str_replace("_qOe_", '"', $val);
								if( $tempVal2 =="" ){$tempVal2 .=   hash("sha224",$val); }
								else{ $tempVal2 .=  ', '.  hash("sha224",$val);} }  } 
			$sql2 = 'SELECT * FROM `_survery_tcr` WHERE `user_id`="'. $userId .'" ; ';
			$statement2 = $pdo->query( $sql2 );
			while($row = $statement2->fetch(PDO::FETCH_ASSOC)){ $tempUserInfo = $row['survey_info'] . $additional ."|_-_|"; }		
			$sql3 = " UPDATE `_survery_tcr` SET `survey_info`='".$tempUserInfo."',`updated`='". $date->format('Y-m-d H:i:s')."' WHERE `user_id`='". $userId ."'  ;" ;
			$result = $pdo->exec( $sql3 );
			ob_end_clean();
			echo json_encode($tempVal2 ); 
			unset( $buildOBJ );	unset( $tempUserInfo );	unset( $buildOBJ,$mysqli,$pdo,$MyDb);
			flush(); break;} 
		case "test_results":{ 
			ob_start();
			require_once('/_config/class._connect.inc.php'); 
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $buildOBJ['page_turn']='';	
				$sql = "UPDATE `survey_results` SET `correct`='".$submission."' , `incorrect`='".$additional."' , `user_level`='".$results."' ,
				`updated`='". $date->format('Y-m-d H:i:s')."' WHERE `user_id`='". $userId."' && `test_name`='". $index."' ; ";
				$result = $pdo->exec( $sql );
			if($result!=1 ){ $result = "no_page"; } 	unset( $buildOBJ,$mysqli,$pdo,$MyDb);
			ob_end_clean();
			flush(); break;} 
		case "user_name":{ 
			ob_start();
			require_once('/_config/class._connect.inc.php'); 
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array();	
				$result = '';
				$sql = " UPDATE `_survery_tcr` SET `user_name`='".$submission."',`updated`='". $date->format('Y-m-d H:i:s')."' WHERE `user_id`='". $userId ."'; " ;
				$result = $pdo->exec( $sql );		
				if($result!=1 ){ $result = "no_user"; }
				else{ $result = "name_success"; }
			ob_end_clean();
				echo json_encode($result );  unset( $buildOBJ,$mysqli,$pdo,$MyDb);
			flush(); break;} 
		case "default":{ flush(); 	unset( $host,$database,$username,$password,$mysqli,$pdo);	break;}			 
		} 
	ob_flush(); unset($date,$action,$_GET,$index,$additional,$submission,$results,$userId,$html,$temp);    
?>
