<?php
class downLDR{
	function results_zip($route_set, $return, $date){	
			$zip = new ZipArchive();  
			$foldBld = $zip->open('../_library/published/'.$route_set.'.zip', ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE);
			if ($foldBld === TRUE) { $zip->addFromString('README.txt', 'These downloaded files were created and zipped by Surveyor Elite '. $date->format('Y-m-d H:i:s').' Copyright SurveyorElite.com/Mark Bazzone.  Unzipped files will be in XML format.  See _schema.xsd in each folder for xml information.  Questions regarding file contents, contact domain downloaded from.  Questions about Surveyor Elite, visit http://www.surveyorelite.com. ');
				$zip->close(); $return='ok'; } else{ $return='failed'; } 
			if ($handle1 = opendir('../_library/published/'.$route_set.'/xml/')) {
				while (false !== ($entry = readdir($handle1))) {
				if($entry!="_schema.xsd" && $entry!="." && $entry!=".."){
					if ($handle2 = opendir('../_library/published/'.$route_set.'/xml/'.$entry.'/')) {
						if ($zip->open('../_library/published/'.$route_set.'.zip') === TRUE) {
						$zip->addEmptyDir($entry);
						$zip->close();}
						while (false !== ($entry2 = readdir($handle2))) {
						if($entry2!="_schema.xsd" && $entry2!="." && $entry2!=".."){			
							if ($zip->open('../_library/published/'.$route_set.'.zip') === TRUE) {
							$zip->addEmptyDir($entry.'/'. $entry2);
							$zip->close();}
							if ($handle3 = opendir('../_library/published/'.$route_set.'/xml/'.$entry.'/'.$entry2.'/')) { 
							while (false !== ($entry3 = readdir($handle3))) {
								if ($zip->open('../_library/published/'.$route_set.'.zip') === TRUE) {
								$zip->addFile('../_library/published/'.$route_set.'/xml/'.$entry.'/'.$entry2.'/'.$entry3, $entry.'/'. $entry2.'/'.$entry3);
								$zip->close();}
								$return=$entry3;}
							} } } } } } 
				closedir($handle3);closedir($handle2);closedir($handle1); }
				return $return; }
	function tracer_zip($route_set, $return, $date){	
			$zip = new ZipArchive();  
			$foldBld = $zip->open('../_library/published/'.$route_set.'.zip', ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE);
			if ($foldBld === TRUE) { $zip->addFromString('README.txt', 'These downloaded files were created and zipped by Surveyor Elite '. $date->format('Y-m-d H:i:s').' Copyright SurveyorElite.com/Mark Bazzone.  Unzipped files will be in XML format.  See _schema.xsd in each folder for xml information.  Questions regarding file contents, contact domain downloaded from.  Questions about Surveyor Elite, visit http://www.surveyorelite.com. ');
				$zip->close(); $return='ok'; } else{ $return='failed'; } 
			if ($handle1 = opendir('../_library/published/'.$route_set.'/xml/')) {
				while (false !== ($entry = readdir($handle1))) {
				if($entry!="_schema.xsd" && $entry!="." && $entry!=".."){
					if ($handle2 = opendir('../_library/published/'.$route_set.'/xml/'.$entry.'/')) {
						if ($zip->open('../_library/published/'.$route_set.'.zip') === TRUE) {
						$zip->addEmptyDir($entry);
						$zip->close();}
						while (false !== ($entry2 = readdir($handle2))) {
						if($entry2!="." && $entry2!=".."){			
								if ($zip->open('../_library/published/'.$route_set.'.zip') === TRUE) {
								$zip->addFile('../_library/published/'.$route_set.'/xml/'.$entry.'/'.$entry2, $entry.'/'. $entry2);
								$zip->close();}
								$return=$entry2; }
							} } } } 
				closedir($handle2);closedir($handle1); } 
				return $return; } }
?>