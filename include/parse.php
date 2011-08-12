<?php
	include('class.php');
	/*
		http://awe.sm/5Qkks
		http://twtpoll.com/tn3p7n
	*/
	if (isset($_POST['url'])){
		if ($_POST['url'] != ''){
			/*$ch = curl_init();

			// set url
			curl_setopt($ch, CURLOPT_URL, $_POST['url']);

			//return the result as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);

			// if the string is a valid bit.ly, gaw.kr
			if (substr($output,0,4) == "<htm"){
			    $start = strpos($output,'a href="');
				$end = strpos($output,'">moved here<');
				$result = substr($output,$start + 8,$end-$start - 13);
				echo '<a href="' . $result . '">' . $result . '</a>';
			}
			// if the string is a valid goo.gl
			else if(substr($output,0,4) == "<HTM"){
				$start = strpos($output,'moved <A HREF="');
				$end = strpos($output,'">here<');
				$result = substr($output,$start + 15,$end-$start - 15);
				echo '<a href="' . $result . '">' . $result . '</a>';
			}
			else{
				echo 'fail';
			}
			// close curl
			curl_close($ch);*/
			
			$c = new Curl_example(array('report'=>213,'token'=>'some string'), $_POST['url']);

			$data = $c->get();

			$headers = $c->getHeaders();
			echo '<a href="' . $headers['url'] . '">' . $headers['url'] . '</a>';
		}
		else{
			echo 'empty';
		}
		
	}
	
?>