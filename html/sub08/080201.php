<?
	if($_SESSION["member_id"]){
		$row = mysql_fetch_array(mysql_query("select * from ona_member where mbId = '".$_SESSION["member_id"]."' and mbStatus!='C'"));
	}else{
		goBack("�α����� �̿��Ͽ� �ּ���.");
	}
?>
<script language="javascript">
<!--
	function inputCheck(f){
		if(!f.mbPwd.value){
			alert('��й�ȣ�� �Է��ϼ���');
			f.mbPwd.focus();			
			return false;
		}
		if(!f.contents.value){
			alert('Ż������� �Է��ϼ���');
			f.contents.focus();			
			return false;
		}
		if(confirm('ȸ�� Ż���Ͻðڽ��ϱ�?\nŻ��� ȸ������ ������ �����˴ϴ�.')){
			return;
		}else{
			return false;
		}
	}
//-->
</script>
<table border="0" cellpadding="0" cellspacing="0">

<form method="post" action="../sub08/080201_proc.php" onSubmit="return inputCheck(this);" target="iframe">
	<input type="hidden" name="mbId" value="<?=$_SESSION[member_id]?>">

	<tr>
		<td style="padding-bottom:26px;"> </td>
	</tr>
	<tr>
		<td><img src="../../images/sub08/img_01.gif" /></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="tit_lv1"><img src="../../images/sub08/stitle_01.gif" width="48" height="15" /></td>
	</tr>
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tableA">				
				<tr>
					<td width="152" class="input_tit">����</td>
					<td width="503" class="input_item"><?=$row[mbName]?></td>
				</tr>
				<tr>
					<td class="input_tit">��й�ȣ</td>
					<td class="input_item">
						<input name="mbPwd" type="password" class="input" id="textfield2" style="width:150px" />
					</td>
				</tr>
				<tr>
					<td class="input_tit" style="border-bottom:none;">Ż�����</td>
					<td class="input_item" style="border-bottom:none;">
						<textarea name="contents" style="width:100%;height:100px;IME-MODE:active;"></textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" style="padding:18px 0px 0px 0px"> <input type="image" src="../../images/sub08/btn_01.gif" alt="�α���" width="59" height="19" border="0" /> <img src="../../images/member/btn_cancel02.gif" alt="���" border="0" onClick="history.back();" style="cursor:pointer"></td>
	</tr>

</form>

</table>