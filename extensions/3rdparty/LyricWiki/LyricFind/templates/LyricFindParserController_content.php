<?php
/**
 * @var $artist
 * @var $song
 * @var $songwriter
 * @var $lyricfindid
 * @var $publisher
 * @var $album
 * @var $lyric
 * @var $ringtoneUrl
 */

$imgPath = $wg->ExtensionsPath . '/3rdparty/LyricWiki/LyricFind/images';
?>
<div itemscope itemtype="http://schema.org/MusicGroup">
	<meta itemprop="name" content="<?= htmlspecialchars($artist) ?>">

	<div class="lyricfind-header plainlinks">
		<?= wfMessage('lyricfind-header', $artist, $song)->parse() ?>
	</div>

	<div class="lyricfind-credits" data-lyricfindid="<?= $lyricfindid ?>">
		<p>
			<?= wfMessage('lyricfind-songwrites') ?>: <em><?= $songwriter ?></em>
			<br>
			<?= wfMessage('lyricfind-publishers') ?>: <em><?= $publisher ?></em>
		</p>

		<noscript>
			<div class="lyricfind-header">
				You must enable javascript to view this page. This is a requirement of our licensing agreement with LyricFind.
			</div>
			<style>
				.lyricbox {
					display: none !important;
				}
			</style>
		</noscript>
	</div>

	<p><small><?= wfMessage('lyricfind-song-by', $artist)->parse() ?></small></p>

	<div class="lyricbox" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">
		<meta itemprop="byArtist" content="<?= htmlspecialchars($artist) ?>">
		<meta itemprop="inAlbum" content="<?= htmlspecialchars($album) ?>">
		<meta itemprop="name" content="<?= htmlspecialchars($song) ?>">

		<div class="rtMatcher">
			<a href="<?=  htmlspecialchars($ringtoneUrl)?>" rel="nofollow" target="_blank">
				<img src="<?= $imgPath ?>/phone_left.gif" alt="phone" width=16 height=17>
				<?= wfMessage('lyricfind-send-ringtone', $song) ?>
				<img src="<?= $imgPath ?>/phone_right.gif" alt="phone" width=16 height=17>
			</a>
		</div>

		<div itemprop="text">
			<p><?= $lyric ?></p>
		</div>

		<div class="rtMatcher">
			<a href="<?=  htmlspecialchars($ringtoneUrl)?>" rel="nofollow" target="_blank">
				<img src="<?= $imgPath ?>/phone_left.gif" alt="phone" width=16 height=17>
				<?= wfMessage('lyricfind-send-ringtone', $song) ?>
				<img src="<?= $imgPath ?>/phone_right.gif" alt="phone" width=16 height=17>
			</a>
		</div>
	</div>

	<div class="lyricfind-branding">
		<?= wfMessage('lyricfind-copyright')->parse() ?>
	</div>
</div>
