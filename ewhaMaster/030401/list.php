<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// �α��� üũ
	include "../../include/board/030301_val.php"; 

	if($_SESSION['member_level'] < 9){
		echo "<script>alert('���� ������ �����ϴ�.');</script>";
		exit;
	}

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
<table width="650" border="0" cellspacing="0" cellpadding="0" align="left">
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
								<td style="padding:0px 0px 0px 3px"><img src="../../images/sub03/btn_next.gif" alt="������" onclick="location.href='<?=$_SERVER['PHP_SELF']?>?pno=<?=$pno?>&toYear=<?=$mNextYear?>&toMonth=1&gubun=<?=$gubun?>&msChk=<?=$msChk?>&search=<?=$search?>&keyword=<?=$keyword?>&edu_kind=<?=$edu_kind?>'" style="cursor:hand"	 ></td>
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
			<table width="614" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<!---����Ʈ--->
						<table width="614" border="0" align="center" cellpadding="1" cellspacing="0">
						<?
							$mDays=0;
							for($mRows = 0;$mRows < $mSetRows;$mRows++){
								echo "<TR>";
								for($mCols = 1;$mCols < 8;$mCols++){
									echo "<td width='86' valign='top'>";
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
	<? 
		if(trim($wdate)){ 

			$query	= "SELECT * FROM ona_030401 WHERE wdate='$wdate' ORDER BY idx";
			//echo $query;
			$result	= mysql_query($query);
			$nums	= @mysql_num_rows($result);

			if(!$total_count){ $total_count = 100; }

			if ($page == ""){ $page = "1"; }
			$url				= $PHP_SELF;
			$total_page	= ceil($nums/$total_count);
			$set_page 	= $total_count * ($page-1);
			$list_page 	= 10;
			$last 			= $page * $total_count;

			$paging		= common_paging($url,$nums,$page,$list_page,$total_count);
			if ($last > $nums){ $last = $nums; }
	?>
	<tr>
		<td align="left" style="padding:10 0 0 10">��¥ : <b><?=$wdate?></b></td>
	</tr>
	<tr>
		<td style="padding:10px">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td height="2" colspan="5" class="bline1"></td>
							</tr>
							<tr>
								<td width="5%" align="center" class="btitle1">��ȣ</td>
								<td width="10%" align="center" class="btitle1">�ڳ��</td>
								<td width="10%" align="center" class="btitle1">�б޸�</td>
								<td width="10%" align="center" class="btitle1">�Ͱ�����</td>
								<td width="10%" align="center" class="btitle1">��û�Ͻ�</td>
							</tr>
							<tr>
								<td height="1" colspan="5" class="bline2"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>
						<?						
							$no = $nums - $set_page;

							if ($nums){
								for ($i = $set_page; $i < $last; $i++){
								@mysql_data_seek($result,$i);
								$row= mysql_fetch_array($result);								
						?>				
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="5%" align="center" class="bcontent"><?=$no?></td>
								<td width="10%" align="center" class="bcontent"><?=$row[childName]?></td>
								<td width="10%" align="center" class="bcontent"><?=$arrClass[$row[childClass]]?><?=$row[childClass2]?", ".$arrClass[$row[childClass2]]:""?></td>
								<td width="10%" align="center" class="bcontent"><?=$row[childTime]?></td>
								<td width="10%" align="center" class="bcontent"><?=date("Y.m.d", $row[regdate]);?></td>
							</tr>						
							<? if($row[childMemo]){ ?>
							<tr>
								<td colspan="5" class="bcontent" style="padding:5 5 5 110">
									<table width="100%" border="0" cellspacing="1" cellpadding="0" bgColor="#EFEFEF">
										<tr>
											<td bgColor="#FFFFFF" style="padding:5px"><?=nl2br($row[childMemo])?></td>
										</tr>
									</table>								
								</td>
							</tr>							
							<? } ?>
							<tr>
								<td height="1" colspan="5" class="bline3"></td>
							</tr>
						</table>
						<?
								$no = $no-1;
								}
							}else{ // �Խù��� ������
								if($nums < "1"){
						?>
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="center" class="bcontent"><font color="#444444">�Խù��� �����ϴ�.</font></td>
							</tr>
							<tr>
								<td height="1" colspan="4" class="bline3"></td>
							</tr>
						</table>
						<?	  }
							}
						?>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	<? } ?>
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
?>
<table width="86" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td><img src="../../images/sub03/box2_top.gif"></td>
	</tr>
	<tr>
		<td height="60" valign="top" background="../../images/sub03/box2_bg.gif">
			<table width="75" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td class="<?=$dayClass?>"><?=$mSCH['day']?></td>
				</tr>
				<tr>
					<td height="60" valign="middle" align="center" class="moon_02">
					<?	
						$today = date("Y-m-d",$today);
						$query	= "SELECT count(*) FROM ona_030401 WHERE wdate='".$today."'";
						//echo $query;
						$result	= mysql_query($query);
						$row		= @mysql_fetch_array($result);
						$cnt = $row[0]==0?'':number_format($row[0]);
						echo "<span onClick=\"location.href('/ewhaMaster/030401/list.php?wdate=$today')\" style='cursor:pointer'> <b>".$cnt."</b></span><br>";
					?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td><img src="../../images/sub03/box2_bottom.gif"></td>
	</tr>
</table>
<?
    }
?>