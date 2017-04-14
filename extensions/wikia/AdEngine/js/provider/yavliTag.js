/*global define*/
define('ext.wikia.adEngine.provider.yavliTag', [
	'ext.wikia.adEngine.adContext',
	'ext.wikia.aRecoveryEngine.adBlockDetection',
	'wikia.document',
	'wikia.log'
], function (adContext, adBlockDetection, doc, log) {
	'use strict';

	var logGroup = 'ext.wikia.adEngine.provider.yavliTag';

	log('init', 'debug', logGroup);

	function add() {
		adBlockDetection.addOnBlockingCallback(function () {
			var context = adContext.getContext(),
				yavli = doc.createElement('script');

			yavli.async = true;
			yavli.type = 'text/javascript';
			yavli.src = context.opts.yavliUrl;

			log('Appending Yavli to the end of body', 'debug', logGroup);
			doc.body.appendChild(yavli);
		});
	}

	return {
		add: add
	};
});
