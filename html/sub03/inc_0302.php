<?
	$yy	 = $yy?$yy:date("Y");
	$mm	 = $mm!=""?$mm:date("m");
  	$mm	 = sprintf("%02d",$mm);
  	if($mm > 12){	//���� �Ϳ� Ŭ��������.
		$mm = "01";
		$yy	= $yy + 1;
	}
	if($mm < 1){		
		$mm = 12;
		$yy	= $yy - 1;
	}
	$total_days=date("t", mktime(0,0,0,$mm,1,$yy)); //�ش���� �ϼ�
	$first_day=date("w", mktime(0,0,0,$mm,1,$yy));  //�ش���� ù���� ����
	$code = $pno=="030201"?"A1":"A2";
?>

<script language="javascript">
	function saveToExcel(name){
		tableObj = document.getElementById("dataTable");
		var form = document.getElementById("excelForm");
		form.data.value = tableObj.outerHTML;
		form.name.value = name;
		form.submit();
	}
</script>

<form name="excelForm" method="post" target="excelFrame" action="/include/global/excel_download.php">
	<INPUT TYPE="HIDDEN" NAME="data">
	<INPUT TYPE="HIDDEN" NAME="name">
</form>
<iframe width=0 height=0 frameborder=0 id="excelFrame" name="excelFrame"></iframe>

<table width="655" border="0" cellspacing="0" cellpadding="0">	

<form method="get" action="<?=$PHP_SELF?>">
	<input type="hidden" name="pno" value="<?=$pno?>">
	<input type="hidden" name="code" value="<?=$code?>">
	<input type="hidden" name="type" value="<?=$type?>">

	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="82" valign="top" background="../../images/sub03/img_01.gif" style="padding:15px 0px 0px 0px">
						<!--- ���� ���� ���--->
						<table border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td style="padding:0px 3px 0px 0px"><a href="<?=$PHP_SELF?>?msChk=<?=$msChk?>&pno=<?=$pno?>&yy=<?=$yy-1?>&mm=<?=$mm?>"><img src="../../images/sub03/btn_prev.gif" alt="������" border="0"></a></td>
								<td><a href="<?=$PHP_SELF?>?msChk=<?=$msChk?>&pno=<?=$pno?>&yy=<?=$yy?>&mm=<?=$mm-1?>"><img src="../../images/sub03/btn_prev1.gif" alt="������" border="0"></a></td>
								<td width="145">
									<!--- ��--->
									<table border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td style="padding:0px 10px 0px 0px"><a href="#"><img src="../../images/sub03/<?=$yy?>.gif"></a></td>
											<td><img src="../../images/sub03/no_<?=substr($mm,0,1)?>.gif"></td>
											<td style="padding-left:4px;"><img src="../../images/sub03/no_<?=substr($mm,1,1)?>.gif"></td>
										</tr>
									</table>
									<!--- ��(e)--->
								</td>
								<td><a href="<?=$PHP_SELF?>?msChk=<?=$msChk?>&pno=<?=$pno?>&yy=<?=$yy?>&mm=<?=$mm+1?>"><img src="../../images/sub03/btn_next1.gif" alt="������" border="0"></a></td>
								<td style="padding:0px 0px 0px 3px"><a href="<?=$PHP_SELF?>?msChk=<?=$msChk?>&pno=<?=$pno?>&yy=<?=$yy+1?>&mm=<?=$mm?>"><img src="../../images/sub03/btn_next.gif" alt="������"></a></td>
							</tr>
						</table>
						<!--- ���� ���� ���(e)--->
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr id="dataTable">
		<td>
			<!---����Ʈ--->
			<?
				//################################################
				//	�ش���� �޴� ���ϱ� {{
				//################################################
				for( $i = 1 ; $i <= $total_days ; $i++  ) {

					if( $i < 10 )	 $today = "$yy-$mm-0$i";
					else			 $today = "$yy-$mm-$i";

					$weekday = date("w", mktime(0,0,0,$mm,$i,$yy));
					$ar[0] = $i;

					if( $weekday != 0 && $weekday != 6 ) 
					{
						$query	= "SELECT * FROM ona_menulist WHERE mdate='$today' AND code='$code'";						
						//echo $query."<br>";
						$result	= mysql_query($query);
						$row		= @mysql_fetch_array($result);
						if( $row ) {

							for( $j = 1 ; $j <= 5; $j++ ) {
								$maximun = $pno=="030201"?"2":"5";						
								for( $n = 1 ; $n <= $maximun; $n++ ) {									
									if( $row[m0.$j.$n] != "" ) $ar[$j].= $row[m0.$j.$n]."<br>";
								}
							}

						} else {
							$ar[1] = "";
							$ar[2] = "";
							$ar[3] = "";
							$ar[4] = "";
							$ar[5] = "";
						}

					} else {
						$ar[1] = "";
						$ar[2] = "";
						$ar[3] = "";
						$ar[4] = "";
						$ar[5] = "";
					}

					$ar_date[$i] = $ar;

					$ar[1] = "";
					$ar[2] = "";
					$ar[3] = "";
					$ar[4] = "";
					$ar[5] = "";

				}
				//################################################
				//	�ش���� �޴� ���ϱ� }}
				//################################################

				//################################################
				//	�޷� Print ���ڿ� ���ϱ� {{
				//################################################
				$days = 0-$first_day+1 ;

				$str_cal = "";

				$str_cal .="
						<table border='0' cellspacing='0' cellpadding='0'>
							<tr>
								<td width='61' align='center' class='cell010_r'>����</td>
								<td width='118' align='center' class='cell010_r'>��</td>
								<td width='118' align='center' class='cell010_r'>ȭ</td>
								<td width='118' align='center' class='cell010_r'>��</td>
								<td width='118' align='center' class='cell010_r'>��</td>
								<td width='118' align='center' class='cell11'>��</td>
							</tr>";

				for( $k = 1 ; $k <= 6 ; $k++ ) {

					$start = $days;

					if( $start == $total_days ) {	// ������ ���̰� �Ͽ����̸� ����.
						$weekday=date("w",  mktime(0,0,0,$mm,$days,$yy));
						if( $weekday == 0 || $weekday == 6 ) break;
					}
					
					$str_cal .="<tr>";

					for ( $col = 0 ; $col <=6 ; $col++ ) {

						$tdClass = $col<5?"cell12":"cell13";

						if( $col == 0  || $col == 6 ) {
							if ( $col == 0 ) $str_cal .="<td align='center' class='".$tdClass."'>".$k."��</td>";
						}else{	
							if( $days >= 1 && $days <= $total_days && $_SESSION['masterSession']) {
									$mdate = "$yy-$mm-";
									if( $days < 10 ) $mdate.="0".$days;
									else $mdate.=$days;

									if($ar_date[$days][0]){
										$arDate1 = $ar_date[$days][0];
									}else{
										$arDate1 = "&nbsp;";
									}
									$str_cal .="<td align='center' class='".$tdClass."' style='cursor:pointer' onclick=\"location.href='$PHP_SELF?pno=$pno&type=$type&mode=write&pageFile=reg&mdate=$mdate&code=$code';\">".$arDate1."</td>";
							} else {
								if($ar_date[$days][0]){
									$arDate1 = $ar_date[$days][0];
								}else{
									$arDate1 = "&nbsp;";
								}
								$str_cal .="<td align='center' class='".$tdClass."'>".$arDate1."</td>";
							}
						}
						$days++;
					}												
					$str_cal .="</tr>";
					  
					$days = $start;

					if($pno == "030201"){

						// ������
						$days = $start;
						$str_cal .="<tr>";
						for ( $col = 0 ; $col <=6 ; $col++ ) { 
							if( $col == 0 || $col == 6 ) {
								if ( $col == 0 ) $str_cal .="<td align='center' class='cell05_r' style='padding:15px 0px 15px 0px'>������</td>";
							} else {

								if($ar_date[$days][1]){
									$arDate2 = $ar_date[$days][1];
								}else{
									$arDate2 = "&nbsp;";
								}

								if($col == "6"){ 
									$tdClass = "cell09c"; 
								}else{
									$tdClass = "cell09_rc"; 
								}

								$tdClass = $col<5?"4_r":"3";
									
								$str_cal .="<td align='center' class=\"cell0".$tdClass."\">".$arDate2."</td>";
							}
							$days++;
						}
						$str_cal .="</tr>";

					}else{

						// ���� ����
						$days = $start;
						$str_cal .="<tr>";
						for ( $col = 0 ; $col <=6 ; $col++ ) { 
							if( $col == 0 || $col == 6 ) {
								if ( $col == 0 ) $str_cal .="<td align='center' class='cell05_r' style='padding:15px 0px 15px 0px'>���� ����</td>";
							} else {

								if($ar_date[$days][1]){
									$arDate2 = $ar_date[$days][1];
								}else{
									$arDate2 = "&nbsp;";
								}

								if($col == "6"){ 
									$tdClass = "cell09c"; 
								}else{
									$tdClass = "cell09_rc"; 
								}

								$tdClass = $col<5?"4_r":"3";
									
								$str_cal .="<td align='center' class=\"cell0".$tdClass."\">".$arDate2."</td>";
							}
							$days++;
						}
						$str_cal .="</tr>";

						// ����
						$days = $start;
						$str_cal .="<tr>";
						for ( $col = 0 ; $col <=6 ; $col++ ) { 
							if( $col == 0 || $col == 6 ) {
								if ( $col == 0 ) $str_cal .="<td align='center' class='cell05_r' style='padding:15px 0px 15px 0px'>����</td>";
							} else {

								if($ar_date[$days][2]){
									$arDate3 = $ar_date[$days][2];
								}else{
									$arDate3 = "&nbsp;";
								}

								if($col == "6"){ 
									$tdClass = "cell09c"; 
								}else{
									$tdClass = "cell09_rc"; 
								}

								$tdClass = $col<5?"4_r":"3";
								$str_cal .="<td align='center' class=\"cell0".$tdClass."\">".$arDate3."</td>";
							}
							$days++;
						}
						$str_cal .="</tr>";

						// ���� ����		
						$days = $start;
						$str_cal .="<tr>";
						for ( $col = 0 ; $col <=6 ; $col++ ) { 
							if( $col == 0 || $col == 6 ) {
								if ( $col == 0 ) $str_cal .="<td align='center' class='cell05_r' style='padding:15px 0px 15px 0px'>���� ����</td>";
							} else {

								if($ar_date[$days][3]){
									$arDate4 = $ar_date[$days][3];
								}else{
									$arDate4 = "&nbsp;";
								}

								if($col == "6"){ 
									$tdClass = "cell09c"; 
								}else{
									$tdClass = "cell09_rc"; 
								}

								$tdClass = $col<5?"4_r":"3";
									
								$str_cal .="<td align='center' class=\"cell0".$tdClass."\">".$arDate4."</td>";
							}
							$days++;
						}
						$str_cal .="</tr>";

						// ����		
						$days = $start;
						$str_cal .="<tr>";
						for ( $col = 0 ; $col <=6 ; $col++ ) { 
							if( $col == 0 || $col == 6 ) {
								if ( $col == 0 ) $str_cal .="<td align='center' class='cell05_r' style='padding:15px 0px 15px 0px'>����</td>";
							} else {

								if($ar_date[$days][4]){
									$arDate5 = $ar_date[$days][4];
								}else{
									$arDate5 = "&nbsp;";
								}

								if($col == "6"){ 
									$tdClass = "cell09c"; 
								}else{
									$tdClass = "cell09_rc"; 
								}

								$tdClass = $col<5?"4_r":"3";
									
								$str_cal .="<td align='center' class=\"cell0".$tdClass."\">".$arDate5."</td>";
							}
							$days++;
						}
						$str_cal .="</tr>";
					}
					if( $days > $total_days ) break;
				} 
				$str_cal .="</table>";
				echo $str_cal;
			?>
			<!---����Ʈ(e)--->
		</td>
	</tr>