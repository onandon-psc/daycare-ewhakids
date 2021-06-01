<?
session_start();
//##########################################
// �������� �����ֱ� ���� ���� ������
// 
// $pno  ;  ������ ��ȣ ( ���� �߿��� ���ڰ� )
//
// $row_page ; $pno�� �̿��Ͽ� ���� ������ ���� ����
//
//##########################################
include "../php/common.php";		// ���� �Լ�
include "../php/cls_db.php"	;		// DB ���� �� �������

if( $pno ) {
	if( !is_numeric( $pno ) ) goBack("[E001] ���ٿ���");
}
if( $idx ) {
	if( !is_numeric( $idx ) ) goBack("[E002] ���ٿ���");
}

$pno_1 = substr($pno, 0, 2 );		// ��з�
$pno_2 = substr($pno, 2, 2 );		// �ߺз�
$pno_3 = substr($pno, 4, 2 );		// �Һз�
/*
$_SESSION[member_id]			= "onandon";			// �׽�Ʈ
$_SESSION[member_name]	= "������";		// �׽�Ʈ
$_SESSION[member_level]		= "9";				// �׽�Ʈ
*/
/*
$_SESSION[member_id]			= "";			// �׽�Ʈ
$_SESSION[member_name]	= "";		// �׽�Ʈ
$_SESSION[member_level]		= "";				// �׽�Ʈ
*/

// 1.2 DB ���� üũ üũ
$query = "select * from board_manager where pno = :V1 and last_yn='Y' and use_yn='Y' ";
$rs->open_bind( $query, Array($pno) );
$row_page = $rs->next();
$rs->close();
if( !$row_page ) {
	goBack("�������� ���� �������Դϴ�.");
}
#$row_page[tblName] = "board_notice";
#$row_page[kind]		  = $cPageType_Board;
#$row_page[link_file]	  = "../php/board";

### ������ CSS �� ����ǥ ����.#######
$csBdTitle	= " class='btitle$pno_1' ";
$csBdLine	= " class='bline$pno_1' ";
$csBdBack	= " class='bback$pno_1' ";
$cContentWidth=676;

#### DB ���̺� ���� ###############
$table			= $row_page[TBLNAME];
$table_hit		= "board_hit";
$table_comment	= "board_comment";
$file_url			= "../upload/$pno/";


#### ���� ���� ###############
$boardWriteBtn				= 0 ;			// ���� ��ư
if( $_SESSION[member_id] ) {
	$boardWriteBtn			= 1;
	if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardWriteBtn = 0;
}
$boardReplyBtn				= 0;			// ��� ��ư
if( $_SESSION[member_id] ) {
	$boardReplyBtn				= 1;
	if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardReplyBtn = 0;
	if( $row_page[BD_REPLY] == "N" ) $boardReplyBtn = 0;
}
$boardModifyBtn			= 0;			// ���� ��ư
if( $_SESSION[member_id] ) {
	$boardModifyBtn			= 1;
	if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardModifyBtn = 0;
}
$boardDeleteBtn			= 0;			// ���� ��ư
if( $_SESSION[member_id] ) {
	$boardDeleteBtn			= 1;
	if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardDeleteBtn = 0;
}
$boardSecu					= 0;
if( $row_page[BD_SECU] =="Y" )	$boardSecu					= 1;
$boardFileNum			= $row_page[BD_FILE];														// ÷������ ����
$boardPreNext			= 0 ;		if( $row_page[BD_PRENEXT] == "Y" )  $boardPreNext	= 1;		// ����/������ ǥ�� ����
$boardComment			= 0 ;		if( $row_page[BD_COMMENT] == "Y" )	$boardComment	= 1;		// ��� ��뿩��
$boardListNum			= $row_page[BD_LIST];														// ���� ����Ʈ Row ��

$boardViewClick  = 1;		// View Ŭ�� ����
if( $row_page[BD_VIEW] > "0" && !$_SESSION[member_id] ) {
	$boardViewClick = 0;
	$boardViewScript ="alert('�α����� �Ͻñ� �ٶ��ϴ�.');";
}



#### ������ ��Ŭ��� ###############
include "../include/head.php";		//  head
include "../include/adminbody_start.php";

#### ���帵ũ���� ###############
$list_file			= $PHP_SELF."?pno=$pno&gubun=$gubun";
$write_file			= $PHP_SELF."?pno=$pno&gubun=$gubun&mode=write";
$view_file			= $PHP_SELF."?pno=$pno&gubun=$gubun&mode=view";
$modify_file		= $PHP_SELF."?pno=$pno&gubun=$gubun&mode=modify";
$delete_file		= $PHP_SELF."?pno=$pno&gubun=$gubun&mode=delete";


switch($row_page[KIND])
{
case $cPageType_Board :  // Board Ÿ�� �̸�
	

	if( !$mode ) {

		include("$row_page[LINK_FILE]_list.php");

	} elseif( $mode == "write" ) {

		if( $_SESSION[member_id] == "" && $_SESSION[member_level] != "9" ) {
			goBack("[E101] ��������� �����ϴ�.");
		}

		switch($send ) {
		case "modify_ok":
		case "modify":
			if( !$idx ) goBack("[E101] �߸��� ������ �Ͽ����ϴ�.");
			break;
		}

		include("$row_page[LINK_FILE]_write.php");

	}else if( $mode == "view" ) {

		if( !$idx ) goBack("[E201] �߸��� ������ �Ͽ����ϴ�.");

		switch( $send )
		{
			case "delete":
			case "comment_write":
			case "comment_modify":
			case "comment_delete":
				if( $_SESSION[member_id] == "" && $_SESSION[member_level] != "9" ) {
					goBack("[E201] ������ �����ϴ�.");
				}
				break;
		}

		include("$row_page[LINK_FILE]_$mode.php");
	}

	break;

case $cPageType_Html :		// HTML Ÿ���̸�

	$content		= stripslashes(db_lob($row_page[CONTENT]));
	$content		= str_replace("<P>","",$content);
	$content		= str_replace("</P>","<br>",$content);

	if( $content ) {
		echo $content;
	} else {
		echo ("<div align=center><img src='/images/common/ing.gif'></div>");
	}

	break;

case $cPageType_Link :		// ��ũ���� �̸�

	if( file_exists($row_page[LINK_FILE]) ) {
		include $row_page[LINK_FILE];
	} else {
		echo ("<div align=center><img src='/images/common/ing.gif'></div>");
	}
	
	break;
}

include "../include/body_end.php";
?>