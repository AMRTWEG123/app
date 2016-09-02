/*global define*/
define('ext.wikia.adEngine.lookup.adapter.appnexus',[
	'wikia.geo',
	'wikia.instantGlobals',
	'ext.wikia.adEngine.lookup.adapter.appnexusPlacements'
], function (geo, instantGlobals, appnexusPlacements) {
	'use strict';

	var bidderName = 'appnexus',
		slots = {
			oasis: {
				TOP_LEADERBOARD: {
					sizes: [
						[728, 90],
						[970, 250]
					]
				},
				TOP_RIGHT_BOXAD: {
					sizes: [
						[300, 250],
						[300, 600]
					]
				}
			},
			mercury: {
				MOBILE_TOP_LEADERBOARD: {
					sizes: [
						[320, 50]
					]
				}
			}
		};

	function isEnabled() {
		return geo.isProperGeo(instantGlobals.wgAdDriverAppNexusBidderCountries);
	}

	function prepareAdUnit(slotName, config) {
		return {
			code: slotName,
			sizes: config.sizes,
			bids: [
				{
					bidder: bidderName,
					params: {
						placementId: appnexusPlacements.getPlacement()
					}
				}
			]
		};
	}

	function getAdUnits(skin) {
		var adUnits = [];

		Object.keys(slots[skin]).forEach(function(slotName) {
			adUnits.push(prepareAdUnit(slotName, slots[skin][slotName]));
		});

		return adUnits;
	}

	return {
		getAdUnits: getAdUnits,
		isEnabled: isEnabled
	};
});
