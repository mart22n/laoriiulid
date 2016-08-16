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
					<form class="pure-form pure-form-aligned" action="add_item.php" method="post" target="hiddenFrame">
						<fieldset>
							<div class="pure-control-group">
								<label>Toote nimi</label>
								<select id="nimi">
									<option><h3>LISA UUS...</h3></option>
									<?php
										$conn = create_conn();
										$sql = "SELECT nimi FROM Items ORDERBY ";
										$result = exec_query($conn, $sql);
										if ($result->num_rows >= 1) {
											while($row = $result->fetch_assoc()) {
												echo '<option>' . $row['nimi'] . '</option>';
											}
										}
									?>
								</select>
							</div>

							<div class="pure-control-group">
								<label>Augu suurus</label>
								<input id="augu_suurus" type="text" placeholder="Augu suurus" required>
							</div>

							<div class="pure-control-group">
								<label>Augu intervall</label>
								<input id="augu_intervall" type="text" placeholder="Augu intervall" required>
							</div>

							<div class="pure-control-group">
								<label>Saadavus</label>
								<select id="saadavus">
									<option>Laos olemas</option>
									<option>Tellimisel</option>
								</select>
							</div>
												
							<div class="pure-control-group">
								<label>Link  http://</label>
								<input id="link" type="text" placeholder="Link">
							</div>
							
							<div class="pure-control-group">
								<label>"Vaata saadavust" link  http://</label>
								<input class="pure-input-2-3" id="link_vaata_saadavust" type="text" placeholder="Link, mis avaneb, kui vajutada nupul VAATA SAADAVUST" 									required>
							</div>	
							
							<div class="pure-control-group">
								<label>Kategooria</label>
								<select id="hashtag">
									<option>#kaubariiul</option>
									<option>#moodulriiul</option>
									<option>#konsoolriiul</option>
								</select>
							</div>
								
							<div class="pure-control-group">
								<label>Soovitused</label>
								<textarea id="soovitused" placeholder="Soovitused"></textarea>
							</div>	
							
							<div class="pure-control-group">
								<label>Alternatiivid</label>
								<textarea id="alternatiivid" placeholder="Alternatiivid"></textarea>
							</div>

							<div class="pure-control-group">
							<label></label>
							<button id="add_item" type="submit" class="pure-button pure-button-primary" onclick="btnLisa_click()">Lisa</button>
							<button id="change_item" type="submit" class="pure-button pure-button-primary" onclick="btnLisa_click()">Muuda</button>
							<button id="delete_item" type="submit" class="pure-button pure-button-primary" onclick="btnLisa_click()">Kustuta</button>
							<button id="delete_all" type="submit" class="pure-button pure-button-primary" onclick="btnLisa_click()">Kustuta kõik riiulid</button>
							</div>	
							
						</fieldset>
					</form>
				</div>
				<div style="display: table-cell;">
					<div class="container">
						<h4>Lisa pilte (pildi lisamiseks vajuta esmalt nuppu "sirvi/lehitse/browse", seejärel nuppu "Lae pilt üles")</h4>
						<br>
						<br>
						<form id="upload" method="post" action="upload.php" enctype="multipart/form-data" target="hiddenFrame">
							<div id="drop" style="margin-left: 30px;">
								<input type="file" name="fileToUpload" id="fileToUpload"/>
								<!-- <button type="submit" class="pure-button pure-button-primary" name="submit">Lae &uumlles!</button> -->
								<input type="button"  class="pure-button  pure-button-primary" id="upload_button" value="Lae pilt &uuml;les" onclick="upload();"/>
								<br>
								<br>
                                <div id="picture_names">&Uuml;leslaetud pildid: <br></div>
                                <iframe id="hiddenFrame" name="hiddenFrame" class="hide"></iframe>
								<br>
								<div>
								<p style="float: left;">Kustuta kõik antud riiuli pildid:</p>
								<input type="button" style="margin-left: 10px;" class="pure-button  pure-button-primary" id="delete_pictures_button" value="Kustuta" onclick="upload();"/>
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