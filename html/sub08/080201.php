<?
	if($_SESSION["member_id"]){
		$row = mysql_fetch_array(mysql_query("select * from ona_member where mbId = '".$_SESSION["member_id"]."' and mbStatus!='C'"));
	}else{
		goBack("로그인후 이용하여 주세요.");
	}
?>
<script language="javascript">
<!--
	function inputCheck(f){
		if(!f.mbPwd.value){
			alert('비밀번호를 입력하세요');
			f.mbPwd.focus();			
			return false;
		}
		if(!f.contents.value){
			alert('탈퇴사유를 입력하세요');
			f.contents.focus();			
			return false;
		}
		if(confirm('회원 탈퇴하시겠습니까?\n탈퇴시 회원님의 정보가 삭제됩니다.')){
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
					<td width="152" class="input_tit">성명</td>
					<td width="503" class="input_item"><?=$row[mbName]?></td>
				</tr>
				<tr>
					<td class="input_tit">비밀번호</td>
					<td class="input_item">
						<input name="mbPwd" type="password" class="input" id="textfield2" style="width:150px" />
					</td>
				</tr>
				<tr>
					<td class="input_tit" style="border-bottom:none;">탈퇴사유</td>
					<td class="input_item" style="border-bottom:none;">
						<textarea name="contents" style="width:100%;height:100px;IME-MODE:active;"></textarea>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td align="center" style="padding:18px 0px 0px 0px"> <input type="image" src="../../images/sub08/btn_01.gif" alt="로그인" width="59" height="19" border="0" /> <img src="../../images/member/btn_cancel02.gif" alt="취소" border="0" onClick="history.back();" style="cursor:pointer"></td>
	</tr>

</form>

</table>