<?php
	include('class.php');
	/*
		http://awe.sm/5Qkks
		http://twtpoll.com/tn3p7n
	*/
	if (isset($_POST['url'])){
		if ($_POST['url'] != ''){
			if (stripos($_POST['url'],'http://') != 0){
				$url = 'http://' . $_POST['url'];
			}
			else{
				$url = $_POST['url'];
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