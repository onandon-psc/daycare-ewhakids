<?
	include "../../ewhaMaster/common/admin_login_check2.php";

	$idx	 =	 trim($_POST[idx]);

	$query	= "SELECT * FROM ona_application WHERE idx='".$idx."' ORDER BY idx DESC";
	//echo $query;
	$result	= mysql_query($query);
	$row	 	= mysql_fetch_array($result);

	if(!$_SESSION[masterSession]) {
		if($_SESSION[member_id] != $row[mbId])
		{
			echo "<script>alert('ȸ�������� ��ġ���� �ʽ��ϴ�!!!');location.href='/html/sub/index.php?pno=060301'</script>";
			exit;
		}
	}

?>

<script>
function delete_check(){
	if(confirm('�����Ͻðڽ��ϱ�?')){
		document.getElementsByName('delete_form')[0].submit();
	}
}
function modify(idx){
	document.modify_form.modify_idx.value = idx;
	document.modify_form.submit();
}
</script>
<? if($_SESSION[masterSession]) { ?>
<form name="modify_form" method="get" action='http://ewhakids.or.kr/ewhaMaster/sub/index.php'>
<input type="hidden" name="msChk" value="master">
<input type="hidden" name="pno" value="060201">
<input type="hidden" name="modify_idx" value="">
<input type="hidden" name="childAge" value="<?=$childAge?>">
<input type="hidden" name="page" value="<?=$page?>">
</form>
<? } else { ?>
<form name="modify_form" method="get" action='http://ewhakids.or.kr/html/sub/index.php'>
<input type="hidden" name="msChk" value="">
<input type="hidden" name="pno" value="060201">
<input type="hidden" name="modify_idx" value="">
<input type="hidden" name="childAge" value="<?=$childAge?>">
<input type="hidden" name="page" value="<?=$page?>">
</form>
<? } ?>

<form name=delete_form method=post action='/html/sub06/060201_proc.php' target="iframe">
<input type=hidden name=idx value='<?=$idx;?>' >
<input type=hidden name=send value='delete' >
<input type="hidden" name="childAge" value="<?=$childAge?>">
<input type="hidden" name="page" value="<?=$page?>">
</form>

<table width="655" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td style="padding-bottom:26px;"> </td>
	</tr>
	<tr>
		<td align="center"> </td>
	</tr>
	<tr>
		<td align="center">
			<table border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td style="padding-bottom:26px;"> </td>
				</tr>
				<tr>
					<td>
						<!---�����Է�--->
						<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableA">
							<tr>
							<?
								$waittype = '';
								if(strpos($row[waittype],'14')===false){
								}
								else
								{
									$waittype .= '2014�� �����';
								}

								if(strpos($row[waittype],'15')===false){
								}
								else
								{
									if($waittype != '')
									{
										$waittype .= ', 2015�� ������';
									}
									else
									{
										$waittype .= '2015�� ������';
									}
								}
							?>
								<td width="143" class="input_tit">�Լ������</td>
								<td width="513" class="input_item"><?=$waittype?>&nbsp;</td>
							</tr>
							<tr>
								<td width="143" class="input_tit">�ڳ��</td>
								<td width="513" class="input_item"><?=$row[childName]?>&nbsp;</td>
							</tr>
							<? if($row[childBirth] != '') { ?>

							<tr>
								<td class="input_tit">�������</td>
								<td class="input_item"><?=$row[childBirth]?>&nbsp;</td>
							</tr>
							<? } else { ?>
							<tr>
								<td class="input_tit">�������</td>
								<td class="input_item"><?=substr($row[childJumin],0,6)?>&nbsp;</td>
							</tr>
							<? } ?>
							<?
							  $temp_sex = '';
							  if($row[sex] == '1')
							  {
								  $temp_sex = '��';
							  }
							  else if($row[sex] == '2')
							  {
								  $temp_sex = '��';
							  }
							  else
							  {
								  $temp_sex = '���Է�';
							  }
							?>
							<tr>
								<td class="input_tit">����</td>
								<td class="input_item"><?=$temp_sex?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">�θ��</td>
								<td class="input_item"><?=$row[parentName]?>&nbsp;</td>
							</tr>
							<?
								$tmp_app = '';

								if($row[class3] == '1')
								{
									$tmp_app = '��ȸ ������';
								}
								else if($row[class3] == '3')
								{
									$tmp_app = '������ �ٷ��� �� �����Ļ��ü� ������';
								}
								else if($row[class3] == '5')
								{
									$tmp_app = '�ǿ��� ���� �� ��ȸ�� �Ⱓ�� �ٷ��� �� ��ȸ�� ���� ��������� �� 6���� �̻� ������Ա���';
								}
								else if($row[class3] == '7')
								{
									$tmp_app = '��ȸ�� ���־�ü ������';
								}
								else if($row[class3] == '9')
								{
									$tmp_app = '��ȸ ������ �����޴� ���� �� ��ü ������';
								}
							?>
							<tr>
								<td class="input_tit">�ԼҴ�� </td>
								<td class="input_item"><?=$tmp_app?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">�ҼӺ�ó1 </td>
								<td class="input_item"><?=$row[class1]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">�ҼӺ�ó2</td>
								<td class="input_item"><?=$row[class2]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">����</td>
								<td class="input_item"><?=$row[position1]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">����</td>
								<td class="input_item"><?=$row[position2]?>&nbsp;</td>
							</tr>
							<?
								$tmp_ht = explode(",",$row[homeType]);
								foreach( $tmp_ht as $v)
								{
									switch($v){
										case "0��" :
											$tmp_hometype[] = "�������";
											break;
										case 'a' :
											$tmp_hometype[] = "�Ѻθ�";
											break;
										case 'b' :
											$tmp_hometype[] = "���ҵ�";
											break;
										case 'c' :
											$tmp_hometype[] = "�θ����";
											break;
										case 'd' :
											$tmp_hometype[] = "�ڳ��� �������";
											break;
										case 'e' :
											$tmp_hometype[] = "�ٹ�ȭ ����";
											break;
										case 'f' :
											$tmp_hometype[] = "���հ���";
											break;
										case 'g' :
											$tmp_hometype[] = "�¹���";
											break;
										case 'h' :
											$tmp_hometype[] = "���ڳ� �� ���ڳ�";
											break;
										case 'i' :
											$tmp_hometype[] = "��Ÿ���ҵ�(3,4��)";
											break;
										case 'j' :
											$tmp_hometype[] = "�Ծ�����";
											break;
										case 'k' :
											$tmp_hometype[] = "�������";
											break;
										case 'l' :
											$tmp_hometype[] = "�ش����";
											break;
									}
								}
								$tmp_hometype = implode(", ",$tmp_hometype);
							?>
							<tr>
								<td class="input_tit">�����з�</td>
								<td class="input_item"><?=$tmp_hometype?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">��⳯¥</td>
								<td class="input_item"><?=date("Y-m-d",$row[regdate])?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">������ȣ</td>
								<td class="input_item"><?=$row[telephone]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">�ڵ��� ��ȣ </td>
								<td class="input_item"><?=$row[mobile]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit">�̸���</td>
								<td class="input_item"><?=$row[email]?>&nbsp;</td>
							</tr>
							<tr>
								<td class="input_tit" style="border-bottom:none;">������� ��������<br>
									�̸�/������� </td>
								<td class="input_item" style="border-bottom:none;">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td style="padding:0px 0px 5px 0px">- �̸� : <?=$row[recordName]?><br>- ������� : <?=$row[recordBirth]?>&nbsp;</td>
										</tr>										
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
					<input type="hidden" name="pno" value="<?=$pno?>">
					<input type="hidden" name="childAge" value="<?=$childAge?>">
					<input type="hidden" name="page" value="<?=$page?>">
					<input type="hidden" name="search" value="<?=$search?>">
					<input type="hidden" name="keyword" value="<?=$keyword?>">
				<tr>
					<td class="button">
					<? if($_SESSION[masterSession]) { ?>
						<input type="image" src="../../images/sub06/btn_ok.gif" align="absmiddle" alt="���" hspace="5" style="cursor:pointer" />
						&nbsp;&nbsp;
						<span style='border:1px solid #aaaaaa; padding:3 7 2 7'><a href="javascript:modify('<?=$idx;?>');">����</a></span>
						&nbsp;&nbsp;
						<span style='border:1px solid #aaaaaa; padding:3 7 2 7'><a href='javascript:delete_check();'>����</a></span>
					<? } else { ?>
						<input type="image" src="../../images/sub06/btn_ok.gif" align="absmiddle" alt="���" hspace="5" style="cursor:pointer" />
						&nbsp;&nbsp;
						<span style='border:1px solid #aaaaaa; padding:3 7 2 7'><a href="javascript:modify('<?=$idx;?>');">����</a></span>
						&nbsp;&nbsp;
						<span style='border:1px solid #aaaaaa; padding:3 7 2 7'><a href='javascript:delete_check();'>����</a></span>
					<? } ?>
					</td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
</table>