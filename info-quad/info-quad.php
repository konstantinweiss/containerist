<?php

class Container_InfoQuad extends Containerist {
	var $title = '';
	var $type = 'standard';
	var $style = 'http://containerist.org/container/info-quad/info-quad.css';
	var $content = '';
	
	function output_ctn() {
		$source = "";
		$source .= '@title: '.$this->title."\n";
		$source .= '@type: '.$this->type."\n";
		if ($this->style) $source .= '@style: '.$this->style."\n";
		$source .= "\n--- CONTENT ---\n";
		foreach ($this->items as $item) {
			$source .= "## Teaser:\n";
			$keys = array_keys($item);
			$i = 0;
			foreach($item as $value) {
				$source .= "@".$keys[$i].": ";
				$source .= $value."\n";
				$i++;
			}
			$source .= "\n";
		}
		return $source;
	}
	
	function output_html() {
		$html = file_get_contents (FILEBASE.'/containerist/'.$this->type.'/'.$this->type.".html");
		$html = str_replace ('$meta', "", $html);
		$html = str_replace ('$style', $this->style, $html);
		$item_tpl = file_get_contents (FILEBASE.'/containerist/'.$this->type.'/'.$this->type."_item.html");
		$content_html = "";
		foreach ($this->items as $item) {
			$item_html = $item_tpl;
			$keys = array_keys($item);
			$i = 0;
			foreach($item as $value) {
				$item_html = str_replace('$item_'.$keys[$i], $value, $item_html);
				$i++;
			}
			$content_html .= $item_html;
		}
		$html = str_replace ('$content', $content_html, $html);
		return $html;
	}
	
	function populate_from_source ($source) {
		parent::prepopulate_from_source ($source);
		$this->content = $this->structure_content();
	}
	
	function structure_content () {
		$item_strs = explode("## Teaser:\n", $this->content_unstructured);
		array_shift($item_strs);
		$items = array();
		foreach ($item_strs as $str) {
			$item = parent::parse_block($str);
			array_push($items, $item);
		}
		$this->items = $items;
	}
}