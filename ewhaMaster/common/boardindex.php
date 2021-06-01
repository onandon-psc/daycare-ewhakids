<?
session_start();
//##########################################
// 컨텐츠를 보여주기 위한 메인 페이지
// 
// $pno  ;  페이지 번호 ( 가장 중요한 인자값 )
//
// $row_page ; $pno를 이용하여 구한 페이지 설정 정보
//
//##########################################
include "../php/common.php";		// 공통 함수
include "../php/cls_db.php"	;		// DB 연결 및 상수설정

if( $pno ) {
	if( !is_numeric( $pno ) ) goBack("[E001] 접근오류");
}
if( $idx ) {
	if( !is_numeric( $idx ) ) goBack("[E002] 접근오류");
}

$pno_1 = substr($pno, 0, 2 );		// 대분류
$pno_2 = substr($pno, 2, 2 );		// 중분류
$pno_3 = substr($pno, 4, 2 );		// 소분류
/*
$_SESSION[member_id]			= "onandon";			// 테스트
$_SESSION[member_name]	= "관리자";		// 테스트
$_SESSION[member_level]		= "9";				// 테스트
*/
/*
$_SESSION[member_id]			= "";			// 테스트
$_SESSION[member_name]	= "";		// 테스트
$_SESSION[member_level]		= "";				// 테스트
*/

// 1.2 DB 정보 체크 체크
$query = "select * from board_manager where pno = :V1 and last_yn='Y' and use_yn='Y' ";
$rs->open_bind( $query, Array($pno) );
$row_page = $rs->next();
$rs->close();
if( !$row_page ) {
	goBack("존재하지 않은 페이지입니다.");
}
#$row_page[tblName] = "board_notice";
#$row_page[kind]		  = $cPageType_Board;
#$row_page[link_file]	  = "../php/board";

### 페이지 CSS 및 색상표 설정.#######
$csBdTitle	= " class='btitle$pno_1' ";
$csBdLine	= " class='bline$pno_1' ";
$csBdBack	= " class='bback$pno_1' ";
$cContentWidth=676;

#### DB 테이블 정보 ###############
$table			= $row_page[TBLNAME];
$table_hit		= "board_hit";
$table_comment	= "board_comment";
$file_url			= "../upload/$pno/";


#### 보드 정보 ###############
$boardWriteBtn				= 0 ;			// 쓰기 버튼
if( $_SESSION[member_id] ) {
	$boardWriteBtn			= 1;
	if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardWriteBtn = 0;
}
$boardReplyBtn				= 0;			// 댓글 버튼
if( $_SESSION[member_id] ) {
	$boardReplyBtn				= 1;
	if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardReplyBtn = 0;
	if( $row_page[BD_REPLY] == "N" ) $boardReplyBtn = 0;
}
$boardModifyBtn			= 0;			// 수정 버튼
if( $_SESSION[member_id] ) {
	$boardModifyBtn			= 1;
	if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardModifyBtn = 0;
}
$boardDeleteBtn			= 0;			// 삭제 버튼
if( $_SESSION[member_id] ) {
	$boardDeleteBtn			= 1;
	if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardDeleteBtn = 0;
}
$boardSecu					= 0;
if( $row_page[BD_SECU] =="Y" )	$boardSecu					= 1;
$boardFileNum			= $row_page[BD_FILE];														// 첨부파일 개수
$boardPreNext			= 0 ;		if( $row_page[BD_PRENEXT] == "Y" )  $boardPreNext	= 1;		// 이전/다음글 표시 여부
$boardComment			= 0 ;		if( $row_page[BD_COMMENT] == "Y" )	$boardComment	= 1;		// 댓글 사용여부
$boardListNum			= $row_page[BD_LIST];														// 보드 리스트 Row 수

$boardViewClick  = 1;		// View 클릭 제어
if( $row_page[BD_VIEW] > "0" && !$_SESSION[member_id] ) {
	$boardViewClick = 0;
	$boardViewScript ="alert('로그인을 하시기 바랍니다.');";
}



#### 페이지 인클루그 ###############
include "../include/head.php";		//  head
include "../include/adminbody_start.php";

#### 보드링크파일 ###############
$list_file			= $PHP_SELF."?pno=$pno&gubun=$gubun";
$write_file			= $PHP_SELF."?pno=$pno&gubun=$gubun&mode=write";
$view_file			= $PHP_SELF."?pno=$pno&gubun=$gubun&mode=view";
$modify_file		= $PHP_SELF."?pno=$pno&gubun=$gubun&mode=modify";
$delete_file		= $PHP_SELF."?pno=$pno&gubun=$gubun&mode=delete";


switch($row_page[KIND])
{
case $cPageType_Board :  // Board 타입 이면
	

	if( !$mode ) {

		include("$row_page[LINK_FILE]_list.php");

	} elseif( $mode == "write" ) {

		if( $_SESSION[member_id] == "" && $_SESSION[member_level] != "9" ) {
			goBack("[E101] 쓰기권한이 없습니다.");
		}

		switch($send ) {
		case "modify_ok":
		case "modify":
			if( !$idx ) goBack("[E101] 잘못된 접근을 하였습니다.");
			break;
		}

		include("$row_page[LINK_FILE]_write.php");

	}else if( $mode == "view" ) {

		if( !$idx ) goBack("[E201] 잘못된 접근을 하였습니다.");

		switch( $send )
		{
			case "delete":
			case "comment_write":
			case "comment_modify":
			case "comment_delete":
				if( $_SESSION[member_id] == "" && $_SESSION[member_level] != "9" ) {
					goBack("[E201] 권한이 없습니다.");
				}
				break;
		}

		include("$row_page[LINK_FILE]_$mode.php");
	}

	break;

case $cPageType_Html :		// HTML 타입이면

	$content		= stripslashes(db_lob($row_page[CONTENT]));
	$content		= str_replace("<P>","",$content);
	$content		= str_replace("</P>","<br>",$content);

	if( $content ) {
		echo $content;
	} else {
		echo ("<div align=center><img src='/images/common/ing.gif'></div>");
	}

	break;

case $cPageType_Link :		// 링크파일 이면

	if( file_exists($row_page[LINK_FILE]) ) {
		include $row_page[LINK_FILE];
	} else {
		echo ("<div align=center><img src='/images/common/ing.gif'></div>");
	}
	
	break;
}

include "../include/body_end.php";
?>