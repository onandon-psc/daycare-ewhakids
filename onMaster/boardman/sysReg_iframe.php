<?
    include "../../include/global/config.php";
    include "../board_session.php";

    if($seq || $pno){

        $query  = "SELECT * FROM BOARD_MANAGER WHERE pno='$pno' && seq='$seq'";
        $result = mysql_query($query);
        $row        = mysql_fetch_array($result);

        $btnText = "����";

        $pno_1 = substr($pno, 0, 2 );
        $pno_2 = substr($pno, 2, 2 );
        $pno_3 = substr($pno, 4, 2 );
        $pno_4 = substr($pno, 6, 2 );
        $pno_5 = substr($pno, 8, 2 );
        $pno_6 = substr($pno, 10, 2 );

        $mode = "modify";

    }else{

        $btnText = "���";
        $mode = "write";
		$row[TBLNAME] = "ona_board_";
		$row[LINK_FILE] = "board_common";
        $row[USE_YN] = "Y";
        $row[BD_LIST] = "10";
        $row[BD_VIEW] = "0";
        $row[BD_WRITE] = "1";
        $row[BD_REPLY] = "N";
        $row[BD_COMMENT] = "N";
        $row[BD_PRENEXT] = "N";
        $row[BD_FILE] = "1";
        $row[BD_SECU] = "N";

    }

    function printSelectUseNo( $objName, $sel )
    {
        echo("<select name='$objName'> ");
        $sel_str = "";  if( $sel == "N" ) $sel_str = " selected ";
        echo("<option value='N' $sel_str>������</option>");
        $sel_str = "";  if( $sel == "Y" ) $sel_str = " selected ";
        echo("<option value='Y' $sel_str>���</option>");
        echo("</select> ");
    }

?>
<script language="javascript">

	function run(){
		window.returnValue = 1;
		window.close();
	}

    function form_submit()
    {
        var f = document.thisForm;
        if( f.cate2.value =="" ) {
            alert("Depth2 �ڵ带 �Է��Ͻʽÿ�");
            f.cate2.focus();
            return false;
        }
        if( f.cate2Name.value == "" ) {
            alert("Depth2�� �� �Է��Ͻʽÿ�");
            f.cate2Name.focus();
            return false;
        }
        if( f.cate3.value =="" ) {
            alert("Depth3 �ڵ带 �Է��Ͻʽÿ�");
            f.cate3.focus();
            return false;
        } 
        return true;
    }

    function search_mid()
    {
        var f = document.thisForm;
        ifsearch.location.href="midsearch.php?cate1=" + f.cate1.value;
    }

    function search_mid2()
    {
        var f = document.thisForm;
        ifsearch2.location.href="midsearch2.php?cate1="+ f.cate1.value +"&cate2=" + f.cate2.value;
    }

    function use_midcode()
    {
        var f    = document.thisForm;
        var cb = f.midcode;
        if(cb.value) {
            var arr = cb.value.split( ",");
            f.cate2.value = arr[0];
            f.cate2Name.value = arr[1];
            search_mid2();
        }
    }

    function use_midcode2()
    {
        var f    = document.thisForm;
        var cb = f.midcode2;
        if(cb.value) {
            var arr = cb.value.split( ",");
            f.cate3.value = arr[0];
            f.cate3Name.value = arr[1];
        }
    }

    function pageType(v)
	{
		f = document.thisForm;
		switch(v)
		{	
			case "1":
				if(f.mode.value !='modify') f.tblName.value = "ona_board_";
				break;
			case "2":
				f.tblName.value = "ona_html";
				break;
			case "3":
			case "4":
				if(f.mode.value !='modify'){
					f.tblName.value  = "";
					f.link_file.value    = f.rma_link_file.value;	
					if(v=="3") f.link_file.value = "";
				}
				break;			
		}
		if(v==1) v2 = "block";
		else v2 = "none";
		for(var i=1; i<=4; i++) document.getElementById('idBoardType'+i).style.display = v2;
		document.getElementById('idOption').style.display = v2;		

		if(v!=3) v3 = "block";
		else v3 = "none";
		for(var i=1; i<=4; i++) document.getElementById('idTable'+i).style.display = v3;
    }
	
</script>

<iframe name="ifsearch"  style="display:none;" width="0" height="0"></iframe>
<iframe name="ifsearch2"  style="display:none;" width="0" height="0"></iframe>

<body onLoad="search_mid();">
<table width='670' border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" bgcolor="#EFEFEF" style="padding:5px">�� <b>�޴�����</b></td>
  </tr>
  <tr>
    <td height="5"></td>
  </tr>
  <form name="thisForm" method="post" action="sysProc.php" onSubmit="return form_submit()" target="iframe">
    <input type=hidden name=pno value='<?=$pno?>'>
    <input type=hidden name=seq value='<?=$seq?>'>
    <input type=hidden name=hidpno value='<?=$pno?>'>
    <input type=hidden name=hidseq value='<?=$seq?>'>
    <input type=hidden name=mode value='<?=$mode?>'>
    <input type=hidden name="rma_link_file" value='<?=$row[LINK_FILE]?>'>
    <tr>
      <td style='background-image:url(/images/community/bm.gif); background-repeat:repeat-y;' align='center'>
        <table width='100%' cellpadding='0' cellspacing='0' border='0'>
          <col width='100'>
          <col width='570'>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>��뿩��</b></td>
            <td align="left">
              <table width="99%" bgcolor="#ffffff">
                <tr>
                  <td><? printSelectUseNo( "use_yn", $row[USE_YN] ) ; ?> </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>������ Ÿ��</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
                    <input type="radio" name="kind" value="1" <?if($row[KIND]=="1" || !$row[KIND]){echo"checked";}?> onClick="pageType('1')">
                    ����&nbsp;
                    <input type="radio" name="kind" value="2" <?if($row[KIND]=="2"){echo"checked";}?> onClick="pageType('2')">
                    ����&nbsp;
                    <input type="radio" name="kind" value="3" <?if($row[KIND]=="3"){echo"checked";}?> onClick="pageType('3')">
                    ��ũ&nbsp;
                    <input type="radio" name="kind" value="4" <?if($row[KIND]=="4"){echo"checked";}?> onClick="pageType('4')">
                    DB��ũ</TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
		  
          <tr id="idBoardType1" bgcolor="#FBF9F5">
            <td align='center'><b>�Խ��� Ÿ��</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
                    <input type="radio" name="boardkind" value="0" <?if($row[BOARDKIND]=="0" || !$row[BOARDKIND]){echo"checked";}?>>
                    �ϹݰԽ���&nbsp;
                    <input type="radio" name="boardkind" value="1" <?if($row[BOARDKIND]=="1"){echo"checked";}?>>
                    ����Խ���</TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr id="idBoardType2">
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr id="idBoardType3">
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr id="idBoardType4">
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>

          <tr align='center' bgcolor="#FBF9F5">
            <td><b>Depth1</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
                    <? if( $mode == "write" ) { ?>
                    <select name="cate1" onchange='search_mid();'>
                      <?
                        $codeQuery   = "SELECT * FROM BOARD_MANAGER_CATE WHERE viewType='Y'";
                        $codeResult  = mysql_query($codeQuery);
                        while($codeRow = mysql_fetch_array($codeResult)){
                    ?>
                      <option value='<?=$codeRow[MENUCODE]?>' <?if($pno_1 == $codeRow[MENUCODE]){echo"selected";}?>>[
                      <?=$codeRow[MENUCODE]?>
                      ]
                      <?=$codeRow[MENUNAME]?>
                      </option>
                      <?
                        }
                    ?>
                    </select>
                    <? } else {
                                echo "<input type=text name='cate1' size=3 value='$pno_1' readonly> ";
                                echo "<b>$row[CATE1]</b>";
                    }?>
                  </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>Depth2</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>�ڵ� :
                    <input type="text" name="cate2" size="3" maxlength="2" style="text-align:center" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); this.value = ''; this.focus(); return false; };" value ='<?=$pno_2?>' <? if($mode=="modify") echo " readonly "; ?>>
                    &nbsp; �з��� :
                    <input type="text" name="cate2Name" value='<?=$row[CATE2]?>'>
                    <select name='midcode'>
                    </select>
                    <input type=button value='���' onClick="use_midcode();">
                  </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>Depth3</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>�ڵ� :
                    <input type="text" name="cate3" size="3" maxlength="2" style="text-align:center" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); this.value = ''; this.focus(); return false; };" value ='<?=$pno_3?>'>
                    &nbsp; �з��� :
                    <input type="text" name="cate3Name" value='<?=$row[CATE3]?>'>
                    <select name='midcode2'>
                    </select>
                    <input name="use_midcode2_btn" type=button value='���' onClick="use_midcode2();" disabled>
                  </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td colspan="2" align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD><font color="#FF0000" style="padding:0 0 0 24">�� <b>Depth4</b> �̻� ���ʹ� �ʼ� �Է»����� �ƴմϴ�.</font></TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>Depth4</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>�ڵ� :
                    <input type="text" name="cate4" size="3" maxlength="2" style="text-align:center" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); this.value = ''; this.focus(); return false; };" value='<?=$pno_4?>'>
                    &nbsp; �з��� :
                    <input type="text" name="cate4Name" value='<?=$row[CATE4]?>'>
                  </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr align='center' bgcolor="#FBF9F5">
            <td><b>Depth5</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>�ڵ� :
                    <input type="text" name="cate5" size="3" maxlength="2" style="text-align:center" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); this.value = ''; this.focus(); return false; };" value='<?=$pno_5?>'>
                    &nbsp; �з��� :
                    <input type="text" name="cate5Name" value='<?=$row[CATE5]?>'>
                  </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>

          <tr id="idTable1" align='center' bgcolor="#FBF9F5">
            <td><b>���̺��</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
					<input type="hidden" name="tblNameMmr" value='<?=$row[TBLNAME]?>'>
                    <input type="text" name="tblName" size="36" value='<?=$row[TBLNAME]?>' maxlength="50">  
					<font color="#FF0000">�� '<b>ona_board_</b>' �Ǵ� '<b>���Է�</b>'�� �ڵ��ȣ�� ���</font>
                  </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr id="idTable2">
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr id="idTable3">
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr id="idTable4">
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>

          <tr align='center' bgcolor="#FBF9F5">
            <td><b>��ũ����</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
                    <input type="text" name="link_file" size="36" value='<?=$row[LINK_FILE]?>'> 
					<font color="#FF0000">�� '<b>���Է�</b>'�� �ڵ��ȣ�� ���</font>
                    <br>&nbsp;( <b>���� :</b> ../php/board <b>��ũ :</b> ../php/xxxx.php )
					</TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <!-- 
		  <tr align='center' bgcolor="#FBF9F5">
            <td><b>TAB��ũ����</b></td>
            <td align="left">
              <TABLE width="99%" bgcolor="#FFFFFF">
                <TR>
                  <TD>
                    <input type="text" name="tab_file" style="width:50%" value='<?=$row[TAB_FILE]?>'>
                    &nbsp;( �������� Tab���� ������ ǥ�� ) </TD>
                </TR>
              </TABLE>
            </td>
          </tr>
          <tr>
            <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
          </tr>
          <tr>
            <td height='1' colspan='2' bgcolor='#D3A66D'></td>
          </tr> 
		  -->
          <tr id="idOption">
            <td colspan='2'>
              <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                <tr>
                  <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
                </tr>
                <tr align='center' bgcolor="#FBF9F5">
                  <td width="100"><b>����</b></td>
                  <td align="left">
                    <TABLE width="99%" cellpadding='0' cellspacing='0' border='0' bgcolor="#FFFFFF">
                      <TR>
                        <TD align="center" width="10%" height="30"><b>�������</b></TD>
                        <TD align="left" width="15%">
                          <select name="bd_view">
                            <option value="0" <?if($row[BD_VIEW]=="0") echo ("selected");?>>���ȸ��</option>
                            <option value="1" <?if($row[BD_VIEW]=="1") echo ("selected");?>>�Ϲ�ȸ��</option>
                            <option value="9" <?if($row[BD_VIEW]=="9") echo ("selected");?>>������</option>
                          </select>
                        </TD>
                        <TD align="center" width="10%"><b>����Ʈ��</b></TD>
                        <TD align="left" width="10%">
                          <input type="text" name="bd_list" size="3" value="<?=$row[BD_LIST]?>" maxlength="2" style="text-align:center" onKeyUp="if(this.value.match(/[^0-9]/)) { alert('���ڸ� �־��ּ���'); this.value = ''; this.focus(); return false; };">
                        </td>
                        <TD align="center" width="10%"><b>÷������</b></td>
                        <TD align="left" width="10%">
                          <select name=bd_file>
                            <option value='0' <? if($row[BD_FILE]==0 ) echo ("selected");?>>0��</option>
                            <option value='1' <? if($row[BD_FILE]==1 ) echo ("selected");?>>1��</option>
                            <option value='2' <? if($row[BD_FILE]==2 ) echo ("selected");?>>2��</option>
                            <option value='3' <? if($row[BD_FILE]==3 ) echo ("selected");?>>3��</option>
                            <option value='4' <? if($row[BD_FILE]==4 ) echo ("selected");?>>4��</option>
                            <option value='5' <? if($row[BD_FILE]==5 ) echo ("selected");?>>5��</option>
                          </select>
                        </TD>
                        <TD align="center" width="15%"><b>����/������</b></TD>
                        <TD align="left" width="15%"><? printSelectUseNo( "bd_prenext", $row[BD_PRENEXT] ) ; ?> </td>
                      </TR>
                      <tr>
                        <td colspan="8" height="1" bgcolor="#D3A66D"></td>
                      </tr>
                      <TR>
                        <TD align="center" height="30"><b>�������</b></TD>
                        <TD align="left">
                          <select name="bd_write">
                            <option value="0" <?if($row[BD_WRITE]=="0") echo ("selected");?>>���ȸ��</option>
                            <option value="1" <?if($row[BD_WRITE]=="1") echo ("selected");?>>�Ϲ�ȸ��</option>
                            <option value="9" <?if($row[BD_WRITE]=="9") echo ("selected");?>>������</option>
                          </select>
                        </TD>
                        <td align="center"><b>��ۻ��</b></td>
                        <td align="left"><? printSelectUseNo( "bd_reply", $row[BD_REPLY] ) ; ?></td>
                        <td align="center"><b>�ڸ�Ʈ</b></td>
                        <td align="left"><? printSelectUseNo( "bd_comment", $row[BD_COMMENT] ) ; ?></td>
                        <td align="center"><b>��б�</b></td>
                        <td align="left"><? printSelectUseNo( "bd_secu", $row[BD_SECU] ) ; ?></td>
                      </TR>
                    </TABLE>
                  </td>
                </tr>
                <tr>
                  <td height='5' colspan='2' bgcolor="#FBF9F5"></td>
                </tr>
                <tr>
                  <td height='1' colspan='2' bgcolor='#D3A66D'></td>
                </tr>
              </table>
            </td>
          </tr>
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
              <input type="submit" value="<?=$btnText?>" style="padding:3px;cursor:pointer">
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </form>
</table>
<? if( $mode == "modify" ) echo "<script>pageType('".$row[KIND]."')</script>"; ?>
