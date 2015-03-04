<?php
class database
{

	var $debug		= 0; #디버깅관련 출력
	var $dbcon		= 0;

	var $query_id	= 0;
	var $row_array	= array();
	var $row		= 1;

	##  blob 
	var $blob_id = 0;
	var $blob_mode = -1;
	var $byte_text;
	
//참조 :  
//http://www.startupcto.com/backend-tech/going-utf-8-utf8-with-php-and-mysql : any latin1 (iso-8859-1) characters to utf8 characters:
//http://jejucity.org/entry/mysql-utf8-utf-8-%EB%B3%80%ED%99%98 
	
	function database($cfg){
		$this->dbcon = !$this->dbcon ? mysql_connect($cfg["host"], $cfg["id"], $cfg["pwd"]): "";
		mysql_select_db($cfg["dbname"], $this->dbcon);
		if ( !$this->dbcon ) {echo "sql 데이터 베이스에 연결할 수 없습니다."; exit;}
		//mysql_query("set names euckr"); //나중에 변수 받아 자동으로 처리되게 조정
		//mysql_query("set names utf-8"); //예전버젼과 호환성 문제
		//mysql_query("set names utf8");
		//현재를 아래것이 미완성 전체적으로 인자값 수정요망
		$tmp =  explode( ".", mysql_get_server_info());//// 5.0.37-log  4.0.1-alpha

		if($cfg["common"]["lan"] == "euc-kr"){
			mysql_query("set names euckr");
		}else {
			if($tmp[0] >=  5){
				mysql_query("set names utf8");
			}else{
				mysql_query("set names utf-8");
			}

			
		}

	}


########## database 관련 에러문 출력	
	function alert($msg) {
		printf("<b>database error:</b> %s<br>\n", $msg);
		exit;
	}
	
	function error($msg, $err, $flag=TRUE) {##플래그 내용은 _query 참조
		echo "<br> ------------------------------ <br>";
		echo "Error : ".mysql_error($this->dbcon)."<br>";
		//echo "Error : ".$err."<br>";
		echo "OutPut Message : ".$msg;
		echo "<br> ------------------------------ <br>";
		if ($flag) exit;
	}

	function print_error($header = "None haeder"){
		printf("<b>%s : %s:%s <br>\n", $header, $this->errno, $this->alert);
	}


	function check_error($result_id) {
		if (!strcmp($result_id, " "))	{ 		// Found error
			$this->alert = mysql_error($result_id);
			return 0;
		}
		else {        				// Not found error
			$this->alert = " ";
			return 1;
		}
	}

		

########## database 관련 기본 명령 재 정의	
	function _query($str, $flag=TRUE){##
	##플래그 값 TRUE : 에러가 존재시 멈춤, FALSE : 에러존재시 계속진행(롤백관련)
		if(!$str) $this->error("string 이 존재 하지 않습니다.", mysql_error(),$flag);
		if(is_numeric($flag)){
			if($flag == 1) echo $str;
			if($flag == 2){ echo $str;exit;}
		}
		if($flag == FALSE){
			$result = mysql_query($str, $this->dbcon);//에러 무시하고 바로 진행
		}else{
			$result = mysql_query($str, $this->dbcon) or $this->error($str, mysql_error(),$flag);
			//echo $result = mysql_query($str, $this->dbcon) or die(mysql_error());
		}

		$this->query_id = $result;
		return $result;
	}
/*
	function query($query_string, $type = 0) {
	$this->connect();
	
	if( $this->debug ) echo $query_string."<hr>";
	
	$this->query_id = mysql_query($query_string, $this->link_id);
	
	$this->row   = 1;
	if (!$this->query_id) {
	if($this->check_error($this->link_id)){
	$this->print_error("query() - 2");
	$this->alert("Invalid SQL: ".$query_string);
	}
	}

	*/
	//$this->query_id = mysql_query($query_string, $this->link_id);
	function _fetch_array($qry=null, $type=3){
		#type : MYSQL_ASSOC, MYSQL_NUM, MYSQL_BOTH;
		if(is_int($qry)){$type = $qry;$qry=null;}//현재 타입을 배고하여 _fetch_array(3) 이런식으로 넘어온 값들을 변환
		$qry = $qry ? $qry : $this->query_id;
		if(!$qry){ $this->error("query 결과값이 없습니다", mysql_error(),$flag); exit;}
		return mysql_fetch_array($qry, $type);
	}
	
	function _fetch_assoc($result=null){
		$result = $result ? $result : $this->query_id;
		return mysql_fetch_assoc($result);
	}

	function _num_rows($result=null){
		$result = $result ? $result : $this->query_id;
		return mysql_num_rows($result);
	}

	function _affected_rows($result=null){
		$result = $result ? $result : $this->query_id;
		return mysql_affected_rows($result);
	}

	function _data_seek($result=null, $cnt){
		$result = $result ? $result : $this->query_id;
		return @mysql_data_seek($result, $cnt);
	}

	function _insert_id(){
		return  mysql_insert_id();
	}

	function _close(){
		mysql_close($this->dbcon);
	}

	function _drop_table($tablename){
		$sqlstr = "DROP TABLE IF EXISTS `".$tablename."`";
		$this->_query($sqlstr);
	}

	function _result($row, $cnt, $result=null){
		$result = $result ? $result : $this->query_id;
		return mysql_result($result, $row, $cnt);
	}

	function _free_result(){
		mysql_free_result();
	}

########## database 관련 간략 사용
/*	function get_rows( $type=3 ){## 사용하지 말것 이후 string으로 변경
		if($this->query_id > 0){
			$this->row_array = $this->_fetch_array($type);		
			if(!$this->check_error($this->link_id)) $this->print_error("next_record()");
			$stat = is_array($this->row_array);
			if (!$stat) {
				if($this->blob_id) $this->_free_result($this->query_id);
				$this->query_id = 0;
			}else return $this->row_array;
		}else return 0;
	}
 추후 아래것으로 테스트 후 상기것을 대체*/
	public function get_rows($str) {
		$result = $this->_query($str);
		while($row=mysql_fetch_array($result, MYSQL_ASSOC)) $arr[]=$row;
		return $arr;
	}

	


	//배열로 변환하여 값 전달(이후 상ㅇ기 get_rows를 대체)
	public function fetch_array($str) {
		$result = $this->_query($str);
		
		while($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
			$arr[]=$row;
		}
		return $arr;
	}

	
	function get_row($str, $flag=TRUE){
		$this->_query($str, $flag);
		$list = $this->_fetch_array();
		return $list;
	}

	function get_one($str){
		$this->_query($str);
		$list = $this->_fetch_array();
		return $list[0];
	}

	function num_rows($str){
		$this->_query($str);
		$result = $this->_num_rows();
		return $result;
	}


	function is_table($tablename){
		$this->_query("SHOW TABLES");
		while($list = $this->_fetch_array()):
			if ( strtolower( (string)$list[0] ) == strtolower( (string)$tablename ) ) return true;
		endwhile;
		return false;
	}

  # 요청한 데이타를 저장한다.
  function Insert ($query) {
    if(!$this->isConnect()) $this->Connect();

    if (!($this->result = @mysql_query($query, $this->id))) {
      $this->gMessage = $query." : ".mysql_error();
      return false;
    }
    $this->a_rows = @mysql_affected_rows($this->id);
    return true;
  }

  # 요청한 데이타를 업데이트한다.
  function Update ($query) {
    if(!$this->isConnect()) $this->Connect();

    if (!($this->result = @mysql_query($query, $this->id))) {
      $this->gMessage = $query." : ".mysql_error();
      return false;
    }
    $this->a_rows = @mysql_affected_rows($this->id);
    return true;
  }

  # 요청한 데이타를 삭제한다.
  function Delete ($query) {
    if(!$this->isConnect()) $this->Connect();

    if (!($this->result = @mysql_query($query, $this->id))) {
      $this->gMessage = $query." : ".mysql_error();
      return false;
    }
    $this->a_rows = @mysql_affected_rows($this->id);
    return true;
  }

	## 사용법
	## field : Array ("filed1"=>$value1, "field2"=>$value2);
	function insertData($tablename, $field) {

		$fieldname=$this->fieldname($field);

		$sql="insert into ".$tablename;
		foreach($fieldname as $key => $val) {
				$check=$key+1;
				$check2=$key-1;
				if($fieldname[$check]!="") {
					if($fieldname[$check2]=="") {
						$fields.=" (".$val.", ";
						$values.="'".$field[$val]."', ";
					}
					else {
						$fields.=$val.", ";
						$values.="'".$field[$val]."', ";
					}
				}
				else {
					$fields.=$val.") values(";
					$values.="'".$field[$val]."') ";
				}
		}
		$sql=$sql.$fields.$values;

		$result=$this->_query($sql);
		return $result;
	}

/*****************************************
	데이터 수정(업데이트)
*****************************************/
	function updateData($tablename, $field, $where) {

		$where = " where ".$where;

		unset($field[$escape]);

		$fieldname=$this->fieldname($field);

		$sql="update ".$tablename." set ";
		$check=0;
		foreach($field as $key => $val) {
			if($fieldname[$check+1]) {
				$order.=$fieldname[$check]."='".$val."', ";
			}
			else {
				$order.=$fieldname[$check]."='".$val."' ";
			}
			$check++;
		}

		$sql.=$order.$where;

		$result=$this->_query($sql);
		return $result;
	}

/******************************************
	데이터 삭제
******************************************/
	function deleteData($tablename, $where, $backURL="") {
		$where = " where ".$where;
		$sql="delete from ".$tablename." ".$where;
		$result=$this->_query($sql);
		return $result;
	}

	function fieldname($data) {
		foreach($data as $key => $val) {
				$keyname[]=$key;
		}
		return $keyname;
	}

function _b_to_blob(&$content){
	return $content;
}

function db_date_format($field){
	return "DATE_FORMAT(".$field.", '%Y-%m-%d') as date";
}

function db_date_format_noalias($field){
	return "DATE_FORMAT(".$field.", '%Y-%m-%d')";
}

########## database 세부 사용

	function _getone($str){//<-- 위의 것으로 통일(함수 규칙을 위해)
		$this->_query($str);
		$list = $this->_fetch_array();
		return $list[0];
	}
	
	function getone($str){//<-- 위의 것으로 통일(함수 규칙을 위해)
		$this->_query($str);
		$list = $this->_fetch_array();
		return $list[0];
	}

	function get_count($select, $from, $where, $orderby){


	}
	
	function get_select($select, $from, $where, $orderby=null, $limit1=null, $limit2=null, $op=null){
		# $orderby 인자값 : 필드명@정렬 으로 전송, 혹은 field1 asc, field2 desc
		$tmp = explode("@", $orderby);
		if ($tmp[1]) $orderby = $tmp[0]." ".$tmp[1];
		$sqlstr = "select ".$select." from ".$from;
		if($where) $sqlstr .= " ".$where;
		if($orderby) $sqlstr .= " order by ".str_replace("order by", "", $orderby);
		if(is_int($limit1)) $sqlstr .= " limit ".$limit1;
		if($limit2) $sqlstr .= " ,".$limit2;
		//if($op == 1) echo $sqlstr;//출력
		if($this->debug == true) echo $sqlstr;
		$result = $this->_query($sqlstr);
		return $result;		
	}
	

	## get_date 와 paging 은 한번에 사용하는 것이 좋으며 아래와 같이 사용하시면 됩니다.
	/***

	$result = $this->get_date($tbname, $fields, $whereis, $order, $cp, 10, 10);

	## 페이징 관련
	$head = "next.php";
	$attr["form"] = "search_frm";
	$paging = $this->mydb->paging($head, $attr);


	책크
	<script>
	function postSend(url, form){//페이징관련처리
	if(form == "undefined" || form == ""){
	form = "postForm";	
	}
	var formid = eval("$('#"+form+"')");
	formid.attr("action", url);
	formid.submit();
	}
	</script>

	<form id="postForm">
	</form>

	****/

	##  상기 get_select 와 동일 아래것을 이용할 예정
	##
	public function get_date($tablename, $field, $where="", $order="", $page=1, $listno=10, $pageno=10, $flag=null){
		//$flag[] : Array "rand"
		# $orderby 인자값 : 필드명@정렬 으로 전송, 혹은 field1 asc, field2 desc
		//$tmp = explode("\@", $orderby);
		//if ($tmp[1]) $orderby = $tmp[0]." ".$tmp[1];
		$this->listno		= $listno;
		$this->pageno		= $pageno;
		$this->page		= $page ? $page:1;
		

		$start	= ($this->page - 1) * $listno;

		$sqlstr = "select count(*) from ".$tablename." ".$where;
		$this->total = $this->get_one($sqlstr);//total을 리턴한다.
		
		$orderby = $order;
		$limit = "limit ".$start.", ".$listno;

		$sqlstr = "select ".$field." from ".$tablename." ".$where." ".$orderby." ".$limit;
		return $this->get_rows($sqlstr);
	
	}
########## database 롤백관련
	function _rollback($flag=0){#롤백관련
		switch($flag){
			case 1:$str="commit"; $this->_rollback(3);break;
			case 2:$str="rollback";break;
			case 3:$str="set autocommit=1";break;
			default:$str="set autocommit=0";break;
		}
			
		/*switch($flag){
			case 1:$str="submit";break;
			case 2:$str="rollback";break;
			//case 3:$str="set autocommit=1";break;
			default:$str="begin";break;
		}*/
		$this->_query($str);
	}
	
	function _exe_rollback($arr){#롤백관련, $arr:배열
		$cnt = count($arr);
		foreach($arr as $val) if($val) $cnt--;
		return $cnt==0 ? $this->_rollback(1) : $this->_rollback(2) ;
	}
	
	function _rollbackMsg(){
		echo "table type : MYISAM : 불가 , InnoDB : 가능";
		echo " create table test (.............)type=BDB;";
	}

	
########## database 시스템 정보 관련
	function _get_system_info(){
		echo "<br>-------------------------------------<br>";
		echo "client_info:".mysql_get_client_info()."<br>"; 
		echo "host_info:".mysql_get_host_info()."<br>"; 
		echo "proto_info:".mysql_get_proto_info()."<br>"; 
		echo "server_info:".mysql_get_server_info()."<br>"; 
		echo "<br>-------------------------------------<br>";
	}
		
/*
	
	##  blob 
	var $blob_id = 0;
	var $blob_mode = -1;
	var $byte_text;
	function debug( $arg ) {
		$this->debug = $arg;
	}
	

	

	
	// 1 is using scroll cursor
	function query($query_string, $type = 0) {
	$this->connect();
	
	if( $this->debug ) echo $query_string."<hr>";
	
	$this->query_id = mysql_query($query_string, $this->link_id);
	
	$this->row   = 1;
	if (!$this->query_id) {
	if($this->check_error($this->link_id)){
	$this->print_error("query() - 2");
	$this->alert("Invalid SQL: ".$query_string);
	}
	}
	
	
	return $this->query_id;
	}
	
	function next_record( $type=3 ){
		if($this->query_id > 0){
			$this->record = mysql_fetch_array($this->query_id,$type);
			
			if(!$this->check_error($this->link_id))
			$this->print_error("next_record()");
			
			$stat = is_array($this->record);
			
			if (!$stat) {
				if($this->blob_id)
				mysql_free_result($this->query_id);
				$this->query_id = 0;
			}
			return $stat;
		}
	return 0;
	}
	
	function next_record_array(){
		return $this->record;
	}
	
	function next_record_ex(&$record){
	if($this->query_id > 0){
	$record = mysql_fetch_array($this->query_id);
	
	if(!$this->check_error($this->link_id))
	$this->print_error("next_record_ex()");
	
	$stat = is_array($record);
	
	if (!$stat) {
	if($this->blob_id)
	mysql_free_result($this->query_id);
	$this->query_id = 0;
	}
	return $stat;
	}
	return 0;
	}
	
	function seek($pos) {
	$this->row = $pos;
	if($this->row > 0)
	mysql_data_seek($this->query_id, $this->row - 1 );
	
	}

	
	function num_fields() {
	return mysql_num_fields($this->query_id);
	}
	
	function nf() {
	return $this->num_rows();
	}
	

	function f($Name) {
	return $this->record[$Name];
	}
	



	
	function _db_to_blob(&$content){
	return "'$content'";
	}
	
	function _db_date_format($field){
	return "DATE_FORMAT($field, '%Y-%m-%d') as date";
	}
	
	function _db_date_format_noalias($field){
	return "DATE_FORMAT($field, '%Y-%m-%d')";
	}
	
	$_DB_HINT_FAST_FIRST_ROWS = "";
	$_DB_HINT_BOARD_DOC_INDEX = "";
	$_DB_HINT_TOTAL_DOC_INDEX = "";
	
	#current virsion support scroll & sequence cursor 
	$_DB_CURSOR_TYPE = 1 //if 1, use scroll cursor, 
	//but DB is not support, then set = 1
	
	//대표적인 예
	//$query = "select count(1) from 테이명 group by 필드명";
	//$db->query($query);
	//$total = $db->num_rows();
	
	
	//$query = "select count(1) from 테이블명";
	//$db->query($query);
	//$db->next_record();
	//$total = $db->f(0);
	
	//$sqlstr = "select * from 테이블명";
	//$db->query($sqlstr);
	//while( $db->next_record() ) {
	//	extract( $db->next_record_array() );//필드명에 맞추어 변수 반환
	//}
	*/
}			