<? 
	session_start(); 
	session_destroy();	
	session_start(); 
	$_SESSION["indexok"]="Y";
	echo " <script>
			   <!--
					//alert('�α׾ƿ� �Ǿ����ϴ�.');
					location.href='/assembly/';
				-->
			   </script>";
?>