<?

// creates a new, empty stack

// set stack id
$id = ($id) ? $id : $_GET['id'];
if ($param2) $content = $param2;
$content = ($content) ? $content : $_GET['content'];

if (!$id) {
	print 'error: no id given';
	die;
}
if (!$content) {
  print 'error: no content given';
  die;
}

$filepath = $repo.'/stacks/'.$id.'.txt';
if (!is_file ($filepath)) {
  print 'error: no stack with this id found.';
  die;
}

$content = str_replace ('.ctn', '', $content);
$stack = new CTN_single ($content);
unset ($stack->site);
unset ($stack->renderer);
print $stack->structure();
// print $content;
file_write ($filepath, $stack->structure());
print '1';