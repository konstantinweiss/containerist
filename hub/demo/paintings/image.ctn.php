<?
$data_source = mod ('container', 'paintings', false, 'paintings');
$ctn = new CTN_single ($data_source);

$id = $node->last;

foreach ($ctn->items as $item) {
	if ($item['id'] == $id) {
		$painting = $item;
	}
}

// print_r ($painting);
?>CTN: image
image: <?=$painting['id']?>.jpg
