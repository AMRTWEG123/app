<footer class="wds-global-footer <?= $model['international_header'] ? 'wds-is-international' : 'wds-is-en' ?>">
	<?php if ( $model['international_header'] ) : ?>
	<div class="wds-global-footer__header-wrapper">
		<h2 class="wds-global-footer__header">
			<?= DesignSystemHelper::getSvg( $model['international_header']['header']['image'], 'wds-global-footer__wikia-logo wds-is-large' ) ?>
			<span class="wds-global-footer__home-of-fandom"><?= $model['international_header']['header']['subtitle']['key'] ?></span>
		</h2>
	</div>
	<?php endif; ?>
	<div class="wds-global-footer__main">
		<?php if ( $model['fandom']['header'] ) : ?>
			<?= $app->renderView('DesignSystemGlobalFooter', 'imageHeader', [
				'model' => $model['fandom']['header'],
				'section' => 'fandom'
			]); ?>
		<?php endif; ?>
		<div class="wds-global-footer__fandom-sections">
			<?= $app->renderView('DesignSystemGlobalFooter', 'section', [
				'model' => $model['fandom_overview'],
				'name' => 'fandom-overview',
				'parentName' => 'fandom'
			]); ?>
			<?= $app->renderView('DesignSystemGlobalFooter', 'section', [
				'model' => $model['follow_us'],
				'name' => 'follow-us',
				'parentName' => 'fandom'
			]); ?>
		</div>
		<?php if ( $model['wikia']['header'] ) : ?>
			<?= $app->renderView('DesignSystemGlobalFooter', 'imageHeader', [
				'model' => $model['wikia']['header'],
				'section' => 'wikia'
			]); ?>
		<? endif; ?>
		<div class="wds-global-footer__wikia-sections">
			<?= $app->renderView('DesignSystemGlobalFooter', 'section', [
				'model' => $model['company_overview'],
				'name' => 'company-overview',
				'parentName' => 'wikia'
			]); ?>
			<?= $app->renderView('DesignSystemGlobalFooter', 'section', [
				'model' => $model['site_overview'],
				'name' => 'site-overview',
				'parentName' => 'wikia'
			]); ?>
			<?= $app->renderView('DesignSystemGlobalFooter', 'section', [
				'model' => $model['community'],
				'name' => 'community',
				'parentName' => 'wikia'
			]); ?>
			<?= $app->renderView('DesignSystemGlobalFooter', 'section', [
				'model' => $model['create_wiki'],
				'name' => 'create-wiki',
				'parentName' => 'wikia'
			]); ?>
			<?= $app->renderView('DesignSystemGlobalFooter', 'section', [
				'model' => $model['community_apps'],
				'name' => 'community-apps',
				'parentName' => 'wikia'
			]); ?>
			<?= $app->renderView('DesignSystemGlobalFooter', 'section', [
				'model' => $model['advertise'],
				'name' => 'advertise',
				'parentName' => 'wikia'
			]); ?>
		</div>
	</div>
	<div class="wds-global-footer__licensing-and-vertical">
		<span><?= $model['licensing_and_vertical']['description']['key'] ?></span>
	</div>
</footer>
