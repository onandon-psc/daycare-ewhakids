<?
	$file_url = "../../upload/board/";

	//--------------------------------------------
	// 지정된 Folder에서만 다운로드 가능 하도록 수정
	//--------------------------------------------

	if(empty($_REQUEST[file])){ exit; }
	
	$file_name = stripslashes($file);
	$file_name = ereg_replace("[[:space:]]","_",$file_name);
	$file_name = ereg_replace("#","",$file_name);
	$file_name = ereg_replace("%","",$file_name);

	$change_file_name = strtolower($file_name);

	if ( ereg(".php",$change_file_name) ||      
		ereg(".phtml",$change_file_name) ||
		ereg(".php3",$change_file_name) ||
		ereg(".php4",$change_file_name) ||
		ereg(".inc",$change_file_name) ) {	
		exit;

	}else{	

		if(!is_file($file_url.$file)){
			echo "<script>alert('파일을 찾을수 없습니다.');</script>";
			exit;
		}

		header("Cache-control: private");	
		if (eregi("(MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT)) {
				Header("Content-type:application/octet-stream"); 
				Header("Content-Length:".filesize("$file_url$file"));
				Header("Content-Disposition:attachment;filename=".$file);
				Header("Content-Transfer-Encoding:binary"); 
				Header("Pragma:no-cache"); 
				Header("Expires:0"); 
		} else {
				Header("Content-type:file/unknown"); 
				Header("Content-Length:".filesize("$file_url$file"));
				Header("Content-Disposition:attachment;filename=".$file);
				Header("Content-Description:PHP3 Generated Data"); 
				Header("Pragma: no-cache"); 
				Header("Expires: 0"); 
		}

		$fp = fopen($file_url.$file, "rb"); 
		if (!fpassthru($fp)) fclose($fp); 
		clearstatcache();
	}
?>