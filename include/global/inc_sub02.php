<?
	#### ���帵ũ���� ###############
	$list_file        = $PHP_SELF."?pno=$pno";
	$write_file     = $PHP_SELF."?pno=$pno&mode=write";
	$view_file		= $PHP_SELF."?pno=$pno&mode=view";
	$modify_file	= $PHP_SELF."?pno=$pno&mode=modify";
	$delete_file	= $PHP_SELF."?pno=$pno&mode=delete";

	include_once($_SERVER[DOCUMENT_ROOT]."/include/global/inc_download.php"); 

		if( mktime() < mktime(0,0,0,3,9,2015)){ 
			if(!$_SESSION['masterSession'])
			{
				if(substr($pno,0,2)=='04')
				{
					echo "<div align=center><img src='/images/common/img_1.gif'></div>";
					return;
				}
			}
		}
		if(!$_SESSION['masterSession']){
			if($pno=='060401' || $pno=='060501' || $pno=='030301'){
				if($_SESSION['member_level']=='' || $_SESSION['member_level']=='R'){
				goBack("��ȸ���̻� �����մϴ�.");
				}
			}
		}
	//echo $row_page[KIND];
	switch($row_page[KIND])
	{
		case $cPageType_Board :  // Board Ÿ�� �̸�

			// ��������
			require_once $_SERVER["DOCUMENT_ROOT"]."/include/cheditor/cheditor.php";
			require_once $_SERVER["DOCUMENT_ROOT"]."/summernote/summernote.php";

			if( empty($mode) ) {
				include $_SERVER["DOCUMENT_ROOT"]."/include/board/$row_page[LINK_FILE]_list.php";
				//echo $_SERVER["DOCUMENT_ROOT"]."/include/board/$row_page[LINK_FILE]_list.php";
			} elseif( $mode == "write" || $mode == "modify" || $mode == "reply" ) {

				if( empty($_SESSION[member_id]) && $_SESSION['masterSession'] ) {
					goBack("[E101] ��������� �����ϴ�.");
				}

				switch( $send ) {
					case "modify_ok":
						if( !$board_idx ) goBack("[E101] �߸��� ������ �Ͽ����ϴ�.");
						break;
				}
				include $_SERVER["DOCUMENT_ROOT"]."/include/board/$row_page[LINK_FILE]_write.php";
				//echo $_SERVER["DOCUMENT_ROOT"]."/include/board/$row_page[LINK_FILE]_write.php";

			}else if( $mode == "view" ) {

				if( !$board_idx ) goBack("[E201] �߸��� ������ �Ͽ����ϴ�.");

				switch( $send )
				{
					case "delete":
					case "comment_write":
					case "comment_modify":
					case "comment_delete":
						if( empty($_SESSION[member_id]) ) {
							goBack("[E201] ������ �����ϴ�.");
						}
						break;
				}

				include $_SERVER["DOCUMENT_ROOT"]."/include/board/$row_page[LINK_FILE]_$mode.php";
			}

			break;

		case $cPageType_Html :	// HTML Ÿ���̸�

			$content        = stripslashes(db_lob($row_page[CONTENT]));
			$content        = str_replace("<P>","",$content);
			$content        = str_replace("</P>","<br>",$content);

			if( $content ) {
				echo $content;
			} else {
				echo ("<div align=center><img src='/images/common/img_1.gif'></div>");
			}

			break;

		case $cPageType_Link :	// ��ũ���� �̸�
			if( file_exists($row_page[LINK_FILE]) ) {			
				include $row_page[LINK_FILE];
			} else {
				$fileExists = $_SERVER["DOCUMENT_ROOT"]."/html/sub".substr($pno,0,2)."/".$pno;
				if( file_exists($fileExists.".php") ){
					include $fileExists.".php";
					//echo $fileExists.".php";
				}else if( file_exists($fileExists.".html") ){
					include $fileExists.".html";
					//echo $fileExists.".html";
				}else{
					// ������ �غ���
					echo "<div align=center><img src='/images/common/img_1.gif'></div>";
				}
			}
			break;
		
		case $cPageType_Toys :	// DB��ũ �̸�

			if(!$row_page[LINK_FILE]) $row_page[LINK_FILE] = $_SERVER["DOCUMENT_ROOT"]."/html/sub".substr($pno,0,2)."/".$pno;

			if($mode){
				include("$row_page[LINK_FILE]_$mode.php");
				//echo "$row_page[LINK_FILE]_$mode.php";
			}else{
				include("$row_page[LINK_FILE]_list.php");
				//echo "$row_page[LINK_FILE]_list.php";
			}
			break;
	}
?>