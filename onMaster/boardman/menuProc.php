<?
	include "../../include/global/config.php";
	include "../board_session.php"; 

	switch ($sendType){

		case "modify": // 수정
			$query	= "UPDATE BOARD_MANAGER_CATE SET menuCode='$menuCode', menuName='$menuName', viewType='$viewType' WHERE menuCode='".$idx."'";
			break;

		case "delete": // 삭제
			$query	= "DELETE FROM BOARD_MANAGER_CATE WHERE menuCode='".$menuCode."'";
			break;

		default : // 등록
			$query	= "INSERT INTO BOARD_MANAGER_CATE (
								menuCode, menuName, viewType
							) VALUES(
								'$menuCode', '$menuName', '$viewType'
							)";
			break;

	}
	mysql_query($query);
?>
<script language="javascript" type="text/javascript">
<!--
	function exe(){
		<? if($sendType == "modify"){ ?>
			alert('수정 되었습니다.');
			parent.formReg.action = "menuReg.php";
			parent.formReg.submit();
		<? }else{ ?>
			parent.location.href='menuList_iframe.php';
		<? } ?>
	}
	exe();
//-->
</script>