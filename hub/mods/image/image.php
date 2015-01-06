<?

// displays an image.

$id = $id ? $id : $_GET['id'];
$id = $id ? $id : $node->last;

$img_src = DOMAIN.$node->repo.'/images/'.$id;

print $img_src;

header("Location: $img_src");