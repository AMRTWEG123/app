/*global define*/
define('ext.wikia.adEngine.video.player.ui.volumeControl', [
	'wikia.document',
	'wikia.log'
], function (doc, log) {
	'use strict';
	var logGroup = 'ext.wikia.adEngine.video.player.ui.volumeControl';

	function createVolumeControl() {
		var volume = doc.createElement('div'),
			speaker = doc.createElement('a');

		speaker.className = 'speaker';
		speaker.appendChild(doc.createElement('span'));
		volume.className = 'ima-mute-div hidden';

		volume.appendChild(speaker);
		volume.speaker = speaker;
		log('volume control is added', log.levels.info, logGroup);

		volume.mute = function () {
			volume.speaker.classList.add('mute');
			log('mute', log.levels.info, logGroup);
		};

		volume.unmute = function () {
			volume.speaker.classList.remove('mute');
			log('unmute', log.levels.info, logGroup);
		};

		return volume;
	}

	function updateCurrentState(video, volumeControl) {
		if (video.isMuted()) {
			volumeControl.mute();
		} else {
			volumeControl.unmute();
		}
	}

	function add(video) {
		var volumeControl = createVolumeControl();

		video.addEventListener('volumeChange', function () {
			updateCurrentState(video, volumeControl);
		});

		video.addEventListener('wikiaAdStarted', function () {
			updateCurrentState(video, volumeControl);
			volumeControl.classList.remove('hidden');
		});

		volumeControl.addEventListener('click', function (e) {
			video.volumeToggle();
			e.preventDefault();
		});

		video.container.appendChild(volumeControl);
	}

	return {
		add: add
	};
});
