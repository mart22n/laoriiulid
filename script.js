var activeHashTag="";

function upload()
{
	document.getElementById("upload_button").value = "Laadimas...";
	document.getElementById("upload_button").disabled = true;
	document.getElementById("add_item").disabled = true;
	document.getElementById("upload").target = 'hiddenFrame';
	document.getElementById("upload").submit();
	 
	var iFrame = document.getElementById("hiddenFrame");
	iFrame.contentDocument.getElementsByTagName("body")[0].innerHTML = "";
	var timeoutCounter = 0;
	checkComplete(timeoutCounter);
}

var checkComplete = function(timeoutCounter)
{
	timeoutCounter++;
	var iFrame = document.getElementById("hiddenFrame").contentDocument.getElementsByTagName("body")[0];
	 
	if(iFrame.innerHTML == "")
	{
		setTimeout ( function() { checkComplete(timeoutCounter) }, 500);
	}
	else
	{
		document.getElementById("upload_button").value = "Lae pilt üles";
		document.getElementById("upload_button").disabled = false;
		document.getElementById("add_item").disabled = false;
		if(iFrame.innerHTML == "success ")
		{
			var fileinfo = document.getElementById("fileToUpload");
			if ('files' in fileinfo) {
				if (fileinfo.files.length > 0) {
					document.getElementById("pildi_nimi").innerHTML += fileinfo.files[0].name + "<br>";
				}
			}
			return 0;
		}
		else
		{
			alert("Viga: " + iFrame.innerHTML);
			return -1;
		}
	}
}

function stringContainsDot(str) {
	return str.match(/\./g) !== null;
}

// When the user clicks on the button, open the modal 
function modal_link_click(clicked_id) {
	initialScrollPos = document.documentElement.scrollTop | document.body.scrollTop;
	document.getElementById('item_info_modal').innerHTML = "<a href=\"#\" class=\"close\">x</a>";
	$('.modal .close').on('click', function(e){
		e.preventDefault();
		$.modal().close();
		document.documentElement.scrollTop = document.body.scrollTop = initialScrollPos;
	});
	
    $('#item_info_modal').modal().open();
	var req = new XMLHttpRequest();
	var url = "get_item_record_by_name.php";
	// extract the item's name from div id string
	var params = clicked_id.substring(11, clicked_id.length);
	
	req.onreadystatechange = function() {
		if(req.readyState == 4 && req.status == 200) {
			var itemRecord = req.responseText.split("\<br\>");
			var itemDetails = itemRecord[0].split(",");
			
			// if link string contains dot, we probably have a non-empty link url
			var linkTransformArray = (stringContainsDot(itemDetails[4]) ? [
				{"<>": "h3", "align": "left", "html": [
					{"<>":"a","class":"modal-link","href":"${link}","target":"_blank", "html":"Link: ${link}"}
					]
					},
					{ "<>": "p", "align": "center", "html": "" }
			]
				: {});
					
			var transform = [
				{ "<>": "h3", "align": "left", "html": "Nimi: ${nimi}" },
				{ "<>": "p", "align": "left", "html": "" },
				{"<>":"h3","align": "left","html":"Augu suurus: ${augu_suurus}"},
				{ "<>": "p", "align": "center", "html": "" },
				{ "<>": "h3", "align": "left", "html": "Augu intervall: ${augu_intervall}" },
				{ "<>": "p", "align": "center", "html": "" },
				{ "<>": "h3", "align": "left", "html": "Saadavus: ${saadavus}" },
				{ "<>": "p", "align": "center", "html": "" },
				linkTransformArray,
				{ "<>": "h3", "align": "left", "html": "Soovitused: ${soovitused}" },
				{"<>":"p","align":"center","html":""},
				{ "<>": "h3", "align": "left", "html": "Alternatiivid: ${alternatiivid}" },
			  ];
			
			$('#item_info_modal').json2html(itemRecord[0], transform);
			
			transform = [
				{"<>":"img","class":"modal-img","src":"${pildi_nimi}","alt":"(pilt puudub)","html":""},
				{"<>":"br","html":""}
			  ];
			for(i = 1; i < itemRecord.length - 1; ++i) {
				
				$('#item_info_modal').json2html(itemRecord[i], transform);
			}
			$('#item_info_modal').append("<br><h3 align=\"left\">Tellimiseks täida palun allolev vorm: </h3>" +
				"<form id=\"order_form\" class=\"pure-form pure-form-aligned\"" +
				"action=\"order.php\" method=\"post\" target=\"_parent\">" +
					"<fieldset>" +
						"<input type=\"hidden\" id=\"riiuli_nimi\" name=\"riiuli_nimi\" value=\"\" />" +
						"<input type=\"hidden\" id=\"augu_suurus\" name=\"augu_suurus\" value=\"\" />" +
						"<input type=\"hidden\" id=\"augu_intervall\" name=\"augu_intervall\" value=\"\" />" +
						"<input type=\"hidden\" id=\"saadavus\" name=\"saadavus\" value=\"\" />" +
						"<input type=\"hidden\" id=\"link\" name=\"link\" value=\"\" />" +
						"<div style=\"float:left\">" +
							"<div class=\"pure-control-group\">" +
								"<label><h4>Nimi</h4></label>" +
								"<input style=\"height:auto\" name=\"nimi\" type=\"text\" placeholder=\"Nimi\" required>" +
							"</div>" +
							"<div class=\"pure-control-group\">" +
								"<label><h4>e-post</h4></label>" +
								"<input id=\"email\" name=\"email\" style=\"height:auto\" type=\"text\" placeholder=\"e-post\" required>" +
							"</div>" +
							"<div class=\"pure-control-group\">" +
								"<label><h4>Telefon</h4></label>" +
								"<input id=\"phone\" name=\"phone\" style=\"height:auto\" type=\"text\" placeholder=\"Telefon\" optional>" +
							"</div>" +
							"<div class=\"pure-control-group\">" +
								"<label><h4>Lisainfo</h4></label>" +
								"<textarea placeholder=\"Lisainfo\" name=\"lisainfo\"></textarea>" +
							"</div>" +
							"<div class=\"pure-control-group\">" +
								"<label></label>" +
								"<button type='button' id=\"submit_button\" class=\"pure-button pure-button-primary\">Saada</button>" +
							"</div>" +
						"</div>" +
					"</fieldset>" +
				"</form></div>");
			var jsonObject = JSON.parse(itemRecord[0]);
			$('#riiuli_nimi').val(jsonObject.nimi);
			$('#augu_suurus').val(jsonObject.augu_suurus);
			$('#augu_intervall').val(jsonObject.augu_intervall);
			$('#saadavus').val(jsonObject.saadavus);
			$('#link').val(jsonObject.link);
			//document.getElementById('riiuli_modal_body').innerHTML = json2html.transform(riiulRecord[0], transform);
		}
	};
	req.open("POST", url, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	req.send("nimi=" + params);
}

var initialScrollPos = 0;
function display_items_from_json_data(result, rowName) {
	rowName = "#" + rowName;
	var itemRecord = result.split("\<br\>");
	var content = "";
	for(i = 0; i < itemRecord.length - 1; ++i) {
		var jsonObject = JSON.parse(itemRecord[i]);
		//var item_name = jsonObject["nimi"];
		content += '<div id="box">';
		var linkTransformArray = (jsonObject.link.length > 7 ? { "<>": "p", "html": [
                    {"<>": "a", "class": "item-link", "href": "${link}", "target" : "_blank", "html": "Link: ${link}"}
                ]
				}
		: {"<>": "p", "html" : "<br>"});
		var transform = 
            [
                {"<>": "a", "class": "modal_link", "id": "modal_link_${nimi}", "href": "#", "html": [
                    {"<>": "span", "class": "big_link_span", "html": ""}
                ]
                },
                {"<>": "div", "class": "image-div", "html": [
                    { "<>": "img", "src": "${pildi_nimi}", "class": "tootepilt", "alt": "(pilt puudub)", "html": "" }
                ]
                },
                {"<>": "div", "id": "bottomtext", "html": [
                    {"<>": "h3", "html": "${nimi}"},
                    {"<>": "div", "id": "textinfo", "html": [
                        {"<>": "p", "html": "Augu laius: ${augu_suurus}<br>"},
                        {"<>": "p", "html": "Augu intervall: ${augu_intervall}<br>"},
                        linkTransformArray
                    ]
                    },
					{"<>": "a", "class": "btn", "href": "mailto:info@laomaailm.ee?Subject=${nimi}", "html": [
						{"<>": "div", "class": "buttoninside", "html": "TELLI"}
					]
					}
                ]
                }
            ];
		
		content += json2html.transform(itemRecord[i], transform);
		content += "</div></div>";
		//$(rowName).on('click', $("#modal_link_" + item_name), function() {
		//$(".container-fluid").on('click', $("#modal_link_" + item_name), function() {
		//	modal_link_click("modal_link_" + item_name);
		//});
		
		var linkIndexInString = content.lastIndexOf("href=\"#\"") + "href=\"#\"".length;
		var insertableLink = " onclick=\"modal_link_click(this.id)\"";
		content = [content.slice(0, linkIndexInString), insertableLink, content.slice(linkIndexInString)].join('');
		
	}
	$(rowName).append(content);
}

function btnLisa_click() {
	 document.getElementById("pildi_nimi").innerHTML = "&Uuml;leslaetud pildid: <br>";
}

function getHashTagFromUri() {
    var regex = new RegExp("\#.*"),
        results = regex.exec(location.href);
    return (results === null ? "" : results[0]);
}

var indexPage = false;
$(document).ready(function () {
	var lastPartOfUri = document.location.href.match(/[^\/]+$/);
    indexPage = (lastPartOfUri !== null && lastPartOfUri[0].match(/index\.php/g) !== null);
	$('#item_info_modal').on('click', 'button.pure-button', function() {
		if (validateEmail($("#email").val()) === true) {
			$('#order_form')[0].submit();
		}
		else {
			alert('e-mailiaadress ei vasta nõuetele!');
		}
	});
});

function validateEmail(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

var incrementInTable = 4, offsetInTable = 12, isPreviousEventComplete = true, isDataAvailable = true;
 $(window).scroll(function () {
	if(indexPage === true) {
		if ($(document).height() - 100 <= $(window).scrollTop() + $(window).height()) {
			
			var rows = document.getElementsByClassName("item-row");
			var rowName = rows[rows.length - 1].id;
		   if (isPreviousEventComplete) { //&& isDataAvailable) {
				isPreviousEventComplete = false;
				$.ajax({
					type: "GET",
					url:  'download_more_items.php?offsetInTable=' + offsetInTable + '&incrementInTable=' + incrementInTable +
						'&hashtag=' + encodeURIComponent(getHashTagFromUri()) + '',
					success: function (result) {
						display_items_from_json_data(result, rowName);
	
						offsetInTable += incrementInTable;
						isPreviousEventComplete = true;
			
						if (result === '') { //When data is not available
							//isDataAvailable = false;
						}
						else {
							var rowNumber = rowName.match('[0-9]+');
							var newRowName = "item_row_" + (parseInt(rowNumber) + 1);
							$("<div id=\"" + newRowName + "\" class=\"row-fluid item-row\">").insertAfter("#" + rowName);
						}
					},
					error: function (error) {
						alert(error);
					}	
				});
			}
		}
	}
});
