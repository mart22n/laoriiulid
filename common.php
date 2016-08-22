<?php

define("hashtag1", "#kaubariiul");
define("hashtag2", "#moodulriiul");
define("hashtag3", "#konsoolriiul");
define("currently_displayed_item_count", "12");
define ("laomaailm_email_addr", "info@laomaailm.ee");
define ("admin_email_addr", "ottle2010@gmail.com");

date_default_timezone_set("Europe/Tallinn");
//error_reporting(-1);
//assert_options(ASSERT_ACTIVE, 1);
//assert_options(ASSERT_WARNING, 0);
//assert_options(ASSERT_BAIL, 0);
//assert_options(ASSERT_QUIET_EVAL, 0);
//assert_options(ASSERT_CALLBACK, 'assert_callcack');
//set_error_handler('error_handler');
//set_exception_handler('exception_handler');
//register_shutdown_function('shutdown_handler');

//function assert_callcack($file, $line, $message) {
//    throw new Customizable_Exception($message, null, $file, $line);
//}
//
//function error_handler($errno, $error, $file, $line, $vars) {
//    if ($errno === 0 || ($errno & error_reporting()) === 0) {
//        return;
//    }
//
//    throw new Customizable_Exception($error, $errno, $file, $line);
//}
//
//function exception_handler(Exception $e) {
//    // Do what ever!
//    echo '<pre>', print_r($e, true), '</pre>';
//    exit;
//}
//
//function shutdown_handler() {
//    try {
//        if (null !== $error = error_get_last()) {
//            throw new Customizable_Exception($error['message'], $error['type'], $error['file'], $error['line']);
//        }
//    } catch (Exception $e) {
//        exception_handler($e);
//    }
//}
//
//function exit_nicely($errormsg, $errorcode) {
//	fwrite(STDERR, $errormsg . "\n");
//	exit($errorcode);
//}
//
//class Customizable_Exception extends Exception {
//    public function __construct($message = null, $code = null, $file = null, $line = null) {
//        if ($code === null) {
//            parent::__construct($message);
//        } else {
//            parent::__construct($message, $code);
//        }
//        if ($file !== null) {
//            $this->file = $file;
//        }
//        if ($line !== null) {
//            $this->line = $line;
//        }
//    }
//}

session_start();

$servername = "localhost";
$username = "mart22n_db";
$password = "Merekurat666";
$dbname = "mart22n_db";

function create_conn() {
	global $servername, $username, $password, $dbname;
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
		fwrite(STDERR, "Connection failed: " . $conn->connect_error . "\n");
		exit(1);
	}
	return $conn;
}

function exec_query($conn, $sql) {
	$result = $conn->query($sql);
	//echo '<script type="text/javascript">alert("Error: ' . $conn->error . '");</script>';
	return $result;
}
?>