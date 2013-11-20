<li class="feature" data-name="<?= $feature['name'] ?>">
	<h3>
		<?= wfMsg('wikifeatures-feature-heading-'.$feature['name']) ?>
		<? if (isset($feature['active'])) { ?>
		<span class="active-on">
			<?= wfMsg('wikifeatures-active-on', $feature['active']) ?>
		</span>
		<? } ?>
	</h3>

	<div class="representation<?= !empty($feature['new']) ? ' promotion' : '' ?>">
		<div class="feature-image-wrapper">
			<img src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/<?= $feature['name'] ?>.png" >
		</div>
		<? if(!empty($feature['new'])) { ?>
			<span class="promo-text"><?= wfMsg('wikifeatures-promotion-new') ?></span>
		<? } ?>
	</div>
	<div class="details">
		<p>
			<?= wfMsgExt('wikifeatures-feature-description-'.$feature['name'], 'parseinline') ?>
		</p>
	</div>
	<div class="actions">
		<? if ($editable && isset($feature['enabled'])) { ?>
			<span class="slider<?= $feature['enabled'] ? ' on' : '' ?>">
				<span class="button"></span>
				<span class="textoff"><?= wfMsg('wikifeatures-toggle-inactive') ?></span>
				<span class="texton"><?= wfMsg('wikifeatures-toggle-active') ?></span>
				<span class="loading"></span>
			</span>
		<? } ?>
		<? if (isset($feature['active'])) { ?>
			<button class="secondary feedback">
				<img height="10" width="10" src="<?= $wg->ExtensionsPath ?>/wikia/WikiFeatures/images/star-inactive.png">
				<?php echo wfMsg('wikifeatures-feedback'); ?>
			</button>
		<? } ?>
	</div>
</li>