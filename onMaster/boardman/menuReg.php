<?
	include "../../include/global/config.php";
	include "../board_session.php"; 

	if($menuCode){
		$query	= "SELECT * FROM BOARD_MANAGER_CATE WHERE menuCode='".$menuCode."'";
		$result	= mysql_query($query);
		$row		= mysql_fetch_array($result);
		$btnText = "����";
	}else{
		$btnText = "���";
	}
?>

<script language="javascript">
<!--
	function inputCheck(frm){
		if(!frm.menuName.value){
			alert('�޴����� �Է��Ͻʽÿ�!!');
			frm.menuName.focus();
			return false;
		}
		return;
	}
//-->
</script>

<table width='98%' border="0" cellspacing="0" cellpadding="0">
<form name="formReg" method="post" action="menuProc.php" onsubmit="return inputCheck(this);" target="iframe">
	<? if($menuCode){ ?>
	<input type="hidden" name="sendType" value="modify">
	<input type="hidden" name="idx" value="<?=$menuCode?>">
	<? } ?>
	<tr>
	  <td align="left" bgcolor="#EFEFEF" style="padding:5px">�� <b>��з�����</b></td>
	</tr>
	<tr>
	  <td height="5"></td>
	</tr>    
    <tr>
      <td style='background-image:url(/images/community/bm.gif); background-repeat:repeat-y;' align='center'>
        <table border='0' width='100%' cellpadding='0' cellspacing='0'>
          <col width='100'>
          <col width='480'>
          <col width='90'>
          <tr>
            <td height='1' colspan='3' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='3' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>�ڵ�</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
                    <select name="menuCode">
                      <? 
						for($i=1;$i<=20;$i++){

							$ii = codeNumber($i);

							$chkQuery	= "SELECT MENUCODE FROM BOARD_MANAGER_CATE WHERE menuCode='".$ii."'";
							$chkResult	= mysql_query($chkQuery);
							$chkRow		= mysql_fetch_array($chkResult);

							if($menuCode){ // ����
		
								if(($chkRow[MENUCODE] != $ii) || ($menuCode == $ii)){
                      ?>
                      <option value="<?=$ii?>" <?if($row[MENUCODE] == $chkRow[MENUCODE]){echo"selected";}?>><?=$ii?></option>
                      <?		}
							}else{
								if($chkRow[MENUCODE] != $ii){
                      ?>
                      <option value="<?=$ii?>"><?=$ii?></option>
                      <?		
								}
							}							
						}
                      ?>
                    </select>
                  </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='3' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='3' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='3' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>�޴���</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
                    <input type="text" name="menuName" maxlength="50" style="width:100%" value="<?=$row[MENUNAME]?>">
                  </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='3' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='3' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='3' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>��뿩��</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
                    <input type="radio" name="viewType" value="Y" <?if($row[VIEWTYPE]=="Y" || !$row[VIEWTYPE]){echo"checked";}?>>
                    ���&nbsp;
                    <input type="radio" name="viewType" value="N" <?if($row[VIEWTYPE]=="N"){echo"checked";}?>>
                    ������</TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='3' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='3' bgcolor='#D3A66D'></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="right" style="padding:5 0 0 0">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>
              <input type="button" value="���" onclick="location.href('menuList_iframe.php');" style="padding:3px;cursor:pointer">
            </td>
            <td align="right">
              <input type="submit" value="<?=$btnText?>" style="padding:3px;cursor:pointer">
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </form>
</table>
