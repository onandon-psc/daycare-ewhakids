<?
	include "../../include/global/config.php";
	//##########################################
	// 컨텐츠를 보여주기 위한 메인 페이지
	//
	// $pno  ;  페이지 번호 ( 가장 중요한 인자값 )
	//
	// $row_page ; $pno를 이용하여 구한 페이지 설정 정보
	//
	//##########################################

	//---------------------------------------
	//   페이지 접속 통계
	//---------------------------------------
	$toDay = strtotime(date("Y-m-d"));
	/*
	$query = "SELECT * FROM ddm_page_count WHERE regdate='$toDay' && pno='$pno'";
	$result	= mysql_query($query);
	$row		= @mysql_fetch_array($result);

	if($row[pno]){
		$query = "UPDATE ddm_page_count SET count=count+1 WHERE regdate='$toDay' && pno='$pno'";
	}else{
		$query  ="INSERT INTO ddm_page_count (regdate,pno,count) VALUES ('$toDay','$pno','1')";
	}
	mysql_query($query);
	*/
	//---------------------------------------
	//   환경 설정 상수
	//---------------------------------------

	//###  페이지 타입 #####//
	$cPageType_Board = "1";         // Board 타입
	$cPageType_Html	= "2";
	$cPageType_Link		= "3";
	$cPageType_Toys	= "4";          //장난감도서관 관련
	$cPageType_Par		= "5";          //평가인증자료실

	//include "common.php";     // 공통 함수

	$indexKind = "2";

	//if ($pno=='080201') {echo "<script>alert('시범서비스 중입니다. \\n\\n회원가입이 불가능하십니다.');history.back();</script>";}
	//include "cls_db.php"  ;       // DB 연결 및 상수설정

	if( empty($pno) ) $pno = "010101";

	if( !empty($pno) ) {
		if( !is_numeric( $pno ) ) goBack("[E001] 접근오류");
	}
	if( !empty($board_idx) ) {
		if( !is_numeric( $board_idx ) ) goBack("[E002] 접근오류");
	}

	if(!stristr($HTTP_HOST,"develop")){
	//	if(in_array(substr($pno,0,2),array("08"))){
	//			goBack("준비중입니다.");
	//	}
	}

	$pno_1 = substr($pno, 0, 2 );       // Depth1
	$pno_2 = substr($pno, 2, 2 );       // Depth2
	$pno_3 = substr($pno, 4, 2 );       // Depth3
	$pno_4 = substr($pno, 6, 2 );       // Depth4

	// 1.2 DB 정보 체크 체크
	$query	= "SELECT * FROM BOARD_MANAGER WHERE PNO='$pno'  AND LAST_YN='Y' AND USE_YN='Y' ";
	$result	= mysql_query($query);
	$row_page = @mysql_fetch_array($result);


	### 페이지 CSS 및 색상표 설정.#######
	$depth01 = intval(substr($pno,0,2));
	$depth02 = intval(substr($pno,2,2));
	$depth03 = intval(substr($pno,4,2));
	$depth04 = intval(substr($pno,6,2));


	### 페이지 CSS 및 색상표 설정.#######
	$csBdTitle  = " class='btitle$pno_1' ";
	$csBdLine   = " class='bline$pno_1' ";
	$csBdBack   = " class='bback$pno_1' ";
	$cContentWidth=676;


	#### DB 테이블 정보 ###############
	$table					= $row_page[TBLNAME];
	$boardHit_table	= "ddm_board_hit";
	$table_hit				= "board_hit";
	$table_comment	= "board_comment";
	$file_url					= "../../upload/board/";

	#### 보드 정보 ###############
	$boardWriteBtn              = 0 ;           // 쓰기 버튼
	if( $_SESSION[member_id] ) {
		$boardWriteBtn          = 1;
		if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardWriteBtn = 0;
	}
	$boardReplyBtn              = 0;            // 댓글 버튼
	if( $_SESSION[member_id] ) {
		$boardReplyBtn              = 1;
		if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardReplyBtn = 0;
		if( $row_page[BD_REPLY] == "N" ) $boardReplyBtn = 0;
	}
	$boardModifyBtn         = 0;            // 수정 버튼
	if( $_SESSION[member_id] ) {
		$boardModifyBtn         = 1;
		if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardModifyBtn = 0;
	}
	$boardDeleteBtn         = 0;            // 삭제 버튼
	if( $_SESSION[member_id] ) {
		$boardDeleteBtn         = 1;
		if( $row_page[BD_WRITE] == "9"  && $_SESSION[member_level] != '9' ) $boardDeleteBtn = 0;
	}
	$boardSecu				    = 0;
	if( $row_page[BD_SECU] =="Y" )  $boardSecu                  = 1;
	$boardFileNum				= $row_page[BD_FILE];                                                                           // 첨부파일 개수
	$boardPreNext				= 0 ;       if( $row_page[BD_PRENEXT] == "Y" )  $boardPreNext   = 1;       // 이전/다음글 표시 여부
	$boardComment			= 0 ;       if( $row_page[BD_COMMENT] == "Y" )  $boardComment   = 1;   // 댓글 사용여부
	$boardListNum				= $row_page[BD_LIST];                                                                          // 보드 리스트 Row 수

	$boardTab					= $row_page[TAB_FILE];                                                                         // Tab 메뉴파일
	$boardStyle					= $row_page[BOARDKIND];                                                                     // 게시판 스타일

	$boardViewClick  = 1;       // View 클릭 제어
	if( $row_page[BD_VIEW] > "0" && !$_SESSION[member_id] ) {
		$boardViewClick = 0;
		$boardViewScript ="alert('로그인을 하시기 바랍니다.');";
	}

	$week_arr = array("<span style='color:red'>일</span>", "월", "화", "수", "목", "금", "<span style='color:blue'>토</span>");

	//echo $_SESSION['masterSession']."*";
	#### 페이지 인클루그 ###############
?>