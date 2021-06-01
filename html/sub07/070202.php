<?
	if( $pno == "080101" && $_SESSION['member_id'] ){

		$query	= "SELECT * FROM ona_member WHERE mbId='".trim($_SESSION['member_id'])."' && mbStatus!='C'";
		$result	= mysql_query($query);
		$row		= mysql_fetch_array($result);

		$query = "SELECT * FROM ona_member_family WHERE mbId = '".trim($_SESSION["member_id"])."' ORDER BY idx";
		$childRows = sqlArray($query);

		$exJumin	= explode("-", $row[mbJumin]);		
		$exEmail	= explode("@", $row[mbEmail]);		
		$modeValue = "modify";

	}else if($pno == "070202"){
		$modeValue = "write";
	}else{
		goUrl('/');
	}	
?> 
<script language="javascript" src="/include/js/member.js"></script>
<script language="javascript">
<!--
	function lengthCheck( checkTag ){
		f = document.frm;
		if ( checkTag.name == "mbJumin1" ){
			if ( checkTag.value.length >= 6 )
			{
				checkTag.blur();					
				f.mbJumin2.focus();
			}
		}
	}
//-->
</script>

<form name="locationFrm" method="post">
	<input type="hidden" name="pno">
	<input type="hidden" name="mbId">
	<input type="hidden" name="mbPwd">
	<input type="hidden" name="mbName">
</form>
<?
//		$tmpproc= "/html/sub07/070202_proc.php";
//		$tmpchk = "return input_check(this);";

//		if($_SERVER['REMOTE_ADDR']!='112.218.172.4233')
//		{
			$tmpproc= "/html/sub07/070202_proc2.php";
			$tmpchk = "return input_check2(this);";
//		}
?>
<form name="frm" method="post" action="<?=$tmpproc?>" onsubmit="<?=$tmpchk?>" target="iframe">
	<input type="hidden" name="ret_host" value="<?=$_SERVER['HTTP_HOST']?>">
	<input type="hidden" name="idCheck">
	<input type="hidden" name="mode" value="<?=$modeValue?>">
	<!-- <input type="hidden" name="mbNickOld" value="<?=$row['mbNick']?>"> -->
<table border="0" cellpadding="0" cellspacing="0">



	<tr>
		<td style="padding-bottom:26px;"> </td>
	</tr>
	<? if($pno == "070202"){ ?>
	<tr>
		<td><img src="../../images/member/img_03.gif" /></td>
	</tr>
	<tr>
		<td align="center">
			<table width="656" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="../../images/member/step01.gif" alt="약관동의"></td>
                    <td><img src="../../images/member/step_img1.gif" align="absmiddle"/></td>
                    <td><img src="../../images/member/step02_on.gif" alt="개인정보입력"></td>
                    <td><img src="../../images/member/step_img1.gif" align="absmiddle"/></td>
                    <td><img src="../../images/member/step03.gif" alt="회원가입완료"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="tit_lv1"><img src="../../images/member/stitle_01.gif" /></td>
	</tr>
	<? }else{ ?>
	<tr>
		<td><img src="../../images/sub08/img_02.gif"></td>
	</tr>
	<tr>
		<td align="center">&nbsp;</td>
	</tr>
	<tr>
		<td class="tit_lv1"><img src="../../images/sub08/stitle_02.gif" width="73" height="15" /></td>
	</tr>
	<? } ?>	
	<tr>
		<td style="padding:0px 0px 5px 3px"><img src="../../images/member/text_02.gif" /></td>
	</tr>
	<!-- 내용 -->
	<?
//		if($_SERVER['REMOTE_ADDR']!='112.218.172.4233')
//		{
			include "../../html/sub07/new_inc_member.php"; 
//		}
//		else
//		{
//			include "../../html/sub07/inc_member.php"; 
//		}
	?>
	<tr>
		<td class="button"><input type="image" src="../../images/member/<?=$modeValue=="modify"?"btn_modify":"btn_join"?>.gif" hspace="5" border="0" /><img src="../../images/member/btn_cancel.gif" onClick="history.back();" style="cursor:pointer" alt="취소" hspace="5" /></td>
	</tr>

</table>
</form>