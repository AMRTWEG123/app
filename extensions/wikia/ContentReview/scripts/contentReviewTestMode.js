define(
	'ext.wikia.contentReview.testMode',
	['jquery', 'mw', 'wikia.loader', 'wikia.nirvana', 'wikia.window', 'wikia.querystring', 'BannerNotification'],
	function($, mw, loader, nirvana, win, Querystring, BannerNotification) {

	function init() {
		$.when(loader({
			type: loader.MULTI,
			resources: {
				messages: 'ContentReviewTestMode'
			}
		})).done(function (res) {
			mw.messages.set(res.messages);
			bindEvents();
		});

		showTestModeNotification();
	}

	function bindEvents() {
		$('#WikiaPage')
			.on('click', '.content-review-test-mode-enable', enableTestMode)
			.on('click', '.content-review-test-mode-disable', disableTestMode);
	}

	function enableTestMode(event) {
		event.preventDefault();

		var data = {
			pageId: mw.config.get('wgArticleId'),
			wikiId: mw.config.get('wgCityId'),
			editToken: mw.user.tokens.get('editToken')
		};

		nirvana.sendRequest({
			controller: 'ContentReviewApiController',
			method: 'enableTestMode',
			data: data,
			callback: function () {
				reloadPage();
			},
			onErrorCallback: function() {
				showErrorMessage();
			}
		});
	}

	function disableTestMode() {
		nirvana.sendRequest({
			controller: 'ContentReviewApiController',
			method: 'disableTestMode',
			callback: function () {
				reloadPage();
			},
			onErrorCallback: function() {
				showErrorMessage();
			}
		});
	}

	function showTestModeNotification() {
		if ( win.contentReviewTestModeEnabled ) {
			nirvana.sendRequest({
				controller: 'ContentReviewApiController',
				method: 'showTestModeNotification',
				callback: function (response) {
					var notification;
					if ( response.notification ) {
						notification = new BannerNotification(
							response.notification,
							'notify'
						);

						notification.show();
					}
				}
			});
		}
	}

	function showErrorMessage() {
		var notification = new BannerNotification(
			mw.message('content-review-test-mode-error').escaped(),
			'error'
		);

		notification.show();
	}

	function reloadPage() {
		var qs = new Querystring();
		qs.addCb().goTo();
	}

	return {
		init: init,
		enableTestMode: enableTestMode
	};
});