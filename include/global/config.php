<?php
	########################################
	#																			  #
	#								ȯ�漳��								  #
	#																			  #
	########################################

	// ���� ����
	/*
	ini_set ('error_reporting', E_ALL | E_STRICT);						// ���� ���� ���� : ���� ���� ����
	ini_set ('display_errors', 'Off');												// ���� ���� ��� X
	ini_set ('log_reeors', 'On');													// ���� �뺸
	ini_set ('error_log','/usr/local/apache/logs/error_log');		// ���� ���
	*/
	// HTTP/1.0
	@header("Pragma: no-cache");
	@session_cache_limiter("no-cache, must-revalidate");
	@session_start();

	// ��ü����
	$INFO[company] = "��ȸ��2�����";
	$INFO[url]			= "http://".$_SERVER['HTTP_HOST']."/";
	$INFO[rentUrl]		= "http://rent.gskids.or.kr";
	$INFO[email]		= "master@ewhakids.or.kr";
	
	// ������ ����
	$DIR[root]			= $_SERVER["DOCUMENT_ROOT"]."/";

	// �����ͺ��̽� ����	
	include $DIR[root]."include/db/connect.php";	

	// �����Լ�
	include $DIR[root]."include/global/func.php";

    // ���� ���
	/*
	$COUNTER[IGNORE_IP] = array();
	include $DIR[root]."include/global/counter.php";
	*/
	
	// ���ε� ���ϰ��
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
