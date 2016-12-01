<?php


class ARecoveryModuleTest extends WikiaBaseTest {

	public function getUser( $isLoggedIn ) {
		$stubs = $this->getMockBuilder( User::class )->getMock();
		$stubs->method( 'isLoggedIn' )
			->willReturn( $isLoggedIn );
		return $stubs;
	}

	public function getData()
	{
		// User is logged in, SPRecoveryEnabled, SPMMSEnabled, isDisabled (expected value)
		return [
			// User is not logged in
			[false, false, false, true],
			[false, false, true, false],
			[false, true, false, false],
			[false, true, true, false],

			// User is logged in
			[true, true, true, true],
			[true, false, false, true],
		];
	}

	/**
	 * @dataProvider getData
	 *
	 * @param $userLoggedIn boolean - current user is loggedIn
	 * @param $recoveryEnabled boolean - $wgAdDriverEnableSourcePointRecovery
	 * @param $MMSEnabled boolean - $wgAdDriverEnableSourcePointMMS
	 * @param $expected boolean - is recovery disabled
	 */
	public function testRecoveryDisabled($userLoggedIn, $recoveryEnabled, $MMSEnabled, $expected ) {
		$this->mockGlobalVariable( 'wgUser', $this->getUser( $userLoggedIn ) );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointRecovery', $recoveryEnabled );
		$this->mockGlobalVariable( 'wgAdDriverEnableSourcePointMMS', $MMSEnabled );

		$this->assertEquals( $expected, ARecoveryModule::isDisabled() );
	}
}
