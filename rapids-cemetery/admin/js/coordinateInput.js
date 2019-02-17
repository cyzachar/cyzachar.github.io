function coordinateInput(mapContainerId, startLat, startLong, startZoom, maxZoom, allowPolygons, mapboxAccessToken) {
	this.map = L.map(mapContainerId).setView([startLat, startLong], startZoom);

	this.shapeLayer = null;

	this.allowPolygons = allowPolygons;

	L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		maxZoom: maxZoom,
		maxNativeZoom: 20,
		id: 'mapbox.satellite',
		accessToken: mapboxAccessToken
	}).addTo(this.map);

	this.showDrawControls();

	var parent = this;

	this.map.on('pm:create', function(e) {
		parent.shapeLayer = e.layer;
		parent.showEditControls();
	});

	this.map.on('pm:remove', function(e) {
		parent.shapeLayer = null;
		parent.showDrawControls();
	});
}

coordinateInput.prototype.showDrawControls = function() {
	this.map.pm.removeControls();

	this.map.pm.enableDraw('Poly', { allowSelfIntersection: false });
	this.map.pm.disableDraw('Poly');

	this.map.pm.addControls({
		position: 'topleft',
		drawMarker: true,
		drawPolygon: this.allowPolygons,
		dragMode: false,
		editMode: false,
		removalMode: false,
		drawPolyline: false,
		drawRectangle: false,
		drawCircle: false,
		cutPolygon: false
	});
}

coordinateInput.prototype.showEditControls = function() {
	this.map.pm.removeControls();

	this.map.pm.disableDraw('Marker');
	this.map.pm.disableDraw('Poly');

	this.map.pm.enableGlobalEditMode({
		allowSelfIntersection: false
	});

	this.map.pm.disableGlobalEditMode();

	this.map.pm.addControls({
		position: 'topleft',
		drawMarker: false,
		drawPolygon: false,
		dragMode: true,
		editMode: true,
		removalMode: true,
		drawPolyline: false,
		drawRectangle: false,
		drawCircle: false,
		cutPolygon: false
	});
}

coordinateInput.prototype.getCoords = function() {
	if (this.shapeLayer === null) {
		return null;
	}

	if (typeof this.shapeLayer.getLatLngs === "function") {
		return this.shapeLayer.getLatLngs()[0];
	}
	
	if (typeof this.shapeLayer.getLatLng === "function") {
		return [this.shapeLayer.getLatLng()];
	}
}

coordinateInput.prototype.setCoords = function(coords /*Array of Leaflet LatLng objects*/) {
	if (coords.length === 1) {
		this.shapeLayer = L.marker(coords[0]).addTo(this.map);
	} else {
		this.shapeLayer = L.polygon(coords).addTo(this.map);
	}

	this.showEditControls();
}