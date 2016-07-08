<?php
require './common.php';

function display_first_items($conn, $result) {
$item_index = 0;
$row_index = 0;

	while($result->num_rows > $item_index) {
		echo
			'<div id="item_row_' . $row_index++ . '" class="row-fluid item-row">';
		for($i = 0; $i < 4 && $result->num_rows > $item_index++; ++$i) {
			$item_record = $result->fetch_assoc();
			echo 
                '<div id="box">
                    <div class="span3">
					    <a class="modal_link" onClick="modal_link_click(this.id)" id="modal_link_' . $item_record["nimi"] . '" href="#"><span class="big_link_span"></span></a>';	
			$sql = "SELECT pildi_nimi FROM Items_pictures WHERE riiuli_nimi = '".$item_record['nimi']."' ";
			$result_items_pictures = exec_query($conn, $sql);
			
			if ($result_items_pictures->num_rows >= 1) {
				$items_pictures_record = $result_items_pictures->fetch_assoc();
				echo
                        '<img class="tootepilt" src="' . $items_pictures_record['pildi_nimi'] . '">
                        <div id="bottomtext">
					        <h3>' . $item_record["nimi"] . '</h3>';
			}
			echo 
                            '<div id="textinfo">
						        Augu laius: ' . $item_record['augu_suurus'] . '<br><br>
						        Augu intervall: ' . $item_record['augu_intervall'] . '<br><br>
						        Saadavus: ' . $item_record["saadavus"] . '
					        </div>
                            <a class="btn" href="mailto:info@laomaailm.ee?Subject=' . $item_record["nimi"] . '"><div class="buttoninside">TELLI</div></a>
				        </div>
                    </div>
                </div>';
		}
		echo
			'</div>';
	}
	echo 
            '<div id="item_row_' . $row_index++ . '" class="row-fluid item-row">
		</div>';
	$conn->close();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<title>Laoriiulid</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link media="screen" rel="stylesheet" type="text/css" href="style.css" />
	<link href='http://fonts.googleapis.com/css?family=Old+Standard+TT:400,400italic' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="stylesheet" href="style.css" type="text/css">
	<link href="css" rel="stylesheet" type="text/css">
	<link href="bootstrap.css" rel="stylesheet" type="text/css">
	<link href="bootstrap-responsive.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="/the-modal-master/the-modal.css" media="all" />
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
	<style type="text/css">
		@-moz-document url-prefix() {
		  .buttoninside {
		padding-left: 25px;
		padding-top: 6px;
		margin-left: 105px;
		margin-top: 38px;
		width: 70px;
		height: 35px;
		background: url(images/btn.png) repeat-x;
		}
	}
	</style>
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
        
    <div class="modal" id="item_info_modal" style="display: none">
        <a href="#" class="close">×</a>
    </div>
	<div class="ylatext">Laoriiulid</div>
	<div class="alatext">Kasutatud laoriiulid</div>
			
	<div style=" width:100%">
		<div style="margin:0 auto; display: table;">
			<div style="display:table-cell;">
				<form style="margin:auto 3px;" class="pure-form pure-form-aligned" action="index.php" method="post">
					<button name="#hashtag1" type="submit" class="pure-button pure-button-primary">#hashtag1</button>
				</form>
			</div>
			<div style="display:table-cell;"> 
				<form style="margin:auto 3px;" class="pure-form pure-form-aligned" action="index.php" method="post">
					<button name="#hashtag2" type="submit" class="pure-button pure-button-primary">#hashtag2</button>
				</form>
			</div>
			<div style="display:table-cell;">   
				<form style="margin:auto 3px;" class="pure-form pure-form-aligned" action="index.php" method="post">
					<button name="#hashtag3" type="submit" class="pure-button pure-button-primary">#hashtag3</button>
				</form>
			</div>
		</div>
	</div>
    
<?php

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$currently_displayed_item_count = 8;
if(isset($_POST["#hashtag1"])) {
    $hashtag = $_POST["#hashtag1"];
    $sql = "SELECT * FROM Items WHERE hashtag = '#hashtag1' LIMIT " . $currently_displayed_item_count . "";
}

else if(isset($_POST["#hashtag2"])) {
    $hashtag = $_POST["#hashtag2"];
    $sql = "SELECT * FROM Items WHERE hashtag = '#hashtag2' LIMIT " . $currently_displayed_item_count . "";
}

else if(isset($_POST["#hashtag3"])) {
    $hashtag = $_POST["#hashtag3"];
    $sql = "SELECT * FROM Items WHERE hashtag = '#hashtag3' LIMIT " . $currently_displayed_item_count . "";
}
else {
    $sql = "SELECT * FROM Items LIMIT " . $currently_displayed_item_count . "";
}

$result_items = exec_query($conn, $sql);
echo $conn->error;
display_first_items($conn, $result_items);
?>
	<div class="row-fluid">
		<p><a href="http://www.laomaailm.ee/" target="_blank">Laomaailm.ee</a> | <a href="mailto:info@laomaailm.ee">info@laomaailm.ee</a></p>
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="script.js"></script>
    <script src="/jquery.json2html-master/jquery.json2html.js"></script>
    <script src="/jquery.json2html-master/json2html.js"></script>
    <script type="text/javascript" src="/the-modal-master/jquery.the-modal.js"></script>
</body></html>
