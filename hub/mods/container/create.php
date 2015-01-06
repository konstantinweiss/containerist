<?

// creates a new, empty stack

// set stack id
$id = ($id) ? $id : $_GET['id'];
// set content. this can get more elegant
$content = $content ? $content : $_GET['content'];
if (!$content AND $param2) $content = $param2;
if (!$content) $content = '';

$context = $context ? $context : $_GET['module'];
$context = $context ? $context : $param3;
$context = $context ? $context : 'ctn';

if (!$id) {
	print 'error: no id set';
	die;
}

$filepath = $repo.'/'.$context.'/'.$id.'.txt';
	print 'mark 2: '.$filepath;
if (!is_file ($filepath)) {
	if (!is_dir ($repo.'/'.$context)) {
		mkdir ($repo.'/'.$context);
	}
	file_write ($filepath, $content);
	print $content;
	print '1';
} else {
	print 'error: container with this id already exists.';
}
