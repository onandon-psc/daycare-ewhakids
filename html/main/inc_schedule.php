<?
	if($load == "Y"){ //ajax���� ȣ���������� ǥ��

		header("content-type:text/xml; charset=euc-kr");
		// ������ ����
		$DIR[root]          = "../../";

		// �����ͺ��̽� ����
		$DB[host]	= "localhost";
		$DB[user]	= "gskids";
		$DB[name]	= "gskids";
		$DB[pwd]	= "~gskids";

		include $DIR[root]."include/db/connect.php";
		include $DIR[root]."include/global/func.php";
		$db = dbConnect($DB[host],$DB[user],$DB[name],$DB[pwd]);	

	}
	/********** ����� ������ **********/
	$mStartYear=date("Y");
	$mEndYear=date("Y")+4;

	/**********�Է°�**********/
	if($mMonth>12){
		$mYear++;
		$mMonth = 1;
	}
	if($mMonth=="0"){
		$mYear--;
		$mMonth = 12;
	}


	if(!$mYear) $mYear=date("Y");
	if(!$mMonth) $mMonth=date("m");
	if(!$mToDay) $mToDay=date("d");

	/**********��갪**********/
	$mktime=mktime(0,0,0,$mMonth,1,$mYear);//�ԷµȰ����γ�-��-01�������
	$mLastDay=date("t",$mktime);//������year��month����������ϼ����ؿ���
	$mStartDay=date("w",$mktime);//���ۿ��Ͼ˾Ƴ���

	//�������ϼ����ϱ�
	$mPrevDayCount=date("t",mktime(0,0,0,$mMonth,0,$mYear))-$mStartDay+1;

	$mNowDayCount=1;//�̹�������ī����
	$mNextDayCount=1;//����������ī����

	//�޷¿� ǥ�õ� ���� ����
	$mDays = 0;
	for($week = 0; $week < $mStartDay; $week ++) { // �ش���� ó�� ������ �Ǳ� �� ���� �߰�.
		$arrSCH[$mDays]['day'] = "&nbsp";
		$arrSCH[$mDays]['gubun'] = "";
		$arrSCH[$mDays]['edutype'] = "";
		$arrSCH[$mDays]['eduidx'] = "";
		$mDays++;
	}

	for($schDay = 1; $schDay <= $mLastDay; $schDay ++) {
		$arrSCH[$mDays]['day'] = $schDay;
		$arrSCH[$mDays]['gubun'] = "";
		$arrSCH[$mDays]['edutype'] = "";
		$arrSCH[$mDays]['eduidx'] = "";
		$mDays++;
	}

	// ����� ���
	$mSetRows = ceil(($mDays) / 7 );

	//�ش糯�ڿ� ������ó��
	$mWhere .= " where edu_kind in ('�����ڱ���','�θ���','��¦������','�������ȳ�') && from_unixtime(edu_sdate,'%Y')='$mYear' && from_unixtime(edu_sdate,'%m')='".codeNumber($mMonth)."'";
	$sql	= "SELECT idx,gubun,title,eTime,from_unixtime(edu_sdate,'%m') as smon,from_unixtime(edu_sdate,'%d') as sday, from_unixtime(edu_edate,'%m') as emon,";
	$sql .= " from_unixtime(edu_edate,'%d') as eday from ddm_edu_main";
	$sql .= $mWhere;
	$sql .= " order by edu_sdate asc";
	$result = @mysql_query($sql);
	while($rs=@mysql_fetch_array($result)){
		$mArrDay = $mStartDay + $rs['sday'] -1;
		$arrSCH[$mArrDay]['gubun'][] = $rs['gubun'];
		$arrSCH[$mArrDay]['title'][] = $rs['title'];
		$arrSCH[$mArrDay]['eTime'][] = $rs['eTime'];
	}
?>
<script type="text/javascript" src="/include/js/osAjax.js"></script>
<script language="JavaScript">
	function MoveMonth(params)
	{
		var url = "inc_schedule.php";
		params += "&load=Y";
		aComplete(url, params, 'post', 'text', Move_Complete);
		return false;
	}

	function Move_Complete( req )
	{
		$i('Main_Schedule_Cal').innerHTML = req;
	}

	function TodayView(para){	
		schedule_today.location.href="inc_schedule_today.php?"+para;
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="3"><img src="/images/main/main_boxA_img.gif"></td>
	</tr>
	<tr>
		<td class="main_boxA_01"></td>
		<td class="main_boxA_02"></td>
		<td class="main_boxA_03"></td>
	</tr>
	<tr>
		<td class="main_boxA_04"></td>
		<td class="main_boxA_05" style="padding:7px 0px 7px 0px;">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding:0px 2px 9px 2px;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td>
									<table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td style="padding-right:7px;"><img src="/images/main/number_gray_<?=intval(substr($mYear,0,1))?>.gif"><img src="/images/main/number_gray_<?=intval(substr($mYear,1,1))?>.gif"><img src="/images/main/number_gray_<?=intval(substr($mYear,2,1))?>.gif"><img src="/images/main/number_gray_<?=intval(substr($mYear,3,1))?>.gif"></td>
											<td><img src="/images/main/month_prev.gif" border="0" align="absmiddle" onclick="MoveMonth('mYear=<?=$mYear?>&mMonth=<?=$mMonth-1?>')" style="cursor:pointer"></td>
											<td width="50" align="center"><img src="/images/main/number_orenge_<?=date("m",$mktime)?>.gif" align="absmiddle"></td>
											<td><img src="/images/main/month_next.gif" border="0" align="absmiddle" onclick="MoveMonth('mYear=<?=$mYear?>&mMonth=<?=$mMonth+1?>')" style="cursor:pointer"></td>
										</tr>
									</table>
								</td>
								<td valign="top" class="right" style="padding-top:1px;"><img src="/images/main/title_calendar.gif"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td class="center"><img src="/images/main/calendar_img.gif"></td>
				</tr>
				<tr>
					<td>
						<table border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#FFFFFF" >
							<?
								$mDays=0;
								if(intval($mMonth) < 10){ $mMonth = "0".intval($mMonth); }
								for($mRows = 0;$mRows < $mSetRows;$mRows++){
									echo "<TR>";
									for($mCols = 1;$mCols < 8;$mCols++){					
										
										$classType = "main_date text11_gray center";
										/*
										for($i=0;$i<sizeof($arrSCH[$mDays]['gubun']);$i++){
											if($arrSCH[$mDays]['gubun'][$i]) $classType = "mdate100";
										}
										*/
										$GET_Day = codeNumber($arrSCH[$mDays]['day']);
										// ����ǥ��
										if(($mYear.$mMonth.$GET_Day)==date("Ymd")) $classType = "main_date_on text11_white center";
										echo "<td height='17' class='".$classType."'>".$arrSCH[$mDays]['day']."</td>";										
										$mDays++;
									}
									echo "</TR>";
								}
							?>					
						</table>						
					</td>
				</tr>
			</table>
		</td>
		<td class="main_boxA_06"></td>
	</tr>
	<tr>
		<td colspan="3" class="main_boxA_10"></td>
	</tr>
	<tr>
		<td class="main_boxA_04"></td>
		<td class="main_boxA_05" style="padding:8px 0px 3px 6px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="main_date_tit text11_gray2 bold"><?=$mMonth?>�� <?=$mToDay?>��</td>
				</tr>				
				<tr>
					<td class="text11_gray">
						<script language="javascript">
						<!--
						//�Ʒ� ����ǥ iframe ������¡ ��Ű��
						function resizeIframe(fr) {
							fr.setExpression('height',schedule_today.document.body.scrollHeight);
						}
						//-->
						</script>
						<IFRAME name="schedule_today" id="schedule_today" src="inc_schedule_today.php?toYear=<?=$mYear?>&toMonth=<?=codeNumber($mMonth)?>&today=<?=$mToDay?>" width="200" height="30" frameborder="0" scrolling="no" onload="resizeIframe(this)"></IFRAME>
					</td>
				</tr>			
			</table>
		</td>
		<td class="main_boxA_06"></td>
	</tr>
	<tr>
		<td class="main_boxA_07"></td>
		<td class="main_boxA_08"></td>
		<td class="main_boxA_09"></td>
	</tr>
</table>