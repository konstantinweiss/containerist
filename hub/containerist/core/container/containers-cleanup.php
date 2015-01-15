<?

/**
 * deletes all unused containers (see 'containers-unused')
 *
 * @return string / list of deleted containers.
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