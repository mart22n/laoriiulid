<?php require './common.php'; ?>
<html>
<head>
<title>Admin panel</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<link rel="stylesheet" href="admin.css">
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>
</head>
	<body>
		<div style="width: 100%; display: table;">
			<div style="display: table-row">
				<div style="width: 600px; display: table-cell;"> 
					<form class="pure-form pure-form-aligned" action="add_item.php" method="post" target="hiddenFrame">
						<fieldset>
							<div class="pure-control-group">
								<label>Toote nimi</label>
								<input name="nimi" type="text" placeholder="Toote nimi" required>
							</div>

							<div class="pure-control-group">
								<label>Augu suurus</label>
								<input name="augu_suurus" type="text" placeholder="Augu suurus" required>
							</div>

							<div class="pure-control-group">
								<label>Augu intervall</label>
								<input name="augu_intervall" type="text" placeholder="Augu intervall" required>
							</div>

							<div class="pure-control-group">
								<label>Saadavus</label>
								<select name="saadavus">
									<option>Laos olemas</option>
									<option>Tellimisel</option>
								</select>
							</div>
												
							<div class="pure-control-group">
								<label>Link  http://</label>
								<input name="link" type="text" placeholder="Link">
							</div>	
							
							<div class="pure-control-group">
								<label>Hashtag</label>
								<select name="hashtag">
									<option>#hashtag1</option>
									<option>#hashtag2</option>
									<option>#hashtag3</option>
								</select>
							</div>
								
							<div class="pure-control-group">
								<label>Soovitused</label>
								<textarea name="soovitused" placeholder="Soovitused"></textarea>
							</div>	
							
							<div class="pure-control-group">
								<label>Alternatiivid</label>
								<textarea name="alternatiivid" placeholder="Alternatiivid"></textarea>
							</div>

							<div class="pure-control-group">
							<label></label>
							<button id="add_item" type="submit" class="pure-button pure-button-primary" onclick="btnLisa_click()">Lisa!</button>
							</div>	
							
						</fieldset>
					</form>
				</div>
				<div style="display: table-cell;">
					<div class="container">
						<label><b>Lisa pilte (j&auml;rgmise pildi lisamiseks vajuta nuppu "sirvi/lehitse")</b></label>
						<br>
						<br>
						<br>
						<form id="upload" method="post" action="upload.php" enctype="multipart/form-data" target="hiddenFrame">
							<div id="drop">
								<input type="file" name="fileToUpload" id="fileToUpload"/>
								<!-- <button type="submit" class="pure-button pure-button-primary" name="submit">Lae &uumlles!</button> -->
								<input type="button"  class="pure-button  pure-button-primary" id="upload_button" value="Lae pilt &uuml;les" onclick="upload()"/>
								<br>
                                <br>
                                <div id="pildi_nimi">&Uuml;leslaetud pildid: <br></div>
                                <iframe id="hiddenFrame" name="hiddenFrame" class="hide"></iframe>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- JavaScript Includes -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<!-- Our main JS file -->
	<script src="script.js"></script>

	</body>
</html>