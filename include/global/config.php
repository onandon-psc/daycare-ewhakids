<?php
	########################################
	#																			  #
	#								환경설정								  #
	#																			  #
	########################################

	// 오류 보고
	/*
	ini_set ('error_reporting', E_ALL | E_STRICT);						// 오류 보고 수준 : 가장 높은 수준
	ini_set ('display_errors', 'Off');												// 오류 보고 사용 X
	ini_set ('log_reeors', 'On');													// 오류 통보
	ini_set ('error_log','/usr/local/apache/logs/error_log');		// 오류 기록
	*/
	// HTTP/1.0
	@header("Pragma: no-cache");
	@session_cache_limiter("no-cache, must-revalidate");
	@session_start();

	// 업체정보
	$INFO[company] = "국회제2어린이집";
	$INFO[url]			= "http://".$_SERVER['HTTP_HOST']."/";
	$INFO[rentUrl]		= "http://rent.gskids.or.kr";
	$INFO[email]		= "master@ewhakids.or.kr";
	
	// 절대경로 설정
	$DIR[root]			= $_SERVER["DOCUMENT_ROOT"]."/";

	// 데이터베이스 접속	
	include $DIR[root]."include/db/connect.php";	

	// 공통함수
	include $DIR[root]."include/global/func.php";

    // 접속 통계
	/*
	$COUNTER[IGNORE_IP] = array();
	include $DIR[root]."include/global/counter.php";
	*/
	
	// 업로드 파일경로
	$fileUrl = $_SERVER["DOCUMENT_ROOT"]."/upload/board/";

	if($charType != "no") echo "<meta http-equiv='content-type' content='text/html; charset=euc-kr'>";
	if($cssType != "no")	echo "<link rel='stylesheet' href='/include/css/style.css' type='text/css'>";
	if($iframeType != "no") echo "<iframe name='iframe' style='display:none;' width='0' height='0'></iframe>";
	if($blurType != "no")
	{
		echo"<script language='javascript'>
					function autoBlur(){
					  if(event.srcElement.tagName=='A'||event.srcElement.tagName=='IMG') document.body.focus();
					}
					document.onfocusin=autoBlur;
				 </script>";
	}
/*
	if(!ereg("127.0.0.1|222.107.128.188|211.46.125.253", $_SERVER['REMOTE_ADDR']))
	{		
		echo "<script>location.href('../../html/intro/notice1.html');</script>";		
	}
*/
?>
