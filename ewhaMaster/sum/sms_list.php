<?
    include "../../include/global/config.php";
    include "../common/admin_login_check.php";              // 로그인 체크

    $tableName	= "gn_connection_count";

	$listQuery		= "SELECT * FROM $tableName ORDER BY regdate";
	$listResult		= mysql_query($listQuery);
	$list_num		= @mysql_num_rows($listResult);	

	if(!$total_count){ $total_count = 20; }

	if ($page == ""){ $page = "1"; }				
	$url				= $PHP_SELF."?";
	$total_page	= ceil($list_num/$total_count);
	$set_page 	= $total_count * ($page-1);
	$list_page 	= 10;
	$last 			= $page * $total_count;

	$paging		= common_paging($url,$list_num,$page,$list_page,$total_count);
	if ($last > $list_num){ $last = $list_num; }
?>
<link rel="stylesheet" href="/include/css/gangnam_style.css" type="text/css">
<script language="javascript" src="../../include/js/choice.js"></script>

<TABLE width="100%" border="0" cellpadding="0" cellspacing="0">
    <TR height="30">
        <TD bgcolor="#ececec">&nbsp;&nbsp;<img src="/images/admin/menu.gif"> 기타관리 > <b>SMS 발송내역</b></TD>
    </TR>
    <TR>
        <TD height="15"></TD>
    </TR>
    <TR>
        <TD>
            <TABLE width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                <TR>
                    <TD>
                        <TABLE width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                            <TR>
                                <TD colspan="7" height="3" bgcolor="#9DB0A1"></TD>
                            </TR>
                            <TR height="26" bgcolor="#F2F3E8">                   
                                <TD width="10%" align="center"><B>날짜</B></TD>
                                <TD width="5%" align="center"><B>접속수</B></TD>
								<TD width="85%">&nbsp;</TD>
                            </TR>
                            <TR>
                                <TD colspan="7" bgcolor="#9DB0A1" height="1"></TD>
                            </TR>
							<?	
								$no = $list_num - $set_page;
								if ($list_num){
									for ($i = $set_page; $i < $last; $i++){
										@mysql_data_seek($listResult,$i);
										$row= mysql_fetch_array($listResult);
							?>
							<TR height="26">                   
                                <TD align="center"><?=date("Y.m.d",$row[regdate])?></TD>
                                <TD align="right"><?=number_format($row[count])?></TD>
								<TD>&nbsp;</TD>
                            </TR>
                            <TR>
                                <TD colspan="7" bgcolor="#EFEFEF"></TD>
                            </TR>
							<?		}
								}
							?>
                            <TR>
                                <TD colspan="7" height="3" bgcolor="#9DB0A1"></TD>
                            </TR>
                        </TABLE>
                        <P style="margin-top:10px">
                        <TABLE width="100%" cellpadding="5" cellspacing="0" border="0" align="center">
                            <TR>
                                <TD align="center">
                                    <!-- start : 페이징 -->
                                    <TABLE width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <TR>
                                            <TD align="center"><?if($list_num){echo"$paging[paging]";}else{echo"&nbsp;";} ?></TD>
                                        </TR>
                                    </TABLE>
                                    <!-- end : 페이징 -->
                                </TD>
                            </TR>
                        </TABLE>
                    </TD>
                </TR>
                <TR>
                    <TD height="100"></TD>
                </TR>
                </form>
            </TABLE>
        </TD>
    </TR>
</TABLE>
