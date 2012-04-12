<?php

class Container_Page extends Containerist {
	var $title = '';
	var $style = 'http://page.containerist.org/theme/page.css';
	var $origin = '';
	var $cargo = array();
	
	function output_ctn() {
		$source = "";
		foreach ($this->cargo as $ctn_origin) {
			$source .= $ctn_origin."\n";
		}
		return $source;
	}
	
	function output_html() {
		$html = file_get_contents (FILEBASE.'/containerist/page/page.html');
		$html = str_replace ('$title', $this->title, $html);
		$html = str_replace ('$css', $this->style, $html);
		$html = str_replace ('$origin', $this->origin, $html);
		$ctn_tpl = file_get_contents (FILEBASE.'/containerist/page/page_container.html');
		$cargo_html = "";
		$i = 0;
		foreach ($this->cargo as $ctn_origin) {
			$ctn_html = $ctn_tpl;
			$ctn_html = str_replace ('$origin', $ctn_origin, $ctn_html);
			$ctn_html = str_replace ('$i', $i, $ctn_html);
			$ctn_html = str_replace ('$webbase', WEBBASE, $ctn_html);
			$cargo_html .= $ctn_html;
			$i++;
		}
		$html = str_replace ('$cargo', $cargo_html, $html);
		return $html;
	}
	
	function populate_from_source ($source) {
		$ctns = explode ("\n", $source);
		foreach ($ctns as $ctn_origin) {
			if ($ctn_origin != "") {
				array_push ($this->cargo, $ctn_origin);
			}
		}
	}	
}