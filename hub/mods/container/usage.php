<?

$id = ($id) ? $id : $_GET['id'];

if (!$id) {
	print 'error: no container id given';
	die;
}

$list = yaml_read (mod ('stacks'));
$list = $list['items'];

$usage = array ();
foreach ($list as $stack_id) {
  $stack_source = mod ('stack', $stack_id);
  $stack = new CTN_single ($stack_source);
  foreach ($stack->origins as $name_) {
    $name = extract_name ($name_);
    if ($name == $id) {
      array_push ($usage, $stack_id);
    }
  }
}

$ctn->CTN = 'list';
$ctn->items = $usage;
print_r (yaml_ctn ($ctn));