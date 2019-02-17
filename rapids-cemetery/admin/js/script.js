function loadPOI(){
	//get data from test json
	console.log("loadPOI");
	$.getJSON( 'testData.json', function( data ) {
		//for each POI
	  $.each( data.poi, function(index, aPoi) {
			//append new div to POI list
			$("#poiList").append(getListRow(aPoi.poiName, aPoi.poiID, "editPoi.php"));
	  });
	});
}	//end loadPOI function

function loadHistoric(){
	//get data from test json
	$.getJSON( 'testData.json', function( data ) {
		//for each POI
	  $.each( data.locations, function(index, aLoc) {
			//append new row to historic list
			$("#historicList").append(getListRow(aLoc.hl_name, aLoc.hlID, "editHistoric.php"));
	  });
	});
}	//end loadHistoric function

function getListRow(name, id, editUrl){
	var newRow = $("<div></div>").addClass("listRow");
	var rowLbl = $("<p></p>").text(name);
	var controls = $("<div></div>").addClass("controls");
	var editBtn = $("<button></button>").addClass("editBtn").text("Edit").click(function(){
		//redirect to editPoi pg on click
		window.location.href = editUrl + "?id=" + id;
	});
	var deleteBtn = $("<button></button>").addClass("deleteBtn").text("Delete").click(function(){
		//remove POI div on click
		newRow.remove();
	});
	controls.append(editBtn).append(deleteBtn);
	newRow.append(rowLbl).append(controls);
	return newRow;
}

function getPoiNamesArray(poiData, callback){
	//fill array with all POI names and ids
	//var p1 = new Promise(function(resolve, reject) {
			var poiArr = [];
		  $.each(poiData, function(index, aPoi) {
				poiArr.push({"name": aPoi.poiName, "id": aPoi.poiID});
		  });
			//resolve(poiArr);
	//});

	//p1.then(function(poiArr){
		callback(poiArr);
	//});
}

function getTourData(callback){
	var p1 = new Promise(function(resolve, reject) {
		//get data from test json
		$.getJSON( '../testData.json', function( data ) {


			// var fillPoiPromise = new Promise(function(resolve, reject){
			// 	var poiArr = [];
			// 	//fill array with all POI names and ids
			//   $.each( data.poi, function(index, aPoi) {
			// 		poiArr.push({"name": aPoi.poiName, "id": aPoi.poiID});
			//   });
			// 	resolve(poiArr);
			// });
			//
			// fillPoiPromise.then(function(poiArr){
			console.log("data:");
			console.log(data);
			console.log("tour data:");
			console.log(data.tour);
			getPoiNamesArray(data.poi, function(poiArr){
				var tourStopArr = [];

				//for each stop
				//NOTE: assumes that json returned will be in ascending order for tour_order
				$.each(data.tour, function(index, aStop) {
					var stopId = aStop.poiID;
					console.log("stopId: " + stopId);
					//add the name and id of POI with corresponding id to array of stops
					$.each(poiArr, function(i, aPoi) {
						if(aPoi.id == stopId){
							tourStopArr.push({"name": aPoi.name, "id": aPoi.id});
							//break;
						}
					});	//end for each POI
				});	//end for each tour stop

				resolve(poiArr, tourStopArr);
			});
			// });
		});	//end getJSON
	});

	p1.then(function(poiArr, tourStopArr){
		console.log("poiArr:");
		console.log(poiArr);
		console.log("tourStopArr:");
		console.log(tourStopArr);
		callback(poiArr, tourStopArr);
	});
}

//Note that selectedArr will hold an associative array w/ "poiID" & "tour_order" as attributes
function updateTour(dualList){
	var selectedArr = dualList.getSelection();
	console.log(selectedArr);
	alert("Tour has been updated!");
}

function uploadImg(imgDisplayId){
	//get img file to upload from file input
	var fileInput = document.getElementById("imgFile");
	var file = fileInput.files[0];
	var form_data = new FormData();
	var oFReader = new FileReader();
	oFReader.readAsDataURL(file);
	form_data.append("file", file);

	//ajax call to
	$.ajax({
		url:"upload.php",
		method:"POST",
		data: form_data,
		contentType: false,
		cache: false,
		processData: false,
		beforeSend:function(){
			console.log("uploading...");
		},
		success:function(data)
		{
			//add newly updated image to page
			console.log("upload successful");
			var newImg = $("<img>");
		  newImg.attr('src', data);
			$("#" + imgDisplayId).append(newImg);
		}
	});
}	//end uploadImg function
