<?php
	$today = date("Y").date("m").date("d");
	$filename = "[$today]$name.xls";
	$data = stripslashes($data);
	$data = eregi_replace("<a[^>]*>","",$data);
	$today = date("Y").date("m").date("d");
	$filename = "[$today]$name.xls";
	$excel = stripslashes($excel);
	$speed = 250; // kb/s ������ �ٿ�ε带 �޴´�.
	$isLimit = 0;
	$disposition = "1";   // 1 �̸� �ٿ�, 0 �̸� �������� �ν��ϸ� ȭ�鿡 ��� 
	$disposition = ($disposition) ? "attachment" : "inline"; 
	header("Content-type: file/unknown"); 
	header("Content-Disposition: $disposition; filename=$filename"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 
	echo "<meta http-equiv='content-type' content='text/html; charset=euc-kr'>";
	echo "<style>td {font-size:12px;border:1 solid #999999;mso-number-format:'\@';}</style>";
	echo $data;
?> 