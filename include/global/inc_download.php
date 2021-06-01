<script language="javascript" src="/include/js/popup.js"></script>		
<script language="javascript">		
<!--
	function jsDownload(v1){
		
		f = document.popupFrm;

		var window_left = screen.width;
		var window_top = screen.height;

		var w = 200;
		var h	 = 100;

		var t = (screen.height/2) - (h/2)-100;
		var l = (screen.width/2) - (w/2);
		
		file_open_popup("../../include/global/download.php?file="+v1,'DL', 'DL',w,h,t,l);
	}
//-->
</script>

<form name="popupFrm" method="post" action="/include/global/download.php">
	<input type="hidden" name="">
</form>