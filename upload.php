<?php
ini_set("display_errors", "1");

function redirect($error = "unknown"){
	header("Location: index.php?error=".$error);
}

$files = array();
for($i = 0;$i<count($_FILES["csv_file"]["name"]);$i++){
	if($_FILES["csv_file"]["error"][$i] == UPLOAD_ERR_OK && is_uploaded_file($_FILES["csv_file"]["tmp_name"][$i])){
		$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv','application/octet-stream');
		if(in_array($_FILES['csv_file']['type'][$i],$mimes)){
			if($_FILES["csv_file"]["size"][$i] < 20000000){
				$file = file_get_contents($_FILES["csv_file"]["tmp_name"][$i]);
				$array = explode(PHP_EOL, $file);
				$output = "";
				foreach ($array as $line){
					if(strpos($line, "\"") !== false){
						$output .= $line.PHP_EOL;
					}else{
						$data = explode(",", $line);
						$delimiter = false;
						foreach($data as $value){
							$output .= $value;
							if($delimiter)
								$output .= ",";
							else 
								$output .= ".";
							$delimiter = !$delimiter;
						}
						$output = substr($output, 0, strlen($output)-1);
						$output .= PHP_EOL;
					}
				}
				$files[$i] = array($_FILES["csv_file"]["name"][$i],$output);
				//header('Content-Type: text/csv');
				///header('Content-Disposition: attachment; filename="'..'"');
				//echo $output;
			}
		}
	}
}
if(count($files) > 0){
	if(count($files) == 1){
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="'.$files[0][0].'"');
		echo $files[0][1];
	}else{
		$zip = new ZipArchive();
		$filename = "converted_csv.zip";
		
		if($zip->open($filename, ZIPARCHIVE::CREATE) !== true){
			redirect("cannot_zip");
		}
		
		foreach($files as $file){
			$zip->addFromString($file[0], $file[1]);
		}
		$zip->close();
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$filename);
		header("Content-Transfer-Encoding: binary");
		clearstatcache();
		header("Content-Length: ".filesize($filename));
		readfile($filename);
	}
}else{
	redirect("invalid_files");
}
?>