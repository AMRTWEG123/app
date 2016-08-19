<?php

class PortabilityDashboardModel {
	const PORTABILITY_DASHBOARD_TABLE = 'portability_dashboard';
	const WIKI_ID_FIELD = 'wiki_id';
	const CUSTOM_INFOBOXES_FIELD = 'custom_infoboxes';
	const TYPELESS_FIELD = 'typeless';
	const WIKIS_LIMIT = 500;

	private $connection;

	public function __construct( $db = null ) {
		$this->connection = $db;
	}

	/**
	 * gets full (non filtered) list of data for portability dashboard
	 * @return array
	 */
	public function getList() {
		$rowList = $this->getRowList();

		return $this->extendList( $rowList );
	}

	/**
	 * For wiki url in form:
	 * - www.yugioh.wikia.com
	 * - yugioh.wikia.com
	 * return portability data
	 *
	 * @param $wikiUrl
	 * @return array
	 */
	public function getWikiByUrl( $wikiUrl ) {
		$wiki = [ ];
		$wikiId = WikiFactory::DomainToID( $wikiUrl );

		if ( $wikiId ) {
			$dataRow = $this->getWikiById( $wikiId );

			if ( $dataRow ) {
				$wiki = $this->extendList( $dataRow );
			}
		}

		return $wiki;
	}

	/**
	 * @param $rowList
	 * @return array
	 */
	private function extendList( $rowList ) {
		$wikiParamsList = $this->getWikiParamsList( $rowList );

		return $this->extendRowListWithWikiParams( $rowList, $wikiParamsList );
	}

	private function getWikiById( $id ) {
		return ( new WikiaSQL() )
			->SELECT_ALL()
			->FROM( static::PORTABILITY_DASHBOARD_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $id )
			->AND_( 'excluded' )->EQUAL_TO( 0 )
			->ORDER_BY( 'migration_impact' )
			->DESC()
			->LIMIT( 1 )
			->run( $this->readDB(), function ( ResultWrapper $rows ) {
				$result = [ ];
				while ( $row = $rows->fetchObject() ) {
					$result[] = [
						'wikiId' => $row->wiki_id,
						'portability' => $this->floatToPercent( $row->portability ),
						'infoboxPortability' => $this->floatToPercent( $row->infobox_portability ),
						'traffic' => $row->traffic,
						'migrationImpact' => $row->migration_impact,
						'typelessTemplatesCount' => $row->typeless,
						'customInfoboxesCount' => $row->custom_infoboxes
					];
				}
				return $result;
			} );
	}

	/**
	 * gets row list from DB
	 * @return bool|mixed
	 */
	private function getRowList() {
		return ( new WikiaSQL() )
			->SELECT_ALL()
			->FROM( static::PORTABILITY_DASHBOARD_TABLE )
			->WHERE( 'excluded' )->EQUAL_TO( 0 )
			->ORDER_BY( 'migration_impact' )
			->DESC()
			->LIMIT( static::WIKIS_LIMIT )
			->run( $this->readDB(), function ( ResultWrapper $rows ) {
				$result = [ ];
				while ( $row = $rows->fetchObject() ) {
					$result[] = [
						'wikiId' => $row->wiki_id,
						'portability' => $this->floatToPercent( $row->portability ),
						'infoboxPortability' => $this->floatToPercent( $row->infobox_portability ),
						'traffic' => $row->traffic,
						'migrationImpact' => $row->migration_impact,
						'typelessTemplatesCount' => $row->typeless,
						'customInfoboxesCount' => $row->custom_infoboxes
					];
				}
				return $result;
			} );
	}

	/**
	 * updates custom infobox count in portability DB table
	 * @param int $wikiId
	 * @param int $count
	 */
	public function updateInfoboxesCount( $wikiId, $count ) {
		( new WikiaSQL() )
			->INSERT()
			->INTO( self::PORTABILITY_DASHBOARD_TABLE, [ self::WIKI_ID_FIELD, self::CUSTOM_INFOBOXES_FIELD ] )
			->VALUES( [ [ (int)$wikiId, (int)$count ] ] )
			->ON_DUPLICATE_KEY_UPDATE( [ self::CUSTOM_INFOBOXES_FIELD => (int)$count ] )
			->run( $this->connect( DB_MASTER ) );
	}

	/**
	 * updates unclassified templates count in portability DB table
	 * @param int $wikiId
	 * @param int $count
	 */
	public function updateTemplatesTypeCount( $wikiId, $count ) {
		( new WikiaSQL() )
			->INSERT()
			->INTO( self::PORTABILITY_DASHBOARD_TABLE, [ self::WIKI_ID_FIELD, self::TYPELESS_FIELD ] )
			->VALUES( [ [ (int)$wikiId, (int)$count ] ] )
			->ON_DUPLICATE_KEY_UPDATE( [ self::TYPELESS_FIELD => (int)$count ] )
			->run( $this->connect( DB_MASTER ) );
	}

	/**
	 * gets wiki params based on row list wiki ids
	 * @param array $rowList
	 * @return array - wiki params array with wiki Ids as array keys
	 */
	private function getWikiParamsList( $rowList ) {
		return WikiFactory::getWikisByID(
			array_map(
				function ( $item ) {
					return $item[ 'wikiId' ];
				},
				$rowList
			)
		);
	}

	/**
	 * extends row list with wiki params
	 * @param array $rowList
	 * @param array $wikiParamsList
	 * @return array
	 */
	private function extendRowListWithWikiParams( $rowList, $wikiParamsList ) {
		return array_map(
			function ( $item ) use ( $wikiParamsList ) {
				return $this->extendListItem( $item, $wikiParamsList[ $item[ 'wikiId' ] ] );
			},
			$rowList
		);
	}

	/**
	 * extends list item with wiki params data
	 * @param array $item
	 * @param stdClass $itemWikiParams
	 * @return array mixed
	 */
	private function extendListItem( $item, $itemWikiParams ) {
		return array_merge($item, [
			'wikiUrl' => rtrim( $itemWikiParams->city_url, '/' ),
			'wikiTitle' => $itemWikiParams->city_title,
			'wikiLang' => $itemWikiParams->city_lang,
		] );
	}

	/**
	 * gets DB slave connection
	 * @return DatabaseMysqli|null
	 */
	private function readDB() {
		if ( !isset( $this->connection ) ) {
			$this->connection = $this->connect( DB_SLAVE );
		}
		return $this->connection;
	}

	/**
	 * gets DB connection
	 * @return DatabaseMysqli|null
	 */
	private function connect( $type = DB_SLAVE ) {
		global $wgExternalDatawareDB;
		return wfGetDB( $type, array(), $wgExternalDatawareDB );
	}

	/**
	 * converts float number to percent
	 * @param float $float
	 * @return int
	 */
	private function floatToPercent( $float ) {
		return sprintf( "%.2f" , $float * 100 );
	}
}
