<?
$counter[FROM_DAYS] = 30;	
if ($counter[FROM_DAYS] > 0) {
	$sql = sprintf("DELETE FROM gs_counter_ref WHERE (DATE_ADD(REFER_DATE, INTERVAL %d DAY) < sysdate())", $counter[FROM_DAYS]);
	//DebugStr($sql);
	mysql_query($sql);
	mysql_query("OPTIMIZE TABLE gs_counter");
	mysql_query("OPTIMIZE TABLE gs_counter_rank");
	mysql_query("OPTIMIZE TABLE gs_counter_ref");
}
	if ($mode=="referer") { //============================================================ ���Ӱ��?>

	<?if ($reftype=="all") { //==================== ��ü���
		if ($kt && $ks) $wsql = "WHERE $kt LIKE '%$ks%'";

		$list_num = sqlRowOne("select count(UID) from gs_counter_ref $wsql");
		if ($list_num > 0) {
			if(!$total_count){ $total_count = 50; }

			if ($page == ""){ $page = "1"; }				
			$url				= $PHP_SELF."?mode=referer&reftype=$reftype&cyear=$cyear&cmonth=$cmonth&cday=$cday";
			$total_page	= ceil($list_num/$total_count);
			$set_page 	= $total_count * ($page-1);
			$list_page 	= 10;
			$last 			= $page * $total_count;

			$paging		= common_paging($url,$list_num,$page,$list_page,$total_count);
			if ($last > $list_num){ $last = $list_num; }

			$sql = "SELECT * FROM gs_counter_ref $wsql ORDER BY UID DESC limit $set_page, $total_count";
			//DebugStr($sql);
			$rs = sqlArray($sql);
			$CurrentNo = $list_num - (($page-1) * $total_count);
		}
		?>
		<!------------------------ ��ü ���� ��� ------------------------->
		<table width="<?=$TOTWIDTH?>"" border=0 cellspacing=1 cellpadding=2 align=center>
			<tr>
				<td height=24><?if ($list_num > 0) echo"$paging[paging]";?></td>
				<td align=right nowrap><?if ($list_num > 0) {?>�� �˻���� : <b><?=$list_num?></b>��, <b><?=$page?></b>/<b><?=$total_page?></b>������<?}?></td>
			</tr>
		</table>
		<table width="<?=$TOTWIDTH?>" border=0 cellspacing=1 cellpadding=3 style="table-layout:fixed" class=line_lt align=center>
			<col width=50></col><col width=120></col><col width=100></col><col width=130></col><col width=></col>
			<tr align=center>
				<td class=list_hd>NO</td>
				<td class=list_hd>�����Ͻ�</td>
				<td class=list_hd>����IP</td>
				<td class=list_hd>����ȣ��Ʈ</td>
				<td class=list_hd><a class=button href="<?=$PHP_SELF?>?mode=referer&cyear=<?=$cyear?>&cmonth=<?=$cmonth?>&cday=<?=$cday?>"><b>���Ӱ��[��躸��]</b></a></td>
			</tr>
			<?if ($list_num > 0) foreach($rs as $v) { $tref = split("/", $v[REFERER]); ?>
			<tr class=content>
				<td nowrap align=center><?=$CurrentNo?></td>
				<td nowrap><?=$v[REFER_DATE]?></td>
				<td nowrap><a href="http://<?=$v[IP]?>" target="_blank"><?=$v[IP]?></a></td>
				<td><a href="http://<?=$v[HOST]?>" target="_blank"><?=$v[HOST]?></a></td>
				<td nowrap align=left style="word-break:break-all;"><a href="<?=$v[REFERER]?>" target="_blank"><?if ($v[REFERER]) { echo($v[REFERER]); } //echo("http://$tref[2]");?></a></td>
			</tr>
			<?$CurrentNo--; } unset($rs);?>
		</table>

	<?} else { //==================== �����

		$trs = sqlRow("SELECT count(*) as TI, sum(HIT) as TOTHIT FROM gs_counter_ref_rank");
		$list_num = $trs[TI];
		$TOT = $trs[TOTHIT];
		unset($trs);
		if ($list_num > 0) {
			if(!$total_count){ $total_count = 50; }

			if ($page == ""){ $page = "1"; }				
			$url				= $PHP_SELF."?mode=referer&reftype=$reftype&cyear=$cyear&cmonth=$cmonth&cday=$cday";
			$total_page	= ceil($list_num/$total_count);
			$set_page 	= $total_count * ($page-1);
			$list_page 	= 10;
			$last 			= $page * $total_count;

			$paging		= common_paging($url,$list_num,$page,$list_page,$total_count);
			if ($last > $list_num){ $last = $list_num; }

			$sql = "SELECT * FROM gs_counter_ref_rank ORDER BY HIT DESC limit $set_page, $total_count";
			//DebugStr($sql);
			$rs = sqlArray($sql);
			$CurrentNo = ($page-1) * $total_count + 1;
		}
		?>
		<!------------------------ ���� ��� ��� ------------------------->
		<table width="<?=$TOTWIDTH?>"" border=0 cellspacing=1 cellpadding=2 align=center>
			<tr>
				<td height=24><?if ($list_num > 0) echo"$paging[paging]";?></td>
				<td align=right nowrap><?if ($list_num > 0) {?>�� �˻���� : <b><?=$list_num?></b>��, <b><?=$page?></b>/<b><?=$total_page?></b>������<?}?></td>
			</tr>
		</table>
		<table width="<?=$TOTWIDTH?>" border=0 cellspacing=1 cellpadding=3 style="table-layout:fixed" class=line_lt align=center>
			<col width=50></col><col width=></col><col width=80></col><col width=140></col><col width=50></col><col width=300></col>
			<tr>
				<td class=list_hd align=center>����</td>
				<td class=list_hd align=center>���Ӱ��</td>
				<td class=list_hd align=center>���Ӽ�</td>
				<td class=list_hd align=center>�ֱ�����</td>
				<td class=list_hd align=center>����</td>
				<td class=list_hd align=center><a class=norm href="<?=$PHP_SELF?>?mode=referer&reftype=all&cyear=<?=$cyear?>&cmonth=<?=$cmonth?>&cday=<?=$cday?>"><b>���Ӱ��[��ü����]</b></a></td>
			</tr>
			<?if ($list_num > 0) foreach($rs as $v) {?>
			<tr class=content align=center>
				<td nowrap><b><?=$CurrentNo?></b></td>
				<td align=left nowrap><?if ($v[REFERER_SITE]=="") {?><b>���ã��(�Ǵ� ����������)�� ��������</b><?} else {?><a href="<?=$v[REFERER_SITE]?>" target="_blank"><span style="color:#F45C00;"><b><?=$v[REFERER_SITE]?></b></span></a><?}?></td>
				<td nowrap><span class=warning><b><?=number_format($v[HIT])?></b></span></td>
				<td nowrap><span class=green><?=$v[REFER_DATE]?></span></td>
				<td nowrap align=right><span class=dark><?=round(($v[HIT]/$TOT)*100, 2);?>%</span>&nbsp;</td>
				<td nowrap align=left><span class="filterwhitegreen" width=<?=intval(($v[HIT]/$TOT)*300);?> height=10><script></script></span></td>
			</tr>
			<?$CurrentNo++; } unset($rs);?>
		</table>

	<?}?>

	<!------------------------ ��ü ���� ��� �˻� ------------------------->
	<form action="<?=$PHP_SELF?>">
	<input type=hidden name=reftype value="all">
	<input type=hidden name=mode value="referer">
	<input type=hidden name=cyear value="<?=$cyear?>">
	<input type=hidden name=cmonth value="<?=$cmonth?>">
	<input type=hidden name=cday value="<?=$cday?>">
	<table width="<?=$TOTWIDTH?>"" border=0 cellspacing=1 cellpadding=2 align=center>
		<tr>
			<td height=24 nowrap valign=top><?if ($list_num > 0) echo"$paging[paging]";?></td>
			<td align=right height=24 nowrap valign=top>
				<?$trs = Array("IP"=>"���� IP", "HOST"=>"����ȣ��Ʈ", "REFERER"=>"���Ӱ��");?>
				<select name="kt">
				<?foreach($trs as $k => $v){?>
				<option value="<?=$k?>" <?=$kt==$v?"selected":""?>><?=$v?>
				<?}?>
				</select>
				<input type=text name=ks size=15 value="<?=$ks?>">
				<input class=norm type=submit value=" �˻� ">
			</td>
		</tr>
		<tr><td colspan=2 height=50 align=center>
			<table border=0>
				<tr><td>
					�� REFERER �׸��� ����ִ� ���� ���ã�⳪ URL�� ���� �Է��Ͽ� ������ ����Դϴ�.<br>
					�� ���ӷ�Ʈ������ �ֱ� <?=$counter[FROM_DAYS]?>�ϱ��� ������ �Ǹ� �Ⱓ�� ������ �ڵ����� �����˴ϴ�.<br>
					�� ���Ӱ�ο� ���ӷ�Ʈ, ������踦 �ʱ�ȭ �Ͻ÷��� [<a href="mb_counter_proc.php?act=initlog" onclick="return confirm('��� ������踦 �ʱ�ȭ �Ͻðڽ��ϱ�?\n\n��� �����͸� �����ϸ� ������ �ڷ�� ������ �Ұ����մϴ�.');"><b style="color:#000075;">��� �ʱ�ȭ</b></a>]�� Ŭ���ϼ���.<br>
					�� ���Ӱ�θ� �ʱ�ȭ �Ͻ÷��� [<a href="mb_counter_proc.php?act=initref" onclick="return confirm('���Ӱ�θ� �ʱ�ȭ �Ͻðڽ��ϱ�?\n\n��� �����͸� �����ϸ� ������ �ڷ�� ������ �Ұ����մϴ�.');"><b style="color:#000075;">�ʱ�ȭ</b></a>]�� Ŭ���ϼ���. (���Ӱ�θ� �ʱ�ȭ�Ǹ� �ٸ� ���� �����˴ϴ�)
				</td></tr>
			</table>
		</td></tr>
		<tr><td colspan=2 height=1 bgcolor="#cccccc"></td></tr>
	</table>
	</form>

<?}?>