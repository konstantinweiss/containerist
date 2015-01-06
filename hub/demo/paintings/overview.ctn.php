<?
$data_source = mod ('container', 'paintings', false, 'paintings');
$ctn = new CTN_single ($data_source);

$module_slug = 'painting';


// set type to tiles
$ctn->CTN = 'tiles';
$ctn->topimage = true;

// set url, image and teaser text
foreach ($ctn->items as $i=>$item) {
  $ctn->items[$i]['url'] = $module_slug.'/'.$item['id'];
  $ctn->items[$i]['image'] = $item['id'].'.jpg';
  $text  = $item['year'].'<br/>';
  $text .= $item['size'].', '.$item['material'].'<br/>';
  $ctn->items[$i]['text'] = $text;
}

// unset what's internal
unset ($ctn->tplbase);
unset ($ctn->webbase);

// output
print $ctn->structure();
