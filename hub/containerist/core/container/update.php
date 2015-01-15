<?

/**
 * updates the content of a container
 *
 * @param string   $id      ID of the contianer to be updated
 * @param string   $content The new content
 * @return boolean          Success
 */

$id = ($id) ? $id : $_GET['id'];

if ($param2) $content = $param2;
$content = $content ? $content : $_GET['content'];

if (!$id) {
	print 'error: no id given';
	die;
}
if (!$content) {
  print 'error: no content given';
  die;
}

$filepath = $hub->containers[$id];
if (!$filepath) {
  print 'error: no container with this id found.';
  die;
}

file_write ($filepath, $content);
print '1';