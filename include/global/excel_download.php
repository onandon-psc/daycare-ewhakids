<?php
	$today = date("Y").date("m").date("d");
	$filename = "[$today]$name.xls";
	$data = stripslashes($data);
	$data = eregi_replace("<a[^>]*>","",$data);
	$today = date("Y").date("m").date("d");
	$filename = "[$today]$name.xls";
	$excel = stripslashes($excel);
	$speed = 250; // kb/s 비율로 다운로드를 받는다.
	$isLimit = 0;
	$disposition = "1";   // 1 이면 다운, 0 이면 브라우져가 인식하면 화면에 출력 
	$disposition = ($disposition) ? "attachment" : "inline"; 
	header("Content-type: file/unknown"); 
	header("Content-Disposition: $disposition; filename=$filename"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	echo "<meta http-equiv='content-type' content='text/html; charset=euc-kr'>";
	echo "<style>td {font-size:12px;border:1 solid #999999;mso-number-format:'\@';}</style>";
	echo $data;
?> 