<?
	include "../../include/global/config.php";
	include "../board_session.php"; 

	$query	= "SELECT * FROM BOARD_MANAGER_CATE ";
	$result	= mysql_query($query);
?>
<script language="javascript">
<!--
	function locationMod(menuCode)
	{
		f = document.locationFrm;
		f.sendType.value = "";
		f.menuCode.value = menuCode;
		f.action = "menuReg.php";
		f.target	 = "";
		f.submit();
	}

	function locationDel(menuName,menuCode)
	{
		f = document.locationFrm;
		if(confirm('[ '+menuName+' ]��(��) ���� �Ͻðڽ��ϱ�?\n\n������ ���� ��� ������ �����˴ϴ�.')){
			f.sendType.value = "delete";
			f.menuCode.value = menuCode;
			f.action	 = "menuProc.php";
			f.target	 = "iframe";
			f.submit();
		}
	}
//-->
</script>

<form name="locationFrm" method="post">
  <input type="hidden" name="sendType" value="delete">
  <input type="hidden" name="menuCode">
</form>

<table width='98%' border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="left" bgcolor="#EFEFEF" style="padding:5px">�� <b>��з�����</b></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <tr>
    <td style='background-image:url(/images/community/bm.gif); background-repeat:repeat-y;' align='center'>
      <table border='0' width='100%' cellpadding='0' cellspacing='0'>
        <col width='10%'>
        <col width=''>
        <col width='20%'>
        <col width='20%'>
        <tr>
          <td height='1' colspan='4' bgcolor='#D3A66D'></td>
        </tr>
        <tr>
          <td height='5' colspan='4' bgcolor="#FBF9F5"></td>
        </tr>
        <tr align='center' bgcolor="#FBF9F5">
          <td><b>�ڵ�</b></td>
          <td><b>��з���</b></td>
          <td><b>��뿩��</b></td>
          <td><b>����</b> | <b>����</b></td>
        </tr>
        <tr>
          <td height='5' colspan='4' bgcolor="#FBF9F5"></td>
        </tr>
        <tr>
          <td height='1' colspan='4' bgcolor='#D3A66D'></td>
        </tr>
        <!-- �ݺ� ���� -->
        <?	
			$TotalNum= 0;
			while($row = @mysql_fetch_array($result)){
		?>
        <tr align='center' style='padding:3 0 3 0'>
          <td height='30'><?=$row[MENUCODE]?></td>
          <td align='left'><b><?=$row[MENUNAME]?></b></td>
          <td><?=$row[VIEWTYPE]?></td>
          <td><a href="javascript:locationMod('<?=$row[MENUCODE]?>');">����</a> | <a href="javascript:locationDel('<?=$row[MENUNAME]?>','<?=$row[MENUCODE]?>');">����</a></td>
        </tr>
        <tr>
          <td height='1' colspan='4' bgcolor='#D3A66D'></td>
        </tr>
        <? 
				$TotalNum++;
			}
			if(!$TotalNum){
		?>
        <tr>
          <td colspan="4" height="26" align="center" bgcolor="#FFFFFF"><font color="#B24C3A">��ϵ� �Խù��� �����ϴ�.</font></td>
        </tr>
        <tr>
          <td height='1' colspan='4' bgcolor='#D3A66D'></td>
        </tr>
        <? } ?>
      </table>
    </td>
  </tr>
  <tr>
    <td align="right" style="padding:5 0 0 0">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <input type="button" value="�ݱ�" onClick="parent.run();" style="padding:3px;cursor:pointer">
          </td>
          <td align="right">
            <input type="button" value="���" onClick="location.href('menuReg.php')" style="padding:3px;cursor:pointer">
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
