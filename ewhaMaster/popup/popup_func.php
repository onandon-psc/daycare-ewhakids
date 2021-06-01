<?
	// 팝업 파일 생성
	function make_popup( $idx, $subject, $file, $visionDay, $contentType, $arrArea, $arrTarget, $arrUrl, $content, $skin )
	{
		global $send, $fileUrl, $iLinkCount, $openType;

		// 포맷 파일 Load
		$loadFile = "../../include/popup/popup_Form.html";
		$fp = fopen( $loadFile, "r");
		if( !$fp ) return false;
		$loadContents = fread( $fp, filesize( $loadFile ) ) ;
		fclose($fp);

		$loadContents = str_replace("[POP_TITLE]", $subject, $loadContents );								// 타이틀
		$loadContents = str_replace("[POP_COOKNM]", "pop_cook_$idx", $loadContents );			// 쿠키명
		$loadContents = str_replace("[POP_COOKDAY]", $visionDay, $loadContents );					// 쿠키날짜
		$loadContents = str_replace("[POP_IMAGE]", $fileUrl."/".urlencode($file), $loadContents );	// 이미지

		$map_func = "";
		$map_pos  = "";
	
		if($contentType==1){
			for( $n = 0 ; $n < $iLinkCount; $n++ ) 
			{		
				if( $arrArea[$n] && $arrUrl[$n] )
				{					
					$map_func .= "function map_go_".$n."(){";

					if($arrTarget[$n]=="P")
					{
						if($openType == "P") $map_func .= "opener.location.href =\"$arrUrl[$n]\"; window.close(); ";
						else $map_func .= "parent.location.href =\"$arrUrl[$n]\"; window.close(); ";
					}else{
						$map_func .= "window.open(\"$arrUrl[$n]\")";
					}

					$map_func .= "}";

					$map_pos .= "
					<area shape='rect' coords='$arrArea[$n]' href='javascript:map_go_$n();'> ";
				}
			}
		}

		if($contentType==2){
			if($arrUrl[0]){
				if($arrTarget[0]=="P")
				{
					if($openType == "P") $ext = "onclick=\"opener.location.href='$arrUrl[0]';window.close();\" style='cursor:pointer;'";
					else $ext = $ext = "onclick=\"parent.location.href='$arrUrl[0]';window.close();\" style='cursor:pointer;'";
				}else{
					$ext = "onclick=\"window.open('$arrUrl[0]')\" style='cursor:pointer;'";
				}
			}
		}

		if($contentType==3){
			$ext = " style='display:none' ";
			$content = "<div style=\"height:100%;overflow-y:auto;\">".$content."</div>";
		}	

		if($contentType==4){
			$ext = " style='display:none' ";
			
			$loadFile2 = "../../include/popup/skin_0".$skin.".html";
			$fp2 = fopen( $loadFile2, "r");
			if( !$fp2 ) return false;
			$loadContents2 = fread( $fp2, filesize( $loadFile2 ) ) ;
			fclose($fp2);
			
			$content = "<div style=\"height:100%;overflow-y:auto;\">".$content."</div>";			
			$content = str_replace("[CONTENT]", $content , $loadContents2 );			
		}		

		$wnd = $send == "preView" ? mktime() : $idx;			
		
		if($openType=="P")
		{
			$closeValue = "close_popup";
			$closeHTML = "<span onClick='window.close();' style='cursor:pointer'>[창닫기]</span>";
		}else{
			$closeValue = "close_popup_div";
			$closeHTML = "<span onClick=\"parent.Hide('wnd_".$wnd."');\" style='cursor:pointer'>[창닫기]</span>";
		}

		$loadContents = str_replace("[MAP_FUNCTION]", $map_func , $loadContents );					// 맵 함수
		$loadContents = str_replace("[MAP_POS]", $map_pos, $loadContents );							// 맵 위치
		$loadContents = str_replace("[EXT]", $ext, $loadContents );												// 맵 위치
		$loadContents = str_replace("[POP_HTML]", stripslashes($content), $loadContents );		// 이미지
		$loadContents = str_replace("[BG_IMAGE]", $bg_image, $loadContents );							// 이미지
		$loadContents = str_replace("[COOKIE_EXT]", $cookie_ext, $loadContents );						// 이미지
		$loadContents = str_replace("[POP_IDX]", $wnd, $loadContents );										// 타이틀
		$loadContents = str_replace("[POP_CLOSE_KIND]", $closeValue, $loadContents );				// 그만보기
		$loadContents = str_replace("[POP_CLOSE]", $closeHTML, $loadContents );						// 닫기

		$popupFile = "../../html/popup/popup_".$idx.".html";;

		$fp = fopen( $popupFile, "w+" );
		if( !$fp ) return false;
		fwrite ( $fp, $loadContents );
		fclose( $fp );

		//include $popupFile;
		if( $idx == "preView" ) echo "<script language='javascript'>parent.preViewerPopup(".mktime().");</script>";
		return true;

	}	
?>