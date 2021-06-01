<?
	include "../../include/global/config.php"; 
	
	if(!empty($pno)){
	
		$query = "DELETE FROM BOARD_MANAGER WHERE PNO='$pno'";
		mysql_query($query);
		
		echo "<script>
					 location.href('index.php?$returnParam');
				  </script>";

	}
	
?>