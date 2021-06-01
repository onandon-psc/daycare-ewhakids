<?include $_SERVER["DOCUMENT_ROOT"]."/include/global/config.php"; ?>
<html>
<head>
<title>++ <?=$INFO[company]?> - PAGE MANAGER ++</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<style>
* {font-size:11px;}
</style>
<script src="/include/js/func.js"></script>
</head>
<script>
function inputCheck(f){
	if(!f.M_ID.value){alert('아이디를 입력해 주십시오!!');f.M_ID.focus();return false;}
	if(!f.M_PWD.value){alert('비밀번호를 입력해 주십시오!!');f.M_PWD.focus();return false;}
	return true;
}
</script>
<body bgcolor="#F5F5EA" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.thisForm.M_ID.focus();">
<iframe name="onMasterLoginFrame" src="about:blank" style="display:none"></iframe>
<form name="thisForm" method="post" action="login_proc.php" onsubmit="return inputCheck(this);" target="onMasterLoginFrame">

  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">  
    <tr>
      <td height="100%">
        <table width="100%" height="558"  border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="top" style="padding-top:180px;">
              <table width="400" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top" >
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="60%" valign="bottom" style="padding-bottom:6px;"><b>-
                          <?=$INFO[company]?>
                          </b></td>
                        <td width="40%" align="right" valign="bottom" style="padding:0 3 6 0"><b> 개발관리</b></td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="100" align="center" valign="middle" bgcolor="#FFFFFF">
                    <table width="395" height="95" border="0" cellpadding="0" cellspacing="0" bgcolor="#F0F0E5">
                      <tr>
                        <td align="center">
                          <table width="300" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td align="center">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="20%" height="24" align="center">아이디</td>
                                    <td width="53%">
                                      <input name="M_ID" type="text" maxlength="20" tabindex="1" style="width:150px;height:22px;IME-MODE:DISABLED;" onkeydown="onlyId()" onkeypress="onlyId()">
                                    </td>
                                    <td width="27%" rowspan="2">
                                      <input name="submit" type="submit" style="width:100%;height:50; cursor:pointer" value="Login">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td height="24" align="center">비밀번호</td>
                                    <td>
                                      <input name="M_PWD" type="password" maxlength="20" tabindex="2" style="width:150px; height:22px" >
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>   
  </table>
</form>
</body>
</html>