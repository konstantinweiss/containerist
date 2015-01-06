<?

// outputs the container structure

$id = $id ? $id : $_GET['id'];

$raw = $raw ? $raw : $_GET['raw'];
$raw = $raw ? $raw : $param2;

$context = $context ? $context : $_GET['context'];
$context = $context ? $context : $param3;
$context = $context ? $context : 'ctn';

if (!$id) {
	print 'error: no container ID provided';
	die;
}

$vars = $_GET;
$vars['repo'] = $repo;
foreach ($path as $key=>$value) {
  $vars[$key] = $value;
}

$filepath = $repo.'/'.$context.'/'.$id.'.txt';
if (!is_file ($filepath)) {
	print 'empty.';
} else {
  $source = file_get_contents ($filepath);
  // print $source;
  if ($raw) {
    print $source;
  } else {
    print mustache ($source, $vars);
  }
}