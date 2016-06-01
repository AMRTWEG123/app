<?php

class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const ALL_ADMINS_MCACHE_KEY = 'community_page_all_admins';
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';
	const GLOBAL_BOTS_MCACHE_KEY = 'community_page_global_bots';
	const ALL_BOTS_MCACHE_KEY = 'community_page_all_bots';
	const ALL_MEMBERS_MCACHE_KEY = 'community_page_all_members';
	const MEMBER_COUNT_MCACHE_KEY = 'community_member_count';
	const RECENTLY_JOINED_MCACHE_KEY = 'community_page_recently_joined';

	const ALL_CONTRIBUTORS_MODAL_LIMIT = 50;

	private $wikiService;
	private $admins;

	public function __construct() {
		$this->wikiService = new WikiService();
	}

	/**
	 * Returns list of User IDs that are admins
	 * @return array of User IDs
	 */
	public function getAdmins() {
		if ( $this->admins === null ) {
			$this->admins = $this->wikiService->getWikiAdminIds( 0, false, false, null, false );
		}

		return $this->admins;
	}

	/**
	 * Check if a user is an admin
	 *
	 * @param int $userId
	 * @param array $admins
	 * @return bool
	 */
	public function isAdmin( $userId, $admins ) {
		return in_array( $userId, $admins );
	}

	/**
	 * Get the user id and this week contribution count of all users contributed to this wiki whis week;
	 * Bots filtered out;
	 * Ordered from most to least active;
	 *
	 * @return array|null
	 */
	public function getTopContributors() {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::TOP_CONTRIB_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$botIds = $this->getBotIds();

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'wup_user, wup_value' )
					->FROM ( 'wikia_user_properties' )
					->WHERE( 'wup_property' )->EQUAL_TO( 'editcountThisWeek' )
					->AND_( 'wup_user' )->NOT_IN( $botIds )
					->ORDER_BY( 'CAST(wup_value as unsigned) DESC, wup_user ASC' );

				$result = $sqlData->runLoop( $db, function ( &$result, $row ) {
					$result[] = [
						'userId' => $row->wup_user,
						'contributions' => $row->wup_value,
						'isAdmin' => $this->isAdmin( $row->wup_user, $this->getAdmins() ),
					];
				} );

				return $result;
			}
		);
		return $data;
	}
	/**
	 * Get all admins who have contributed in the last two years ordered by number of contributions
	 * filter out bots
	 *
	 * @return array|null
	 */
	public function getAllAdmins() {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::ALL_ADMINS_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$adminIds = $this->getAdmins();
				$botIds = $this->getBotIds();

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'rev_user_text, rev_user, wup_value' )
					->FROM ( 'revision FORCE INDEX (user_timestamp)' )
					->LEFT_JOIN( 'wikia_user_properties' )
					->ON( 'rev_user', 'wup_user' )
					->WHERE( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->AND_( 'rev_user' )->IN( $adminIds )
					->AND_( 'rev_user' )->NOT_IN( $botIds )
					->AND_( 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->AND_( 'wup_property' )->EQUAL_TO( 'editcount' )
					->GROUP_BY( 'rev_user' )
					->ORDER_BY( 'CAST(wup_value as unsigned) DESC, rev_user_text' );

				$result = $sqlData->runLoop( $db, function ( &$result, $row ) {
					$result[] = [
						'userId' => $row->rev_user,
						'contributions' => (int)$row->wup_value,
						'isAdmin' => true,
					];
				} );

				return $result;
			}
		);
		return $data;
	}

	/**
	 * @return array|null
	 */
	private function getGlobalBotIds() {
		$botIds = WikiaDataAccess::cache(
			wfMemcKey( self::GLOBAL_BOTS_MCACHE_KEY ),
			WikiaResponse::CACHE_LONG,
			function () {
				global $wgExternalSharedDB;
				$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'ug_user' )
					->FROM ( 'user_groups' )
					->WHERE( 'ug_group' )->IN( [ 'bot', 'bot-global' ] )
					->GROUP_BY( 'ug_user' )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$sqlData[] = $row->ug_user;
					} );

				return $sqlData;
			}
		);

		return $botIds;
	}

	private function getBotIds() {
		$botIds = WikiaDataAccess::cache(
			wfMemcKey( self::ALL_BOTS_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$localBots = ( new WikiaSQL() )
					->SELECT( 'ug_user' )
					->FROM ( 'user_groups' )
					->WHERE( 'ug_group' )->IN( [ 'bot', 'bot-global' ] )
					->GROUP_BY( 'ug_user' )
					->runLoop( $db, function ( &$localBots, $row ) {
						$localBots[] = $row->ug_user;
					} );

				$allBots = array_merge( $localBots, $this->getGlobalBotIds() );

				return $allBots;
			}
		);

		return $botIds;
	}

	/**
	 * Utility function used to filter out users that should not show up on the member's list
	 * @param User $user
	 * @return bool
	 */
	private function showMember( User $user ) {
		return !( $user->isAnon() || $user->isBlocked() || in_array( $user->getId(), $this->getBotIds() ) );
	}

	/**
	 * Get a list of users who have made their first edits in the last n days
	 *
	 * @param int $limit
	 * @return array
	 */
	public function getRecentlyJoinedUsers( $limit = 14 ) {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::RECENTLY_JOINED_MCACHE_KEY, $limit ),
			WikiaResponse::CACHE_STANDARD,
			function () use ( $limit ) {
				$db = wfGetDB( DB_SLAVE );

				$sqlData = ( new WikiaSQL() )
					->SELECT( '*' )
					->FROM ( 'wikia_user_properties' )
					->WHERE ( 'wup_property' )->EQUAL_TO( 'firstContributionTimestamp' )
					->AND_ ( 'wup_value > DATE_SUB(now(), INTERVAL 14 DAY)' )
					->ORDER_BY( 'wup_value DESC' )
					->LIMIT( $limit )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$user = User::newFromId( $row->wup_user );
						$userName = $user->getName();

						if ( $this->showMember( $user ) ) {
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );

							$sqlData[] = [
								'userId' => $row->wup_user,
								'oldestRevision' => $row->wup_value,
								'contributions' => 0, // $row->contributions,
								'userName' => $userName,
								'avatar' => $avatar,
								'profilePage' => $user->getUserPage()->getLocalURL(),
							];
						}
					} );

				return $sqlData;
			}
		);

		return $data;
	}

	private function addCurrentUserIfContributor( $allContributorsData, $currentUserId ) {
		global $wgCityId;

		$key = array_search( $currentUserId, array_column( $allContributorsData, 'userId' ) );

		if ( $key !== false ) {
			$data = $allContributorsData[$key];
			$data['isCurrent'] = true;
			unset( $allContributorsData[$key] );
			array_unshift( $allContributorsData, $data );
		} else {
			// Get current user's stats
			$userInfo = $this->wikiService->getUserInfo(
				$currentUserId,
				$wgCityId,
				AvatarService::AVATAR_SIZE_SMALL_PLUS
			);

			if ( $userInfo['lastRevision'] !== null ) {
				// Add current user on top of list
				$avatar = AvatarService::renderAvatar( $userInfo['name'], AvatarService::AVATAR_SIZE_SMALL_PLUS );

				$data = [
					'userId' => $currentUserId,
					'latestRevision' => $userInfo['lastRevision'],
					'timeAgo' => wfTimeFormatAgo( $userInfo['lastRevision'] ),
					'userName' => $userInfo['name'],
					'isAdmin' => $this->isAdmin( $currentUserId, $this->getAdmins() ),
					'isCurrent' => true,
					'avatar' => $avatar,
					'profilePage' => $userInfo['userPageUrl'],
				];

				array_unshift( $allContributorsData, $data );
			}
		}

		return $allContributorsData;
	}

	/**
	 * Gets a list of all members of the community.
	 * Any user who has made an edit in the last 2 years is a member
	 *
	 * @param int $currentUserId
	 * @return Mixed|null
	 */
	public function getAllContributors( $currentUserId = 0 ) {
		$allContributorsData = WikiaDataAccess::cache(
			wfMemcKey( self::ALL_MEMBERS_MCACHE_KEY ),
			WikiaResponse::CACHE_SHORT,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$botIds = $this->getBotIds();

				$userSqlData = ( new WikiaSQL() )
					->SELECT( 'rev_user, MAX(rev_timestamp) as last_revision' )
					->FROM( 'revision' )
					->WHERE( 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->AND_( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->AND_( 'rev_user' )->NOT_IN( $botIds )
					->GROUP_BY( 'rev_user' )
					->ORDER_BY( 'last_revision DESC' )
					->LIMIT( self::ALL_CONTRIBUTORS_MODAL_LIMIT )
					->runLoop( $db, function ( &$userSqlData, $row ) {
						$userId = (int) $row->rev_user;
						$user = User::newFromId( $userId );

						if ( !$user->isBlocked() ) {
							$userName = $user->getName();
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );

							$userSqlData[] = [
								'userId' => $userId,
								'latestRevision' => $row->last_revision,
								'timeAgo' => wfTimeFormatAgo( $row->last_revision ),
								'userName' => $userName,
								'isAdmin' => $this->isAdmin( $userId, $this->getAdmins() ),
								'isCurrent' => false,
								'avatar' => $avatar,
								'profilePage' => $user->getUserPage()->getLocalURL(),
							];
						}
					} );

				return $userSqlData;
			}
		);

		return $this->addCurrentUserIfContributor( $allContributorsData, $currentUserId );
	}

	/**
	 * Gets a count of all members of the community.
	 * Any user who has made an edit in the last 2 years is a member
	 *
	 * @return integer
	 */
	public function getMemberCount() {
		$allContributorsCount = WikiaDataAccess::cache(
			wfMemcKey( self::MEMBER_COUNT_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				$db = wfGetDB( DB_SLAVE );

				$sqlCount = ( new WikiaSQL() )
					->SELECT( 'COUNT( DISTINCT rev_user )' )
					->AS_( 'all_contributors_count' )
					->FROM( 'revision' )
					->WHERE( 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->AND_( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->runLoop( $db, function ( &$sqlCount, $row ) {
						$sqlCount = $row->all_contributors_count;
					} );

				return $sqlCount;
			}
		);

		return $allContributorsCount;
	}
}
