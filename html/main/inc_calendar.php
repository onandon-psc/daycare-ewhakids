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
<table width="207" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="47" valign="top" background="/images/main/bg_01.gif" style="padding:22px 0px 0px 102px">
			<!--������--->
			<table width="95" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="11"><img src="/images/main/btn_pr.gif" alt="������" border="0" onclick="location.href='<?=$_SERVER['PHP_SELF']?>?toYear=<?=$mYear?>&toMonth=<?=$mPrevMonth?>&gubun=<?=$gubun?>&msChk=<?=$msChk?>&search=<?=$search?>&keyword=<?=$keyword?>&edu_kind=<?=$edu_kind?>'" style="cursor:hand"></td>
					<td width="37" align="center" class="font_orenge1"><?=$mYear?></td>
					<td width="35"><a href="../../html/sub/index.php?pno=030301&toYear=<?=$mYear?>&toMonth=<?=$mMonth?>"><img src="/images/main/m_<?=$mMonth?>.gif" width="29" height="22"></a></td>
					<td width="12"><img src="/images/main/btn_ne.gif" alt="������" border="0" onclick="location.href='<?=$_SERVER['PHP_SELF']?>?pno=<?=$pno?>&toYear=<?=$mYear?>&toMonth=<?=$mNextMonth?>&gubun=<?=$gubun?>&msChk=<?=$msChk?>&search=<?=$search?>&keyword=<?=$keyword?>&edu_kind=<?=$edu_kind?>'" style="cursor:hand"></td>
				</tr>
			</table>
			<!--������(e)--->
		</td>
	</tr>
	<tr>
		<td background="/images/main/img_bg5.gif">
			<table width="189" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td height="22"><img src="/images/main/img_05.gif" /></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td height="89" valign="top" background="/images/main/bg_02.gif" style="padding:1px 0px 0px 0px">
			<table width="182" border="0" align="center" cellpadding="0" cellspacing="0">
			<!---����--->
			<?
				$mDays=0;
				for($mRows = 0;$mRows < $mSetRows;$mRows++){
					echo "<TR>";
					for($mCols = 1;$mCols < 8;$mCols++){
						echo "<td width='26' height='12' align='center'>";
						DispCell($mCols,$mDays,$mYear,$mMonth,$arrSCH[$mDays]);
						echo "</TD>";						
						$mDays++;
					}
					echo "</TR>";
				}
			?>
			</table>
			<!-- <table width="182" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="26" height="12" align="center"><img src="/images/main/o_07.gif" /></td>
					<td width="26" height="12" align="center"><img src="/images/main/g_08.gif" /></td>
					<td width="26" height="12" align="center"><img src="/images/main/g_09.gif" /></td>
					<td width="26" height="12" align="center"><a href="#"><img src="/images/main/r_09.gif" border="0" /></a></td>
					<td width="26" height="12" align="center"><img src="/images/main/g_10.gif" /></td>
					<td width="26" height="12" align="center"><img src="/images/main/g_11.gif" /></td>
					<td width="26" height="12" align="center"><img src="/images/main/b_12.gif" /></td>
				</tr>
			</table> -->
			<!---����(e)--->
		</td>
	</tr>
</table>
<?
    function DispCell($mCols,$mCellIdx,$mYear,$mMonth,$mSCH){
		
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

		$query	= "SELECT board_idx, board_kind, board_subject 
						FROM ona_board_030301 
						WHERE board_email='".date("Y-m-d",$today)."' ORDER BY board_idx";
		//echo $query;
		$result	= mysql_query($query);
		$row = @mysql_fetch_array($result);
		
		switch($mWeek)
		{
			case "0":
				$type = "o";
				break;
			case "6":
				$type = "b";
				break;
			default:
				$type = "g";
				break;
		}
		
		$type = $row[board_idx]?"r":$type;
		if(trim(intval($mSCH['day'])))
		{
			echo "<span onClick=\"location.href('../../html/sub/index.php?pno=030301')\" style='cursor:pointer'><img src='/images/main/".$type."_".codeNumber($mSCH['day']).".gif' border='0' /></span><br>";
		}
    }
?>