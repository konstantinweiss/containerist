<?

// outputs the container source

$id = $id ? $id : $_GET['id'];

$raw = $raw ? $raw : $_GET['raw'];
$raw = $raw ? $raw : $param2;

if (!$id) {
	print 'error: no container ID provided';
	die;
}


$filepath = $hub->containers[$id];
if (!$filepath) {
	print 'empty.';
} else {
  $source = file_get_contents ($filepath);
  // print $source;
  if ($raw) {
    print $source;
  } else {
    $vars = $_GET;
    $vars['repo'] = $node->repo;
    foreach ($path as $key=>$value) {
      $vars[$key] = $value;
    }
    print mustache ($source, $vars);
  }
}