<?
	$thisDate = strtotime(date("Y-m-d"));

	/********** ����� ������ **********/
	$mStartYear=date("Y");
	$mEndYear=date("Y")+4;

	/**********�Է°�**********/
	$mYear=($_GET['toYear'])?$_GET['toYear']:date("Y");
	$mMonth=($_GET['toMonth'])?$_GET['toMonth']:date("m");

	/**********��갪**********/
	$mktime=mktime(0,0,0,$mMonth,1,$mYear);//�ԷµȰ����γ�-��-01�������
	$mLastDay=date("t",$mktime);//������year��month����������ϼ����ؿ���
	$mStartDay=date("w",$mktime);//���ۿ��Ͼ˾Ƴ���

	//�������ϼ����ϱ�
	$mPrevDayCount=date("t",mktime(0,0,0,$mMonth,0,$mYear))-$mStartDay+1;

	$mNowDayCount=1;//�̹�������ī����
	$mNextDayCount=1;//����������ī����

	//����,���������
	$mPrevYear		= $mYear-1;
	$mNextYear		= $mYear+1;
	/*
	$mPrevMonth	= sprintf("%02d",($mMonth-1));
	$mNextMonth	= sprintf("%02d",($mMonth+1));
	*/

	if( $mMonth < 1 ){
		$mYear		-= 1;
		$mMonth	= "12";	
	}
	
	if( $mMonth > 12 ){
		$mYear		+= 1;
		$mMonth	= "01";
	}

	$mPrevMonth= sprintf("%02d",($mMonth-1));
	$mNextMonth= sprintf("%02d",($mMonth+1));	

	$mDays = 0;
	for($week = 0; $week < $mStartDay; $week ++) { // �ش���� ó�� ������ �Ǳ� �� ���� �߰�.
		$arrSCH[$mDays]['day'] = "&nbsp";
		$mDays++;
	}

	for($schDay = 1; $schDay <= $mLastDay; $schDay ++) {
		$arrSCH[$mDays]['day'] = $schDay;
		$mDays++;
	}

	// ����� ���
	$mSetRows = ceil(($mDays) / 7 );
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td height="80" valign="top" background="../../images/sub03/bg_01.gif" style="padding:28px 0px 0px 0px">

						<!--- ���� ���� ���--->
						<table border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
								<td style="padding:0px 3px 0px 0px"><img src="../../images/sub03/btn_prev.gif" alt="������" border="0" onclick="location.href='<?=$_SERVER['PHP_SELF']?>?pno=<?=$pno?>&toYear=<?=$mPrevYear?>&toMonth=1&gubun=<?=$gubun?>&msChk=<?=$msChk?>&search=<?=$search?>&keyword=<?=$keyword?>&edu_kind=<?=$edu_kind?>'" style="cursor:hand"/></td>
								<td><img src="../../images/sub03/btn_prev1.gif" alt="������" border="0" onclick="location.href='<?=$_SERVER['PHP_SELF']?>?pno=<?=$pno?>&toYear=<?=$mYear?>&toMonth=<?=$mPrevMonth?>&gubun=<?=$gubun?>&msChk=<?=$msChk?>&search=<?=$search?>&keyword=<?=$keyword?>&edu_kind=<?=$edu_kind?>'" style="cursor:hand"></td>
								<td width="145">
									<!--- ��--->
									<table border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td style="padding:0px 10px 0px 0px"><img src="../../images/sub03/<?=$mYear?>.gif"></td>
											<td><img src="../../images/sub03/no_<?=substr($mMonth,0,1)?>.gif"></td>
											<td style="padding-left:4px;"><img src="../../images/sub03/no_<?=substr($mMonth,1,1)?>.gif" ></td>
										</tr>
									</table>
									<!--- ��(e)--->
								</td>
								<td><img src="../../images/sub03/btn_next1.gif" alt="������" border="0" onclick="location.href='<?=$_SERVER['PHP_SELF']?>?pno=<?=$pno?>&toYear=<?=$mYear?>&toMonth=<?=$mNextMonth?>&gubun=<?=$gubun?>&msChk=<?=$msChk?>&search=<?=$search?>&keyword=<?=$keyword?>&edu_kind=<?=$edu_kind?>'" style="cursor:hand"></td>
								<td style="padding:0px 0px 0px 3px"><img src="../../images/sub03/btn_next.gif" alt="������" onclick="location.href='<?=$_SERVER['PHP_SELF']?>?pno=<?=$pno?>&toYear=<?=$mNextYear?>&toMonth=1&gubun=<?=$gubun?>&msChk=<?=$msChk?>&search=<?=$search?>&keyword=<?=$keyword?>&edu_kind=<?=$edu_kind?>'" style="cursor:hand"	 ><?
														if($_SESSION['masterSession'])
														{
															echo "&nbsp<img src='../../images/btn/btn_print.gif' alt='�μ�' onClick='window.print();return false;'>";
														}
													?></td>
							</tr>
						</table>
						<!--- ���� ���� ���(e)--->
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<!---����--->
			<table width="614" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="../../images/sub03/img_04.gif"></td>
				</tr>
			</table>
			<!---����(e)--->
		</td>
	</tr>
	<tr>
		<td></td>
	</tr>
	<tr>
		<td>
			<!---Į���� �Ϻ�--->
			<!---Į���� �Ϻ�(e)--->
		</td>
	</tr>
	<tr>
		<td>
			<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<!---����Ʈ--->
						<table width="100%" height="90" border="0" align="center" cellpadding="0" cellspacing="0">
						<?
							$mDays=0;
							for($mRows = 0;$mRows < $mSetRows;$mRows++){
								echo "<TR>";
								for($mCols = 1;$mCols < 8;$mCols++){
									if($mCols == 1 || $mCols == 7)
									{
										$temp_width = "50";
									}
									else
									{
										$temp_width = "105";
									}
									echo "<td width='".$temp_width."' valign='top'>";
									DispCell($mCols,$mDays,$mYear,$mMonth,$arrSCH[$mDays]);
									echo "</TD>";
									if($mCols<7) echo "<td width='2' valign='top'>&nbsp;</td>";
									$mDays++;
								}
								echo "</TR>";
							}
						?>
						</table>
						<!---����Ʈ(e)--->
					</td>
				</tr>								
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="../../images/sub03/img_05.gif"></td>
	</tr>
	<tr>
		<td height="45">&nbsp;</td>
	</tr>	
</table>
<?
    function DispCell($mCols,$mCellIdx,$mYear,$mMonth,$mSCH){

		if($mSCH == "")
		{
			$mSCH['day'] = "&nbsp";
		}
		
		global $pno, $week_arr, $whereAnd;

		$today = strtotime($mYear."-".$mMonth."-".$mSCH['day']);

        if($mSCH['day'] == "&nbsp"){
            $mCellColor = 1;
        }else{
            $mWeek =  date( "w", mktime( 0, 0, 0, $mMonth, $mSCH['day'], $mYear));
            $dayClass = "moon_01";
            if($mWeek == 0) $dayClass = "moon_03";
            if($mWeek == 6) $dayClass = "moon_04";
        }
		$wdate = $mYear."-".codeNumber($mMonth)."-".codeNumber($mSCH['day']);

		// ����ǥ��
		if(($mYear.$mMonth.$mSCH['day'])==date("Ymd")) $type = "calendar_today";
?>
<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td class="boxA_01"></td>
		<td class="boxA_02"></td>
		<td class="boxA_03"></td>
	</tr>
	<tr>
		<td class="boxA_04"></td>
		<td class="boxA_05" valign="top">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td class="<?=$dayClass?>"><?=$mSCH['day']?></td>
				</tr>
				<tr>
					<td height="60" valign="top" class="moon_02">
					<? include "../../include/board/030301_val.php"; ?>
					<?	
						$query	= "SELECT board_idx, board_kind, board_subject, board_pwd
										FROM ona_board_030301 
										WHERE board_email='".date("Y-m-d",$today)."' ORDER BY board_idx";
						//echo $query;
						$result	= mysql_query($query);
						while($row = @mysql_fetch_array($result))
						{
								$tmp = explode(",", $row[board_kind]);

								$tmpClass1 = $arrClass["$tmp[0]"];
								$tmpClass2 = "";
								if($tmp[1]) { $tmpClass1 = $tmpClass1.", ".$arrClass["$tmp[1]"]; }

								if($tmp[0]!="")
								{
									$tmpClass2 = "<".str_replace("��","",$tmpClass1).">";
								}
							$img = $row[board_pwd]?$row[board_pwd]."":"all";
							if(trim($row[board_idx])){
							echo "<span onClick=\"location.href('../../html/sub/index.php?pno=$pno&mode=view&board_idx=$row[board_idx]')\" style='cursor:pointer'><img src='/images/sub03/icon_".$img.".gif'	align='absmiddle'> ".$row[board_subject].$tmpClass2."</span><br>";
							}
						}						
					?>
					</td>
				</tr>
			</table>
		</td>
	    <td class="boxA_06"></td>
	</tr>
	<tr>
		<td class="boxA_07"></td>
		<td class="boxA_08"></td>
		<td class="boxA_09"></td>
	</tr>
</table>
<?
    }
?>