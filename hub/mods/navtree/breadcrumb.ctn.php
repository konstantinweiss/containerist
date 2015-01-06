<?
$stack = ($stack) ? $stack : $_GET['stack'];
if ($path->third) {
	$stack = ($stack) ? $stack : $path->second;
}

$data = mod ('container', 'navtree', false, 'navtree');
$data = yaml_read ($data);

foreach ($data['items'] as $item) {
	if ($item['url'] == $stack) {
		if ($item['url'] != 'index') {
			print "[Home](index) → [".$item['label']."](".$item['url'].")";
		} else {
			print "Home";
		}
	}
}
