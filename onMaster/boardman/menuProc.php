<?
	include "../../include/global/config.php";
	include "../board_session.php"; 

	switch ($sendType){

		case "modify": // ����
			$query	= "UPDATE BOARD_MANAGER_CATE SET menuCode='$menuCode', menuName='$menuName', viewType='$viewType' WHERE menuCode='".$idx."'";
			break;

		case "delete": // ����
			$query	= "DELETE FROM BOARD_MANAGER_CATE WHERE menuCode='".$menuCode."'";
			break;

		default : // ���
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
			alert('���� �Ǿ����ϴ�.');
			parent.formReg.action = "menuReg.php";
			parent.formReg.submit();
		<? }else{ ?>
			parent.location.href='menuList_iframe.php';
		<? } ?>
	}
	exe();
//-->
</script>