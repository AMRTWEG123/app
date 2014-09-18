<?php

use Wikia\Search\Services\NearbyPOISearchService;
use Wikia\Search\Services\IDSEntitySearchService;

class PalantirApiController extends WikiaApiController {

	const PI = 3.14;

	const EARTH_RADIUS = 6374;

	const DEGREES_IN_PI = 180;

	const DEFAULT_RADIUS = 180;

	const METADATA_CACHE_EXPIRATION = 300; // 5 minutes

	/**
	 * @var IDSEntitySearchService
	 */
	protected $IDSEntity;

	/**
	 * @var QuestDetailsSolrHelper
	 */
	protected $solrHelper;

	/**
	 * @var Wikia\Search\Services\NearbyPOISearchService
	 */
	protected $nearbySearch;

	/**
	 * @var QuestDetailsSearchService
	 */
	protected $questDetailsSearch;

	public function getQuestDetails() {
		$fingerprintId = $this->getRequest()->getVal( 'fingerprint_id' );
		$questId = $this->getRequest()->getVal( 'quest_id' );
		$category = $this->getRequest()->getVal( 'category' );
		$limit = $this->getRequest()->getVal( 'limit' );

		$this->validateQuestDetailsParameters( $limit );

		$solrResponse = $this->getQuestDetailsSearch()
			->newQuery()
			->withFingerprint( $fingerprintId )
			->withQuestId( $questId )

			->withWikiId( $this->wg->CityId )
			->limit( $limit )
			->search();

		$result = $this->fillDataFromMain( $solrResponse,$category );

		if( empty( $result ) ) {
			throw new NotFoundApiException();
		}
		$this->setResponseData( $result, null, self::METADATA_CACHE_EXPIRATION );
	}

	/**
	 * @param QuestDetailsSearchService $service
	 */
	public function setQuestDetailsSearch( $service ) {
		$this->questDetailsSearch = $service;
	}

	/**
	 * @return QuestDetailsSearchService
	 */
	protected function getQuestDetailsSearch() {
		if ( !isset( $this->questDetailsSearch ) ) {
			// TODO: consider using of some dependency injection mechanism
			$this->questDetailsSearch = new QuestDetailsSearchService();
		}
		return $this->questDetailsSearch;
	}

	protected function validateQuestDetailsParameters( $limit ) {
		if ( !empty( $limit ) && !preg_match( '/^\d+$/i', $limit ) ) {
			throw new BadRequestApiException( "Parameter 'limit' is invalid" );
		}
	}

	public function getNearbyQuests() {
		$lat = $this->getRequest()->getVal( 'latitude' );
		$long = $this->getRequest()->getVal( 'longitude' );
		$region = $this->getRequest()->getVal( 'region' );
		$radius = $this->getRequest()->getVal( 'radius', self::DEFAULT_RADIUS );
		$limit = $this->getRequest()->getVal( 'limit' );

		$this->validateNearbyQuestsParameters( $lat, $long, $radius, $limit );

		$radiusKilometers = $this->radiusDegreesToKilometers( $radius );
		$nearbySearch = $this->getNearbySearch();

		$solrResponse = $nearbySearch->newQuery()
			->latitude( $lat )
			->longitude( $long )
			->radius( $radiusKilometers )
			->region( $region )
			->setFields( "*" )
			->limit( $limit )
			->withWikiaId( $this->wg->CityId )
			->search();

		$result = $this->fillDataFromMain( $solrResponse, null );

		if( empty( $result ) ) {
			throw new NotFoundApiException();
		}

		$this->setResponseData( $result, null, self::METADATA_CACHE_EXPIRATION );
	}

	protected function fillDataFromMain( $metadataResp, $category ) {
		if(empty($metadataResp)){
			return [];
		}
		$solrHelper = $this->getSolrHelper();

		$ids = [ ];
		$metadata = [ ];
		foreach ( $metadataResp as $item ) {
			$ids[ ] = $item[ "id" ];
			$metadata[ $item[ "id" ] ] = $item;
		}

		$IDSEntity = $this->getIDSEntity()
			->setIds( $ids )
			->setFields( $solrHelper->getRequiredSolrFields() );
		if ( !empty( $category ) ) {
			$IDSEntity->setCategories( [ $category ] );
		}
		$result = $IDSEntity->query( "*:*" );

		$mapped = [ ];
		foreach ( $result as $item ) {
			$item[ "metadata" ] = $metadata[ $item[ "id" ] ];
			$mapped[ $item[ "id" ] ] = $item;
		}

		$result = [ ];
		foreach ( $ids as $id ) {
			if ( isset( $mapped[ $id ] ) ) {
				$result[ ] = $mapped[ $id ];
			}
		}

		return  $solrHelper->consumeResponse( $result );
	}

	protected function radiusDegreesToKilometers( $radiusDegrees ) {
		return ( $radiusDegrees / self::DEGREES_IN_PI ) * self::EARTH_RADIUS * self::PI;
	}

	/**
	 * @param \Wikia\Search\Services\NearbyPOISearchService $nearbySearch
	 */
	public function setNearbySearch( $nearbySearch ) {
		$this->nearbySearch = $nearbySearch;
	}

	/**
	 * @return \Wikia\Search\Services\NearbyPOISearchService
	 */
	public function getNearbySearch() {
		if( empty( $this->nearbySearch ) ) {
			$this->nearbySearch = new NearbyPOISearchService();
		}
		return $this->nearbySearch;
	}

	/**
	 * @param \QuestDetailsSolrHelper $solrHelper
	 */
	public function setSolrHelper( $solrHelper ) {
		$this->solrHelper = $solrHelper;
	}

	/**
	 * @return \QuestDetailsSolrHelper
	 */
	public function getSolrHelper() {
		if( empty( $this->solrHelper ) ) {
			$this->solrHelper = new QuestDetailsSolrHelper();
		}
		return $this->solrHelper;
	}

	/**
	 * @param IDSEntitySearchService $IDSEntity
	 */
	public function setIDSEntity( $IDSEntity ) {
		$this->IDSEntity = $IDSEntity;
	}

	/**
	 * @return IDSEntitySearchService
	 */
	public function getIDSEntity() {
		if(empty($this->IDSEntity)){
			$this->IDSEntity = new IDSEntitySearchService();
		}
		return $this->IDSEntity;
	}

	protected function validateNearbyQuestsParameters( $lat, $long, $radius, $limit ) {
		// positive and negative floating numbers
		if ( !preg_match( '/^-?\d+(\.\d+)?$/i', $lat ) ) {
			throw new BadRequestApiException( "Parameter 'latitude' is invalid" );
		}

		// positive and negative floating numbers
		if ( !preg_match( '/^-?\d+(\.\d+)?$/i', $long ) ) {
			throw new BadRequestApiException( "Parameter 'longitude' is invalid" );
		}

		$lat = doubleval( $lat );
		if ( ( $lat < -90 ) || ( $lat > 90 ) ) {
			throw new BadRequestApiException( "Invalid latitude: latitudes range from -90 to 90: provided latitude: ${lat}" );
		}

		$long = doubleval( $long );
		if ( ( $long < -180 ) || ( $long > 180 ) ) {
			throw new BadRequestApiException( "Invalid longitude: longitudes range from -180 to 180: provided longitude: ${long}" );
		}

		// only positive floating numbers
		if ( !empty( $radius ) && !preg_match( '/^\d+(\.\d+)?$/i', $radius ) ) {
			throw new BadRequestApiException( "Parameter 'radius' is invalid" );
		}
		$radius = doubleval( $radius );
		if( $radius > 180 ) {
			throw new BadRequestApiException( "Invalid radius: radiuses range from 0 to 180: provided radius: ${radius}" );
		}

		// only positive integer numbers
		if ( !empty( $limit ) && !preg_match( '/^\d+$/i', $limit ) ) {
			throw new BadRequestApiException( "Parameter 'limit' is invalid" );
		}
	}
}
