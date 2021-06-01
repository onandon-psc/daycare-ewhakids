<?
	include "../../include/global/config.php";
	include "../board_session.php"; 
?>
<script language='javascript'>
<!--
	function setSelect_allDeleteOption(obj){
		for(var i= obj.length-1; i >= 0; i--)
			obj.options[i]= null;
		return;
	}
	function setSelect_addOption(obj, txt, val){
		obj.options[obj.length]= new Option(val, txt);
		return;
	}
//-->
</script>
<?
	// 중분류 명칭 검색
	if( !$cate1 ) exit;

	$query = "SELECT substring(PNO,1,4) AS CD, CATE2 FROM BOARD_MANAGER WHERE LAST_YN='Y' && substring(PNO,1,2) = '$cate1' GROUP BY substring(PNO,1,4), CATE2 ";
	$result = mysql_query($query);
		
	if( $result ) {
?>

<script language='javascript'>
<!--	
	var cb = parent.thisForm.midcode;
	setSelect_allDeleteOption( cb );

<?
		while( $row = @mysql_fetch_array($result) ){
			$val = substr($row[CD], 2,2) .",". $row[CATE2] ;
			echo("setSelect_addOption(cb,'$val','$val');
			");
		}		
?>
//-->
</script>
<?
	}
?>
