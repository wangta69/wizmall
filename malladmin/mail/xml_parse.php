<?php
class xml {
var $parser;
var $tagname = "";
var $filename = array();
function xml() 
{
$this->parser = xml_parser_create();

xml_set_object($this->parser, $this);
xml_set_element_handler($this->parser, "tag_open", "tag_close");
xml_set_character_data_handler($this->parser, "cdata");
}

function parse($data) 
{
xml_parse($this->parser, $data);
}

function tag_open($parser, $tag, $attributes) 
{

$this->tagname = $tag;
}

function cdata($parser, $cdata) 
{

//if($this->tagname == "ORDNO" && trim($cdata)){
	//$this->filename[$this->tagname] = $cdata;
	if(trim($cdata)){
	$this->filename[$this->tagname][] = $cdata;
	//echo $this->tagname.":".$cdata."<br />";
	}
//}
}

function tag_close($parser, $tag) 
{ 

}

}