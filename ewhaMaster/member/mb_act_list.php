<?
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// �α��� üũ

	if($_SESSION['member_level'] < 9){
		echo "<script>alert('���� ������ �����ϴ�.');</script>";
		exit;
	}

	$tableName		= "gs_act_list";
	$_ACT_ARR = sqlArray("select idx, name from gs_act_list order by idx asc");
	
	$mode = trim($_POST['mode']);
	$idx = trim($_POST['idx']);
	$name = trim($_POST['name']);
	
	if($mode=="insert"){
		$query = "insert into $tableName set name = '$name', regdate = now()";
		mysql_query($query);
		echo "<script>parent.location.reload();</script>";
		exit;
	}
	
	if($mode=="modify"){
		$query = "update $tableName set name = '$name', regdate= now() where idx='$idx'";
		mysql_query($query);
		echo "<script>parent.location.reload();</script>";
		exit;
	}
	
	if($mode=="delete"){
		$query = "delete from $tableName where idx='$idx'";
		mysql_query($query);
		echo "<script>parent.location.reload();</script>";
		exit;
	}

?>
<style type="text/css">
input.norm { width:60px; height:20px; border:1px outset #cccccc; background-color:#ffffff; cursor:pointer; }
input.sel  { width:60px; height:20px; border:1px outset #cccccc; background-color:#F1E650; cursor:pointer; }
.line_lt 		{ background-color:#CCCCCC; } /* Light Line */
.list_hd 		{ background-color:#EEEEEE; color:#8080C0; } /* List Header 1 */
.content 		{ background-color:#FFFFFF; } /* Content */
a, a:visited			{ color:#8080FF; text-decoration:none; }
a:hover, a:active	{ color:#000075; text-decoration:underline; }
.searchbar	{ background-color:#efefef; } /* Search Bar */
* { font-family:����; font-size:12px; line-height:150%; }
</style>
<script language='javascript' src='/include/js/func.js'></script>
<script>
function checkActListForm(form){
	if(form.mode.value=="insert"){
		if(!form.name.value){alert("�ü��� �Է��� �ּ���.");form.name.focus();return false;}
	}
	if(form.mode.value=="modify"){
		if(!form.name.value){alert("�ü��� �Է��� �ּ���.");form.name.focus();return false;}
	}
	return true;
}
function checkDelete(form){
	if(confirm("���� ���� �Ͻðڽ��ϱ�?")){
		form.mode.value="delete";
		form.submit();
	}
}
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr height=30>
    <td bgcolor=#ececec>&nbsp;&nbsp;<b>�� �ü�����</b></td>
  </tr>
  <tr>
    <td height="15"></td>
  </tr>
  <tr height=30>
    <td ><input type="button" value="ȸ���ü��̿�" class="norm" style="width:100px;" onclick="location='mb_act.php';"></td>
  </tr>
</table>

<table align="left" border=0 cellpadding=0 cellspacing=1 bgcolor="#CCCCCC" style="padding-left:10px;padding-right:10px;">
<input type="hidden" name="name" value="" onsubmit="return checkActListForm(this)">
	<tr bgcolor="#EEEEEE" height="30">
		<td>��ȣ</td>
		<td>�ü�</td>
		<td>���</td>
	</tr>
<?if($_ACT_ARR) foreach($_ACT_ARR as $k => $v){?>
<form name="actListForm" method="post" target="iframe">
<input type="hidden" name="mode" value="modify">
<input type="hidden" name="idx" value="<?=$v[idx]?>">
	<tr bgcolor="#FFFFFF" height="30">
		<td><?=$v[idx]?></td>
		<td><input type="text" name="name" value="<?=$v[name]?>" class="input" style="ime-mode:active;"></td>
		<td><input type="submit" value="����" class="norm"><input type="button" value="����" class="norm" onclick="checkDelete(this.form)"></td>
	</tr>
</form>
<?}?>
<form name="actListForm" method="post" onsubmit="return checkActListForm(this)" target="iframe">
<input type="hidden" name="mode" value="insert">
	<tr bgcolor="#FFFFFF" height="30">
		<td>New</td>
		<td><input type="text" name="name" value="" class="input" style="ime-mode:active;"></td>
		<td><input type="submit" value="���" class="norm"></td>
	</tr>
</form>
</table>