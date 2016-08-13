<?php
require './common.php';
?>

<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Päringu tulemused</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" href="style.css" type="text/css">
	<link href="css" rel="stylesheet" type="text/css">
	<link href="bootstrap.css" rel="stylesheet" type="text/css">
	<link href="bootstrap-responsive.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/the-modal-master/the-modal.css" media="all" />
	<script type="text/javascript">// Promises 
	var _eid_promises = {}; 
	// Turn the incoming message from extension 
	// into pending Promise resolving 
	window.addEventListener("message", function(event) { 
		if(event.source !== window) return; 
		if(event.data.src && (event.data.src === "background.js")) { 
			console.log("Page received: "); 
			console.log(event.data); 
			// Get the promise 
			if(event.data.nonce) { 
				var p = _eid_promises[event.data.nonce]; 
				// resolve 
				if(event.data.result === "ok") { 
					if(event.data.signature !== undefined) { 
						p.resolve({hex: event.data.signature}); 
					} else if(event.data.version !== undefined) { 
						p.resolve(event.data.extension + "/" + event.data.version); 
					} else if(event.data.cert !== undefined) { 
						p.resolve({hex: event.data.cert}); 
					} else { 
						console.log("No idea how to handle message"); 
						console.log(event.data); 
					} 
				} else { 
					// reject 
					p.reject(new Error(event.data.result)); 
				} 
				delete _eid_promises[event.data.nonce]; 
			} else { 
				console.log("No nonce in event msg"); 
			} 
		} 
	}, false); 
	 
	 
	function TokenSigning() { 
		function nonce() { 
			var val = ""; 
			var hex = "abcdefghijklmnopqrstuvwxyz0123456789"; 
			for(var i = 0; i < 16; i++) val += hex.charAt(Math.floor(Math.random() * hex.length)); 
			return val; 
		} 
	 
		function messagePromise(msg) { 
			return new Promise(function(resolve, reject) { 
				// amend with necessary metadata 
				msg["nonce"] = nonce(); 
				msg["src"] = "page.js"; 
				// send message 
				window.postMessage(msg, "*"); 
				// and store promise callbacks 
				_eid_promises[msg.nonce] = { 
					resolve: resolve, 
					reject: reject 
				}; 
			}); 
		} 
		this.getCertificate = function(options) { 
			var msg = {type: "CERT", lang: options.lang}; 
			console.log("getCertificate()"); 
			return messagePromise(msg); 
		}; 
		this.sign = function(cert, hash, options) { 
			var msg = {type: "SIGN", cert: cert.hex, hash: hash.hex, hashtype: hash.type, lang: options.lang}; 
			console.log("sign()"); 
			return messagePromise(msg); 
		}; 
		this.getVersion = function() { 
			console.log("getVersion()"); 
			return messagePromise({ 
				type: "VERSION" 
			}); 
		}; 
	}</script><style type="text/css"></style></head>

	<body cz-shortcut-listen="true">
        
    <div class="modal" id="riiul_modal" style="display: none">
        <a href="#" class="close">×</a>
    </div>
	<div class="container-fluid">
	<div class="row-fluid">


			<h1>Päringu tulemused</h1>
			<h4>Kasutatud laoriiulid</h4>
			
	</div>
	<div class="row-fluid">

<?php

// // Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$nimi = $_POST["nimi"]; 
$nimi = $conn->real_escape_string($nimi);

$hashtag = $_POST["hashtag"];

if(strlen($nimi) > 0) {
    if(strlen($hashtag) > 0) {
        $sql = "SELECT * FROM Riiulid WHERE nimi = '$nimi' AND hashtag = '$hashtag'";
    }
    else
    {
        $sql = "SELECT * FROM Riiulid WHERE nimi = '$nimi'";
    }
}
else {
    if(strlen($hashtag) > 0) {
        $sql = "SELECT * FROM Riiulid WHERE hashtag = '$hashtag'";
    }
}



$result_riiulid = exec_query($conn, $sql);
$riiul_index = 0;

while($result_riiulid->num_rows > $riiul_index) {
	echo
		'<div class="row-fluid">';
	for($i = 0; $i < 4 && $result_riiulid->num_rows > $riiul_index++; ++$i) {
		$row_riiul = $result_riiulid->fetch_assoc();
		echo 
		'<div class="span3 tiny" style="position:relative">
            <a class="modal_link" onClick="modal_link_click(this.id)" id="modal_link_' . $row_riiul["nimi"] . '" href="#"><span class="big_link_span"></span></a>
			<div class="pricing-table-header-tiny">
				<h2>' . $row_riiul["nimi"] . '</h2>';
				
		$sql = "SELECT pildi_nimi FROM Riiulid_pildid WHERE riiuli_nimi = '".$row_riiul['nimi']."' ";
		$result_riiulid_pildid = exec_query($conn, $sql);
		
		if ($result_riiulid_pildid->num_rows >= 1) {
			$row_riiulid_pildid = $result_riiulid_pildid->fetch_assoc();
			echo
				'<img src="' . $row_riiulid_pildid['pildi_nimi'] . '">
			</div>';
		}
		echo 
			'<div class="pricing-table-features">
				<p><strong>Augu laius</strong> ' . $row_riiul['augu_suurus'] . '</p>
				<p><strong>Augu intervall</strong> ' . $row_riiul['augu_intervall'] . '</p>
			</div>
			<div class="pricing-table-signup-tiny">
			  <p><a href="mailto:info@laomaailm.ee?Subject=' . $row_riiul["nimi"] . '" style="position:relative; z-index: 2">Telli</a></p>
			</div>
		</div>';
	}
	echo
		'</div>';
}
$conn->close();
?>
		<div class="row-fluid">
			<p><a href="http://www.laomaailm.ee/" target="_blank">Laomaailm.ee</a> | <a href="mailto:info@laomaailm.ee">info@laomaailm.ee</a></p>
		</div>
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="script.js"></script>
    <script src="/jquery.json2html-master/jquery.json2html.js"></script>
    <script src="http://json2html.com/js/json2html.js"></script>
    <script type="text/javascript" src="/the-modal-master/jquery.the-modal.js"></script>
</body></html>
