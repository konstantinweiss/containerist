<?

$id = $id ? $id : $_GET['id'];
$stack = $stack ? $stack : $_GET['stack'];
$stack = $stack ? $stack : $path->second;

?>
CTN: standard
class: storefill containerist-ui
stylesheet: //<?=$module_dir?>style.css
---
New container.

[Fill empty](<?=$id?>.ctn.edit) or prefill with: 

CTN: tiles
class: flex storefill containerist-ui
stylesheet: //<?=$module_dir?>style.css
items:
 - 
   title : Standard
   image : /<?=$module_dir?>templates/standard.png
   url   : <?=$stack?>/storefill.mod?id=<?=$id?>&type=standard 
 - 
   title : Image
   image : /<?=$module_dir?>templates/image.png
   url   : <?=$stack?>/storefill.mod?id=<?=$id?>&type=image 
 - 
   title : Tiles
   image : /<?=$module_dir?>templates/tiles.png
   url   : <?=$stack?>/storefill.mod?id=<?=$id?>&type=tiles 
 - 
   title : Nav
   image : /<?=$module_dir?>templates/nav.png
   url   : <?=$stack?>/storefill.mod?id=<?=$id?>&type=nav    