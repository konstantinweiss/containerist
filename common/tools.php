<?

/**
 * A File contains several global Functions
 * Most of these functions are only ocasionally used.
 * @author Konstantin Weiss <k@konstantinweiss.com>
 * @package Containerist
 */

// ######### Sanitization Tools ########################################

function sanitize_text($text){
	$clean = stripslashes(strip_tags($text, "<a><i><b><em><strong><blockquote><q><ul><ol><li>"));
	return $clean;
}

function sanitize_array($array){
	foreach ($array as $key => $value){
		if(is_array($value)){
			$clean[$key] = sanitize_array($value);
		}else{
			$clean[$key] = sanitize_text($value);
		}
	}
	return $clean;
}

function sanitize($mixed){
	if(is_array($mixed)){
		$clean = sanitize_array($mixed);
	}else{
		$clean = sanitize_text($mixed);
	}
	return $clean;
}

function clean_str($waste, $str) {
	if (is_array($waste)) {
		foreach ($waste_array as $piece) {
			$str = str_replace($piece, '', $str);
		}
	} else {
		$str = str_replace($waste, '', $str);
	}
	return $str;
}

function sort_articles($articles) {
	// make an array of dates from the $articles array
	$dates = array();
	foreach ($articles as $article) {
		if (!in_array($article->date, $dates)) {
			array_push($dates, $article->date);
		}
	}
	// sort by date, newest first
	rsort($dates);
	// make a new array of articles
	$new_articles = array();
	foreach ($dates as $date) {
		foreach ($articles as $article) {
			if ($article->date == $date) {
				array_push($new_articles, $article);
			}
		}
	}
	return $new_articles;
}

function delete_in_array ($array, $victim) {
	$new = array();
	foreach ($array as $element) {
		if ($element != $victim) array_push($new, $element);
	}
	return $new;
}

function directory_subtract_topics ($files) {
	$new_files = array();
	foreach ($files as $f) {
		if (!in_str(SLUG_TOPIC.'/', $f)) {
			array_push($new_files, $f);
		}
	}
	return $new_files;
}

// ############# PATH Functions ########################################


function extract_id ($_str) {
	$str1 = array_pop(explode("/", $_str));
	return str_replace('.txt', '', $str1);
}

function extract_path ($_str) {
	$filepath = str_replace(SYSBASE.'/', '', $_str);
	$path = str_replace('.txt', '', $filepath);
	return $path;
}

function article_path_by_id ($_nid) {
	$pool_basefilepaths = directory_to_array_recursive($SYSBASE);
	
	foreach ($pool_basefilepaths as $pool_basefilepath) {
		$pool_id = extract_id($pool_basefilepath);
		if ($pool_id == $_nid) {
			$path = extract_path($pool_basefilepath);
		}
	}
	return $path;
}

function is_hidden ($id) {
	$hidden = substr($id, 0, 1) == '_' ? true : false;
	return $hidden;
}





// ######### Files and Directories ########################################

function directory_to_array($path){
	$array = array();
	$handle = opendir ($path);
	$counter = 0;
	while (false !== ($file = readdir ($handle))) {
		if(!($file=="." or $file==".." or substr($file, 0,1)==".")){
			$array[$counter] = $file;
			$counter++;
		}
	}
	if(count($array)){
		sort($array);
	}
	return $array;
}

function directory_to_array_recursive($path, $result = array()){
  
  $array = directory_to_array($path);
  foreach($array as $fileorfolder){
    //print "$fileorfolder";
    if(is_dir($path."/".$fileorfolder) and !($fileorfolder=="." or substr($fileorfolder, 0,1)==".")){
      //print "Folder:".$path."/".$fileorfolder."\n";
      $result = directory_to_array_recursive($path."/".$fileorfolder, $result);
    }else{
      //print "File".$path."/".$fileorfolder."\n";
      $result[$path."/".$fileorfolder] = $path."/".$fileorfolder;
    }
  }
  return $result;
  
}

function directory_txts ($path, $result = array()){
  
  $array = directory_to_array($path);
  foreach($array as $fileorfolder){
    if(is_dir($path."/".$fileorfolder) and !($fileorfolder=="." or substr($fileorfolder, 0,1)==".")){
      $result = directory_txts ($path."/".$fileorfolder, $result);
    }else{
			if (substr($fileorfolder, -4, 4) == '.txt' and !is_hidden($fileorfolder)) {
	      $result[$path."/".$fileorfolder] = $path."/".$fileorfolder;
			}
    }
  }
  return $result;
  
}






function directory_get_folder_from_path($path){
  if(is_dir($path)){
    return $path;
  }elseif(is_file($path)){
    $pieces = explode("/", $path);
    array_pop($pieces);
    $folder = implode("/", $pieces);
    return $folder;
  }else{
    return false;
  }
}




// ############# STRING-Funtkionen ######################################

function in_str($needle, $haystack) {
	$result = false;
	if (strpos($haystack, $needle) !== false) {
		$result = true;
	}
	return $result;
}

function utf16_to_utf8($str) {
    $c0 = ord($str[0]);
    $c1 = ord($str[1]);

    if ($c0 == 0xFE && $c1 == 0xFF) {
        $be = true;
    } else if ($c0 == 0xFF && $c1 == 0xFE) {
        $be = false;
    } else {
        return $str;
    }

    $str = substr($str, 2);
    $len = strlen($str);
    $dec = '';
    for ($i = 0; $i < $len; $i += 2) {
        $c = ($be) ? ord($str[$i]) << 8 | ord($str[$i + 1]) : 
                ord($str[$i + 1]) << 8 | ord($str[$i]);
        if ($c >= 0x0001 && $c <= 0x007F) {
            $dec .= chr($c);
        } else if ($c > 0x07FF) {
            $dec .= chr(0xE0 | (($c >> 12) & 0x0F));
            $dec .= chr(0x80 | (($c >>  6) & 0x3F));
            $dec .= chr(0x80 | (($c >>  0) & 0x3F));
        } else {
            $dec .= chr(0xC0 | (($c >>  6) & 0x1F));
            $dec .= chr(0x80 | (($c >>  0) & 0x3F));
        }
    }
    return $dec;
}




// ############# Field Functions ######################################

function field_content ($obj, $field_type) {
	$content = false;
	foreach ($obj->fields as $field) {
		if ($field->type == $field_type) $content = $field->content;
	}
	return $content;
}




// ############# HTTP-Funtkionen ######################################

function http_request($url, $headers = array(), $method = 'GET', $data = NULL, $retry = 3) {
  global $db_prefix;

  $result = new stdClass();

  // Parse the URL and make sure we can handle the schema.
  $uri = parse_url($url);

  if ($uri == FALSE) {
    $result->error = 'unable to parse URL';
    $result->code = -1001;
    return $result;
  }

  if (!isset($uri['scheme'])) {
    $result->error = 'missing schema';
    $result->code = -1002;
    return $result;
  }

  switch ($uri['scheme']) {
    case 'http':
    case 'feed':
      $port = isset($uri['port']) ? $uri['port'] : 80;
      $host = $uri['host'] . ($port != 80 ? ':'. $port : '');
      $fp = @fsockopen($uri['host'], $port, $errno, $errstr, 15);
      break;
    case 'https':
      // Note: Only works for PHP 4.3 compiled with OpenSSL.
      $port = isset($uri['port']) ? $uri['port'] : 443;
      $host = $uri['host'] . ($port != 443 ? ':'. $port : '');
      $fp = @fsockopen('ssl://'. $uri['host'], $port, $errno, $errstr, 20);
      break;
    default:
      $result->error = 'invalid schema '. $uri['scheme'];
      $result->code = -1003;
      return $result;
  }

  // Make sure the socket opened properly.
  if (!$fp) {
    // When a network error occurs, we use a negative number so it does not
    // clash with the HTTP status codes.
    $result->code = -$errno;
    $result->error = trim($errstr);

    // Mark that this request failed. This will trigger a check of the web
    // server's ability to make outgoing HTTP requests the next time that
    // requirements checking is performed.
    // @see system_requirements()

    return $result;
  }

  // Construct the path to act on.
  $path = isset($uri['path']) ? $uri['path'] : '/';
  if (isset($uri['query'])) {
    $path .= '?'. $uri['query'];
  }

  // Create HTTP request.
  $defaults = array(
    // RFC 2616: "non-standard ports MUST, default ports MAY be included".
    // We don't add the port to prevent from breaking rewrite rules checking the
    // host that do not take into account the port number.
    'Host' => "Host: $host",
    'User-Agent' => 'User-Agent: Containerist (+http://containerist.org/)',
  );

  // Only add Content-Length if we actually have any content or if it is a POST
  // or PUT request. Some non-standard servers get confused by Content-Length in
  // at least HEAD/GET requests, and Squid always requires Content-Length in
  // POST/PUT requests.
  $content_length = strlen($data);
  if ($content_length > 0 || $method == 'POST' || $method == 'PUT') {
    $defaults['Content-Length'] = 'Content-Length: '. $content_length;
  }

  // If the server url has a user then attempt to use basic authentication
  if (isset($uri['user'])) {
    $defaults['Authorization'] = 'Authorization: Basic '. base64_encode($uri['user'] . (!empty($uri['pass']) ? ":". $uri['pass'] : ''));
  }

  foreach ($headers as $header => $value) {
    $defaults[$header] = $header .': '. $value;
  }

  $request = $method .' '. $path ." HTTP/1.0\r\n";
  $request .= implode("\r\n", $defaults);
  $request .= "\r\n\r\n";
  $request .= $data;

  $result->request = $request;

  fwrite($fp, $request);

  // Fetch response.
  $response = '';
  while (!feof($fp) && $chunk = fread($fp, 1024)) {
    $response .= $chunk;
  }
  fclose($fp);

  // Parse response.
  list($split, $result->data) = explode("\r\n\r\n", $response, 2);
  $split = preg_split("/\r\n|\n|\r/", $split);

  list($protocol, $code, $status_message) = explode(' ', trim(array_shift($split)), 3);
  $result->protocol = $protocol;
  $result->status_message = $status_message;

  $result->headers = array();

  // Parse headers.
  while ($line = trim(array_shift($split))) {
    list($header, $value) = explode(':', $line, 2);
    if (isset($result->headers[$header]) && $header == 'Set-Cookie') {
      // RFC 2109: the Set-Cookie response header comprises the token Set-
      // Cookie:, followed by a comma-separated list of one or more cookies.
      $result->headers[$header] .= ','. trim($value);
    }
    else {
      $result->headers[$header] = trim($value);
    }
  }

  $responses = array(
    100 => 'Continue', 101 => 'Switching Protocols',
    200 => 'OK', 201 => 'Created', 202 => 'Accepted', 203 => 'Non-Authoritative Information', 204 => 'No Content', 205 => 'Reset Content', 206 => 'Partial Content',
    300 => 'Multiple Choices', 301 => 'Moved Permanently', 302 => 'Found', 303 => 'See Other', 304 => 'Not Modified', 305 => 'Use Proxy', 307 => 'Temporary Redirect',
    400 => 'Bad Request', 401 => 'Unauthorized', 402 => 'Payment Required', 403 => 'Forbidden', 404 => 'Not Found', 405 => 'Method Not Allowed', 406 => 'Not Acceptable', 407 => 'Proxy Authentication Required', 408 => 'Request Time-out', 409 => 'Conflict', 410 => 'Gone', 411 => 'Length Required', 412 => 'Precondition Failed', 413 => 'Request Entity Too Large', 414 => 'Request-URI Too Large', 415 => 'Unsupported Media Type', 416 => 'Requested range not satisfiable', 417 => 'Expectation Failed',
    500 => 'Internal Server Error', 501 => 'Not Implemented', 502 => 'Bad Gateway', 503 => 'Service Unavailable', 504 => 'Gateway Time-out', 505 => 'HTTP Version not supported'
  );
  // RFC 2616 states that all unknown HTTP codes must be treated the same as the
  // base code in their class.
  if (!isset($responses[$code])) {
    $code = floor($code / 100) * 100;
  }

  switch ($code) {
    case 200: // OK
    case 304: // Not modified
      break;
    case 301: // Moved permanently
    case 302: // Moved temporarily
    case 307: // Moved temporarily
      $location = $result->headers['Location'];

      if ($retry) {
        $result = http_request($result->headers['Location'], $headers, $method, $data, --$retry);
        $result->redirect_code = $result->code;
      }
      $result->redirect_url = $location;

      break;
    default:
      $result->error = $status_message;
  }

  $result->code = $code;
  return $result;
}