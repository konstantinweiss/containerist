<?php

class Container_Standard extends Containerist {
	var $title = '';
	var $type = 'standard';
	var $style = 'http://containerist.org/container/standard/standard.css';
	var $content = '';
	
	function output_ctn() {
		$source = "";
		$source .= '@title: '.$this->title."\n";
		$source .= '@type: '.$this->type."\n";
		if ($this->style) $source .= '@style: '.$this->style."\n";
		$source .= "\n--- CONTENT ---\n";
		$source .= $this->content;
		return $source;
	}
	
	function output_html() {
		$html = file_get_contents (FILEBASE.'/containerist/'.$this->type.'/'.$this->type.".html");
		$html = str_replace ('$meta', "", $html);
		$html = str_replace ('$content', Markdown($this->content), $html);
		$html = str_replace ('$css', $this->style, $html);
		return $html;
	}
	
	function populate_from_source ($source) {
		parent::prepopulate_from_source ($source);
		$this->content = $this->content_unstructured;
	}	
}