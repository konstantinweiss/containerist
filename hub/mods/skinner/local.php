<?php

$id = $id ? $id : $_GET['id'];

if (!$id) {
  print "mod: skinner-local\nAborted. No ID provided.";
  die;
}

// get source
$source = mod ('container', $id);
if ($source == 'empty.') {
  if (find_mod ($id)) {
    $source = mod ($id);
  } else {
    $source = mod ('storefill-prefills', $id, $_GET['stack']);
  }
}

// header
header ("Access-Control-Allow-Origin: *");
header ("Content-Type: text/html;charset=utf-8");

// $params = explode('&', $_SERVER['QUERY_STRING']);
// array_shift ($params);

// any CTN
$ctn = new CTN ($source);
$ctn->tplbase = $node->skin.'/';
$ctn->webbase = DOMAIN.$node->skin.'/';
if ($_GET['css']) $ctn->stylesheet = $_GET['css'];
print $ctn->skin();

