<?php
	include('include/class.php');
	
	mysql_connect('host163.hostmonster.com', 'orchidtr_deredir', '0-sSA$7_rQZ4') or exit(mysql_error());
	mysql_select_db('orchidtr_deredirector') or exit(mysql_error());
	
	function is_valid_callback($subject){
	    $identifier_syntax
	      = '/^[$_\p{L}][$_\p{L}\p{Mn}\p{Mc}\p{Nd}\p{Pc}\x{200C}\x{200D}]*+$/u';

	    $reserved_words = array('break', 'do', 'instanceof', 'typeof', 'case',
	      'else', 'new', 'var', 'catch', 'finally', 'return', 'void', 'continue',
	      'for', 'switch', 'while', 'debugger', 'function', 'this', 'with',
	      'default', 'if', 'throw', 'delete', 'in', 'try', 'class', 'enum',
	      'extends', 'super', 'const', 'export', 'import', 'implements', 'let',
	      'private', 'public', 'yield', 'interface', 'package', 'protected',
	      'static', 'null', 'true', 'false');

	    return preg_match($identifier_syntax, $subject) && !in_array(mb_strtolower($subject, 'UTF-8'), $reserved_words);
	}
	
	header('content-type: application/json; charset=utf-8');
	if (isset($_GET['id'])){
		$account = $_GET['id'];
		
		$sql = 'SELECT * FROM accounts WHERE account = "' . $account . '"';
		$sql_results = mysql_query($sql);
		$row = mysql_fetch_assoc($sql_results);
	 	
		if (empty($row)){
			$result = 'You provided incorrect authentication information. Please check your credentials.';
		}
		else{
			if (isset($_GET['q'])){
				$query = explode('||',$_GET['q']);
			}
			foreach ($query as $q){
				$q = trim($q);
				if ($q != ''){
					if (stripos($q,'http://') != 0){
						$q = 'http://' . $q;
					}

					$c = new url_request($q);

					$data = $c->get();
					if ($data == 'no'){
						$result =  'no';
					}
					else{
						$headers = $c->getHeaders();
						$result[] = $headers['url'];
					}	
				}
				else{
					$result[] = 'empty';
				}
			}
		}
		$result = json_encode($result);

		# JSON if no callback
		if(!isset($_GET['callback'])){
			exit($result);
		}

		# JSONP if valid callback
		if(is_valid_callback($_GET['callback'])){
			exit("{$_GET['callback']}($result)");
		}

		# Otherwise, bad request
		header('Status: 400 Bad Request', true, 400);
	}
	else{
		$result = 'Please provide valid authentication credentials.';
	}
?>