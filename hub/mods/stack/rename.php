<?

// renames a stack

// set old stack name
$id = ($id) ? $id : $_GET['id'];
$to = ($to) ? $to : $_GET['to'];

if (!$id OR !$to) {
	print 'error: no $id or $to parameter set';
	die;
}

$idpath = $repo.'/stacks/'.$id.'.txt';
$topath = $repo.'/stacks/'.$to.'.txt';

if (!is_file ($idpath)) {
	print 'error: stack not found.';
	die;
} else
if (is_file ($topath)) {
	print 'error: stack with new name already exists.';
	die;
} 
else {
	rename ($idpath, $topath);
	print '1';
}
