<div class="wds-global-navigation">
	<div class="wds-global-navigation__content-bar">
		<a href="<?= Sanitizer::encodeAttribute( $model['logo']['header']['href'] ); ?>" class="wds-global-navigation__logo">
			<?= DesignSystemHelper::getSvg(
				$model['logo']['header']['image'],
				'wds-global-navigation__logo-fandom'
			) ?>
			<span class="wds-global-navigation__logo-powered-by">powered by</span>
			<?= DesignSystemHelper::getSvg(
				'wds-company-logo-wikia',
				'wds-global-navigation__logo-wikia'
			) ?>
		</a>
		<?php
		if ( isset( $model['verticals'] ) ):
			foreach ( $model['verticals']['links'] as $link ):
		?>
				<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'linkBranded', [ 'model' => $link ] ); ?>
		<?php
			endforeach;
		endif;
		?>
		<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'dropdown', [ 'model' => $model['wikis'] ] ); ?>
		<form class="wds-global-navigation__search" action="<?= Sanitizer::encodeAttribute( $model['search']['module']['results']['url'] ); ?>">
			<div class="wds-global-navigation__search-input-wrapper">
				<label class="wds-global-navigation__search-label">
					<?= DesignSystemHelper::getSvg(
						'wds-icons-magnifying-glass',
						'wds-icon wds-icon-small'
					) ?>
					<input class="wds-global-navigation__search-input" name="search" placeholder="<?= DesignSystemHelper::renderText( $model['search']['module']['placeholder-inactive'] ); ?>"/>
				</label>
				<button class="wds-button wds-is-text wds-global-navigation__search-close">
					<?= DesignSystemHelper::getSvg(
						'wds-icons-cross',
						'wds-icon wds-icon-small wds-global-navigation__search-close-icon'
					) ?>
				</button>
			</div>
			<button class="wds-button wds-global-navigation__search-submit">
				<?= DesignSystemHelper::getSvg(
					'wds-icons-arrow',
					'wds-icon wds-icon-small wds-global-navigation__search-icon'
				) ?>
			</button>
		</form>
		<?php if ( isset( $model['user'] ) ): ?>
			<?= $app->renderView(
				'DesignSystemGlobalNavigationService',
				'dropdown',
				[
					'model' => $model['user'],
					'type' => 'user-menu',
					'rightAligned' => true,
				]
			); ?>
		<?php elseif ( isset( $model['anon'] ) ): ?>
			<?= $app->renderView( 'DesignSystemGlobalNavigationService', 'accountNavigation', [ 'model' => $model['anon'] ] ); ?>
		<?php endif; ?>
		<div class="wds-global-navigation__notifications-menu wds-dropdown notifications-entry-point">
			<div class="wds-dropdown-toggle wds-global-navigation__dropdown-toggle">
				<div class="wds-global-navigation__notifications-counter">3</div>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-bell',
					'wds-icon wds-icon-small'
				) ?>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-dropdown-tiny',
					'wds-icon wds-icon-tiny wds-dropdown-toggle-chevron'
				) ?>
			</div>
		</div>
		<div class="wds-global-navigation__start-a-wiki">
			<a href="<?= Sanitizer::encodeAttribute( $model['create_wiki']['header']['href'] ); ?>" class="wds-button wds-is-squished wds-is-secondary">
				<span class="wds-global-navigation__start-a-wiki-caption"><?= DesignSystemHelper::renderText( $model['create_wiki']['header']['title'] ) ?></span>
				<?= DesignSystemHelper::getSvg(
					'wds-icons-plus',
					'wds-global-navigation__start-a-wiki-icon wds-icon'
				) ?>
			</a>
		</div>
	</div>
</div>
