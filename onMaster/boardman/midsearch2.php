<?
	include "../../include/global/config.php";
	include "../board_session.php"; 

	$cate2 = $cate1.$cate2;
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
	if( !$cate2 ) exit;

	$query = "SELECT substring(PNO,1,6) AS CD, CATE3 FROM BOARD_MANAGER WHERE LAST_YN='Y' && substring(PNO,1,4) = '$cate2' GROUP BY substring(PNO,1,6), CATE3 ";
	$result = mysql_query($query);
		
	if( $result ) {
?>

<script language='javascript'>
<!--	
	var cb = parent.thisForm.midcode2;
	setSelect_allDeleteOption( cb );

<?
		while( $row = mysql_fetch_array($result) ){
			$val = substr($row[CD], 4,2) .",". $row[CATE3] ;
			echo("setSelect_addOption(cb,'$val','$val');
			");
		}		
?>
	parent.thisForm.use_midcode2_btn.disabled = parent.thisForm.midcode2.options.length?false:true;
//-->
</script>
<?
	}
?>
