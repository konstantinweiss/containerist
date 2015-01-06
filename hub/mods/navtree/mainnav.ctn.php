<?
$stack = ($stack) ? $stack : $_GET['stack'];
if ($node->stack_id) {
	$stack = ($stack) ? $stack : $node->stack_id;
}

$tpl  = file_get_contents ($module_dir.'mainnav.tpl.txt');
$data = mod ('container', 'navtree', false, 'navtree');
if ($data == 'empty.') {
	$data = file_get_contents ($module_dir.'data.txt');
	mod ('container-create', 'navtree', $data, 'navtree');
}
$data = yaml_read ($data);

// set selected nav item
foreach ($data['items'] as $i=>$item) {
	if ($item['url'] == $stack) {
		$data['items'][$i]['selected'] = 'selected';
	}
}

print mustache ($tpl, $data);