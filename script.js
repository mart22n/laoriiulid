const LISA_UUS = "LISA UUS...";

$(document).ready(function (e) {
     $('#nimi').empty();
     $('#nimi').append($("<option><h3></h3></option>"));
     $('#nimi').append($("<option>" + LISA_UUS + "</option>"));
	 $.ajax({
		type:'POST',
		url: 'get_item_names.php',
		success:function(data){
			var itemNames = data.split("\<br\>");
			$.each( itemNames, function( index, itemNameJson ) {
                    if(itemNameJson.length > 0) {                         
                         var itemName = JSON.parse(itemNameJson);
                         $('#nimi').append($("<option>" + itemName + "</option>"));
                    }
			});
          }
	});
	
	$("#nimi_input").hide();
	$("#nimi_input").removeAttr("required");
	$("#nimi").show();
	$("#nimi").attr("required", "true");
    $('#imageUploadForm').on('submit',(function(e) {
        e.preventDefault();
		var form_data = new FormData();
		form_data.append('file', $("#fileToUpload").prop('files')[0]);
        $.ajax({
            type:'POST',
            url: $(this).attr('action'),
            data: form_data,
            cache:false,
            contentType: false,
            processData: false,
            success:function(data){
                if(data === "success ") {
					$("#picture_names").append($("#fileToUpload").prop('files')[0].name + "<br>");
                         $("#delete_pictures_button").prop("disabled", false);
               }
               else
               {
                    alert(data);
               }
               $("#upload-file-btn").attr("src", "images/icon_valipilt.png");
            },
            error: function(data){
                alert("Error" + data);
				$("#upload-file-btn").attr("src", "images/icon_valipilt.png");
            }
        });
    }));

    $("#fileToUpload").on("change", function() {
        $("#imageUploadForm").submit();
    });
	
	$("#upload-file-btn").click(function () {
		$("#fileToUpload").trigger('click');
		$("#upload-file-btn").attr("src", "images/icon_laen_yles.png");
	});
});

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
				{
					"<>": "h4", "align": "left", "html":
					[
						{
							"<>":"p", "class": "abbreviated-link abbreviated-link-in-modal", "html":
							[
								{
									"<>": "span", "html": "Link: "
								},
								{
									"<>":"a","class":"modal-link","href":"${link}","target":"_blank", "html":"${link}"
								},
							]
						}
					]
				},
				{
					"<>": "p", "align": "center", "html": ""
				}
			]
				: {});
					
			var transform = [
				{ "<>": "h2", "align": "left", "html": [
				  {"<>": "b", "html":  "Nimi: ${nimi}" }
				  ]
				},
				{ "<>": "p", "align": "left", "html": "" },
				{"<>":"h4","align": "left","html":"Augu suurus: ${augu_suurus}"},
				{ "<>": "p", "align": "center", "html": "" },
				{ "<>": "h4", "align": "left", "html": "Augu intervall: ${augu_intervall}" },
				{ "<>": "p", "align": "center", "html": "" },
				{ "<>": "h4", "align": "left", "html": "Saadavus: ${saadavus}" },
				{ "<>": "p", "align": "center", "html": "" },
				linkTransformArray,
				{ "<>": "h4", "align": "left", "html": "Soovitused: ${soovitused}" },
				{"<>":"p","align":"center","html":""},
				{ "<>": "h4", "align": "left", "html": "Alternatiivid: ${alternatiivid}" },
			  ];
			
			$('#item_info_modal').json2html(itemRecord[0], transform);
			
			transform = [
				{"<>":"img","class":"modal-img","src":"${pildi_nimi}","alt":"(pilt puudub)","html":""},
				{"<>":"br","html":""}
			  ];
			for(i = 1; i < itemRecord.length - 1; ++i) {
				
				$('#item_info_modal').json2html(itemRecord[i], transform);
			}
			$('#item_info_modal').append("<br><h3 align=\"left\">Päringu esitamiseks täitke allolev vorm: </h3>" +
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
		
		var linkTransformArray = (jsonObject.link.length > 7) ? [
			{
				"<>":"p", "class": "abbreviated-link", "html":
				[
					{
						"<>": "span", "html": "Link: "
					},
					{
						"<>":"a","class":"modal-link item-link","href":"${link}","target":"_blank", "html":"${link}"
					},
				]
			},
			{"<>": "p", "align": "center", "html": "" }
			]
			: {"<>": "p", "html" : "<br>"};
		
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
					
					{"<>": "form", "class": "button-form", "action": "${link_vaata_saadavust}", "target": "_blank", "html": [
						{"<>": "button", "class": "check-availability-button pure-button pure-button-primary", "html": "VAATA SAADAVUST"}
					]
					}
                ]
                }
            ];
		
		content += json2html.transform(itemRecord[i], transform);
		content += "</div></div>";
		
		var linkIndexInString = content.lastIndexOf("href=\"#\"") + "href=\"#\"".length;
		var insertableLink = " onclick=\"modal_link_click(this.id)\"";
		content = [content.slice(0, linkIndexInString), insertableLink, content.slice(linkIndexInString)].join('');
		
	}
	$(rowName).append(content);
}

function requiredFieldsFilled() {
     var requiredFilled = true;
     $( ':input[required]', $("#admin_form") ).each( function () {
          if ( this.value.trim() === '' ) {
              requiredFilled = false;
              return false;
          }
     });
     return requiredFilled;
}

function btnLisa_click() {
     if(requiredFieldsFilled()) {
          var form_data = $('#admin_form').serialize();
          form_data += "&add_item=add_item";
          $.ajax({
          type: "POST",
          url:  'modify_items.php',
          data: form_data,
           processData: false,
               success: function (result) {
                    alert(result);
                    if(result.substring(0, 4) !== "Viga")
                    {
                         window.location.reload(true); 
                    }
               },
               error: function (error) {
                    alert(error);
               }	
          });
     }
}
     
function btnChange_click() {
     if(requiredFieldsFilled()) {
          var form_data = $('#admin_form').serialize();
          form_data += "&change_item=change_item";
          $.ajax({
          type: "POST",
          url:  'modify_items.php',
          data: form_data,
           processData: false,
               success: function (result) {
                    alert(result);
                    if(result.substring(0, 4) !== "Viga")
                    {
                         window.location.reload(true); 
                    }
               },
               error: function (error) {
                    alert(error);
               }	
          });
     }
}

function btnDelete_click() {
	var form_data = $('#admin_form').serialize();
     form_data += "&delete_item=delete_item";
	$.ajax({
	type: "POST",
	url:  'modify_items.php',
	data: form_data,
	 processData: false,
		 success: function (result) {
               alert(result);
               if(result.substring(0, 4) !== "Viga")
               {
                    window.location.reload(true); 
               }
          },
          error: function (error) {
               alert(error);
          }	
	});
}

function btnDeleteAll_click() {
	if(confirm('Oled kindel, et soovid kustutada andmebaasist kõik tooted? (tellimuste info jääb alles)')) {   
     var form_data = $('#admin_form').serialize();
          form_data += "&delete_all=delete_all";
          $.ajax({
          type: "POST",
          url:  'modify_items.php',
          data: form_data,
           processData: false,
                success: function (result) {
                    alert(result);
                    if(result.substring(0, 4) !== "Viga")
                    {
                         window.location.reload(true); 
                    }
               },
               error: function (error) {
                    alert(error);
               }	
          });
     }
}

function delete_pictures() {
	$.ajax({
	type: "POST",
	url:  'delete_pictures.php',
	data: { 'nimi': $( "#nimi option:selected" ).text() },
		success: function (result) {
			$("#delete_pictures_button").prop("disabled", true);
			$("#picture_names").html("&Uuml;leslaetud pildid: <br>");
		},
		error: function (error) {
               alert(error);
		}	
	});
}

function getHashTagFromUri() {
    var regex = new RegExp("\#.*"),
        results = regex.exec(location.href);
    return (results === null || results[0].length <= 1 ? "" : results[0]);
}

var indexPage = false;
$(document).ready(function () {
	var lastPartOfUri = document.location.href.match(/[^\/]+$/);
    indexPage = (lastPartOfUri === null || lastPartOfUri[0].match(/index\.php/g) !== null || lastPartOfUri[0].match(/\#/g) !== null);
	$('#item_info_modal').on('click', 'button.pure-button', function() {
		if (validateEmail($("#email").val()) === true) {
			$('#order_form')[0].submit();
		}
		else {
			alert('e-mailiaadress ei vasta nõuetele!');
		}
	});
	$('#add_item').prop("disabled", true);
	$('#change_item').prop("disabled", true);
	$('#delete_item').prop("disabled", true);
	$("#delete_pictures_button").prop("disabled", true);
});

$('#nimi').change(function() {
	$("#picture_names").html("&Uuml;leslaetud pildid: <br>");
	var name = $( "#nimi option:selected" ).text();
	if(name !== LISA_UUS && name !== "") {
		$('#add_item').prop("disabled", true);
		$('#change_item').prop("disabled", false);
		$('#delete_item').prop("disabled", false);
		downloadExistingItemFields(name);
	}
	else if(name === LISA_UUS)
	{
		$("#nimi").hide();
		$("#nimi").removeAttr("required");
		$("#nimi_input").show();
		$("#nimi_input").attr("required", "true");
		$('#add_item').prop("disabled", false);
		$('#change_item').prop("disabled", true);
		$('#delete_item').prop("disabled", true);
		$('#augu_suurus').val('');
		$('#augu_intervall').val('');
		$('#saadavus').val('');
		$('#link').val('');
		$('#link_vaata_saadavust').val('');
		$('#hashtag').val('');
		$('#soovitused').val('');
		$('#alternatiivid').val('');
	}
});

function downloadExistingItemFields(name) {
	$.ajax({
		type: "POST",
		url:  'get_item_record_by_name.php',
		data: { 'nimi': name },
		success: function (result) {
			fillFormFieldsFromItemRecord(result);
		},
		error: function (error) {
			alert(error);
		}	
	});
}

function fillFormFieldsFromItemRecord(record) {
	var itemData = record.split("\<br\>");
	var jsonObject = JSON.parse(itemData[0]);
	$('#augu_suurus').val(jsonObject.augu_suurus);
	$('#augu_intervall').val(jsonObject.augu_intervall);
	$('#saadavus').val(jsonObject.saadavus);
	$('#link').val(jsonObject.link.indexOf("http") >= 0 ? jsonObject.link.substring(7) : jsonObject.link);
	$('#link_vaata_saadavust').val(jsonObject.link_vaata_saadavust.indexOf("http") >= 0 ? jsonObject.link_vaata_saadavust.substring(7) : jsonObject.link_vaata_saadavust);
	$('#hashtag').val(jsonObject.hashtag);
	$('#soovitused').val(jsonObject.soovitused);
	$('#alternatiivid').val(jsonObject.alternatiivid);
	$("#picture_names").html("&Uuml;leslaetud pildid: <br>");
	var i;
	for(i = 1; i < itemData.length - 1; ++i)
	{
		jsonObject = JSON.parse(itemData[i]);
		$("#picture_names").append(jsonObject.pildi_nimi.substring(jsonObject.pildi_nimi.lastIndexOf("/") + 1) + "<br>");	
	}
	
	$("#delete_pictures_button").prop("disabled", itemData.length < 3);
}

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
		   if (isPreviousEventComplete && isDataAvailable) {
				isPreviousEventComplete = false;
				$.ajax({
					type: "GET",
					url:  'download_more_items.php?offsetInTable=' + offsetInTable + '&incrementInTable=' + incrementInTable +
						'&hashtag=' + encodeURIComponent(getHashTagFromUri()) + '',
					success: function (result) {
						display_items_from_json_data(result, rowName);
	
						offsetInTable += incrementInTable;
						isPreviousEventComplete = true;
			
						if (result === '') {
							isDataAvailable = false;
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
