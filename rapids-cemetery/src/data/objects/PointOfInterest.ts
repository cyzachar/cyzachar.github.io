import * as L from 'leaflet';
import Media from '@/data/objects/Media';

export default class PointOfInterest {
	constructor(
		public id: number,
		public name: string,
		public description: string,
		public tags: Array<string>,
		public media: Array<Media>,
		public coordinates: Array<L.LatLngExpression>
	) {}

	public get mapMarker(): L.Marker | L.Polygon {
		let marker: L.Marker | L.Polygon;

		if (this.coordinates.length == 1) {
			marker = L.marker(this.coordinates[0]);
		} else {
			marker = L.polygon(this.coordinates);
		}

		marker.bindPopup(`<strong>${this.name}</strong><p>${this.description}</p>`);

		return marker;
	}
}