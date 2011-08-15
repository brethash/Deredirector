<?php

include('mysql.php');
include('global.php');

$sub = new PDO("mysql:host=host163.hostmonster.com;dbname=orchidtr_deredirector;","orchidtr_deredir","0-sSA$7_rQZ4");
function PDOBindArray(&$poStatement, &$paArray){
 
	foreach ($paArray as $k=>$v){

		@$poStatement->bindValue(':'.$k,$v);

	} // foreach
 
} // function
function sanitize($string){
	$disallow = array(
			'<script',
			'</script>',
			'.php',
			'.xml',
			'.js',
			'.jsp',
			'.rb',
			'.cgi',
			'.do',
			'--'
		);
	foreach ($disallow as $d){
		$string = str_replace($d,'',$string);
	}
	return $string;
}

$vars = array();
$expected = array(
		'fname',
		'lname',
		'subject',
		'question',
		'email'
	);
foreach ($expected as $e){
	if (isset($_POST[$e])){
		if ($e == 'email'){
			$discard = array('\'','"');
			$enew = str_replace($discard,'',$_POST[$e]);
			$vars[$e] = sanitize($enew);
		}
		else if ($e == 'question'){
			$vars[$e] = nl2br(sanitize($_POST[$e]));
		}
		else{
			$vars[$e] = sanitize($_POST[$e]);
		}
		$sqlvarsappend[] = $e . ', ';
		$sqlvalsappend[] = ":" . $e . ", ";
	}
}

$ssql = "INSERT INTO contact_form (" . rtrim(join('',$sqlvarsappend),', ') . ") VALUES (" . rtrim(join('',$sqlvalsappend),', ') . ")";

$submission=$sub->prepare($ssql);
PDOBindArray($submission,$vars);

// to customer
$to = $vars['email'];
$subject_mail = "Your De-Redirector Question/Comment";
$message = "<html>";
$message = "<head>";
$message = "<title>Your De-Redirector Question/Comment</title>";
$message = "</head>";
$message = "<p>Thank you for visiting deredirector.brethash.com.</p><p>Your question/comment has been received, and you will receive an appropriate response from us within 48 hours.</p>";
$headers = 'From: info@brethash.com' . "\r\n" .
    'Reply-To:info@brethash.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
// For HTML email
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// to me
$to_me = 'info@brethash.com';
$message_me = "<html>";
$message_me .= "<head>";
$message_me .= "<title>De-Redirector Request: " . $vars['subject'] . "</title>";
$message_me .= "</head>";
$message_me .= "<body>";

$message_me .= "<p>De-Redirector Request: " . $vars['subject'] . "</p>";
$message_me .= "<p>Name: " . $vars['fname'] . " " . $vars['lname'] . "</p>";
$message_me .= "<p>" . $vars['question'] . "</p>";

$message_me .= "</body>";
$message_me .= "</html>";
$headers_me = 'From: ' . $vars['fname'] . ' ' . $vars['lname'] . '<' . $vars['email']  . '>' . "\r\n" .
    'Reply-To:' . $vars['email'] . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
// For HTML email
$headers_me .= 'MIME-Version: 1.0' . "\r\n";
$headers_me .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

if($submission->execute()){
	if(mail($to,$subject_mail,$message,$headers) && mail($to_me,'De-Redirector Request: ' . $vars['subject'],$message_me,$headers_me)){
		echo 'success';
	}
}
else{
	//echo mysql_error() . 'fail';
	echo 'fail';
}
?>