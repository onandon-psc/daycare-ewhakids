<?
    include "../../include/global/config.php";
    include "../common/admin_login_check.php";              // �α��� üũ

	/* ȸ�� ����� Update */
	$sql = "SELECT idx, regdate FROM t_member WHERE regDay is null or regDay='' ";
	$result = mysql_query( $sql );
	while( $row = mysql_fetch_array( $result ) ) {
		$regDay = date("Y-m-d", $row[1] );
		$sql = "UPDATE t_member SET regDay ='$regDay' WHERE idx='".$row[0]."'";
		mysql_query( $sql );
	}

	if( !$wkmon ) $wkmon = date("Y-m");
	$y  = substr( $wkmon, 0, 4 );
	$m = substr( $wkmon, 5, 2 );

	$first_day  =  date("w",  mktime(0,0,0,(int)$m,1,$y) );		// ���ۿ�
	$total_day =  date("t", mktime(0,0,0,(int)$m,1,$y) );			// Total ��
	$weeks		=   (int)( ( $first_day + $total_day) / 7 );			//  ��
	if( ( $first_day + $total_day) % 7 ) $weeks++;
	$start_day = -1*$first_day + 1 ;										// ������


	$arMon['rs1'] = 0;
	$arMon['rs2'] = 0;
	$arMon['rs3'] = 0;

	$arGross['rs1'] = 0;
	$arGross['rs2'] = 0;
	$arGross['rs3'] = 0;

	for( $i = 1 ; $i<=$total_day;$i++ ) {
		$arGeneral[$i]   = 0;
		$arTeacher[$i]  = 0;
		$arSisul[$i]		  = 0;
		$arSum[$i]		  = 0;
	}

	// �Ϻ� ��ϼ� ���ϱ�
	$sql = "SELECT 
					right(regDay,2) As day, memtype1, count(memtype1) As cnt
			   FROM 
					t_member
			   WHERE
					left( regDay,7) = '$wkmon' 
			   GROUP BY right(regDay,2), memtype1";

	$result = mysql_query( $sql );
	while( $row = @mysql_fetch_array($result) ) {
		switch( $row[memtype1] ) {
		case "�θ�" :
			$arGeneral[(int)$row[day]] = $row[cnt];	
			$arMon['rs1'] += $row[cnt];
			$arSum[(int)$row[day]]		+= $row[cnt];	
			break;
		case "�ü�":
			$arTeacher[(int)$row[day]] = $row[cnt];	
			$arMon['rs2'] += $row[cnt];
			$arSum[(int)$row[day]]		+= $row[cnt];	
			break;
		case "��Ÿ":
			$arSisul[(int)$row[day]] = $row[cnt];	
			$arMon['rs3'] += $row[cnt];
			$arSum[(int)$row[day]]		+= $row[cnt];	
			break;
		}
	}

	// ���� ���ϱ�
	$sql = "SELECT 
					memtype1 , count(memtype1) As cnt
			   FROM
					t_member
			   WHERE
					left( regDay,7) <= '$wkmon'
			   GROUP BY memtype1";
	$result = mysql_query( $sql );
	while( $row = @mysql_fetch_array($result) ) {
		switch( $row[memtype1] ) {
		case "�θ�" :
			$arGross['rs1'] += $row[cnt];
			break;
		case "�ü�":
			$arGross['rs2'] += $row[cnt];
			break;
		case "��Ÿ":
			$arGross['rs3'] += $row[cnt];
			break;
		}
	}

	$arTitle = Array("(��)","(��)","(ȭ)","(��)","(��)","(��)","(��)","�ְ�");

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
        <td bgcolor="#ececec">&nbsp;&nbsp;<img src="/images/admin/menu.gif"> ��� > <b>ȸ�����</b></td>
    </tr>
    <tr>
        <td height="15"></td>
    </tr>
    <tr>
        <td>
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
					</select>�� 
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
					</select>��

					<font size=2><b>ȸ������ ���</b></font>
					</form>
				</td>
				<td align='right' style="padding:10 0 0 0">
					<table width="400" border="0" cellpadding="0" cellspacing="2" bgcolor="#F4F4F4">
						<tr align="center" bgcolor="#F2F3E8">
							<td width='20%'><b>�� ��</b></td>
							<td width='20%'><b>�� ��</b></td>
							<td width='20%'><b>�� ��</b></td>
							<td width='20%'><b>�� Ÿ</b></td>
							<td width='20%'><b>�� ��</b></td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td width='20%' align="center"><b>�� ��</b></td>
							<td width='20%' align='right'><?=number_format($arMon['rs1'])?> ��</td>
							<td width='20%' align='right'><?=number_format($arMon['rs2'])?> ��</td>
							<td width='20%' align='right'><?=number_format($arMon['rs3'])?> ��</td>
							<td width='20%' align='right'><?=number_format($arMon['rs1']+$arMon['rs2']+$arMon['rs3'])?> ��</td>
						</tr>
						<tr bgcolor="#FFFFFF">
							<td width='20%' align="center"><b>�� ��</b></td>
							<td width='20%' align='right'><?=number_format($arGross['rs1'])?> ��</td>
							<td width='20%' align='right'><?=number_format($arGross['rs2'])?> ��</td>
							<td width='20%' align='right'><?=number_format($arGross['rs3'])?> ��</td>
							<td width='20%' align='right'><?=number_format($arGross['rs1']+$arGross['rs2']+$arGross['rs3'])?> ��</td>
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
					echo("<td><b>����</b></td>");
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i+$w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td><b>".($idx). $arTitle[$w]."</b></td>");
					}
					echo("<td><b>$arTitle[7]</b></td>");
					echo("</tr>");


					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>�� ��</td>");
					$week_sum = 0;
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i + $w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td align='right' bgcolor='white'>".$arGeneral[$idx]."</td>");
						$week_sum += $arGeneral[$idx];
					}
					echo("<td align='right'>$week_sum</td>");
					echo("</tr>");

					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>�� ��</td>");
					$week_sum = 0;
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i +$w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td align='right' bgcolor='white'>".$arTeacher[$idx]."</td>");
						$week_sum += $arTeacher[$idx];
					}
					echo("<td align='right' >$week_sum</td>");
					echo("</tr>");

					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>�� Ÿ</td>");
					$week_sum = 0;
					for( $w = 0 ; $w < 7 ; $w++ )
					{
						$idx = $i +$w;
						if( $idx < 1 || $idx > $total_day ) { echo("<td>&nbsp;</td>");  continue; }
						else echo("<td align='right' bgcolor='white'>".$arSisul[$idx]."</td>");
						$week_sum += $arSisul[$idx];
					}
					echo("<td align='right'>$week_sum</td>");
					echo("</tr>");

					echo("<tr bgcolor='#FFFFFF'>");
					echo("<td align='center'>�� ��</td>");
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