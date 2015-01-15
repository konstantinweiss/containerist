<?

$id = $id ? $id : $_GET['id'];
if (!$id) { print "mod: node\nError: no ID provided\n"; }

$source = mod ('container', $id);
if ($source == 'empty.') {
  if ($hub->has_container_mod ($id)) {
    $source = mod ($id);
  } 
  // else if ($editable) {
  //   $source = mod ('storefill-prefills', $path->name, $_GET['stack']);
  // } 
  else {
    $source = "";
  }

}
print $source;
