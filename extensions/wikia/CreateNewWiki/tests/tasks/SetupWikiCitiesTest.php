<?php

namespace Wikia\CreateNewWiki\Tasks;

class SetupWikiCitiesTest extends \WikiaBaseTest
{

	public function setUp()
	{
		$this->setupFile = dirname(__FILE__) . '/../../CreateNewWiki_setup.php';
		parent::setUp();
	}

	public function tearDown()
	{
		parent::tearDown();
	}
}
