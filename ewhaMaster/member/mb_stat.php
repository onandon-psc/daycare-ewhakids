<?
    include "../../include/global/config.php";
    include "../common/admin_login_check.php";              // 로그인 체크

	/* 회원 등록일 Update */
	$sql = "SELECT idx, regdate FROM ona_member WHERE regDay is null or regDay='' ";
	$result = mysql_query( $sql );
	while( $row = mysql_fetch_array( $result ) ) {
		$regDay = date("Y-m-d", $row[1] );
		$sql = "UPDATE ona_member SET regDay ='$regDay' WHERE idx='".$row[0]."'";
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

	$arMon['rs1'] = 0;
	$arMon['rs2'] = 0;
	$arMon['rs3'] = 0;
	$arMon['rs4'] = 0;

	$arGross['rs1'] = 0;
	$arGross['rs2'] = 0;
	$arGross['rs3'] = 0;
	$arGross['rs4'] = 0;

	for( $i = 1 ; $i<=$total_day;$i++ ) {
		$ar1[$i] = 0;
		$ar2[$i] = 0;
		$ar3[$i] = 0;
		$ar4[$i] = 0;
		$arSum[$i] = 0;
	}

	if($memtype4){
		$whereAdd .= " && memtype4='$memtype4' ";
	}

	// 일별 등록수 구하기
	$sql = "SELECT 
					right(regDay,2) As day, memtype1, count(memtype1) As cnt
			   FROM 
					ona_member
			   WHERE
					left( regDay,7) = '$wkmon' $whereAdd
			   GROUP BY right(regDay,2), memtype1";
	$result = mysql_query( $sql );
	while( $row = @mysql_fetch_array($result) ) {
		switch( $row[memtype1] ) {
		case "부모" :
			$ar1[(int)$row[day]] = $row[cnt];	
			$arMon['rs1'] += $row[cnt];
			$arSum[(int)$row[day]]		+= $row[cnt];	
			break;
		case "종사자":
			$ar2[(int)$row[day]] = $row[cnt];	
			$arMon['rs2'] += $row[cnt];
			$arSum[(int)$row[day]]		+= $row[cnt];	
			break;
		case "기타":
			$ar3[(int)$row[day]] = $row[cnt];	
			$arMon['rs3'] += $row[cnt];
			$arSum[(int)$row[day]]		+= $row[cnt];	
			break;
		case "기관":
			$ar4[(int)$row[day]] = $row[cnt];	
			$arMon['rs4'] += $row[cnt];
			$arSum[(int)$row[day]]		+= $row[cnt];	
			break;
		}
	}

	// 누계 구하기
	$sql = "SELECT 
					memtype1 , count(memtype1) As cnt
			   FROM
					ona_member
			   WHERE
					left( regDay,7) <= '$wkmon' $whereAdd
			   GROUP BY memtype1";
	$result = mysql_query( $sql );
	while( $row = @mysql_fetch_array($result) ) {
		switch( $row[memtype1] ) {
			case "부모" :
				$arGross['rs1'] += $row[cnt];
				break;
			case "종사자":
				$arGross['rs2'] += $row[cnt];
				break;
			case "기타":
				$arGross['rs3'] += $row[cnt];
				break;
			case "기관":
				$arGross['rs4'] += $row[cnt];
				break;
		}
	}

	$arTitle = Array("(일)","(월)","(화)","(수)","(목)","(금)","(토)","주계");

?>
<script language='javascript'>
	function submit_change()
	{
		var f  = document.frm1;
		f.wkmon.value = f.cbyear.value + "-" + f.cbmon.value;
		f.submit();
	}
</script>

<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr height="30">
        <td bgcolor="#ececec">&nbsp;&nbsp;<img src="/images/admin/menu.gif"> 회원관리 > <b>회원가입통계</b></td>
    </tr>
    <tr>
        <td height="15"></td>
    </tr>
    <tr>
        <td align="left" style="padding:0 0 0 20">
		  <table width="60%" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align='center' valign='center'>
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<form name='frm1' method='post' action="<?=$PHP_SELF?>">
						<tr>
							<td>
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
								<font size=2><b>회원가입 통계</b></font>
							</td>
						</tr>
						<tr>
							<td align="center" style="padding:8 0 0 0">
								<select name="memtype4" onchange='this.form.submit();'>
									<option value="">지역구분</option>
									<option value="관내" <?if($memtype4=="관내") echo"selected";?>>관내</option>
									<option value="관외" <?if($memtype4=="관외") echo"selected";?>>관외</option>
								</select>
							</td>
						</tr>
						</form>
					</table>
				</td>
				<td align='right' style="padding:10 0 0 0">
					<table width="360" border="0" cellpadding="0" cellspacing="2" bgcolor="#F4F4F4">
						<tr align="center" bgcolor="#F2F3E8">
							<td width='10%'><b>구 분</b></td>
							<td width='10%'><b>부 모</b></td>
							<td width='10%'><b>종사자</b></td>
							<td width='10%'><b>기 타</b></td>
							<td width='10%'><b>기 관</b></td>
							<td width='10%'><b>합 계</b></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td align="center"><b>월 계</b></td>
							<td align='right'><?=number_format($arMon['rs1'])?>&nbsp;</td>
							<td align='right'><?=number_format($arMon['rs2'])?>&nbsp;</td>
							<td align='right'><?=number_format($arMon['rs3'])?>&nbsp;</td>
							<td align='right'><?=number_format($arMon['rs4'])?>&nbsp;</td>
							<td align='right'><?=number_format($arMon['rs1']+$arMon['rs2']+$arMon['rs3']+$arMon['rs4'])?>&nbsp;</td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td align="center"><b>누 계</b></td>
							<td align='right'><?=number_format($arGross['rs1'])?>&nbsp;</td>
							<td align='right'><?=number_format($arGross['rs2'])?>&nbsp;</td>
							<td align='right'><?=number_format($arGross['rs3'])?>&nbsp;</td>
							<td align='right'><?=number_format($arGross['rs4'])?>&nbsp;</td>
							<td align='right'><?=number_format($arGross['rs1']+$arGross['rs2']+$arGross['rs3']+$arGross['rs4'])?>&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			</table>
			<br>

			<table width="60%" border="0" cellpadding="2" cellspacing="1" bgcolor="#EFEFEF">
			<?
				$i = $start_day;
				for( $j = 0 ; $j < $weeks  ; $j++ )
				{
						
					echo("<tr align='center' bgcolor='#F2F3E8'>");
					echo("<td><b>구&nbsp;&nbsp;분</b></td>");
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i+$w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td><b>".($idx). $arTitle[$w]."</b></td>");
					}
					echo("<td><b>$arTitle[7]</b></td>");
					echo("</tr>");


					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>부 &nbsp;&nbsp;모</td>");
					$week_sum = 0;
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i + $w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td align='right' bgcolor='white'>".$ar1[$idx]."</td>");
						$week_sum += $ar1[$idx];
					}
					echo("<td align='right'>$week_sum</td>");
					echo("</tr>");

					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>종사자</td>");
					$week_sum = 0;
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i +$w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td align='right' bgcolor='white'>".$ar2[$idx]."</td>");
						$week_sum += $ar2[$idx];
					}
					echo("<td align='right' >$week_sum</td>");
					echo("</tr>");

					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>기 &nbsp;&nbsp;타</td>");
					$week_sum = 0;
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i +$w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td align='right' bgcolor='white'>".$ar3[$idx]."</td>");
						$week_sum += $ar3[$idx];
					}
					echo("<td align='right'>$week_sum</td>");
					echo("</tr>");

					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>기 &nbsp;&nbsp;관</td>");
					$week_sum = 0;
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i +$w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td align='right' bgcolor='white'>".$ar4[$idx]."</td>");
						$week_sum += $ar4[$idx];
					}
					echo("<td align='right'>$week_sum</td>");
					echo("</tr>");

					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>소 &nbsp;&nbsp;계</td>");
					$week_sum = 0;
					for( $w = 0 ; $w < 7 ; $w++,$i++ )
					{
						$idx = $i ;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td align='right'>".$arSum[$idx]."</td>");
						$week_sum += $arSum[$idx];
					}
					echo("<td align='right'>$week_sum</td>");
					echo("</tr>");

				}
			?>
			</table>
		</td>
	<tr>
</table>
<br>
<br>
</body>
</html>