<?php

class InsightsCache {
	const
		INSIGHTS_MEMC_PREFIX = 'insights',
		INSIGHTS_MEMC_VERSION = '1.4',
		INSIGHTS_MEMC_TTL = 259200, // Cache for 3 days
		INSIGHTS_MEMC_ARTICLES_KEY = 'articlesData';

	private $memc;

	public function __construct() {
		global $wgMemc;
		$this->memc = $wgMemc;
	}

	public function get( $params ) {
		return $this->memc->get( $this->getMemcKey( $params ) );
	}

	public function set( $params, $data, $ttl = self::INSIGHTS_MEMC_TTL ) {
		$this->memc->set( $this->getMemcKey( $params ), $data, $ttl );
	}

	public function delete( $params ) {
		$this->memc->delete( $this->getMemcKey( $params ) );
	}

	/**
	 * Updates the cached articleData and sorting array
	 *
	 * @param int $articleId
	 */
	public function updateInsightsCache( $sorting, $articleId ) {
		$this->updateArticleDataCache( $articleId );
		$this->updateSortingCache( $sorting, $articleId );
	}

	/**
	 * Removes a fixed article from the articleData array
	 *
	 * @param int $articleId
	 */
	private function updateArticleDataCache( $articleId ) {
		$articleData =  $this->get( self::INSIGHTS_MEMC_ARTICLES_KEY );

		if ( isset( $articleData[$articleId] ) ) {
			unset( $articleData[$articleId] );
			$this->set( self::INSIGHTS_MEMC_ARTICLES_KEY, $articleData );
		}
	}

	/**
	 * Removes a fixed article from the sorting arrays
	 *
	 * @param int $articleId
	 */
	private function updateSortingCache( $sorting, $articleId ) {
		foreach ( $sorting as $key => $item ) {
			$sortingArray = $this->get( $key );
			if ( is_array( $sortingArray ) ) {
				$key = array_search( $articleId, $sortingArray );

				if ( $key !== false && $key !== null ) {
					unset( $sortingArray[$key] );
					$this->set( $key, $sortingArray );
				}
			}
		}
	}

	public function purgeInsightsCache() {
		$this->delete( self::INSIGHTS_MEMC_ARTICLES_KEY );
	}

	/**
	 * Get memcache key for insights
	 *
	 * @param String $params
	 * @return String
	 */
	public function getMemcKey( $params, $type = '', $cacheParams = '' ) {
		return wfMemcKey(
			self::INSIGHTS_MEMC_PREFIX,
			$type,
			$cacheParams,
			$params,
			self::INSIGHTS_MEMC_VERSION
		);
	}
}