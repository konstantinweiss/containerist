<?

$old_id = $old_id ? $old_id : $_GET['old_id'];
$new_id = $new_id ? $new_id : $_GET['new_id'];

// if (!mod ('container', $old_id)) {
//   print "no container with this ID found.";
//   die;
// }

// if (mod ('container', $new_id)) {
//   print "Container with this ID already exists.";
//   die;
// }

mod ('container-rename', $old_id, $new_id);
header('Location: /'.$repo.'/'.$new_id.'.ctn.edit', TRUE, 301);