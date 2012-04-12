<?php

class Container_Image extends Containerist {
	var $title = '';
	var $type = 'image';
	var $style = 'http://containerist.org/container/image/image.css';
	var $images = array();
	
	function output_ctn() {
		$source = "";
		$keys = array_keys($this->meta);
		$i = 0;
		foreach($this->meta as $param) {
			$source .= "@".$keys[$i].": ".$param."\n";
			$i++;
		}
		$source .= "\n--- CONTENT ---\n";
		foreach ($this->images as $image) {
			$source .= $image."\n";
		}
		return $source;
	}
	
	function output_html() {
		$html = file_get_contents (FILEBASE.'/containerist/'.$this->type.'/'.$this->type.".html");
		$html = str_replace ('$meta', "", $html);
		$html = str_replace ('$css', $this->style, $html);
		$content_html = "";
		foreach ($this->images as $image) {
			$content_html .= '<img src="'.$image.'">'."\n";
		}
		$html = str_replace ('$content', $content_html, $html);
		return $html;
	}
	
	function populate_from_source ($source) {
		parent::prepopulate_from_source ($source);
		$img_lines = explode("\n", $this->content_unstructured);
		foreach ($img_lines as $img) {
			if ($img != "") {
				array_push ($this->images, $img);
			}
		}
	}	
}