<?
	session_start();
	if( empty($_SESSION['masterSession']) ){
		echo("
		<script language='javascript'>
			alert('������ �����ϴ�.');
		</script>
		");
		exit;
	}
?>