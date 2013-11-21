<?php
use Wikia\Search\Config, Wikia\Search\QueryService\Factory, Wikia\Search\QueryService\DependencyContainer;
class TvApiController extends WikiaApiController {

	//const PARAMETER_NAMESPACES = 'namespaces';
	const LIMIT_SETTING = 1;
	const RANK_SETTING = 'default';
	const LANG_SETTING = 'en';
	const NAMESPACE_SETTING = 0;
	const API_URL = 'api/v1/Articles/AsSimpleJson?id=';
	const MINIMAL_WIKIA_SCORE = 0.5;
	const MINIMAL_ARTICLE_SCORE = 1.7;

	/**
	 * @var wikiId
	 */
	private $wikiId;

	/**
	 * @var url for wikiId
	 */
	private $url;

	public function getEpisode() {

		if ( !$this->setWikiVariables() ) {
			throw new NotFoundApiException();
		}

		$responseValues = $this->getExactMatch();
		if ( $responseValues === null ) {
			$config = $this->getConfigFromRequest();
			$responseValues = $this->getResponseFromConfig( $config );
		}

		if ( empty($responseValues) ) {
			throw new NotFoundApiException();
		}

		$responseValues[ 'contentUrl' ] = $this->url . self::API_URL . $responseValues[ 'articleId' ];
		$responseValues = array_merge( [ 'wikiId' => (int) $this->wikiId ], $responseValues );

		$response = $this->getResponse();
		$response->setValues( $responseValues );

		$response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
	}

	protected function getExactMatch() {
		$query = $this->request->getVal( 'episodeName', null );
		if ( $query !== null ) {
			return $this->getTitle( $query );
		}
		return null;
	}


	protected function createTitle($text)
	{
		return GlobalTitle::newFromText( $text, NS_MAIN, $this->wikiId );
	}

	protected function getTitle( $text ) {
		//try exact phrase
		$underscoredText = str_replace( ' ', '_', $text );
		$title = $this->createTitle( $underscoredText );
		if( !$title->exists() ) {
			$serializedText = str_replace( ' ', '_', ucwords( strtolower( $text ) ) );
			$title =  $this->createTitle( $serializedText );
		}
		if ( $title->isRedirect() ) {
			$title = $title->getRedirectTarget();
		}
		if($title->exists()) {
			return [
				'articleId' => (int) $title->getArticleID(),
				'title' => $title->getText(),
				'url' => $title->getFullURL()
			];
		}
		return null;
	}


	protected function setWikiVariables(){
		$config = $this->getConfigCrossWiki();
		$resultSet = (new Factory)->getFromConfig( $config )->search();

		foreach( $resultSet->getResults() as $result ) {
			if ( $result['id'] && $result['url'] && $result['score'] > static::MINIMAL_WIKIA_SCORE ) {
				$this->wikiId = $result['id'];
				$this->url = $result['url'];
				return true;
			}
		}

		return false;
	}

	protected function getConfigCrossWiki() {
		$request = $this->getRequest();
		$searchConfig = new Wikia\Search\Config;
		$query = $request->getVal( 'seriesName', null );
		if ( empty( $query ) || $query === null ) {
			throw new InvalidParameterApiException( 'seriesName' );
		}
		$searchConfig->setQuery( $query )
			->setLimit( static::LIMIT_SETTING )
			->setRank( 'default' )
			->setInterWiki( true )
			->setCommercialUse( $this->hideNonCommercialContent() )
			->setLanguageCode( $request->getVal( 'lang', static::LANG_SETTING ) )
			->setHub( 'Entertainment' )
		;
		return $searchConfig;
	}

	/**
	 * Inspects request and sets config accordingly.
	 * @return Wikia\Search\Config
	 */
	protected function getConfigFromRequest() {
		$request = $this->getRequest();
		$searchConfig = new Wikia\Search\Config;
		$searchConfig->setQuery( $request->getVal( 'episodeName', null ) )
			->setLimit( static::LIMIT_SETTING )
			->setPage( static::LIMIT_SETTING )
			->setLanguageCode( static::LANG_SETTING )
			->setRank( static::RANK_SETTING )
			->setWikiId($this->wikiId)
			->setVideoSearch( false )
			->setOnWiki(true)
			->setNamespaces( [static::NAMESPACE_SETTING] );
		;

		return $searchConfig;
	}

	protected function getResponseFromConfig( Wikia\Search\Config $searchConfig ) {
		if (! $searchConfig->getQuery()->hasTerms() ) {
			throw new InvalidParameterApiException( 'episodeName' );
		}

		 if(isset($_SERVER['HTTP_X_ORIGINAL_HOST']))
		 {
			 $host = $_SERVER['HTTP_X_ORIGINAL_HOST'];

		 }
		$host = 'sandbox-s1.www.wikia.com';
		if(!preg_match('/^sandbox-[a-z0-9]{0,3}\.www\.wikia\.com$/',$host))
		{
			$host = null;
		}

		$responseValues = (new Factory)->getFromConfig( $searchConfig )->searchAsApi( [ 'pageid' => 'articleId', 'title', 'url', 'score' ], true );
		//post processing
		if ( !empty( $responseValues[ 'items' ] ) ) {
			$responseValues = $responseValues[ 'items' ][ 0 ];
			if ( $responseValues['score'] < static::MINIMAL_ARTICLE_SCORE ) {
				return null;
			}
			//remove score value from results
			unset( $responseValues['score'] );

			$subpage = strpos( $responseValues['title'], '/' );
			if ( $subpage !== false ) {
				//we found subpage, return only the main page then
				$main = substr( $responseValues['title'], 0, $subpage );
				$result = $this->getTitle( $main );
				if ( $result !== null ) {
					return $result;
				}
			}
			return $responseValues;
		}
		return null;
	}
}