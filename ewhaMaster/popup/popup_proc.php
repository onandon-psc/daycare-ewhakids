<?
	include "../../include/global/config.php"; 
	include "popup_func.php"; 

	$fileUrl = "../../upload/popup";

	$arrParam = array('send','idx');

	foreach($arrParam As $val) ${$val} = trim($_POST[$val]);

	// 팝업이미지
	if(ereg($send,"preView|modify"))
	{
		$query	= "SELECT file FROM ona_popup WHERE idx='$idx'";
		$result	= mysql_query($query);
		$row	 	= mysql_fetch_array($result);
		$loadImg = $row['file'];
	}
			
	if( $contentType <= 2 )
	{		

		if($file)
		{
			$fileMode	= $send == "write" ? "insert" : "edit";
			$fileName = $send == "preView" ? "tmp_img.jpg" : $_FILES['file']['name'];
			$fileTmp	= $_FILES['file']['tmp_name'];
			$file			= File_Process($fileTmp,$fileName,$fileUrl,$fileMode,$loadImg);
		}	

		// 이미지링크
		if($contentType == "1")
		{
			for($n=0; $n < $iLinkCount; $n++)
			{
				$m = intval($n) + 1;
				$arrArea[$n]	 = ${'iLinkArea'.$m};
				$arrTarget[$n]	 = ${'iLinkTarget'.$m};
				$arrUrl[$n]		 = "http://".str_replace("http://","",${'iLinkUrl'.$m});
			}
		}else{
			$arrTarget[0]	= $iLinkTarget;
			$arrUrl[0]			= "http://".str_replace("http://","",$iLinkUrl);
		}

		$content = "";
	}
	
	// 게시일
	if( $visionType != "Y" )
	{
		$sdate = "";
		$edate = "";
	}	

	// 팝업사이즈
	$sizeInfo = $pWidth."|".$pHeight."|".$pTop."|".$pLeft."|".$pScroll;
	
	if(!trim($file)) $file = $loadImg;

	switch($send)
	{
		case "preView": // 미리보기		
			make_popup( 'preView', $subject, $file, $visionDay, $contentType, $arrArea, $arrTarget, $arrUrl, $content, $skin );			
			break;

		case "write": // 등록
			$msg = "등록";
			$query  = "INSERT INTO ona_popup ( 
								openType , subject , sdate , edate , sizeInfo , 
								visionDay , contentType , file , content , skin , 
								status , regdate 
							 ) VALUES (
								'$openType' , '$subject' , '".strtotime($sdate)."' , '".strtotime($edate)."' , '$sizeInfo' , 
								'$visionDay' , '$contentType' , '$file' , '$content' , '$skin' , 
								'$status' , '".mktime()."'
							)";			
			mysql_query($query);
			
			$query = "SELECT max(idx) FROM ona_popup";
			$result	= mysql_query($query);
			$row		= mysql_fetch_array($result);
			$pidx	= $row[0];
			break;
		
		case "modify": // 수정
			$msg = "수정";
			if($file) $setAdd = ", file = '".$file."'";
			$query  = "UPDATE ona_popup SET
								openType = '$openType'
								, subject = '$subject'
								, sdate = '".strtotime($sdate)."'
								, edate = '".strtotime($edate)."'
								, sizeInfo = '$sizeInfo' 
								, visionDay = '$visionDay' 
								, contentType = '$contentType' 
								, content = '$content' 
								, skin = '$skin' 
								, status = '$status'
								$setAdd
							 WHERE idx='$idx'";
			mysql_query($query);
			$pidx = $idx;
			break;

		case "delete": // 삭제
			$msg = "삭제";
			$query = "DELETE FROM ona_popup WHERE idx='$idx'";
			mysql_query($query);
			break;
	}

	if(ereg($send,"write|modify|delete|choice"))
	{
		if(ereg($send,"modify|delete")){
			$query = "DELETE FROM ona_popup_info WHERE pidx='$idx'";
			mysql_query($query);
		}
		
		// 팝업링크
		if($send != "delete")
		{
			for($n=1; $n <= count($arrUrl); $n++)
			{
				if(trim($arrUrl[$n-1]) || $n==1)
				{		
					$query = "INSERT INTO ona_popup_info ( 
										pidx , iLinkArea , iLinkTarget , iLinkUrl 
									) VALUES (
										'$pidx' , '".$arrArea[$n-1]."' , '".$arrTarget[$n-1]."' , '".$arrUrl[$n-1]."'
									)";
					mysql_query($query);
				}
			}			
			// 팝업설정
			make_popup( $pidx, $subject, $file, $visionDay, $contentType, $arrArea, $arrTarget, $arrUrl, $content, $skin );			
		}

		if($send == "choice" && $choiceValue)
		{
			$msg = "변경";
			$exp = explode(",",$choiceValue);
			for($i=0; $i < count($exp); $i++){
				if($i == 0) $sql .= "'".$exp[$i]."'";
				else $sql .= ",'".$exp[$i]."'";
			}	

			if($status == "D")
			{
				$query = "DELETE FROM ona_popup WHERE idx in ( $sql )";
				mysql_query($query);
				$query = "DELETE FROM ona_popup_info WHERE pidx in ( $sql )";
				mysql_query($query);
			}else{
				$query = "UPDATE ona_popup SET status = '$status' WHERE idx in ( $sql )";
				mysql_query($query);
			}
		}
		
		// 팝업.js
		$str = "function init_popup() \r\n";
		$str .="{ \r\n";		
		
		$query	= "SELECT * FROM ona_popup WHERE status='Y'";
		$result	= mysql_query($query);
		while( $row	= mysql_fetch_array($result) )
		{
			// 게시일 체크
			$chk = "Y";
			if($row[sdate] && $row[sdate] > mktime() ) $chk = "N";
			if($row[edate] && ($row[edate]+86400-1) < mktime() ) $chk = "N";
			if($chk == "Y")
			{
				// 게시일
				if($row[sdate]) $sdate = $row[sdate]; else $sdate = 0;
				if($row[edate]) $edate = $row[edate]+86400-1; else $edate = 0;

				// 팝업사이즈
				$expSize = explode("|",$row[sizeInfo]);
				$expSize[1] +=  24;
				if($expSize[4]=="yes") $expSize[0] += 17;

				// 팝엽형태
				$openType = $row[openType]=="D"?"_div":"";

				$str .= "open_popup".$openType."('/html/popup/popup_$row[idx].html','pop_cook_$row[idx]', 'wnd_$row[idx]', $expSize[0],$expSize[1],$expSize[2],$expSize[3],'$expSize[4]',$sdate,$edate);\r\n";
			}
		}
		$str .="} \r\n";
		
		$jsFile = "../../include/js/popup_open.js";
		$fp = fopen($jsFile,"w");
		if( $fp ) {
			fwrite( $fp, $str );
			fclose($fp);
		}	

		$returnValue  = "<script language='javascript'>";
		$returnValue .= "alert('".$msg." 되었습니다.');";

		if(ereg($send,"write|delete")) $returnValue .= "parent.location.href('popup_list.php');";
		else $returnValue .= "parent.location.reload();";

		$returnValue .= "</script>";		
		echo $returnValue;
	}
	exit;
?>
