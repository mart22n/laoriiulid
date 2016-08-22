<?php require './common.php'; ?>
<html>
<head>
<title>Admin panel</title>
<meta charset="UTF-8">
<link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.6.0/pure-min.css">
<link rel="stylesheet" href="style.css">
<style>
  .hide { position:absolute; top:-1px; left:-1px; width:1px; height:1px; }
</style>
</head>
	<body>
		<div style="width: 100%; display: table;">
			<div style="display: table-row">
				<div style="width: 750px; display: table-cell;">
					<h4>Toote lisamiseks, muutmiseks või kustutamiseks vali esmalt toode "Toote nimi" alt:</h4>
					<iframe name="hiddenFrame" class="hide"></iframe>
					<form id="admin_form" class="pure-form pure-form-aligned" action="" method="post" target="hiddenFrame">
						<fieldset>
							<div id="item_name_div" class="pure-control-group">
								<label>Toote nimi</label>
								<input name="nimi_input" id="nimi_input" type="text" placeholder="Toote nimi" style="display: none;" required>
								<select name="nimi" id="nimi">
								</select>
							</div>

							<div class="pure-control-group">
								<label>Augu suurus</label>
								<input name="augu_suurus" id="augu_suurus" type="text" placeholder="Augu suurus" required>
							</div>

							<div class="pure-control-group">
								<label>Augu intervall</label>
								<input name="augu_intervall" id="augu_intervall" type="text" placeholder="Augu intervall" required>
							</div>

							<div class="pure-control-group">
								<label>Saadavus</label>
								<select name="saadavus" id="saadavus">
									<option>Laos olemas</option>
									<option>Tellimisel</option>
								</select>
							</div>
												
							<div class="pure-control-group">
								<label>Link  http://</label>
								<input class="pure-input-2-3" name="link" id="link" type="text" placeholder="Link">
							</div>
							
							<div class="pure-control-group">
								<label>"Vaata saadavust" link  http://</label>
								<input class="pure-input-2-3" name="link_vaata_saadavust" id="link_vaata_saadavust" type="text" placeholder="Link, mis avaneb, kui vajutada nupul VAATA SAADAVUST" 									required>
							</div>	
							
							<div class="pure-control-group">
								<label>Kategooria</label>
								<select name="hashtag" id="hashtag">
									<option>#kaubariiul</option>
									<option>#moodulriiul</option>
									<option>#konsoolriiul</option>
								</select>
							</div>
								
							<div class="pure-control-group">
								<label>Soovitused</label>
								<textarea name="soovitused" id="soovitused" placeholder="Soovitused"></textarea>
							</div>	
							
							<div class="pure-control-group">
								<label>Alternatiivid</label>
								<textarea name="alternatiivid" id="alternatiivid" placeholder="Alternatiivid"></textarea>
							</div>

							<div class="pure-control-group">
							<label></label>
							<button id="add_item" name="add_item" value="add_item" type="submit" class="pure-button pure-button-primary"
									onclick="btnLisa_click();">Lisa</button>
							<button id="change_item" name="change_item" value="change_item" type="submit" class="pure-button pure-button-primary"
									onclick="btnChange_click();">Salvesta muudatused</button>
							<button id="delete_item" name="delete_item" value="delete_item" type="submit" class="pure-button pure-button-primary"
									onclick="btnDelete_click();">Kustuta</button>
							<button id="delete_all" name="delete_all" value="delete_all" type="submit" class="pure-button pure-button-primary"
									onclick="btnDeleteAll_click();">Kustuta kõik tooted</button>
							</div>	
							
						</fieldset>
					</form>
				</div>
				<div style="display: table-cell;">
					<div class="container">
						<h4>Lisa tootele pilte:</h4>
						<br>
						<br>
						<form id="imageUploadForm" method="post" action="upload_picture.php" enctype="multipart/form-data" target="_self">
							<div id="drop" style="margin-left: 30px;">
								<img src="images/icon_valipilt.png" id="upload-file-btn" style="cursor:pointer" />
								<input type="file" id="fileToUpload" style="display:none">
								<!-- <button type="submit" class="pure-button pure-button-primary" name="submit">Lae &uumlles!</button> -->
								<br>
								<br>
                                <div id="picture_names">&Uuml;leslaetud pildid: <br></div>
								<br>
								<div>
								<p style="float: left;">Kustuta kõik antud toote pildid:</p>
								<input type="button" style="margin-left: 10px;" class="pure-button  pure-button-primary" id="delete_pictures_button" value="Kustuta" onclick="delete_pictures();"/>
								</div>
								<br>
                                <br>
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