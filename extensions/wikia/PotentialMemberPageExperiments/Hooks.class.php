<?php

namespace Wikia\PotentialMemberPageExperiments;

class Hooks extends \ContextSource {

	public static function register() {
		$hooks = new self();
		\Hooks::register( 'BeforePageDisplay', [ $hooks, 'onBeforePageDisplay' ] );
	}

	public function onBeforePageDisplay( \OutputPage $out, \Skin $skin ) {
		if ( $this->shouldAddExperimentScript( $skin->getTitle() ) ) {
			$out->addScriptFile( '/extensions/wikia/PotentialMemberPageExperiments/scripts/entry-point-experiment.js' );
		}

		return true;
	}

	private function shouldAddExperimentScript( \Title $title ) {
		$user = $this->getUser();

		return !$user->isLoggedIn() &&
			$title->inNamespace( NS_MAIN ) &&
			$title->getPageLanguage()->getCode() === 'en' && // getPageLanguage returns wgContLang for NS_MAIN pages
			!$title->isMainPage() &&
			$this->getRequest()->getVal( 'action', 'view' ) === 'view';
	}
}
