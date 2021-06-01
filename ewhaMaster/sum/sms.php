<?
    include "../../include/global/config.php";
    include "../common/admin_login_check.php";              // 로그인 체크

	/* 발송일 Update */
	$sql = "SELECT idx, regdate FROM gn_sms_record WHERE regDay is null or regDay='' ";
	$result = mysql_query( $sql );
	while( $row = mysql_fetch_array( $result ) ) {
		$regDay = date("Y-m-d", $row[1] );
		$sql = "UPDATE gn_sms_record SET regDay ='$regDay' WHERE idx='".$row[0]."'";
		mysql_query( $sql );
	}

	if( !$wkmon ) $wkmon = date("Y-m");
	$y  = substr( $wkmon, 0, 4 );
	$m = substr( $wkmon, 5, 2 );

	$first_day  =  date("w",  mktime(0,0,0,(int)$m,1,$y) );		// 시작월
	$total_day =  date("t", mktime(0,0,0,(int)$m,1,$y) );			// Total 월
	$weeks		=   (int)( ( $first_day + $total_day) / 7 );			//  주
	if( ( $first_day + $total_day) % 7 ) $weeks++;
	$start_day = -1*$first_day + 1 ;										// 시작일

	$arMon['rs1']		= 0;
	$arGross['rs1']	= 0;

	for( $i = 1 ; $i<=$total_day;$i++ ) {
		$arSum[$i]		= 0;
	}

	// 일별 발송수 구하기
	$sql = "SELECT 
					right(regDay,2) As day, count(idx) As cnt
			   FROM 
					gn_sms_record
			   WHERE
					left( regDay,7) = '$wkmon' 
			   GROUP BY right(regDay,2), idx";

	$result = mysql_query( $sql );
	while( $row = @mysql_fetch_array($result) ) {
		$arSum[(int)$row[day]]		+= $row[cnt];
	}

	// 누계 구하기
	$sql = "SELECT 
					idx , count(idx) As cnt
			   FROM
					gn_sms_record
			   WHERE
					left( regDay,7) <= '$wkmon'
			   GROUP BY idx";
	$result = mysql_query( $sql );
	while( $row = @mysql_fetch_array($result) ) {
		$arGross['rs1'] += $row[cnt];
	}
	$arTitle = Array("(일)","(월)","(화)","(수)","(목)","(금)","(토)","주계");

?>
<html>
<head>
<title>SMS 통계</title>
<meta http-equiv='Content-Type' content='text/html; charset=euc-kr'>
<link href='/include/css/style.css' rel='stylesheet' type='text/css'>
</head>
<script language='javascript'>
function submit_change()
{
	var f  = document.frm1;
	f.wkmon.value = f.cbyear.value + "-" + f.cbmon.value;
	f.submit();
}
</script>
<body>
<table width="95%" border="0" cellpadding="0" cellspacing="0" align='center'>
<tr>
	<td align='center' valign='center'>
		<form name='frm1' method='post' action="<?=$PHP_SELF?>">
		<input type='hidden' name='wkmon' value="<?=$wkmon?>">
		<select name='cbyear' onchange="submit_change();">
		<? 
			$year = substr( $wkmon, 0, 4 );
			for( $i = $year - 10 ; $i < $year+2 ; $i++ )
			{
				if( $i == $year ) 
					echo("<option value='$i' selected>$i</option>");
				else
					echo("<option value='$i'>$i</option>");

			}
		?>
		</select>년 
		<select name='cbmon' onchange="submit_change();">
		<? 
			$year = substr( $wkmon, 5, 2 );
			for( $i = 1 ; $i <= 12 ; $i++ )
			{
				if( $i < 10 ) 				$mon = "0".$i;
				else							$mon = $i;

				if( $mon == $year ) 
					echo("<option value='$mon' selected>$i</option>");
				else
					echo("<option value='$mon'>$i</option>");

			}
		?>
		</select>월

		<font size=2><b>SMS 통계</b></font>
		</form>
	</td>
	<td align='right' style="padding:10 0 0 0">
		<table width="150" border="0" cellpadding="0" cellspacing="2" bgcolor="#F4F4F4">
			<tr align="center" bgcolor="#F2F3E8">
				<td width='50%'><b>구 분</b></td>
				<td width='50%'><b>SMS</b></td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center"><b>월 계</b></td>
				<td align='right'><?=number_format($arMon['rs1'])?> 명</td>
			</tr>
			<tr bgcolor="#FFFFFF">
				<td align="center"><b>누 계</b></td>
				<td align='right'><?=number_format($arGross['rs1'])?> 명</td>
			</tr>
		</table>
	</td>
</tr>
</table>
<br>

<table width="95%" border="0" cellpadding="2" cellspacing="1" bgcolor="#EFEFEF" align='center'>
<?
	$i = $start_day;
	for( $j = 0 ; $j < $weeks  ; $j++ )
	{
			
		echo("<tr align='center' bgcolor='#F2F3E8'>");
		for( $w = 0 ; $w < 7 ; $w++ )
		{
			$idx = $i+$w;
			if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
			else echo("<td><b>".($idx). $arTitle[$w]."</b></td>");
		}
		echo("<td><b>$arTitle[7]</b></td>");
		echo("</tr>");

		echo("<tr bgcolor='#FFFFFF'>");
		$week_sum = 0;
		for( $w = 0 ; $w < 7 ; $w++,$i++ )
		{
			$idx = $i ;
			if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
			else echo("<td align='center' height='40'>".$arSum[$idx]."</td>");
			$week_sum += $arSum[$idx];
		}
		echo("<td align='right'>$week_sum</td>");
		echo("</tr>");		

	}
?>
</table>
<br>
<br>
</body>
</html>