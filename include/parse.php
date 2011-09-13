<?php
	include('class.php');

	if (isset($_POST['url'])){
		$url = trim($_POST['url']);
		if ($url != ''){
			if (stripos($url,'http://') != 0){
				$url = 'http://' . $url;
			}

			$c = new url_request($url);

			$data = $c->get();
			if ($data == 'no'){
				echo 'no';
			}
			else{
				$headers = $c->getHeaders();
				echo '<a href="' . $headers['url'] . '">' . $headers['url'] . '</a>';
			}	
		}
		else{
			echo 'empty';
		}
	}
?>