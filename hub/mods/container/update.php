<?

$id = ($id) ? $id : $_GET['id'];
if ($param2) $content = $param2;
$content = $content ? $content : $_GET['content'];

$context = $context ? $context : $_GET['context'];
$context = $context ? $context : $param3;

if (!$id) {
	print 'error: no id given';
	die;
}
if (!$content) {
  print 'error: no content given';
  die;
}

if (!$context) $context = 'ctn';
$filepath = $repo.'/'.$context.'/'.$id.'.txt';
if (!is_file ($filepath)) {
  print 'error: no container with this id found.';
  die;
}

file_write ($filepath, $content);
print '1';