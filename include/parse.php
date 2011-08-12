<?php
	/*if (isset($_POST['url'])){
		if ($_POST['url'] != ''){
			$ch = curl_init();

			// set url
			curl_setopt($ch, CURLOPT_URL, $_POST['url']);

			//return the result as a string
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);

			// if the string is not a valid bitly, return fail
			if (substr($output,0,2) != "<!"){
			    $start = strpos($output,'a href="');
				$end = strpos($output,'">moved here<');
				$result = substr($output,$start + 8,$end-$start - 13);
				echo '<a href="' . $result . '">' . $result . '</a>';
			}
			else{
				echo 'fail';
			}
			// close curl
			curl_close($ch);
		}
		else{
			echo 'empty';
		}
	}*/
	$ch = curl_init();

	// set url
	curl_setopt($ch, CURLOPT_URL, $_POST['url']);

	//return the result as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$output = curl_exec($ch);
	
	echo $output;
?>