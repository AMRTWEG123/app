(function($){
	'use strict';
	var $localNav, track;

	track = window.Wikia.Tracker.buildTrackingFunction({
		action: window.Wikia.Tracker.ACTIONS.CLICK,
		trackingMethod: 'both'
	});

	$localNav = $('#localNavigation');

	function trackEvent(event) {
		var canonical, $element, label;

		$element = $(event.currentTarget);
		canonical = $element.data('canonical');

		if (event.which !== 1) {
			return;
		}

		if ($element.hasClass('wordmark')) {
			label = 'wordmark';
		} else if (canonical !== undefined) {
			switch (canonical) {
				case 'wiki-activity':
					label = 'on-the-wiki-activity';
					break;
				case 'random':
					label = 'on-the-wiki-random';
					break;
				case 'newfiles':
					label = 'on-the-wiki-new-photos';
					break;
				case 'chat':
					label = 'on-the-wiki-chat';
					break;
				case 'forum':
					label = 'on-the-wiki-forum';
					break;
				case 'videos':
					label = 'on-the-wiki-videos';
					break;
			}
		} else if ($element.closest('.third').length === 1) {
			label = 'custom-level-3';
		} else if ($element.closest('.second').length === 1) {
			label = 'custom-level-2';
		} else if ($element.closest('.first').length === 1) {
			label = 'custom-level-1';
		}

		if (label !== undefined) {
			track({
				browserEvent: event,
				category: 'wiki-nav',
				label: label
			});
		}
	}

	$localNav.on('click', 'a', trackEvent);
})(jQuery);

