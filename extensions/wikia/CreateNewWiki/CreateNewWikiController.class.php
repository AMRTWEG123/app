<?php

use Wikia\CreateNewWiki\RequestValidator;
use Wikia\CreateNewWiki\ValidationException;
use Wikia\CreateNewWiki\UserValidator;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\Loggable;

class CreateNewWikiController extends WikiaController {
	use Loggable;

	const STATUS_MSG_FIELD         = 'statusMsg';
	const STATUS_HEADER_FIELD      = 'statusHeader';
	const STATUS_FIELD             = 'status';
	const STATUS_ERROR             = 'error';
	const STATUS_CREATION_LIMIT    = 'wikilimit';
	const STATUS_BACKEND_ERROR     = 'backenderror';
	const ERROR_CLASS_FIELD        = 'errClass';
	const ERROR_CODE_FIELD         = 'errCode';
	const ERROR_MESSAGE_FIELD      = 'errMessage';
	const STATUS_OK                = 'ok';
	const SITE_NAME_FIELD          = 'siteName';
	const CITY_ID_FIELD            = 'cityId';
	const CHECK_RESULT_FIELD       = 'res';
	const DAILY_USER_LIMIT         = 2;
	const WF_WDAC_REVIEW_FLAG_NAME = 'wgWikiDirectedAtChildrenByFounder';
	const LANG_ALL_AGES_OPT        = 'en';

	public function index() {
		global $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressToolbar, $wgRequest, $wgUser, $wgWikiaBaseDomain;
		wfProfileIn( __METHOD__ );

		// hide some default oasis UI things
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		$wgSuppressFooter = false;
		$wgSuppressToolbar = true;

		// store the fact we're on CNW
		$this->wg->atCreateNewWikiPage = true;

		if ( !$this->wg->User->isLoggedIn() && !empty( $this->wg->EnableFacebookClientExt ) ) {
			// required for FB Connect to work
			$this->response->addAsset( 'extensions/wikia/UserLogin/js/UserLoginFacebookPageInit.js' );
		}

		// fbconnected means user has gone through step 2 to login via facebook.
		// Therefore, we need to reload some values and start at the step after signup/login
		$fbconnected = $wgRequest->getVal('fbconnected');
		$fbreturn = $wgRequest->getVal('fbreturn');
		if((!empty($fbconnected) && $fbconnected === '1') || (!empty($fbreturn) && $fbreturn === '1')) {
			$this->LoadState();
			$currentStep = 'DescWiki';
		} else {
			$currentStep = '';
		}

		$this->setupVerticalsAndCategories();

		$this->aTopLanguages = explode(',', wfMsg('autocreatewiki-language-top-list'));
		$languages = wfGetFixedLanguageNames();
		asort( $languages );
		$this->aLanguages = $languages;

		$useLang = $wgRequest->getVal('uselang', $wgUser->getGlobalPreference( 'language' ));

		// squash language dialects (same wiki language for different dialects)
		$useLang = $this->squashLanguageDialects($useLang);

		// falling back to english (BugId:3538)
		if ( !array_key_exists($useLang, $this->aLanguages) ) {
			$useLang = 'en';
		}
		$params['wikiLanguage'] = empty($useLang) ? $this->wg->LanguageCode : $useLang;  // precedence: selected form field, uselang, default wiki lang

		// export info if user is logged in
		$this->isUserLoggedIn = $wgUser->isLoggedIn();
		
		$this->wg->Out->addJsConfigVars([
			'wgLangAllAgesOpt' => self::LANG_ALL_AGES_OPT
		]);
		// prefill
		$params['wikiName'] = $wgRequest->getVal('wikiName', '');
		$params['wikiDomain'] = $wgRequest->getVal('wikiDomain', '');
		$params['LangAllAgesOpt'] = self::LANG_ALL_AGES_OPT;
		$this->params = $params;
		$this->signupUrl = '';
		$signupTitle = Title::newFromText('UserSignup', NS_SPECIAL);
		if ( $wgRequest->getInt( 'nocaptchatest' ) ) {
			$this->signupUrl = $signupTitle->getFullURL('nocaptchatest=1');
		} else {
			$this->signupUrl = $signupTitle->getFullURL();
		}

		// Make various parsed messages and status available in JS
		// Necessary because JSMessages does not support parsing
		$this->wikiBuilderCfg = array(
			'name-wiki-submit-error' => wfMessage( 'cnw-name-wiki-submit-error' )->escaped(),
			'desc-wiki-submit-error' => wfMessage( 'cnw-desc-wiki-submit-error' )->escaped(),
			'currentstep' => $currentStep,
			'descriptionplaceholder' => wfMessage( 'cnw-desc-placeholder' )->escaped(),
			'cnw-error-general' => wfMessage( 'cnw-error-general' )->parse(),
			'cnw-error-general-heading' => wfMessage( 'cnw-error-general-heading' )->escaped(),
		);

		// theme designer application theme settings
		$this->applicationThemeSettings = SassUtil::getApplicationThemeSettings();

		// use either wikia.com (production) or wikia-staging.com (staging)
		$this->wikiaBaseDomain = $wgWikiaBaseDomain;

		wfProfileOut( __METHOD__ );
	}

	private function setupVerticalsAndCategories() {
		$allVerticals = WikiFactoryHub::getInstance()->getAllVerticals();
		$allCategories = WikiFactoryHub::getInstance()->getAllCategories( true );

		// Defines order in which verticals are going to be displayed in the <select>
		$verticalsOrder = array( 2, 7, 4, 3, 1, 6, 5 );

		// Defines sets of categories and order of categories in each set
		$categoriesSetsOrder = array(
			1 => array( 28, 23, 24, 25, 27, 16, 21, 22),
			2 => array( 28, 18, 17, 8, 25, 10, 6, 26, 1, 14, 11, 13, 15, 12, 5, 7)
		);

		// Defines mapping between vertical and categories set
		$verticalToCategoriesSetMapping = array( 2 => 1, 7 => 1, 4 => 1, 3 => 1, 1 => 1, 6 => 1, 5 => 2 );

		/**
		 * Current keys for translating Vertical ID to string:
		 * 'oasis-label-wiki-vertical-id-1' => 'TV',
		 * 'oasis-label-wiki-vertical-id-2' => 'Video Games',
		 * 'oasis-label-wiki-vertical-id-3' => 'Books',
		 * 'oasis-label-wiki-vertical-id-4' => 'Comics',
		 * 'oasis-label-wiki-vertical-id-5' => 'Lifestyle',
		 * 'oasis-label-wiki-vertical-id-6' => 'Music',
		 * 'oasis-label-wiki-vertical-id-7' => 'Movies',
		 */
		$this->verticals = [];
		foreach($verticalsOrder as $verticalId) {
			$verticalData = $allVerticals[$verticalId];
			$this->verticals[] = [
				'id' => $verticalData['id'],
				'name' => wfMessage( 'oasis-label-wiki-vertical-id-' . $verticalData['id'] )->escaped(),
				'short' => $verticalData['short'],
				'categoriesSet' => $verticalToCategoriesSetMapping[$verticalId]
			];
		}

		/**
		 * Current keys for translating Category ID to string:
		 * 'oasis-label-wiki-category-id-1' => 'Humor',
		 * 'oasis-label-wiki-category-id-5' => 'Toys',
		 * 'oasis-label-wiki-category-id-6' => 'Food and Drink',
		 * 'oasis-label-wiki-category-id-7' => 'Travel',
		 * 'oasis-label-wiki-category-id-8' => 'Education',
		 * 'oasis-label-wiki-category-id-10' => 'Finance',
		 * 'oasis-label-wiki-category-id-11' => 'Politics',
		 * 'oasis-label-wiki-category-id-12' => 'Technology',
		 * 'oasis-label-wiki-category-id-13' => 'Science',
		 * 'oasis-label-wiki-category-id-14' => 'Philosophy',
		 * 'oasis-label-wiki-category-id-15' => 'Sports',
		 * 'oasis-label-wiki-category-id-16' => 'Music',
		 * 'oasis-label-wiki-category-id-17' => 'Creative',
		 * 'oasis-label-wiki-category-id-18' => 'Auto',
		 * 'oasis-label-wiki-category-id-21' => 'TV',
		 * 'oasis-label-wiki-category-id-22' => 'Video Games',
		 * 'oasis-label-wiki-category-id-23' => 'Books',
		 * 'oasis-label-wiki-category-id-24' => 'Comics',
		 * 'oasis-label-wiki-category-id-25' => 'Fanon',
		 * 'oasis-label-wiki-category-id-26' => 'Home and Garden',
		 * 'oasis-label-wiki-category-id-27' => 'Movies',
		 * 'oasis-label-wiki-category-id-28' => 'Anime',
		 */
		$this->categoriesSets = [];
		foreach($categoriesSetsOrder as $setId => $categoriesOrder) {
			$categoriesSet = [];
			foreach($categoriesOrder as $categoryId) {
				$categoryData = $allCategories[$categoryId];
				$categoryData['name'] = wfMessage( 'oasis-label-wiki-category-id-' . $categoryId )->escaped();
				$categoriesSet[] = $categoryData;
			}
			$this->categoriesSets[$setId] = $categoriesSet;
		}
	}

	/**
	 * Ajax call to validate domain.
	 * Called via nirvana dispatcher
	 */
	public function CheckDomain() {
		wfProfileIn(__METHOD__);
		global $wgRequest;

		$name = $wgRequest->getVal('name');
		$lang = $wgRequest->getVal('lang');

		$this->response->setVal( self::CHECK_RESULT_FIELD, CreateWikiChecks::checkDomainIsCorrect($name, $lang) );

		wfProfileOut(__METHOD__);
	}

	/**
	 * Ajax call for validate wiki name.
	 */
	public function CheckWikiName() {
		$request = $this->getContext()->getRequest();

		$name = $request->getVal('name');
		$lang = $request->getVal('lang');

		$this->response->setVal( self::CHECK_RESULT_FIELD,  CreateWikiChecks::checkWikiNameIsCorrect($name, $lang) );
	}

	/**
	 * Ajax call to Create wiki
	 */
	public function CreateWiki() {
		$this->checkWriteRequest();

		$wgDevelDomains = $this->app->getGlobal('wgDevelDomains');

		try {
			$context = $this->getContext();

			$requestValidator = $this->getRequestValidator();
			$request = $context->getRequest();

			$requestValidator->assertValidParams( $request );
			$requestValidator->assertNotTorNode( $request );

			$userValidator = $this->getUserValidator();
			$user = $context->getUser();

			$userValidator->assertLoggedIn( $user );
			$userValidator->assertEmailConfirmed( $user );
			$userValidator->assertNotBlocked( $user );
			$userValidator->assertNotExceededRateLimit( $user );
		} catch ( ValidationException $validationException ) {
			$httpStatusCode = $validationException->getHttpStatusCode();

			$headerMessageKey = $validationException->getHeaderMessageKey();
			$headerMessageParams = $validationException->getHeaderMessageParams();

			$errorMessageKey = $validationException->getErrorMessageKey();
			$errorMessageParams = $validationException->getErrorMessageParams();

			$headerMessage = wfMessage( $headerMessageKey )->params( $headerMessageParams )->parse();
			$errorMessage = wfMessage( $errorMessageKey )->params( $errorMessageParams )->parse();

			$this->response->setCode( $httpStatusCode );
			$this->response->setValues( [
				static::STATUS_FIELD => static::STATUS_ERROR,
				static::STATUS_MSG_FIELD => $errorMessage,
				static::STATUS_HEADER_FIELD => $headerMessage,
			] );

			return;
		}

		$params = $this->request->getArray( 'data' );

		// CE-315
		if ( $params['wLanguage'] != self::LANG_ALL_AGES_OPT ) {
			$params['wAllAges'] = null;
		}

		$categories = isset($params['wCategories']) ? $params['wCategories'] : array();

		$createWiki = new CreateWiki($params['wName'], $params['wDomain'], $params['wLanguage'], $params['wVertical'], $categories);

		try {
			$createWiki->create();
		}
		catch(Exception $ex) {
			$error_code = $ex->getCode();
			$this->error(
				__METHOD__ . ": backend failed to process the request: " . $ex->getMessage(),
				[
					'code' => $error_code,
					'params' => $params,
					'exception' => $ex
				]
			);
			$this->response->setCode( 500 );
			$this->response->setVal( self::STATUS_FIELD, self::STATUS_BACKEND_ERROR );
			$this->response->setVal( self::STATUS_MSG_FIELD, wfMessage( 'cnw-error-general' )->parse() );
			$this->response->setVal( self::STATUS_HEADER_FIELD, wfMessage( 'cnw-error-general-heading' )->escaped() );
			$this->response->setVal( self::ERROR_CLASS_FIELD, get_class( $ex ) );
			$this->response->setVal( self::ERROR_CODE_FIELD, $ex->getCode() );
			$this->response->setVal( self::ERROR_MESSAGE_FIELD, $ex->getMessage() );
			return;
		}

		$cityId = $createWiki->getCityId();

		if ( isset($params['wAllAges']) && !empty( $params['wAllAges'] ) ) {
			WikiFactory::setVarByName( self::WF_WDAC_REVIEW_FLAG_NAME, $cityId, true, __METHOD__ );
		}

		$this->response->setVal( self::STATUS_FIELD, self::STATUS_OK );
		$this->response->setVal( self::SITE_NAME_FIELD, $createWiki->getSiteName() );
		$this->response->setVal( self::CITY_ID_FIELD, $cityId );
		$finishCreateTitle = GlobalTitle::newFromText( "FinishCreate", NS_SPECIAL, $cityId );

		$finishCreateUrl = empty( $wgDevelDomains ) ? $finishCreateTitle->getFullURL() : str_replace( '.wikia.com', '.'.$wgDevelDomains[0], $finishCreateTitle->getFullURL() );
		$this->response->setVal( 'finishCreateUrl',  $finishCreateUrl );

		$this->info(__METHOD__ . ': completed', [
			'city_id' => $cityId,
			'params' => $params,
		]);
	}

	/**
	 * Loads params from cookie.
	 */
	protected function LoadState() {
		wfProfileIn(__METHOD__);
		if(!empty($_COOKIE['createnewwiki'])) {
			$this->params = json_decode($_COOKIE['createnewwiki'], true);
		} else {
			$this->params = array();
		}
		wfProfileOut(__METHOD__);
	}

	public function Phalanx() {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		$text = $wgRequest->getVal('text','');
		$blockedKeyword = '';

		wfRunHooks( 'CheckContent', array( $text, &$blockedKeyword ) );

		if ( !empty( $blockedKeyword ) ) {
			$this->info( __METHOD__ . ": keyword blocked by Phalanx '" . $text . "'': " . $blockedKeyword );
			$this->response->setVal( self::STATUS_HEADER_FIELD, wfMessage('cnw-badword-header')->text() );
			$this->response->setVal( self::STATUS_MSG_FIELD, wfMessage('cnw-badword-msg', $blockedKeyword)->text() );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Return proper wiki language for for languages that have different dialects.
	 */
	private function squashLanguageDialects($useLang) {
		$squashLanguageData = array(
			'zh-tw' => 'zh',
			'zh-hk' => 'zh',
			'zh-clas' => 'zh',
			'zh-class' => 'zh',
			'zh-classical' => 'zh',
			'zh-cn' => 'zh',
			'zh-hans' => 'zh',
			'zh-hant' => 'zh',
			'zh-min-' => 'zh',
			'zh-min-n' => 'zh',
			'zh-mo' => 'zh',
			'zh-sg' => 'zh',
			'zh-yue' => 'zh',
		);

		return array_key_exists($useLang, $squashLanguageData) ? $squashLanguageData[$useLang] : $useLang;
	}

	private function getRequestValidator(): RequestValidator {
		return Injector::getInjector()->get( RequestValidator::class );
	}

	private function getUserValidator(): UserValidator {
		return Injector::getInjector()->get( UserValidator::class );
	}
}
