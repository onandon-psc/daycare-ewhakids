<?
$charType = "no";
$cssType = "no";
$iframeType = "no";
$blurType = "no";
$castleType = "no";
include $_SERVER["DOCUMENT_ROOT"]."/include/global/config.php";	
include $_SERVER["DOCUMENT_ROOT"]."/onMaster/board_session.php";	

if($_POST["mode"]=="excel_down"){
	$data = stripslashes($data);
	$data = eregi_replace("<a[^>]*>","",$data);
	$today = date("Ymd");
	$filename = "[$today]$name.xls";
	$excel = stripslashes($excel);
	$speed = 250; // kb/s 비율로 다운로드를 받는다.
	$isLimit = 0;
	$disposition = "1";   // 1 이면 다운, 0 이면 브라우져가 인식하면 화면에 출력 
	$disposition = ($disposition) ? "attachment" : "inline";
	header("Content-type: file/unknown");
	header("Content-Disposition: $disposition; filename=\"$filename\"");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo "<meta http-equiv='content-type' content='text/html; charset=euc-kr'>";
	echo "<style>td {font-size:12px;border:thin solid #EFEFEF;mso-number-format:'\@';}</style>";
	echo $data;
	exit;
}
?>
<style>
.* {font-size:11px;}
body {margin:0;}
td,input,textarea,select {font-size:11px;}
</style>
<script>
function saveToExcel(name,tablename){
	var tableObj = document.getElementById(tablename);
	var form = document.excelForm;
	form.data.value = tableObj.parentNode.innerHTML;
	form.name.value = name;
	form.submit();
}
</script>
<form name="excelForm" method="post" target="excelFrame" style="display:none;">
<INPUT TYPE="HIDDEN" NAME="mode" VALUE="excel_down">
<INPUT TYPE="HIDDEN" NAME="data">
<INPUT TYPE="HIDDEN" NAME="name">
</form>
<iframe width=0 height=0 frameborder=0 id="excelFrame" name="excelFrame"></iframe>
<?
error_reporting(E_ERROR);
if($_POST["mode"]=="mysql_query"){
	$tmpsqls = explode("DELIMITER",str_replace("delimiter","DELIMITER",stripslashes($_POST["finalsql"])));
	$delimiter = ";";
	$sqls = "";
	foreach($tmpsqls as $k => $v){
		if($k){
			$delimiter = explode("\n",$v);
			$delimiter = trim($delimiter[0]);
		}
		$v = explode("'",$v);
		foreach($v as $k2 => $v2) if($k2%2==0) $v[$k2] = str_replace($delimiter,"delimiter",$v2);
		$v = implode("'",$v);
		$v = explode("delimiter",$v);
		foreach($v as $k2 => $v2){
			if($k && !$k2) continue;
			$sqls[] = $v2;
		}
	}
	$str = "";
	$str .= "<table border=1 align='left'>";
	foreach($sqls as $sqlk => $sqlv){
		if(!trim($sqlv)) continue;
		if(!$sqlk || $result_layout==1 || ($result_layout==3 && $sqlk%2==0)) $str .= "<tr>";
		$str .= "<td valign=top id='dataTable$sqlk'>";
		$tmpstr = "";
		$result = mysql_query($sqlv);
		$tmpstr[] = "<b style='color:".(mysql_errno()?"red":"blue").";'>SQL ".$sqlk." : ".$sqlv."</b> <input type=button value='EXCEL 저장' onclick=\"saveToExcel('Result $sqlk','dataTable$sqlk')\">";
		$tmpstr[] = "Affected_rows : ".mysql_affected_rows();
		if(mysql_errno()) $tmpstr[] =   "Error ".mysql_errno() . " : " . mysql_error();
		$str .= implode("<br>",$tmpstr);
		$cnt = 0;
		$str .= "<table border=0 cellpadding=3 cellspacing=1 bgcolor='#AAEEFF'>";
		while($row = mysql_fetch_assoc($result)){
			if(!$cnt){
				$str .= "<tr bgcolor='white'>";
				foreach($row as $k => $v){
					$str .= "<td><b>$k</b></td>";
				}
				$str .= "</tr>";
			}
			$str .= "<tr bgcolor='white'>";
			foreach($row as $k => $v){
				if(strpos($v,"\n")!==false) $v="<xmp>$v</xmp>";
				$str .= "<td>$v</td>";
			}
			$str .= "</tr>";
			$cnt++;
		}
		$str .= "</table><br>";

		$str .= "</td>";
		if($sqlk==sizeof($sqls) || $result_layout==1 || ($result_layout==3 && $sqlk%2==1)) $str .= "</tr>";

	}
	$str .= "</table>";
	$str .= "<script>parent.document.sqlForm.submitButton.disabled = false;</script>";
	echo $str;
	exit;
}
?>
<head>
<title>
<?=$INFO[company]?> MYSQL
</title>
</head>
<script>
function formSubmit(form){
	try{
		if(!form.sql.value) return false;
		var tmpStr = "";
		if(document.selection) tmpStr = document.selection.createRange().text;
		if(window.getSelection) tmpStr = form.sql.value.substring(form.sql.selectionStart,form.sql.selectionEnd);
		if(tmpStr.length > 0) form.finalsql.value = tmpStr;
		else form.finalsql.value = form.sql.value; 
		form.submitButton.disabled = true;
		return true;
	}
	catch(e){alert(e.message);return false;}
}
function chkKey(e,form){
	var event = event || e;
	if(event.keyCode == 9){
		event.keyCode = 0;
		event.returnValue = false;
		if(event.preventDefault) event.preventDefault();
		var tmpStr = "";
		if(document.selection) tmpStr = document.selection.createRange().text;
		if(window.getSelection) tmpStr = form.sql.value.substring(form.sql.selectionStart,form.sql.selectionEnd);
		tmpStr = tmpStr.split("\n");
		if(event.shiftLeft){
			for (i in tmpStr){
				tmpStr[i] = tmpStr[i].replace(/^(\t|\s{1,4})/,"");
			}
			tmpStr = tmpStr.join("\n");
		}
		else{
			if(tmpStr.length>1){
				for (i in tmpStr){
					tmpStr[i] = "\t" + tmpStr[i];
				}
				tmpStr = tmpStr.join("\n");
			}
			else{
				tmpStr = "\t" + tmpStr;
			}
		}
		if(document.selection) document.selection.createRange().text = tmpStr;
		if(window.getSelection) {
			var lastStartPosition = form.sql.selectionStart;
			var lastEndPosition = form.sql.selectionEnd;
			form.sql.value = form.sql.value.substring(0,form.sql.selectionStart) + tmpStr + form.sql.value.substring(form.sql.selectionEnd);
			if(lastStartPosition==lastEndPosition) form.sql.selectionStart = lastStartPosition + tmpStr.length;
			else form.sql.selectionStart = lastStartPosition;
			form.sql.selectionEnd = lastEndPosition + tmpStr.length;
		}
	}
	if(event.keyCode == 87 && event.ctrlKey){
		event.keyCode = 0;
		event.returnValue = false;
		if(event.preventDefault) event.preventDefault();
		if(document.all){
			var rng = document.selection.createRange();
			rng.expand("word");
			rng.select();
		}
	}
	if(event.keyCode == 116 || (event.keyCode == 82 && event.ctrlKey)){
		event.keyCode = 0;
		event.returnValue = false;
		if(event.preventDefault) event.preventDefault();
		form.submitButton.click();
	}
}
function setStr(str){
	if(document.all){
		document.sqlForm.sql.setActive();
		document.selection.createRange().text = str + "\n";
		document.selection.empty();
	}
	else{
		document.sqlForm.sql.value += "\n" + str;
	}
}
function tableKeyDownCheck(e){
	var event = event || e;
	if(event.keyCode==116 || event.keyCode == 117){
		event.keyCode = 0;
		event.returnValue = false;
		if(event.preventDefault) event.preventDefault();
	}
}
</script>
<body onkeydown="tableKeyDownCheck(event);">
<table width=100% height=100% border=0 cellpadding=3 cellspacing=1 bgcolor="#fafafa" onkeydown="tableKeyDownCheck(event);">
<form name="sqlForm" method="post" target="exeFrame" onsubmit="return formSubmit(this)">
<input type="hidden" name="mode" value="mysql_query">
<input type="hidden" name="finalsql" value="">
	<tr height=4%>
		<td></td>
		<td>
			<table width="100%">
				<tr>
					<td style="font-size:25px;">MYSQL CONSOLE</td>
					<td align="right">
						<input type="button" value="↑" title="축소" onclick="if(this.form.sql.clientHeight>50) this.form.sql.style.height=this.form.sql.clientHeight-50;">
						<input type="button" value="↓" title="확장" onclick="this.form.sql.style.height=this.form.sql.clientHeight+50;">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr height=2%>
		<td width=100 align=center>SQL</td>
		<td><textarea name="sql" style="width:100%;height:200;ime-mode:inactive;" onkeydown="chkKey(event,this.form)"></textarea></td>
	</tr>
	<tr height=2% id="helptr" style="display:none">
		<td></td>
		<td>
			<table cellpadding=3>
				<tr>
<?
$tmpStr = "";
$tmpStr[] = "SHOW STATUS;";
$tmpStr[] = "SHOW VARIABLES;";
$tmpStr[] = "SHOW PROCESSLIST;";
$tmpStr[] = "SHOW ENGINES;";
$tmpStr[] = "SHOW TRIGGERS;";
$tmpStr[] = "SHOW DATABASES;";
$tmpStr[] = "SHOW CREATE DATABASE dbname;";
$tmpStr[] = "SHOW TABLES;";
$tmpStr[] = "SHOW CREATE TABLE tblname;";
$tmpStr[] = "SHOW TABLE STATUS;";
$tmpStr[] = "SHOW FUNCTION STATUS;";
$tmpStr[] = "SHOW CREATE FUNCTION funcname;";
$tmpStr[] = "SHOW PROCEDURE STATUS;";
$tmpStr[] = "SHOW CREATE PROCEDURE procname;";
$tmpStr[] = "SHOW CHARSET;";
$tmpStr[] = "PROCEDURE ANALYSE;";
$tmpStr[] = "SQL_CALC_FOUND_ROWS;";
$tmpStr[] = "SELECT FOUND_ROWS();";
$tmpStr[] = "SET NAMES utf8;";
foreach($tmpStr as $k => $v){
	if($k%5==0) echo "</tr><tr>";
?>
					<td><a href="#" onclick="setStr('<?=$v?>');return false;"><?=$v?></a></td>
<?}?>
				</tr>
			</table>
		</td>
	</tr>
	<tr height=2%>
		<td></td>
		<td align=center>
			결과창 레이아웃
			<select name="result_layout">
			<option value="1">세로출력
			<option value="2">가로출력
			<option value="3">한줄에 2개씩 출력
			</select>
			<input name="submitButton" type="submit" value="Go (ctrl+R)">
			<input name="claerButton" type="button" value="Clear" onclick="this.form.sql.value='';">
			<input name="claerButton" type="button" value="Help" onclick="document.getElementById('helptr').style.display=document.getElementById('helptr').style.display=='none'?'':'none';">
		</td>
	</tr>
</form>
	<tr height=65%>
		<td align=center>RESULT</td>
		<td><iframe style="width:100%;height:100%;border:1px solid black;" frameborder="0" name="exeFrame"></iframe></td>
	</tr>
</table>