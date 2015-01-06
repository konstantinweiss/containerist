<?
define ("LIB", "mods/lib/");

define ("DOMAIN",   "");
define ("SKINNING_LOCAL", "true");

define ("YARD_RENDERER", DOMAIN."html/");
define ('SKIN', 'squareone');

define ('CTN_TPLBASE', 'skins/'.SKIN.'/');
define ('CTN_WEBBASE', 'http://'.DOMAIN.'skins/'.$skin.'/');
$domain = DOMAIN;




include_once (LIB.'common/tools.php');
include_once (LIB.'yaml/yaml.php');
include_once (LIB.'mustache/mustache.php');
include_once (LIB.'markdown/markdown.php');
include_once (LIB.'containerist/ctn.php');
include_once (LIB.'path/path.php');

