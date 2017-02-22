/*global define*/
define('ext.wikia.aRecoveryEngine.recovery.helper', [
	'ext.wikia.adEngine.adContext',
	'wikia.document',
	'wikia.instantGlobals',
	'wikia.lazyqueue',
	'wikia.log',
	'wikia.window'
], function (
	adContext,
	doc,
	instantGlobals,
	lazyQueue,
	log,
	win
) {
	'use strict';

	var logGroup = 'ext.wikia.aRecoveryEngine.recovery.helper',
		context = adContext.getContext(),
		customLogEndpoint = '/wikia.php?controller=ARecoveryEngineApi&method=getLogInfo&kind=',
		cb = function (callback) {
			callback();
		},
		onBlockingEventsQueue = lazyQueue.makeQueue([], cb),
		onNotBlockingEventsQueue = lazyQueue.makeQueue([], cb);

	function initEventQueues() {
		doc.addEventListener('sp.not_blocking', onNotBlockingEventsQueue.start);
		doc.addEventListener('sp.blocking', onBlockingEventsQueue.start);
	}

	function addOnBlockingCallback(callback) {
		onBlockingEventsQueue.push(callback);
	}

	function addOnNotBlockingCallback(callback) {
		onNotBlockingEventsQueue.push(callback);
	}

	function isSourcePointRecoveryEnabled() {
		var enabled = !!context.opts.sourcePointRecovery && !context.opts.pageFairRecovery;

		log(['isSourcePointRecoveryEnabled', enabled, 'debug', logGroup]);
		return enabled;
	}

	function isPageFairRecoveryEnabled() {
		var enabled = !!context.opts.pageFairRecovery && !context.opts.sourcePointRecovery;

		log(['isPageFairRecoveryEnabled', enabled, 'debug', logGroup]);
		return enabled;
	}

	function isBlocking() {
		log(['isBlocking', !!(win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking)], 'debug', logGroup);
		return !!(win.ads && win.ads.runtime.sp && win.ads.runtime.sp.blocking);
	}

	function isSourcePointRecoverable(slotName, recoverableSlots) {
		return isSourcePointRecoveryEnabled() && recoverableSlots.indexOf(slotName) !== -1;
	}

	function track(type) {
		if (win._sp_ && !win._sp_.trackingSent) {
			if (Wikia && Wikia.Tracker) {
				Wikia.Tracker.track({
					eventName: 'ads.recovery',
					ga_category: 'ads-recovery-blocked',
					ga_action: Wikia.Tracker.ACTIONS.IMPRESSION,
					ga_label: type,
					trackingMethod: 'analytics'
				});
			}
			if (instantGlobals.wgARecoveryEngineCustomLog) {
				try {
					var xmlHttp = new XMLHttpRequest();
					xmlHttp.open('GET', customLogEndpoint+type, true);
					xmlHttp.send();
				} catch (e) {
					log(['track', e], 'error', logGroup);
				}
			}
			win._sp_.trackingSent = true;
		}
	}

	function verifyContent() {
		var wikiaArticle = doc.getElementById('WikiaArticle'),
			display = wikiaArticle.currentStyle ?
						wikiaArticle.currentStyle.display : getComputedStyle(wikiaArticle, null).display;

		if (display === 'none') {
			track('css-display-none');
		}
	}

	function getSafeUri(url) {
		if (isSourcePointRecoveryEnabled() && isBlocking()) {
			url = win._sp_.getSafeUri(url);
		}

		return url;
	}

	return {
		addOnBlockingCallback: addOnBlockingCallback,
		addOnNotBlockingCallback: addOnNotBlockingCallback,
		getSafeUri: getSafeUri,
		initEventQueues: initEventQueues,
		isBlocking: isBlocking,
		isSourcePointRecoverable: isSourcePointRecoverable,
		isSourcePointRecoveryEnabled: isSourcePointRecoveryEnabled,
		isPageFairRecoveryEnabled: isPageFairRecoveryEnabled,
		track: track,
		verifyContent: verifyContent
	};
});
