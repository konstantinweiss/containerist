<?

/**
 * creates a container
 *
 * @param boolean $id ID of the contianer to be created
 * @param string $content (optional)
 * @param string $context (optional) a sub folder into which the container shall be created
 * @return content of the container or error
 */

// set stack id
$id = ($id) ? $id : $_GET['id'];
// set content. this can get more elegant
$content = $content ? $content : $_GET['content'];
if (!$content AND $param2) $content = $param2;
if (!$content) $content = '';

$context = $context ? $context : $_GET['context'];
$context = $context ? $context : $param3;
$context = $context ? $context : 'static';

if (!$id) {
	print 'error: no id set';
	die;
}

$filepath = $node->repo.'/'.CONTAINERS_DIR.$context.'/'.$id.'.txt';
	print 'mark 2: '.$filepath;
if (!is_file ($filepath)) {
	if (!is_dir ($repo.'/'.CONTAINERS_DIR.$context)) {
		mkdir ($repo.'/'.CONTAINERS_DIR.$context);
	}
	file_write ($filepath, $content);
	$hub->register_containers ();
	print $content;
} else {
	print 'error: container with this id already exists.';
}
