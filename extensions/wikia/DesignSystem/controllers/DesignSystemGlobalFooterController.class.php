<?php

class DesignSystemGlobalFooterController extends WikiaService {
	public function index() {
		$this->setVal( 'model', $this->getData() );
	}

	public function section() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
		$this->setVal( 'name', $this->getVal( 'name' ) );
		$this->setVal( 'parentName', $this->getVal( 'parentName' ) );
	}

	public function imageHeader() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
		$this->setVal( 'section', $this->getVal( 'section' ) );
	}

	public function linkBranded() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkImage() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkText() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	private function getData() {
		return $this->sendRequest( 'DesignSystemApi', 'getFooter', [
			'wikiId' => $this->wg->CityId,
			'lang' => $this->wg->Lang->getCode()
		] )->getData();
	}
}
