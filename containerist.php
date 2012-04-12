<?php

require_once ('config.php');

require_once ('common/tools.php');
require_once ('common/markdown.php');
require_once ('standard/standard.php');
require_once ('info-quad/info-quad.php');
require_once ('image/image.php');
require_once ('t-quad/t-quad.php');
require_once ('page/page.php');

# header ("Content-Type: text/plain;charset=utf-8");

class Container {
	
	var $type = false;
	var $origin = false;
	
	function Container ($origin = false) {
		if ($origin) {
			$this->origin = $origin;
			$this->load($this->origin);
		}
	}
	
	function set_type ($type) {
		$this->type = $type;
		switch ($this->type) {
			case 'standard'		: $this->container = new Container_Standard (); break;
			case 'info-quad'	: $this->container = new Container_InfoQuad (); break;
			case 't-quad'		: $this->container = new Container_TQuad (); break;
			case 'image'		: $this->container = new Container_Image (); break;
		}
	}
	
	function load ($origin) {
		$origin = (in_str('http://', $origin)) ? $origin : 'http://'.$origin;
		$c = new Containerist ();
		if (in_str(WEBBASE, $origin) && !in_str('.php', $origin)) {
			$c->load_file($origin);
		} else {
			$c->load_url ($origin);
		}
		$this->set_type ($c->type);
		$this->container->populate_from_source ($c->source);
	}
	
	function load_file ($file_origin) {
		$file_origin = str_replace (WEBBASE, FILEBASE, $origin);
		$source = file_get_contents ($file_origin);
		$c->prepopulate_from_source($source);
		$this->source = $c->source;
		$this->type = $c->type;
	}
	
	function html() {
		return $this->container->output_html();
	}
	
	function ctn () {
		return $this->container->output_ctn();
	}
	
	function output () {
		if ($_GET['ctn'] == true) {
			header ("Content-Type: text/plain;charset=utf-8");
			print $this->ctn();
		} else {
			header ("Content-Type: text/html;charset=utf-8");
			print $this->html();
		}
	}
}

class Containerist {
	
	function load_url ($origin) {
		$this->source = $this->load_from_url ($origin);
		$this->prepopulate_from_source($this->source);
	}
	
	function load_file ($file_origin) {
		$this->source = file_get_contents ($file_origin);
		$this->prepopulate_from_source($this->source);
	}

	function load_from_url ($origin) {
		$url = str_replace (' ', '%20', $origin);
		$request = http_request($url);
		if ($request->code == 200) {
			return $request->data;
		} else {
			print "failed, request code: ".$request->code;
		}
	}

	function detect_type () {
		return $this->type;
	}

	function structure_meta ($str) {
		$lines = explode("\n", $str);
		$meta = array();
		foreach ($lines as $line) {
			$param = $this->parse_parameter ($line);
			switch ($param->key) {
				case 'title': $this->title = $param->value; break;
				case 'type' : $this->type  = $param->value; break;
				case 'style': $this->style = $param->value; break;
			}
			$meta[$param->key] = $param->value;
		}
		$this->meta = $meta;
	}

	function prepopulate_from_source ($source) {
		$this->source = $source;
		$regions = explode("\n\n--- CONTENT ---\n", $source);
		$this->structure_meta ($regions[0]);
		$this->content_unstructured = $regions[1];
	}	

	function parse_block ($str_block) {
		$lines = explode ("\n", $str_block);
		$params = array();
		foreach ($lines as $line) {
			if ($line != "") {
				$param = $this->parse_parameter ($line);
				$params[$param->key] = $param->value;
#				array_push ($params, $param);
			}
		}
		return ($params);
	}

	function parse_parameter ($str) {
		$keyval = explode (': ', $str);
		$param->key = str_replace ('@', '', $keyval[0]);
		$param->value = $keyval[1];
		return $param;
	}
}