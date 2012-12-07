<?php

class MarketingToolboxHooks {

	public static function onMakeGlobalVariablesScript(&$vars) {
		if (F::app()->wg->title->isSpecial('MarketingToolbox')) {
			$toolboxModel = new MarketingToolboxModel();
			$vars['wgMarketingToolboxConstants'] = $toolboxModel->getAvailableStatuses();
			$vars['wgMarketingToolboxUrlRegex'] = WikiaValidatorUrl::URL_REGEX;
			$vars['wgEditHubUrl'] = SpecialPage::getTitleFor('MarketingToolbox','editHub')->getLocalURL();
		}

		return true;
	}
}