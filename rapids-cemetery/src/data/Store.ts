import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

import { LatLng, LatLngExpression } from 'leaflet';
import PointOfInterest from '@/data/objects/PointOfInterest';
import Media from '@/data/objects/Media';

Vue.use(Vuex);

export default new Vuex.Store({
	state: {
		pointsOfInterest: new Array<PointOfInterest>(),
		selectedPoiId: null,
		enabledTags: new Array<string>()
	},
	getters: {
		tags: (state) => {
			let tags = new Array<string>();

			for (let poi of state.pointsOfInterest) {
				for (let tag of poi.tags) {
					if (!tags.includes(tag)) {
						tags.push(tag);
					}
				}
			}

			tags.sort();

			return tags;
		},
		tagEnabled: (state) => (tag: string) => {
			return state.enabledTags.includes(tag);
		},
		visiblePointsOfInterest: (state) => {
			if (state.enabledTags.length === 0) {
				return state.pointsOfInterest;
			}

			let visiblePointsOfInterest = new Array<PointOfInterest>();

			for (let poi of state.pointsOfInterest) {
				for (let tag of poi.tags) {
					if (state.enabledTags.includes(tag)) {
						visiblePointsOfInterest.push(poi);
						break;
					}
				}
			}

			return visiblePointsOfInterest;
		}
	},
	mutations: {
		selectPoi: (state, poiId) => {
			state.selectedPoiId = poiId;
		},
		enableTag: (state, tag: string) => {
			if (!state.enabledTags.includes(tag)) {
				state.enabledTags.push(tag);
			}
		},
		disableTag: (state, tag: string) => {
			if (state.enabledTags.includes(tag)) {
				state.enabledTags.splice(state.enabledTags.indexOf(tag), 1);
			}
		},
		setPointsOfInterest: (state, pointsOfInterest: Array<PointOfInterest>) => {
			state.pointsOfInterest = pointsOfInterest;
		}
	},
	actions: {
		loadPointsOfInterest: (context) => {
			return new Promise((resolve, reject ) => {
				axios.get("/api/poi/getPointsOfInterest.php").then(({ data }) => {
					let pointsOfInterest = new Array<PointOfInterest>();

					for (let poi of data) {
						let media = new Array<Media>();

						for (let m of poi.media) {
							media.push(new Media(
								m.type,
								m.filename
							));
						}

						let coordinates = new Array<LatLngExpression>();

						for (let c of poi.coordinates) {
							coordinates.push(new LatLng(
								c.lat,
								c.lng
							));
						}

						pointsOfInterest.push(new PointOfInterest(
							poi.id,
							poi.name,
							poi.description,
							poi.tags,
							media,
							coordinates
						));
					}

					context.commit("setPointsOfInterest", pointsOfInterest);
					resolve();
				}).catch((error) => {
					console.log(error);
					reject();
				});
			});
		}
	}
});
