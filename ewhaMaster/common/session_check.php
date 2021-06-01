<?
	session_start();
	if( empty($_SESSION['masterSession']) ){
		echo("
		<script language='javascript'>
			alert('권한이 없습니다.');
		</script>
		");
		exit;
	}
?>