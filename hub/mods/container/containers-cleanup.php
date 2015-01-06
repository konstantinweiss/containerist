<?

/*
 *  lists all unused containers of this repo.
 */ 

$unused = yaml_read (mod ('containers-unused'));

print "deleted: \n";

$any = false;
foreach ($unused['items'] as $id) {
  $any = true;
  print "$id\n";
  mod ('container-delete', $id);
}

if (!$any) {
  print "none.";
}