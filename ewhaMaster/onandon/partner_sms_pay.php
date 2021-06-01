<?php 
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// 로그인 체크
	$MNTITLE = "온앤온 > SMS 결제" ;
?>
<body bgcolor='#FFFFFF' topmargin='0' leftmargin='0'>
<table width='974' height=100% cellpadding='0' cellspacing='0' border='1' bordercolorlight='#D8D8D8' bordercolordark='#FFFFFF'>
<tr>
    <td valign='top'>
    <table width='751' height=100% cellspacing='0' cellpadding='0' border='0'>
    <tr height='40'>
        <td bgcolor='#F7F7F7'>
        <table align='center' width='700' cellspacing='0' cellpadding='0' cellspacing='0' border='0'>
        <tr>
            <td height='40'>현재위치 : ADMIN > <?php echo $MNTITLE; ?></td>
        </tr>
        </table>
        </td>    
    </tr>
	<tr height='100%'>
		<td><iframe name="admin_main" width="100%" height='100%' frameborder=0 src="/gsMaster/onandon/partner_sms_pay.html"></iframe></td>
	</tr>
    </table>
    </td>
</tr>
</table>
</body>
</html>
