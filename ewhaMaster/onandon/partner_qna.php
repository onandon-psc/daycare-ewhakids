<?php 
	include "../../include/global/config.php"; 
	include "../common/admin_login_check.php";				// �α��� üũ
	$MNTITLE = " ���������Խ���" ;
?>
<body bgcolor='#FFFFFF' topmargin='0' leftmargin='0'>
<table align="left" width='100%' height=100% cellpadding='0' cellspacing='0' border='1' bordercolorlight='#D8D8D8' bordercolordark='#FFFFFF'>
<tr>
    <td valign='top'>
    <table width='100%' height=100% cellspacing='0' cellpadding='0' border='0'>
    <tr height='40'>
        <td bgcolor='#F7F7F7'>
        <table align='center' width='100%' cellspacing='0' cellpadding='0' cellspacing='0' border='0'>
        <tr>
            <td height='40'>������ġ : ��Ÿ���� > <?php echo $MNTITLE; ?></td>
        </tr>
        </table>
        </td>    
    </tr>
	<tr height='100%'>
		<td><iframe name="admin_main" width="100%" height='100%' frameborder=0 src="/ewhaMaster/onandon/partner_qna.html"></iframe></td>
	</tr>
    </table>
    </td>
</tr>
</table>
</body>
</html>
