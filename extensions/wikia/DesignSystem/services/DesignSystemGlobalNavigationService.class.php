<?php

class DesignSystemGlobalNavigationService extends WikiaService {
	public function index() {
		$this->setVal( 'model', $this->getData() );
	}

	public function linkBranded() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function links() {
		$this->response->setValues( [
			'model' => $this->getVal( 'model' ),
			'type' => $this->getVal( 'type', 'link' ),
			'dropdownRightAligned' => $this->request->getBool( 'dropdownRightAligned' ),
		] );
	}

	public function accountNavigation() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function logo() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function link() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkDropdown() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkAuthentication() {
		$model = $this->getVal( 'model' );
		$href = ( new UserLoginHelper() )->getNewAuthUrl( $model['href'] );

		$this->setVal( 'model', $model );
		$this->setVal( 'href', $href );
	}

	private function getData() {
		return $this->sendRequest( 'DesignSystemApi', 'getNavigation', [
			'wikiId' => $this->wg->CityId,
			'lang' => $this->wg->Lang->getCode()
		] )->getData();
	}
}
