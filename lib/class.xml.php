<?php

####################################################################################
#### XML관련 클라스 모음 (간단한 예)
####################################################################################

####################################################################################
#### XML관련 parsing
####################################################################################
/*
바로 처리하는 것이 좋음
$xmlUrl = "feed.xml"; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);
print_r($arrXml);

function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}
*/
class xmlparse {
	var $parser;
	var $tagname = "";
	var $filename = array();
	var $cnt = 0;
	function xml(){
		$this->parser = xml_parser_create();

		xml_set_object($this->parser, $this);
		xml_set_element_handler($this->parser, "tag_open", "tag_close");
		xml_set_character_data_handler($this->parser, "cdata");
	}

	function parse($data){
		xml_parse($this->parser, $data);
	}

	function tag_open($parser, $tag, $attributes){//테그를 열때마다실행
		if($tag == "CHANNEL"){
			$this->cnt++;
		}
		$this->tagname = $tag;
	}

	function cdata($parser, $cdata){//태그를 연후 내용 실행
		if(trim($cdata)){
			$cnt = $this->cnt;
			$this->filename[$this->tagname][$cnt] = $cdata;
		}
	}

	function tag_close($parser, $tag){ 

	}

} // end of class xml


####################################################################################
#### XML creating
####################################################################################
class xmlcreate{
	var $items					= array();
	var $printheadenable		= false; 
	var $subchannel			= 1;
	function outputXml(){
		//echo "adfasdf";
		header("Content-type: text/xml");
		printf("<?xml version=\"1.0\" encoding=\"%s\" ?>\n","utf-8");
		//print("<rss version=\"2.0\">\n");
print("<rss version=\"2.0\" xmlns:rdf=\"http://www.w3.org/1999/02/22-rdf-syntax-ns#\" xmlns:dc=\"http://purl.org/dc/elements/1.1/\" xmlns:taxo=\"http://purl.org/rss/1.0/modules/taxonomy/\">\n");
		
		
		$this->printChannel();

		print("</rss>\n");
	}
	
	function printChannel(){
		
		print("<channel>\n");
		if($this->printheadenable == true) $this->printhead();
		foreach($this->items as $item){
			while (list($name,$value) = each($item)) {
				$this->getnextdepth($name, $value);
			}			
		}
		print("</channel>\n");
	}
	

	function getnextdepth($name, $value){
		if(is_numeric($name)){//$name 이 숫자(key값이 없는 배열일경우)일경우 에러방지용
			$this->subchannel++;
			$name = "channel_sub".$this->subchannel;
		}
		if(is_array($value)){
			printf("<%s>\n",$name); 
			while (list($name1,$value1) = each($value)) {
				if(is_array($value1)){
					$this->getnextdepth($name1, $value1);
				}else{
					//$value1 = htmlspecialchars($value1);
					$name1 = strip_tags($name1);
					if($name1 == "link") $value1 = htmlspecialchars($value1);
					if($name1 == "guid") $value1 = htmlspecialchars($value1);
					switch($name1){
						case "title":
						case "description":
							printf("<%s><![CDATA[%s]]></%s>\n",$name1,$value1,$name1); 
						break;
						default:
							printf("<%s>%s</%s>\n",$name1,$value1,$name1); 
						break;
					}
				}
				
			}
			printf("</%s>\n",$name); 
		}else{
			//$value = htmlspecialchars($value);
			printf("<%s>%s</%s>\n",$name,$value,$name); 
		}
	}

	function printhead(){
		print("<title> ".$this->title." </title>\n");
		print("<link>".$this->link."</link>\n");
		print("<description>".$this->description."</description>\n");
		print("<language>".$this->language."</language>\n");
		print("<copyright>".$this->copyright."</copyright>\n");
		print("<pubDate>".date("r")."</pubDate>\n");
	}
	
	function addItem($item){
		array_push($this->items,$item);
	}


	//좀더 유연한 폼을 위해 아래로 처리(다음부터 이것으로 처리 : create type2
	//$xml_c->flushItem();//현재 배열에 들어가 있는 내용을 비운다.
	function createElement($depth, $elemnet){
		$this->elements[$depth][]	= $elemnet;
	}

	function createAttribute($depth, $attr=null){
		$this->attribute[$depth][]	= $attr;
	}

	function createTextNode($depth, $text=null){
		$this->textnode[$depth][]	= $text;
	}

	function getAttr($arr){
		//array("PageNo"=>"1", "Source"=>"image/009.jpg", "Width"=>"580", "Height"=>"838", "SceneCount"=>"6");
		$rtn = "";
		if(is_array($arr)){
			foreach($arr as $key => $val){
				$rtn .= " ".$key."=\"".$val."\"";
			}
		}
		return $rtn;
	}

	function printXml($loopcnt = 0){
		if(is_array($this->elements[$loopcnt])){
			foreach($this->elements[$loopcnt] as $key=>$val){
				$attr = $this->getAttr($this->attribute[$loopcnt][$key]);
				printf("<%s%s>\n",$val, $attr);
				if($this->textnode[$loopcnt][$key]) printf("%s",$this->textnode[$loopcnt][$key]);
				if($key	== count($this->elements[$loopcnt]) - 1){
					$loopcnt++;
					$this->printXml($loopcnt);
				}
				printf("\n</%s>\n",$val);
			}
		}
	}


}	

####################################################################################
#### XML 사용예
####################################################################################
/*

##### xml 생성 예
/wizboard/rss.php 참조

$xml_c = new xmlcreate();
//$val1["body"] = eregi_replace("[!@#$%^&()_+|]", "", $val1["body"]); 처럼 사용하여 특수문자 제거
//xml 로 생성코자 하는 내용을 배열에 넣는다
for($i=0; $i<10; $i++){//
	item = array("ordno"=> $ordno,"pname"=> $pname,"pprice"=> $pprice);
	$xml_c->addItem($item);
}

//다차원배열을 사용할경우
for($i=0; $i<10; $i++){//
	$item = array("item"=>array("title"=> $title,"link"=> $link,"guid"=> $guid,"description"=> $description,"pubDate"=> $pubDate));
	$xml_c->addItem($item);
}

$xml_c->printheadenable = true;//title등을 넣을 경우 (rss용)
$xml_c->title = "shop-wiz.com";
$xml_c->link = "http://www.shop-wiz.com";
$xml_c->description = "free solution";
$xml_c->language = "ko";
$xml_c->copyright = "Copyright(c) Shop-wiz.com. All Rights Reserved.";
$xml_c->pubDate = "shop-wiz.com";




$xml_c->outputXml();//xml 파일로 출력한다.

// 특정 파일로 만들경우
ob_start();//출력버퍼링 on(내부 버퍼에 저장되지만 출력되지 않음)
$xml_c->outputXml();//xml 파일로 출력한다.
$content = ob_get_contents();//내부 버퍼 내용을 읽어 들임
ob_end_clean();//버퍼 내용을 출력없이 삭제

$filename = "./tmp.xml";

$fp = fopen($filename, "w");
if ($fp)
{
	fputs($fp, $content);
	fclose($fp);
}


##### xml 파싱예
	$xml_p = new xmlparse();
	
	$file = "http://www.shop-wiz.com/xml/xml_test.php";//현재 xml이 존재하는 곳의 파일 url을 넣는다.
	$fp = fopen($file, "r") or die("$file not found");
	while ($data = fread($fp, 4096)) {
		$xml_p->parse($data);//특정값을 배열에 넣는다.
	}

	foreach($xml_p->filename["ordno"] as $key => $value){	
		$orderno 	= trim($xml_p->filename["ORDNO"][$key]);//값을 가져올때 대소문자에 유의한다.
		$pname 	= trim($xml_p->filename["PNAME"][$key]);
		$pprice 	= trim($xml_p->filename["PPRICE"][$key]);

	}



	###### create type2
	$xml_c->createElement(0,  "comic_data");
	$xml_c->createAttribute(0);
	$xml_c->createTextNode(0);

	$xml_c->createElement( 1, "Page");
	$attArr	 = array("PageNo"=>"1", "Source"=>"image/009.jpg", "Width"=>"580", "Height"=>"838", "SceneCount"=>"6");
	$xml_c->createAttribute( 1, $attArr);
	$xml_c->createTextNode(1);

	//for 문으로 접근
	$xml_c->createElement( 2, "Scene");
	$attArr	= array("SceneNo"=>"1", "top"=>"52", "left"=>"43", "width"=>"241", "height"=>"275");
	$xml_c->createAttribute( 2, $attArr);
	$xml_c->createTextNode(2);


$xml_c->printheadenable = false;//title등을 넣을 경우 (rss용)
$xml_c->title = "";
$xml_c->link = "";
$xml_c->description = "";
$xml_c->language = "";
$xml_c->copyright = "";
$xml_c->pubDate = "";
$xml_c->printXml();//xml 파일로 출력한다.
*/