<?
	include "../../include/global/config.php"; 
	include "../../include/global/sendmail.class.php"; 

	$smsType	= $_POST['smsType'];
	$memtype1	= $_POST['memtype1'];
	$search		= $_POST['search'];
	$keyword		= $_POST['keyword'];
	$delValue		= $_POST['delValue'];

	$smsList = "";

	switch($smsType){
		case "S":	// 검색된 회원
			if( $memtype1 ) $whereAnd .= " && memtype1='$memtype1' ";
			if($search) $whereAnd .= " && ($search like '%$keyword%') ";
			$query	= "SELECT userid,mobile,name FROM ona_member WHERE mobile!='' and status1!='2' $whereAnd ORDER BY idx DESC";
			$result	= mysql_query($query);			
			while( $row = mysql_fetch_array($result)){
				$smsList["name"][] = $row["name"];
				$smsList["mobile"][] = $row["mobile"];
			}
			break;
		case "C":	// 선택된회원
			$ex	 = explode(",",$delValue);
			for($i=0; $i < count($ex); $i++){
				$query	= "SELECT userid,mobile,name FROM ona_member WHERE mobile!='' and status1!='2' && idx='".$ex[$i]."'";
				$result	= mysql_query($query);
				$row		= mysql_fetch_array($result);
				$smsList["name"][] = $row["name"];
				$smsList["mobile"][] = $row["mobile"];
			}			
			break;
		case "A":	// 전체회원
			$query	= "SELECT userid,mobile,name FROM ona_member WHERE mobile!='' and status1!='2' ORDER BY idx DESC";
			$result	= mysql_query($query);			
			while( $row = mysql_fetch_array($result)){
				$smsList["name"][] = $row["name"];
				$smsList["mobile"][] = $row["mobile"];
			}			
			break;
	}
?>
<?if($smsType){?>
<script>
parent.ShowFramePopup("../../gsMaster/member/sms_proc.php?gname=<?=implode("|",$smsList["name"])?>&gphonenumber=<?=str_replace("-","",implode("|",$smsList["mobile"]))?>");
</script>
<?exit;}?>
<form name="partnerForm" method="post" action="http://gulumma.net/guladm/partner/partner_force_login.asp">
<input type="hidden" name="PARTNER_ID" value="gskids">
<input type="hidden" name="PARTNER_PASS" value="dcba">
<input type="hidden" name="TR_ETC3" value="GS">
<input type="hidden" name="TR_ETC4" value="01">
<input type="hidden" name="C_CD" value="GS">
<input type="hidden" name="S_CD" value="01">
<input type="hidden" name="gmsgbox" value="">
<input type="hidden" name="gphonenumber" value="">
<input type="hidden" name="gname" value="">
<input type="hidden" name="rtnURL" value="/guladm/partner/partner_sms.asp">
</form>
<script>
document.partnerForm.gname.value = "<?=$_GET["gname"]?>";
document.partnerForm.gphonenumber.value = "<?=$_GET["gphonenumber"]?>";
document.partnerForm.submit();
</script>
