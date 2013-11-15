<?php
class parseIt{
	function testBreaker( $htmlArray, $buildOBJ, $val, $i){
		$publisher = new publisher();
		$formbuilder = new formbuilder();
		$constructor = new constructor();
		if( $buildOBJ["multiCheck"]===true ){$htmlArray["question_num"][$i]= array(); $htmlArray["choice"][$i]= array(); $htmlArray["answer"][$i]= array();$htmlArray["action_start"][$i]=""; $htmlArray["action_end"][$i]="";}
				$j=0; $tempArray1 = explode("|:=:|", $val);  
				if($tempArray1[0]){ $tempArrayA= explode("|_-_|", $tempArray1[0]); 
			   $tempArrayB= explode("|_:_|", $tempArrayA[1]); 
			   foreach( $tempArrayB as $keyA=>$valA){
				$tempArrayC= explode("|:|", $valA);
				if( trim($tempArrayC[0])=="SVY"){ $htmlArray["action_start"][$i] .= $publisher->buildActionStart("form_select",trim($tempArrayC[1]) );
				if($buildOBJ["tempComplete"]==4){ $buildOBJ["tempFormName"]= trim($tempArrayC[1]);}  }
				else if( trim($tempArrayC[0])=="TM"){ $TM = $publisher->timePiece($tempArrayC[1]);
					$htmlArray["action_start"][$i] .= $publisher->buildActionStart("form_time",$TM ); 	}
				else{ /*nothing*/ }   }   }
				if(isset($tempArray1[1])){  $tempArrayA= explode("|_-_|", $tempArray1[1]);
				foreach( $tempArrayA as $keyA=>$valA){
				if($valA!=""  && $valA!=NULL && $valA!="NULL"){ 
					$tempArrayB= explode("|__|", $valA);
					if(!isset($htmlArray["question_num"][$i][$j])){ $htmlArray["question_num"][$i][$j]=""; }
					if(!isset($htmlArray["choice"][$i][$j])){ $htmlArray["choice"][$i][$j]=""; }
					if(!isset($htmlArray["answer"][$i][$j])){ $htmlArray["answer"][$i][$j]=""; }
				 if(isset($tempArrayB[0]) && $tempArrayB[0]!=""  && $tempArrayB[0]!=NULL && $tempArrayB[0]!="NULL"){ 
				  $tempArrayC=explode("|:|",$tempArrayB[0]);
				  if(isset($tempArrayC[1]) && $tempArrayC[1]!=""  && $tempArrayC[1]!=NULL && $tempArrayC[1]!="NULL"){ 
					$buildOBJ["tempCheckA"] = strpos($tempArrayC[1], 'timeout');
					if($buildOBJ["tempCheckA"]!==false ){ $tempArrayC[1]="timeout";
					$TM = $publisher->timePiece($tempArrayC[2]);
					 $htmlArray["question_num"][$i][$j] .= $publisher->buildQuestionNum("question_num",$tempArrayC[1]." - ".$TM ); }
					else{ $htmlArray["question_num"][$i][$j] .= $publisher->buildQuestionNum("question_num",$tempArrayC[1]); } } } 
				 if(isset($tempArrayB[1]) && $tempArrayB[1]!=""  && $tempArrayB[1]!=NULL && $tempArrayB[1]!="NULL"){ 
				  $tempArrayC=explode("|:-:|",$tempArrayB[1]);
				  foreach($tempArrayC as $keyMax=>$valMax){ 
					if(isset($valMax) && $valMax!=""  && $valMax!=NULL && $valMax!="NULL"){
					$tempArrayD= explode("|_:_|", $valMax); 
					$timeval="";
					foreach($tempArrayD as $keyB => $valB){ 
						$buildOBJ["tempCheckA"] = strpos($valB, 'SLT');
						$buildOBJ["tempCheckB"] = strpos($valB, 'ULT');
						$buildOBJ["tempCheckC"] = strpos($valB, 'SBT');
						$buildOBJ["tempCheckD"] = strpos($valB, 'TM');
						$tempArrayE=explode("|:|",$valB);
						if($buildOBJ["tempCheckA"]!==false ){  
					  $buildOBJ["TEMP"] =  str_replace( "SLT-" , "",$tempArrayE[0]);
						$tempArrayF=explode("_",$buildOBJ["TEMP"]); $timeval="choice";
						$htmlArray["choice"][$i][$j] .= $constructor->bookendXml("start", "choice");
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_value", trim($tempArrayE[1]) );
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_type", trim($tempArrayF[0]) );
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_number", trim($tempArrayF[1]) );
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_action","Select" ); }
						else if($buildOBJ["tempCheckB"]!==false ){ 
					  $buildOBJ["TEMP"] =  str_replace( "ULT-" , "",$tempArrayE[0]);
						$tempArrayF=explode("_",$buildOBJ["TEMP"]); $timeval="choice";
						$htmlArray["choice"][$i][$j] .= $constructor->bookendXml("start", "choice");
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_value", trim($tempArrayE[1]) );
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_type", trim($tempArrayF[0]) );
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_number", trim($tempArrayF[1]) );
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_action","Unselect" ); }
						else if($buildOBJ["tempCheckC"]!==false ){  $timeval="answer";
						$buildOBJ["tempCheck"] = strpos($tempArrayE[1], '|=|');
						if($buildOBJ["tempCheck"]!==false ){ 
					  $tempArrayG=explode("|=|",$tempArrayE[1]); 
					  foreach($tempArrayG as $keyAns=>$valAns){ $htmlArray["answer"][$i][$j] .= $publisher->buildAnswer("answer_value", trim($valAns) ); } }
						else{ $htmlArray["answer"][$i][$j] .= $publisher->buildAnswer("answer_value", trim($tempArrayE[1]) ); }
						$htmlArray["answer"][$i][$j] .= $publisher->buildAnswer("answer_action","Submit" ); }
						else if($buildOBJ["tempCheckD"]!==false ){ 
						$TM = $publisher->timePiece($tempArrayE[1]);
						if($timeval==="choice"){  $timeval="";
						$htmlArray["choice"][$i][$j] .= $publisher->buildChoice("choice_time",$TM );
						$htmlArray["choice"][$i][$j] .= $constructor->bookendXml("end", "choice"); } 
						if($timeval==="answer"){$timeval="";
						$htmlArray["answer"][$i][$j] .= $publisher->buildAnswer("answer_time",$TM ); } }
						else{ /*nothing*/  }  } } } } 
				 $j++; 	} 	}  }
				if(isset($tempArray1[2])){   $tempArray1[2] = str_replace("|-_-|", "", trim($tempArray1[2]) );
				$tempArray1[2] = str_replace("|_-_|", "", trim($tempArray1[2]));
				$tempArrayA= explode("|:|", $tempArray1[2]);
				$htmlArray["action_end"][$i] .= $publisher->buildActionEnd("form_submit",trim($tempArrayA[1]) );  }
				if(isset($tempArray1[1]) && !isset($tempArray1[2]) ){ 
				if($buildOBJ["tempComplete"]==4){ 	$htmlArray["action_end"][$i] .= $publisher->buildActionEnd("form_submit",$buildOBJ["tempFormName"] ); } } 
		return ($htmlArray); } }			
class publisher{  
  	function directoryCreator(){ 
		if(!is_dir('../_library/published')){ mkdir('../_library/published', 0777);}
		if(!is_dir('../_library/published/tracer')){ mkdir('../_library/published/tracer', 0777); }
		if(!is_dir('../_library/published/tracer/xml')){ mkdir('../_library/published/tracer/xml', 0777); }
		if(!is_dir('../_library/published/results')){ mkdir('../_library/published/results', 0777);}
		if(!is_dir('../_library/published/results/xml')){ mkdir('../_library/published/results/xml', 0777); }}
  	function directoryAdd($folder1, $folder2, $folder3){     	
		if(!is_dir('../_library/published/'.$folder1.'/'.$folder2.'/'.$folder3)){ mkdir('../_library/published/'.$folder1.'/'.$folder2.'/'.$folder3, 0777); } }
  	function fileCreator_TCR($tempFileX, $tempFileName, $tempFolder, $tempFileExt){
		$tempPath = "../_library/published/tracer/xml/".$tempFolder."/". $tempFileName.".". $tempFileExt;
		if (!file_exists($tempPath)){ $tempX = fopen($tempPath, 'w') or die("can't open file"); 
		fwrite($tempX, $tempFileX); fclose($tempX); } }
  	function fileCreator_RLT($tempFileX, $tempFileName, $tempFolder, $tempFileExt){
		$tempPath = "../_library/published/results/xml/".$tempFolder."/". $tempFileName.".". $tempFileExt;
		if (!file_exists($tempPath)){ $tempX = fopen($tempPath, 'w') or die("can't open file"); 
		fwrite($tempX, $tempFileX); fclose($tempX); } }
  	function timePiece($timeVal){ $TM = trim($timeVal); $TM =  str_replace( ":0." , ":00.",$TM ); $TM = $TM."0"; return $TM;}
  	function buildUserInfo($key,$val){
		$constructor = new constructor(); $checkArray = array("id","user_id","user_name","ip","email","browser","port","date_time"); $tempHTMLX=""; 
    	if (in_array( $key,$checkArray)){ $tempHTMLX .= $constructor->buildXml($val, $key); }   return $tempHTMLX;}
  	function buildActionStart($key,$val ){
		$constructor = new constructor(); $checkArray = array("start","form_select","form_time"); $tempHTMLX="";
    	if (in_array( $key,$checkArray)){ $tempHTMLX .= $constructor->buildXml($val, $key); } return $tempHTMLX;}
  	function buildQuestionNum($key,$val ){
		$constructor = new constructor(); $checkArray = array("question_num"); $tempHTMLX="";
    	if (in_array( $key,$checkArray)){ $tempHTMLX .= $constructor->buildXml($val, $key); }  return $tempHTMLX;}
  	function buildChoice($key,$val ){
		$constructor = new constructor();
		$checkArray = array("choice_value","choice_type","choice_number","choice_action","choice_time");
		$tempHTMLX="";
    	if (in_array( $key,$checkArray)){ $val = str_replace("_aPe_", "'", $val); $val = str_replace("_qOe_", '"', $val); $tempHTMLX .= $constructor->buildXml($val, $key); } 
		return $tempHTMLX;}
  	function buildAnswer($key,$val){
		$constructor = new constructor(); $checkArray = array("answer_action","answer_value","answer_time"); $tempHTMLX="";
    	if (in_array( $key,$checkArray)){ $val = str_replace("_aPe_", "'", $val); $val = str_replace("_qOe_", '"', $val); $tempHTMLX .= $constructor->buildXml($val, $key); } 
    return $tempHTMLX;}
  	function buildScore($key,$val){
		$constructor = new constructor(); $checkArray = array("correct","incorrect","percent"); $tempHTMLX="";
    	if (in_array( $key,$checkArray)){ $tempHTMLX .= $constructor->buildXml($val, $key); }  return $tempHTMLX;}
  	function buildActionEnd($key,$val ){
		$constructor = new constructor(); $checkArray = array("disconnect","end_time","form_submit"); $tempHTMLX="";
    	if (in_array( $key,$checkArray)){ $tempHTMLX .= $constructor->buildXml($val, $key); } return $tempHTMLX;}  }
class constructor{	
  	function bookendXml($tempKey, $tempElem){ 
		if($tempKey=='doc_start'){$tempXML = '<'.$tempElem.' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="_schema.xsd">';}
		else if($tempKey=='start'){$tempXML = '<'.$tempElem.'>'; }
		else if($tempKey=='end'){$tempXML = '</'.$tempElem.'>'; } else{ /*nothing*/ }
		return $tempXML;  } 
  	function buildXml($tempVal, $tempElem){
		$checkArray = array("id","ip","email","browser","port","date_time","start","form_select","form_time","question_num","choice_value","choice_type","choice_number","choice_action","choice_time","answer_action","answer_value","answer_time","form_submit","end","end_time","user_id","user_name","disconnect","correct","incorrect","percent");
		if (in_array( $tempElem,$checkArray)){ $tempXML = '<'.$tempElem.'>'.$tempVal.'</'.$tempElem.'>'; return $tempXML; } }}
 class formbuilder{ 
  	function buildFormXml($htmlArray, $k){	
		$constructor = new constructor(); $publisher = new publisher(); 
			$finalHTMLX = $constructor->bookendXml("doc_start", "tracking");
		 $finalHTMLX .= $constructor->bookendXml("start", "user");
			$finalHTMLX .= $htmlArray["user_info"][$k];
		 $finalHTMLX .= $constructor->bookendXml("end", "user");
		 $finalHTMLX .= $constructor->bookendXml("start", "actions");
			$finalHTMLX .= $htmlArray["action_setup"][$k];
			$finalHTMLX .= $htmlArray["action_start"][$k];
			foreach($htmlArray["question_num"][$k] as $key=>$val){
		  $finalHTMLX .= $constructor->bookendXml("start", "question");
			$finalHTMLX .= $htmlArray["question_num"][$k][$key]; 
			$finalHTMLX .= $htmlArray["choice"][$k][$key]; 
			$finalHTMLX .= $constructor->bookendXml("start", "answer");
		   $finalHTMLX .= $htmlArray["answer"][$k][$key];
			$finalHTMLX .= $constructor->bookendXml("end", "answer");
		  $finalHTMLX .= $constructor->bookendXml("end", "question");}
			$finalHTMLX .= $htmlArray["action_end"][$k];
			$finalHTMLX .= $htmlArray["end_time"][$k];
			$finalHTMLX .= $publisher->buildActionEnd("disconnect", "Disconnect");
		 $finalHTMLX .= $constructor->bookendXml("end", "actions");
			$finalHTMLX .= $constructor->bookendXml("end", "tracking");	 return $finalHTMLX;}
	function buildMultiXml_1($htmlArray, $k){	
		$constructor = new constructor(); $publisher = new publisher();     
			$finalHTMLX = $htmlArray["action_start"][$k];
			foreach($htmlArray["question_num"][$k] as $key=>$val){
		  $finalHTMLX .= $constructor->bookendXml("start", "question");
			$finalHTMLX .= $htmlArray["question_num"][$k][$key]; 
			$finalHTMLX .= $htmlArray["choice"][$k][$key]; 
			$finalHTMLX .= $constructor->bookendXml("start", "answer");
		   $finalHTMLX .= $htmlArray["answer"][$k][$key];
			$finalHTMLX .= $constructor->bookendXml("end", "answer");
		  $finalHTMLX .= $constructor->bookendXml("end", "question");}
			$finalHTMLX .= $htmlArray["action_end"][$k]; return $finalHTMLX;	}
	function buildMultiXml_2($htmlArray,$k){	
		$constructor = new constructor(); $publisher = new publisher(); 
			$finalHTMLX = $constructor->bookendXml("doc_start", "tracking");
		 $finalHTMLX .= $constructor->bookendXml("start", "user");
			$finalHTMLX .= $htmlArray["user_info"][$k];
		 $finalHTMLX .= $constructor->bookendXml("end", "user");
		 $finalHTMLX .= $constructor->bookendXml("start", "actions");
			$finalHTMLX .= $htmlArray["action_setup"][$k];
			$finalHTMLX .= $htmlArray["multi_form"];
			$finalHTMLX .= $htmlArray["end_time"][$k];
			$finalHTMLX .= $publisher->buildActionEnd("disconnect", "Disconnect");
		 $finalHTMLX .= $constructor->bookendXml("end", "actions");
			$finalHTMLX .= $constructor->bookendXml("end", "tracking");	 return $finalHTMLX;} 
	function buildScoreXml($htmlArray, $k){	
		$constructor = new constructor();
		$publisher = new publisher(); 
			$finalHTMLX = $constructor->bookendXml("doc_start", "results");
		 $finalHTMLX .= $constructor->bookendXml("start", "user");
			$finalHTMLX .= $htmlArray["user_info"][$k];
		 $finalHTMLX .= $constructor->bookendXml("end", "user");
		 $finalHTMLX .= $constructor->bookendXml("start", "actions"); 
			$finalHTMLX .= $htmlArray["action_start"][$k];
			foreach($htmlArray["question_num"][$k] as $key=>$val){
		  $finalHTMLX .= $constructor->bookendXml("start", "question");
			$finalHTMLX .= $htmlArray["question_num"][$k][$key]; 
			$finalHTMLX .= $constructor->bookendXml("start", "answer");
		   $finalHTMLX .= $htmlArray["answer"][$k][$key];
			$finalHTMLX .= $constructor->bookendXml("end", "answer");
		  $finalHTMLX .= $constructor->bookendXml("end", "question"); }
			$finalHTMLX .= $constructor->bookendXml("start", "score");
			$finalHTMLX .= $htmlArray["score"][$k];
			$finalHTMLX .= $constructor->bookendXml("end", "score");
			$finalHTMLX .= $publisher->buildActionEnd("disconnect", "Disconnect");
		 $finalHTMLX .= $constructor->bookendXml("end", "actions");
			$finalHTMLX .= $constructor->bookendXml("end", "results");	 return $finalHTMLX;}
function createSchema_TCR(){ $temp='
<xs:schema elementFormDefault="qualified" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	<xs:element name="tracking">
	<xs:complexType>
		<xs:sequence maxOccurs="1">
			<xs:element name="user" minOccurs="1" maxOccurs="1">
				<xs:complexType> 
					<xs:sequence maxOccurs="1">
						<xs:element name="id" type="xs:string" minOccurs="1" maxOccurs="1"/>
						<xs:element name="ip" type="xs:string" minOccurs="1" maxOccurs="1"/>
						<xs:element name="email" type="xs:string" minOccurs="0" maxOccurs="1"/>
						<xs:element name="browser" type="xs:string" minOccurs="1" maxOccurs="1"/>
						<xs:element name="port" type="xs:integer" minOccurs="1" maxOccurs="1"/>
						<xs:element name="date_time"  type="xs:dateTime" minOccurs="1" maxOccurs="1"/>
					</xs:sequence> 
				</xs:complexType>
			</xs:element>
			<xs:element name="actions" minOccurs="0" maxOccurs="1">
			<xs:complexType>
				<xs:sequence maxOccurs="1"> 
					<xs:element name="start" type="xs:string" minOccurs="1" maxOccurs="1"/> 
					<xs:element name="form_select" type="xs:string" minOccurs="0" maxOccurs="unbounded"/> 
					<xs:element name="form_time" type="xs:time" minOccurs="0" maxOccurs="unbounded"/> 
					<xs:element name="question" minOccurs="0" maxOccurs="unbounded">
						<xs:complexType> 
						<xs:sequence maxOccurs="unbounded">
							<xs:element name="question_num" type="xs:integer" minOccurs="0" maxOccurs="unbounded"/> 
							<xs:element name="choice" minOccurs="0" maxOccurs="unbounded">
								<xs:complexType> 
								<xs:sequence maxOccurs="unbounded">
									<xs:element name="choice_value" type="xs:string" minOccurs="0" maxOccurs="1"/>
									<xs:element name="choice_type" type="xs:string" minOccurs="0" maxOccurs="1"/>
									<xs:element name="choice_number" type="xs:integer" minOccurs="0" maxOccurs="1"/>
									<xs:element name="choice_action" type="xs:string" minOccurs="0" maxOccurs="1"/>
									<xs:element name="choice_time" type="xs:time" minOccurs="0" maxOccurs="1"/>
								</xs:sequence>
								</xs:complexType>	
							</xs:element>
							<xs:element name="answer" minOccurs="0" maxOccurs="unbounded">
								<xs:complexType> 
								<xs:sequence maxOccurs="unbounded">
									<xs:element name="answer_action" type="xs:string" minOccurs="0" maxOccurs="1"/>
									<xs:element name="answer_value" type="xs:string" minOccurs="0" maxOccurs="unbounded"/>
									<xs:element name="answer_time" type="xs:time" minOccurs="0" maxOccurs="1"/>
								</xs:sequence>
								</xs:complexType>	
							</xs:element>
						</xs:sequence>
						</xs:complexType>	
					</xs:element>
					<xs:element name="form_submit" type="xs:string" minOccurs="0" maxOccurs="unbounded"/>
					<xs:element name="end_time"  type="xs:dateTime" minOccurs="1" maxOccurs="1"/>
					<xs:element name="end" type="xs:string" minOccurs="1" maxOccurs="1"/>
				</xs:sequence>
				</xs:complexType>
			</xs:element>
		</xs:sequence> 
		</xs:complexType> 
	</xs:element>
</xs:schema>'; 
return $temp; }
function createSchema_RLT(){$temp='
<xs:schema elementFormDefault="qualified" xmlns:xs="http://www.w3.org/2001/XMLSchema">
	<xs:element name="results">
	<xs:complexType>
		<xs:sequence maxOccurs="1">
			<xs:element name="user" minOccurs="1" maxOccurs="1">
				<xs:complexType> 
					<xs:sequence maxOccurs="1">
						<xs:element name="user_id" type="xs:string" minOccurs="1" maxOccurs="1"/>
						<xs:element name="user_name" type="xs:string" minOccurs="0" maxOccurs="1"/> 
					</xs:sequence> 
				</xs:complexType>
			</xs:element>
			<xs:element name="actions" minOccurs="0" maxOccurs="1">
			<xs:complexType>
				<xs:sequence maxOccurs="1"> 
					<xs:element name="form_select" type="xs:string" minOccurs="0" maxOccurs="unbounded"/> 
					<xs:element name="form_time" type="xs:time" minOccurs="0" maxOccurs="unbounded"/> 
					<xs:element name="question" minOccurs="0" maxOccurs="unbounded">
						<xs:complexType> 
						<xs:sequence maxOccurs="unbounded">
							<xs:element name="question_num" type="xs:int" minOccurs="0" maxOccurs="unbounded"/> 
							<xs:element name="answer" minOccurs="0" maxOccurs="unbounded">
								<xs:complexType> 
								<xs:sequence maxOccurs="unbounded">
									<xs:element name="answer_value" type="xs:string" minOccurs="0" maxOccurs="unbounded"/>
								</xs:sequence>
								</xs:complexType>	
							</xs:element>
						</xs:sequence>
						</xs:complexType>	
					</xs:element>
				</xs:sequence>
			</xs:complexType>
			</xs:element>
			<xs:element name="score" minOccurs="0" maxOccurs="1">
			<xs:complexType>
				<xs:sequence minOccurs="0" maxOccurs="1"> 
					<xs:element name="correct"  type="xs:integer" minOccurs="0" maxOccurs="1"/>
					<xs:element name="incorrect"  type="xs:integer" minOccurs="0" maxOccurs="1"/>
					<xs:element name="percent"  type="xs:integer" minOccurs="0" maxOccurs="1"/>
				</xs:sequence>
			</xs:complexType>	
			</xs:element>
		</xs:sequence> 
	</xs:complexType> 
	</xs:element>
</xs:schema>'; 
return $temp; } }
?>