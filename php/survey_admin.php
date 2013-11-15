<?php /* This page is a PHP file for Surveyor Elite copyright 2013, Mark Bazzone.  SurveyorElite.com */
	$date = new DateTime();
	if(isset($_GET['action'])){  $action=$_GET['action'];  }
	if(isset($_GET['index'])){  $index=$_GET['index'];  }
	if(isset($_GET['additional'])){  $additional=$_GET['additional'];  }
	if(isset($_GET['submission'])){  $submission=$_GET['submission'];  }
	if(isset($_GET['results'])){  $results=$_GET['results'];  }
	if(isset($_GET['UiD'])){  $userId=$_GET['UiD'];  }
	$html=''; $temp= array(); 
	switch ($action) {
		case "defaults_set":{	
			ob_start();
			require_once('../php/_config/class._connect.inc.php'); 
			$host;$database;$username;$password;$mysqli;$pdo;			
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
			$buildOBJ = array(); $buildOBJ['defaults']='';	
			$sql = 'UPDATE `survey_defaults` SET `status`="inactive" WHERE `status`="active" && `default_name`!="surveyType "; ';
			$statement = $pdo->query( $sql );
			$result = $statement->fetch(PDO::FETCH_ASSOC) ;
			$sql2 = 'UPDATE `survey_defaults` SET `status`="active" WHERE `default_value`="'.$additional.'" || `default_value`="'.$submission.'"  || `default_value`="'.$results.'"  ; ';
			$statement2 = $pdo->query( $sql2 );
			$result2 = $statement2->fetch(PDO::FETCH_ASSOC) ;
			ob_end_clean();
			echo json_encode("defaults_saved"); unset( $buildOBJ );	unset( $mysqli,$pdo,$sql2,$sql,$buildOBJ,$MyDb);
			flush(); break;} 	
		case "defaults_get":{ 
			ob_start();
			require_once('../php/_config/class._connect.inc.php'); 
			$host;$database;$username;$password;$mysqli;$pdo;	
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb);
			$mysqli= $MyDb->_SplRs2($action,$MyDb);
			$pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $buildOBJ["return"] ="" ;
			$sql = 'SELECT *
				FROM `survey_defaults` 
				WHERE `status` = "active" && `default_name` = "surveyType" &&  `default_value` = "Admin-On" ';
			$statement = $pdo->query( $sql );
			$result = $statement->fetch(PDO::FETCH_ASSOC) ;
			$sql3 = 'SELECT *
				FROM `survey_defaults` 
				WHERE `status` = "inactive" && `default_name` = "surveyType" &&  `default_value` = "Admin-Off" ';
			$statement3 = $pdo->query( $sql3 );
			$result3 = $statement3->fetch(PDO::FETCH_ASSOC) ;
			if( $result == false || $result3 == false){ $buildOBJ["return"] = "no_page"; }
			else{ $sql2 = 'SELECT * FROM `survey_defaults` WHERE `default_name` != "surveyType" ; ';
				$statement2 = $pdo->query( $sql2 );
				while($row = $statement2->fetch(PDO::FETCH_ASSOC)){	
				$tempID = $row['id'];
				foreach($row as $key=>$val){
					if($key != "status_update"  ){
					if($val == NULL){ $val = "NULL";}
					$buildOBJ[$key."-".$tempID ] = $val;	
					$buildOBJ["return"] .=$key.'|:|'.$val.'|=|'; } }
				$buildOBJ["return"] .=	'|_-_|'; } } 
			ob_end_clean();
			echo json_encode( $buildOBJ["return"] );  unset( $buildOBJ );	unset( $mysqli,$pdo,$sql2,$sql3,$buildOBJ,$MyDb);
			flush(); break;} 
		case "survey_list_get":{
			ob_start();
			require_once('../php/_config/class._connect.inc.php'); 
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $typeOBJ = array(); $return = '';
			$sql = 'SELECT `survey_name`,`form_type`
				FROM `survey_info` ; ';
			$statement = $pdo->query( $sql );
			$i=1; while($row = $statement->fetch(PDO::FETCH_ASSOC)){	
					$buildOBJ[$i] =  $row["survey_name"];
					$typeOBJ[$i] =  $row["form_type"];
					$i++; }	
				foreach($buildOBJ as $key=>$val){ if($val!="" || $val!=NULL){ $return .=$val."|=|"; } }
				 $return .="|_-_|"; 
				foreach($typeOBJ as $key=>$val){ if($val!="" || $val!=NULL){ $return .=$val."|=|"; } }
				if($return=='' ){ $return = "no_test"; }
			ob_end_clean();
			echo json_encode( $return );  unset( $buildOBJ );	unset( $mysqli,$pdo,$sql,$buildOBJ,$MyDb);
			flush(); break;} 
		case "new_info":{
			ob_start();	
			require_once('../php/_config/class._connect.inc.php');
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $return1 = ''; $return2 = ''; $namecheck1 = ''; $namecheck2 = '';
				$temp1= explode("|_-_|", $submission);
					foreach($temp1 as $key=>$val){
						if($val!=""){
						$temp2 = explode("|=|", $val);
						foreach($temp2 as $key2=>$val2){
							if($val2!=""){  
							$val2= $mysqli->real_escape_string($val2);
							if($key2 == 0){ if( $return1 != '' ){ $return1.=","; } $return1.='`'.$val2 .'`' ; if($val2=="survey_name"){$namecheck1=$val2;} }
							if($key2 == 1){ if( $return2 != '' ){ $return2.=","; } $return2.='"'.$val2.'"' ;  if($namecheck1!="" && $namecheck2==""){$namecheck2=$val2;} } }  }  } } 
			$sqlA = 'SELECT `survey_name` FROM `survey_info` WHERE `survey_name` = "'.$namecheck2.'" LIMIT 1; ';
			$statementA = $pdo->query( $sqlA );
			$resultA = $statementA->rowCount(PDO::FETCH_ASSOC) ;
			if($resultA!=1 ){ 
				$sql = 'INSERT INTO `survey_info`('.$return1 .') VALUES ('.$return2 .')';
			 	$result = $pdo->exec( $sql );
				if($result!=1 ){ $result = "no_test"; }
				else{ $result = "new_info"; } }
			else{ $result ="test_exists";}
			ob_end_clean();
			echo json_encode( $result );  unset( $buildOBJ );	unset( $mysqli,$pdo,$sql,$buildOBJ,$MyDb);
			flush(); break;}
		case "edit_info":{	
			ob_start();
			require_once('../php/_config/class._connect.inc.php');
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $return1 = ''; $result = ''; $namecheck1 = ''; $namecheck2 = ''; $namecheck3 = ''; $namecheck4 = '';
				$temp1= explode("|_-_|", $submission);
					foreach($temp1 as $key=>$val){
						if($val!=""){ $temp2 = explode("|=|", $val);
						foreach($temp2 as $key2=>$val2){
							if($val2!=""){ $val2= $mysqli->real_escape_string($val2); 
							if($key2 == 0){ if($val2=="survey_name"){$namecheck1=$val2;} 
								else if($val2=="id"){$namecheck3=$val2;}  
								else{ 	if( $return1 != '' ){$return1.=","; }
									$return1.='`'.$val2 .'`' ;  } }
							if($key2 == 1){ if($namecheck1=="survey_name" && $namecheck2==""){$namecheck2=$val2;}  
								else if($namecheck3=="id" && $namecheck4==""){$namecheck4=$val2;}
								else{ $return1.='="'.$val2.'"' ; } }  }  } }  } 
				$sql = 'UPDATE `survey_info` SET '.$return1.', `updated`="'. $date->format('Y-m-d H:i:s').'"  WHERE `'.$namecheck1.'`="'.$namecheck2.'" && `'.$namecheck3.'`="'.$namecheck4.'"; ';
				$result = $pdo->exec( $sql );
				if($result!=1 ){ $result = "no_info"; }
				else{ $result = "edit_info"; }
			ob_end_clean();
			echo json_encode($result );  unset( $buildOBJ );	unset( $mysqli,$pdo,$sql,$buildOBJ,$MyDb);
			flush();  ob_flush();  break;}
		case "new_question":{
			ob_start();
			require_once('../php/_config/class._connect.inc.php');
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $countCheck1 = ''; $countCheck2 = ''; $newNum =0;	$return1 = ''; $return2 = '';
				$temp1= explode("|_-_|", $submission);
					foreach($temp1 as $key=>$val){
						if($val!=""){
						$temp2 = explode("|:|", $val);
						foreach($temp2 as $key2=>$val2){
							if($val2!=""){
							$val2= $mysqli->real_escape_string($val2);
							if($key2 == 0){ 
								if($val2=="test_id"){ $countCheck1 ='`'.$val2 .'`' ; $countCheck2 ="test_id" ; }
								if( $return1 != '' ){ $return1.=","; } 
								$return1.='`'.$val2 .'`' ;  }  
							if($key2 == 1){ 
								if($countCheck2=="test_id"){ $countCheck2 ='"'.$val2 .'"' ;}
								if( $return2 != '' ){ $return2.=","; } 
								$return2.='"'.$val2.'"' ; }  }  }  }  }  
				$sqlCheck = 'SELECT `question_order` FROM `survey` WHERE '.$countCheck1.'='.$countCheck2.' order by `question_order` desc limit 1 ; ';
				$statementCheck = $pdo->query( $sqlCheck );
				while($row = $statementCheck->fetch(PDO::FETCH_ASSOC)){   $newNum = $row["question_order"] + 1; }				
				if($newNum == 0){ $newNum = 1;}
				$return1.=',`question_order`' ; $return2.=',"'.$newNum .'"' ; 				
				$sql = 'INSERT INTO `survey`('.$return1 .') VALUES ('.$return2 .')';
			 	$result = $pdo->exec( $sql );
				if($result!=1 ){ $result = "no_test"; }
				else{ $result = "new_question"; }
			ob_end_clean();
			echo json_encode( $result );  unset( $return );	unset( $mysqli,$pdo,$sql,$buildOBJ,$MyDb);
			flush(); break;} 
		case "edit_question":{	
			ob_start();
			require_once('../php/_config/class._connect.inc.php');
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $countCheck1 = ''; $countCheck2 = ''; $countCheck3 = ''; $countCheck4 = ''; $return = '';  $result = '';
				$temp1= explode("|_-_|", $submission);
					foreach($temp1 as $key=>$val){
						if($val!=""){
						$temp2 = explode("|:|", $val);
						foreach($temp2 as $key2=>$val2){
							if($val2!=""){ 
							$val2= $mysqli->real_escape_string($val2);
							if($key2 == 0){ 
								if( $return != '' ){ $return.=","; } 
								if($val2=="id"){ $countCheck1 =$val2 ; }
								else if($val2=="test_id"){ $countCheck3 =$val2 ; }
								else{ $return.='`'.$val2 .'`' ; }   }  
							if($key2 == 1){  
								if($countCheck1=="id" && $countCheck2==""){  $countCheck2 =$val2  ;  }
								else if($countCheck3=="test_id" && $countCheck4==""){ $countCheck4 =$val2 ;}
								else{ $return.='="'.$val2.'"' ; }   }  }  }  }  }  
				$sql = 'UPDATE `survey` SET '.$return.' , `updated`="'. $date->format('Y-m-d H:i:s').'"  WHERE `'.$countCheck1.'`="'.$countCheck2.'" && `'.$countCheck3.'`="'.$countCheck4.'"; ';
				$result = $pdo->exec( $sql );			
				if($result!=1 ){ $result = "no_edit_question"; }
				else{ $result = "edit_question"; }
			ob_end_clean();
			echo json_encode($result );  unset( $return );	unset( $mysqli,$pdo,$sql,$buildOBJ,$MyDb);
			flush(); break;}
		case "get_test":{
			ob_start();
			require_once('../php/_config/class._connect.inc.php');
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $return = '';
			$sql = 'SELECT  `id`, `status`, `form_type`, `info_titles`, `page_name`, `survey_title`, `overview`, `user_level`, `time_length`, `timer`, `results`, `purpose`, `author`, `release_date`, `closing`, `closing_link`, `user_name`, `info_image`, `image_comment`
				FROM `survey_info` WHERE `survey_name`="'. $submission.'" ; ';
			$statement = $pdo->query( $sql );
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){							
				foreach($row as $key=>$val){
				if($val==NULL){ $val= "NULL";}	
					$return.= $key.'|:|'.$val.'|_-_|' ; } }	
			if($return!=''){ $return.='|_:_|' ;} 
			$sql = 'SELECT   `id`, `question`, `choices`, `answer`, `comment`, `image`, `question_order`, `type`, `status`
				FROM `survey` WHERE `test_id`="'. $submission.'" order by `question_order` ; ';
			$statement = $pdo->query( $sql );
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){							
				foreach($row as $key=>$val){
				if($val==NULL){ $val= "NULL";}				
					$return.= $key.'_'.$row['id'].'|:|'.$val.'|_-_|' ; } }
			if($return==""){ $return = "error"; } 
			ob_end_clean();
			echo json_encode($return);  unset( $return );	unset( $mysqli,$pdo,$sql,$buildOBJ,$MyDb);
			flush(); break;} 
		case "reorder_questions":{
			ob_start();
			require_once('../php/_config/class._connect.inc.php');
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $return = '';
				$tempVal1 = explode("|_-_|", $submission);
			 	foreach($tempVal1 as $key1=>$val1){
					$tempVal2 = explode("|:|", $val1);
					foreach($tempVal2 as $key2=>$val2){
					if($key2 ==0){ $id =  str_replace( "question_order_" , "", $val2 ); }
					if($key2 ==1){ $buildOBJ["question_order"][$id]= $val2 ;
						$return .= "id-".$id." order-".$val2 . ' ';  } }  }
				if($buildOBJ["question_order"]){
				foreach($buildOBJ["question_order"] as $key3=>$val3){
					$sql = "UPDATE `survey` SET `question_order`='".$val3 ."' , `updated`='". $date->format('Y-m-d H:i:s')."' WHERE `id`='". $key3."'  ; "; 
					$result = $pdo->exec( $sql );
					if($result!=1 ){ $result = "no_question"; } } 	} 
			if($return==""){ $return = "error"; } 
			ob_end_clean();
			echo json_encode($return);  unset( $return );	unset( $mysqli,$pdo,$sql,$buildOBJ,$MyDb);
			flush(); break;}
		case "publish_tracking":{
			ob_start();
			require_once('../php/_config/class._connect.inc.php');
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $return = '';  $i = '';  
			$sql1 = 'SELECT `id`, `user_id` FROM `_survery_tcr` WHERE `export`!="exported" ORDER by `id` asc;'; 
			$statement = $pdo->query( $sql1 );
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){ 	$i++;
					$return .= $row['id'].'|:|' ;   	}	
			$return .= '|_-_|'.$i;
			if($return=="" || $return=='|_-_|'){ $return = "error"; } 
			ob_end_clean();
			echo json_encode($return);  unset( $return );	unset( $mysqli,$pdo,$sql1,$buildOBJ,$MyDb);
			flush();  ob_flush(); break;}
		case "publish_results":{	
			ob_start();
			require_once('../php/_config/class._connect.inc.php'); 
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				$buildOBJ = array(); $return = ''; 	 
			$sql1 = 'SELECT `test_name`, COUNT(`test_name`) AS `total` FROM `survey_results` WHERE `export`!="exported" group by `test_name` asc;'; 
			$statement = $pdo->query( $sql1 );
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){ 	 
					$return .= $row['test_name'].'|-|'.$row['total'].'|:|' ;   	}	 
			if($return=="" ){ $return = "error"; } 
			ob_end_clean();
			echo json_encode($return);  unset( $return );	unset( $mysqli,$pdo,$sql1,$buildOBJ,$MyDb);
			flush(); break;}
		case "publish_tracer":{	
			ob_start();
			require_once('../php/_config/class._connect.inc.php'); 
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				set_time_limit(25000);	
				if( !ini_get('safe_mode') ){ set_time_limit(25000); } 
				require_once('../php/_classes/class.publisher.inc.php');
				$buildOBJ = array();	$buildOBJ["multiCheck"]=''; $htmlArray=array(); $return = ''; $tempNum=0; $i=0; 
				$publisher = new publisher(); $formbuilder = new formbuilder(); $parseIt = new parseIt(); 				
				$publisher->directoryCreator();				 
				$buildOBJ['export']= array(); $htmlArray["user_info"]=array(); $htmlArray["action_start"]=array(); $htmlArray["action_end"]=array(); $htmlArray["question_num"]=array(); $htmlArray["choice"]=array(); $htmlArray["answer"]=array();
				$htmlArray["user_info"][$i]=""; $htmlArray["action_start"][$i]= "";  $htmlArray["action_end"][$i]=""; $htmlArray["question_num"][$i]=""; $htmlArray["answer"][$i]= ""; $htmlArray["action_setup"][$i]=""; $htmlArray["end_time"][$i] ="";
				if( $additional==1){$start=0; $end= $userId;}
				else{$start=($additional*$userId)-$userId;  $end=$userId; }
				$sql1 = 'SELECT `id`, `index_id`, `user`, `user_id`, `user_name`, `export`, `user_info`, `survey_info`, `updated`, `submitted` FROM `_survery_tcr` WHERE `export`!="exported" ORDER BY `id`  asc LIMIT '.$start.','.$end.' ;'; 
				$statement = $pdo->query( $sql1 );
				while($row = $statement->fetch(PDO::FETCH_ASSOC)){ 	
				if($row['id']!=$tempNum ){ $i++; 
					$buildOBJ['export'][$i]=$tempNum=$row['id'];  $newFileName = $row['user_id'];
					$htmlArray["user_info"][$i]=""; $htmlArray["action_start"][$i]=""; $htmlArray["action_end"][$i]="";
					$htmlArray["question_num"][$i]= array(); $htmlArray["choice"][$i]= array(); $htmlArray["answer"][$i]= array(); $htmlArray["action_setup"][$i]= ""; $htmlArray["end_time"][$i] =""; }
				foreach($row as $key=>$val){
					$val=trim($val);
					if($key=="user" || $key=="user_id" || $key=="user_name " || $key=="submitted" ){   
					if($key=="user_id"){$userkey= "id"; } 
					if($key=="user"){$userkey= "ip"; } 
					if($key=="user_name"){$userkey= "email"; } 
					if($key=="submitted"){$userkey= "date_time"; 
						$newFileName =  str_replace( ":" , "-", $val ) ."_". $newFileName ; $newFileName =  str_replace( " " , "_", $newFileName );  
						$tempArrayA=explode(" ", $val);
						$val =  $tempArrayA[0]."T".$tempArrayA[1];
						$buildOBJ["folder_date"]= $tempArrayA[0]; 
						$publisher->directoryAdd("tracer","xml", $buildOBJ["folder_date"]); 
						$tempName = "_schema"; $tempExt = "xsd"; 
						$tempFile = $formbuilder->createSchema_TCR();
						$publisher->fileCreator_TCR($tempFile, $tempName, $buildOBJ["folder_date"], $tempExt); } 
					$htmlArray["user_info"][$i] .= $publisher->buildUserInfo($userkey,$val); }
					if($key=="user_info"){
					$temp = explode("|_-_|", $val);
					foreach($temp as $key1=>$val1){ 
						$val1=trim($val1);
						$temp2 = explode("|=|", $val1); 
						foreach($temp2 as $key2=>$val2){
							$val2=trim($val2);
							if($val2=="BSR"){$key1="browser"; }
							else if($val2=="PRT"){$key1= "port" ;} 
							else{	$buildOBJ[$i][$key1] =$val2;
							$return .= $key1.'|-|'.$val2.'|:|' ;
							$htmlArray["user_info"][$i] .= $publisher->buildUserInfo($key1,$val2); 	}	} 	} }
					else if($key=="survey_info"){ 
						$tempComplete=0;
						$buildOBJ["tempCheck1"] = strpos($val, '|_-_|'); $buildOBJ["tempCheck2"] = strpos($val, '|_:_|'); $buildOBJ["tempCheck3"] = strpos($val, '|:=:|');
						$buildOBJ["tempCheck4"] = strpos($val, '|:-:|'); $buildOBJ["tempCheck5"] = strpos($val, '|-_-|'); $buildOBJ["tempCheck6"] = strpos($val, 'timeout');
						if($buildOBJ["tempCheck1"]!==false && $buildOBJ["tempCheck2"]===false && $buildOBJ["tempCheck3"]===false && $buildOBJ["tempCheck4"]===false && $buildOBJ["tempCheck5"]===false && $buildOBJ["tempCheck6"]===false  ){ $buildOBJ["tempComplete"]=1; /*landing only*/  } 
						if($buildOBJ["tempCheck1"]!==false && $buildOBJ["tempCheck2"]!==false && $buildOBJ["tempCheck3"]!==false && $buildOBJ["tempCheck4"]===false && $buildOBJ["tempCheck5"]===false && $buildOBJ["tempCheck6"]===false ){ $buildOBJ["tempComplet"]=2; /*quiz selected*/  } 
						if($buildOBJ["tempCheck1"]!==false && $buildOBJ["tempCheck2"]!==false && $buildOBJ["tempCheck3"]!==false && $buildOBJ["tempCheck4"]===false && $buildOBJ["tempCheck5"]!==false && $buildOBJ["tempCheck6"]!==false ){ $buildOBJ["tempComplete"]=3; /*quiz selected timout no answers*/  } 
						if($buildOBJ["tempCheck1"]!==false && $buildOBJ["tempCheck2"]!==false && $buildOBJ["tempCheck3"]!==false && $buildOBJ["tempCheck4"]!==false && $buildOBJ["tempCheck5"]===false && $buildOBJ["tempCheck6"]===false ){ $buildOBJ["tempComplete"]=4; /*questions answered*/  } 
						if($buildOBJ["tempCheck1"]!==false && $buildOBJ["tempCheck2"]!==false && $buildOBJ["tempCheck3"]!==false && $buildOBJ["tempCheck4"]!==false && $buildOBJ["tempCheck5"]!==false && $buildOBJ["tempCheck6"]===false ){ $buildOBJ["tempComplete"]=5; /*quiz completed*/  }  
						if($buildOBJ["tempCheck1"]!==false && $buildOBJ["tempCheck2"]!==false && $buildOBJ["tempCheck3"]!==false && $buildOBJ["tempCheck4"]!==false && $buildOBJ["tempCheck5"]!==false && $buildOBJ["tempCheck6"]!==false ){ $buildOBJ["tempComplete"]=6; /*timeout after start before complete*/  }  
						if( $buildOBJ["tempComplete"]>=1){
							$tempText = "Page Landing";
							$htmlArray["action_setup"][$i] .= $publisher->buildActionStart("start",$tempText);
							if($buildOBJ["tempComplete"]>=2){ 
							 $tempArray = explode("|-_-|", $val); 
							if($buildOBJ["tempComplete"]>=3){ if(isset($tempArray[1]) && ( trim($tempArray[1])!="|_-_|")){ 
								$buildOBJ["multiCheck"]=true; } else{ $buildOBJ["multiCheck"]=false; }
								if($buildOBJ["multiCheck"]===false){ $htmlArray = $parseIt->testBreaker($htmlArray, $buildOBJ, $val, $i); }	
								if($buildOBJ["multiCheck"]===true){	
									$buildOBJ["multi_form"]="";
									foreach($tempArray as $keyMulti=>$valMulti){
									if(trim($valMulti)!="|_-_|" ){
									$htmlArray = $parseIt->testBreaker($htmlArray, $buildOBJ, $valMulti, $i); 
									$buildOBJ["multi_form"].=$formbuilder->buildMultiXml_1($htmlArray, $i);
									$htmlArray["multi_form"]=$buildOBJ["multi_form"]; } } } } } } }
					else if($key=="updated"){ 
						$userkey= "end_time";  $val =  str_replace( " " , "T", $val ); 
						$htmlArray["end_time"][$i] .= $publisher->buildActionEnd($userkey, $val);  }
					else{/*skip*/} }
					if($buildOBJ["multiCheck"]===false ){ $tempXML = $formbuilder->buildFormXml($htmlArray, $i);
					$publisher->fileCreator_TCR($tempXML, $newFileName , $buildOBJ["folder_date"], "xml");	}
					if($buildOBJ["multiCheck"]===true ){ $tempXML = $formbuilder->buildMultiXml_2($htmlArray, $i);
					$publisher->fileCreator_TCR($tempXML, $newFileName , $buildOBJ["folder_date"], "xml");	} } 
				foreach($buildOBJ['export'] as $key=>$val){
				$sql = "UPDATE `_survery_tcr` SET `export`='exported', `updated`='". $date->format('Y-m-d H:i:s')."' WHERE `id`='". $val."'; ";
				$result = $pdo->exec( $sql ); }
				if($return=="" ){ $return = "no_publish"; } else { $return="publish_success";}
			ob_end_clean();
			echo json_encode($return );  unset( $sql1,$return,$mysqli,$pdo,$tempArray,$constructor,$publisher,$formbuilder,$constructor,$parseIt,$htmlArray,$buildOBJ,$MyDb);	
			flush(); break;}
		case "publish_tests":{
			ob_start();
			require_once('../php/_config/class._connect.inc.php');
			$MyDb = new _ExFotR();
			$MyDb = $MyDb->_SplRs1($action,$MyDb); $mysqli= $MyDb->_SplRs2($action,$MyDb); $pdo = $MyDb->_SplRs3($action,$MyDb);
				set_time_limit(25000);	
				if( !ini_get('safe_mode') ){ set_time_limit(25000); } 
				require_once('../php/_classes/class.publisher.inc.php');
				$buildOBJ = array();	$buildOBJ['export']=array(); $buildOBJ["multiCheck"]=''; $htmlArray=array(); $return = ''; $tempNum=0; $i=0; 
				$publisher = new publisher(); $formbuilder = new formbuilder(); $parseIt = new parseIt(); 
				$tempName = "_schema";
				$tempExt = "xsd";
				$publisher->directoryCreator(); 
				$publisher->directoryAdd("results","xml", $index); 
				$tempFile = $formbuilder->createSchema_RLT();
				$publisher->fileCreator_RLT($tempFile, $tempName, $index, $tempExt); 
				$htmlArray["user_info"]=array(); $htmlArray["action_start"]=array(); $htmlArray["action_end"]=array(); $htmlArray["question_num"]=array(); $htmlArray["answer"]=array(); $htmlArray["score"]=array();
				$htmlArray["score"][$i]=""; $htmlArray["user_info"][$i]=""; $htmlArray["action_start"][$i]= "";  $htmlArray["action_end"][$i]="";  
				$sqlTst = 'SELECT `form_type` FROM `survey_info` WHERE `survey_name`="'.$index.'" LIMIT 1;'; 
				$statementTst = $pdo->query( $sqlTst );
				$row = $statementTst->fetch(PDO::FETCH_ASSOC);
				$buildOBJ['form_type']= $row['form_type'];
				if( $additional==1){$start=0; $end= $userId;}
				else{$start=($additional*$userId)-$userId;  $end=$userId; }
				$sql1 = 'SELECT `id`, `id_index`, `test_name`, `answers_submitted`, `correct`, `incorrect`, `user_level`, `user_id`, `user_name`, `export`, `updated` FROM `survey_results` WHERE `test_name`="'.$index.'" && `export`!="exported" LIMIT '.$start.','.$end.';'; 
				$statement = $pdo->query( $sql1 );
				while($row = $statement->fetch(PDO::FETCH_ASSOC)){ 
					if($row['id']!=$tempNum ){  $i++; 
						$buildOBJ['export'][$i]=$tempNum=$row['id']; $tempArray2 = explode(" ", $row['updated']); 
						$newFileName = $row['user_id'];
						$htmlArray["user_info"][$i]=""; $htmlArray["action_start"][$i]=""; 
						$htmlArray["question_num"][$i]= array(); $htmlArray["score"][$i]= ""; $htmlArray["answer"][$i]= array(); }						
					if($buildOBJ['form_type']== "Survey"){ $htmlArray["score"][$i]= $publisher->buildScore("correct", 0).$publisher->buildScore("incorrect", 0).$publisher->buildScore("percent", 0); }				
				foreach($row as $key=>$val){	
					if($buildOBJ['form_type']== "Quiz"){ 
					if($key=="correct"){$htmlArray["score"][$i].= $publisher->buildScore($key, trim($val));}
					if($key=="incorrect"){$htmlArray["score"][$i].= $publisher->buildScore($key, trim($val));}
					if($key=="user_level"){$htmlArray["score"][$i].= $publisher->buildScore("percent", trim($val));}  } 
					if($key=="user_id"){ $htmlArray["user_info"][$i] .= $publisher->buildUserInfo($key,$val);}
					if($key=="user_name"){ if($val!=NULL){ $htmlArray["user_info"][$i] .= $publisher->buildUserInfo($key,$val); } }
					if($key=="test_name"){ $htmlArray["action_start"][$i] .= $publisher->buildActionStart("form_select",$val ); }
					if($key=="answers_submitted"){ $j=0;
						$buildOBJ["tempCheckA"] = strpos($val, '|_-_|');
						if($buildOBJ["tempCheckA"]===false){$val=$val.'|_-_|'; }						
						$tempArray= explode("|_-_|", $val);
						foreach($tempArray as $key1=>$val1){
							if (isset($val1) && $val1!=""){ $j++;
							$buildOBJ["tempCheck1"] = strpos($val1, '|=|');
							if($buildOBJ["tempCheck1"]===false){  
							$htmlArray["question_num"][$i][$j] = $publisher->buildQuestionNum("question_num", $j );
							$htmlArray["answer"][$i][$j] = $publisher->buildAnswer("answer_value", trim($val1) ); }
							if($buildOBJ["tempCheck1"]!==false){
							$htmlArray["question_num"][$i][$j] = $publisher->buildQuestionNum("question_num", $j );
							$tempArray1= explode("|=|", $val1);
							$htmlArray["answer"][$i][$j] ="";
							foreach($tempArray1 as $key2=>$val2){
								$htmlArray["answer"][$i][$j] .= $publisher->buildAnswer("answer_value", trim($val2) );} } } } }
					if($key=="updated"){ 
						$tempArrayA=explode(" ", $val);
						$userkey= "form_time";  
						$val = $tempArrayA[0]."T".$tempArrayA[1];  
						$buildOBJ["folder_date"]= $tempArrayA[0]; 
						$publisher->directoryAdd("results","xml", $index."/".$buildOBJ["folder_date"]); 
						$tempName = "_schema"; $tempExt = "xsd"; 
						$tempFile = $formbuilder->createSchema_RLT();
						$publisher->fileCreator_RLT($tempFile, $tempName, $index."/".$buildOBJ["folder_date"], $tempExt);
						$htmlArray["action_start"][$i] .= $publisher->buildActionStart($userkey, $val); } 
					$return .= $val; }
					$tempXML = $formbuilder->buildScoreXml($htmlArray, $i);
					$publisher->fileCreator_RLT($tempXML, $newFileName , $index."/".$buildOBJ["folder_date"], "xml"); }  
				foreach($buildOBJ['export'] as $key=>$val){
				$sql = "UPDATE `survey_results` SET `export`='exported', `updated`='". $date->format('Y-m-d H:i:s')."' WHERE `id`='". $val."'; ";
				$result = $pdo->exec( $sql ); }
				if($return=="" ){ $return = "no_publish"; } else { $return="publish_success";}
			ob_end_clean();
			echo json_encode($return);  unset( $return );	unset( $mysqli,$pdo,$sql1,$buildOBJ,$MyDb);
			flush(); break;} 
		case "file_download":{	
			ob_start();
			require_once('../php/_classes/class.zipper.inc.php');
				$buildOBJ = array(); $return = ''; 
			$downLDR = new downLDR(); $buildOBJ["tempCheck1"] = strpos($additional, 'tracking_download'); $buildOBJ["tempCheck2"] = strpos($additional, 'results_download'); 
			if( $index=="file_download" && $additional=="results_zip"){ if(is_dir('../_library/published/results/')){ $buildOBJ['route_set']="results"; $return = $downLDR->results_zip($buildOBJ['route_set'], $return, $date);  $return = "Zip_success"; }else{ $return = "no_folder";} }
			elseif( $index=="file_download" && $additional=="tracking_zip"){if(is_dir('../_library/published/tracer/')){  $buildOBJ['route_set']="tracer"; $return = $downLDR->tracer_zip($buildOBJ['route_set'], $return, $date);  $return = "Zip_success"; }else{ $return = "no_folder";} } 
			elseif( $index=="file_download" && $buildOBJ["tempCheck1"]!==false){ if(is_file('../_library/published/tracer.zip')){ $return ="<b><i>...ZIP ARCHIVE FOUND!...</i></b><a href='".$additional."' class='zoom_button' >Download Results Now</a>"; }else{ $return = "no_zip";} } 
			elseif( $index=="file_download" && $buildOBJ["tempCheck2"]!==false){ if(is_file('../_library/published/results.zip')){ $return ="<b><i>...ZIP ARCHIVE FOUND!.</i></b><a href='".$additional."'class='zoom_button'  >Download Tracking Now</a>"; }else{ $return = "no_zip";} } 
			else{ /*skip*/ }
			if($return=="" || $return=="failed"){ $return = "error"; }
			ob_end_clean();
			echo json_encode($return);  unset( $return,$buildOBJ, $downLDR);
			flush(); break;}
		case "default":{ flush(); break;}	
			} 
	unset($date,$action,$_GET,$index,$additional,$submission,$results,$userId,$html,$temp);  
	ob_flush();
?>
