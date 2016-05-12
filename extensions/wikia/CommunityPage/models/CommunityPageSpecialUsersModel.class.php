<?php

class CommunityPageSpecialUsersModel {
	const TOP_CONTRIB_MCACHE_KEY = 'community_page_top_contrib';
	const FIRST_REV_MCACHE_KEY = 'community_page_first_revision';
	const GLOBAL_BOTS_MCACHE_KEY = 'community_page_global_bots';
	const ALL_MEMBERS_MCACHE_KEY = 'community_page_all_members';
	const MEMBER_COUNT_MCACHE_KEY = 'community_member_count';
	const RECENTLY_JOINED_MCACHE_KEY = 'community_page_recently_joined';
	const CURR_USER_CONTRIBUTIONS_MCACHE_KEY = 'community_page_current_user_contributions';

	const ALL_CONTRIBUTORS_MODAL_LIMIT = 50;

	private $wikiService;
	private $admins;

	// fixme: Remove WikiService hard dependency
	public function __construct( WikiService $wikiService ) {
		$this->wikiService = $wikiService;
	}

	public function getAdmins() {
		global $wgCityId;

		if ( $this->admins === null ) {
			$this->admins = $this->wikiService->getWikiAdminIds( $wgCityId, false, true );
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
	 * Get the user id and contribution count of the top n contributors to the current wiki,
	 * optionally filtered by admins only
	 *
	 * @param int|NULL $limit Number of rows to fetch
	 * @param string $weekly True for weekly top contributors, false for all members (2 years)
	 * @param bool $onlyAdmins Whether to filter by admins
	 * @return Mixed|null
	 */
	public function getTopContributors( $limit = 10, $weekly = true, $onlyAdmins = false ) {
		$data = WikiaDataAccess::cache(
			wfMemcKey( self::TOP_CONTRIB_MCACHE_KEY, $limit, $weekly, $onlyAdmins ),
			WikiaResponse::CACHE_STANDARD,
			function () use ( $limit, $weekly, $onlyAdmins ) {
				global $wgExternalSharedDB, $wgDBcluster;
				$db = wfGetDB( DB_SLAVE );
				$adminFilter = '';
				if ( $onlyAdmins ) {
					$adminFilter = ' AND (ug_group = "sysop")';
				}

				if ( $weekly ) {
					// From last Sunday (matches wikia_user_properties)
					$dateFilter = 'rev_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))';
				} else {
					$dateFilter = 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)';
				}

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'user_name, user_id, ug_group, count(rev_id) AS revision_count' )
					->FROM ( 'revision FORCE INDEX (user_timestamp)' )
					->LEFT_JOIN( $wgExternalSharedDB . '_' . $wgDBcluster . '.user' )->ON( '(rev_user <> 0) AND (user_id = rev_user)' )
					->LEFT_JOIN( 'user_groups ON (user_id = ug_user)' )
					->WHERE( 'user_id' )->IS_NOT_NULL()
					->AND_( $dateFilter )
					->AND_( '(ug_group IS NULL or (ug_group <> "bot"))' . $adminFilter )
					// TODO: also filter by global bot user ids?
					->GROUP_BY( 'user_name' )
					->ORDER_BY( 'revision_count DESC, user_name' );

				if ( $limit ) {
					$sqlData->LIMIT( $limit );
				}

				$result = $sqlData->runLoop( $db, function ( &$result, $row ) {
					$result[] = [
						'userId' => $row->user_id,
						'userName' => $row->user_name,
						'contributions' => $row->revision_count,
						'isAdmin' => $this->isAdmin( $row->user_id, $this->getAdmins() ),
					];
				} );

				return $result;
			}
		);
		return $data;
	}

	public function getGlobalBotIds() {
		$botIds = WikiaDataAccess::cache(
			wfMemcKey( self::GLOBAL_BOTS_MCACHE_KEY ),
			WikiaResponse::CACHE_STANDARD,
			function () {
				global $wgExternalSharedDB;
				$db = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'user_id' )
					->FROM ( 'user' )
					->LEFT_JOIN( 'user_groups ON (user_id = ug_user)' )
					->WHERE( 'ug_group' )->EQUAL_TO( 'bot-global' )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$sqlData[] = $row->user_id;
					} );

				return $sqlData;
			}
		);

		return $botIds;
	}

	public function filterGlobalBots( array $users ) {
		$botIds = $this->getGlobalBotIds();

		return array_filter( $users, function ( $user ) use ( $botIds ) {
			$userIdIsBot = in_array( $user['userId'], $botIds );
			$userIsWikia = strtolower( $user['userName'] ) === 'wikia';

			return !$userIdIsBot && !$userIsWikia;
		} );
	}

	/**
	 * Get all contributions for a user, limited by most recent n days if $days is not null
	 *
	 * @param User $user
	 * @param weekly If true get user's contributions current week. Otherwise for entire membership period (2 years)
	 * @return int Number of contributions
	 */
	public function getUserContributions( User $user, $weekly = true ) {
		$userId = $user->getId();

		$revisionCount = WikiaDataAccess::cache(
			// TODO: Should purge this when user edits
			wfMemcKey( self::CURR_USER_CONTRIBUTIONS_MCACHE_KEY, $userId, $weekly ),
			WikiaResponse::CACHE_VERY_SHORT, // short cache b/c it's for the current user's info
			function () use ( $userId, $weekly ) {
				$db = wfGetDB( DB_SLAVE );

				if ( $weekly ) {
					// From last Sunday (matches wikia_user_properties)
					$dateFilter = 'rev_timestamp >= FROM_DAYS(TO_DAYS(CURDATE()) - MOD(TO_DAYS(CURDATE()) - 1, 7))';
				} else {
					$dateFilter = 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)';
				}

				$sqlData = ( new WikiaSQL() )
					->SELECT( 'count(rev_id) AS revision_count' )
					->FROM( 'revision' )
					->WHERE( 'rev_user' )->EQUAL_TO( $userId )
					->AND_( $dateFilter )
					->runLoop( $db, function ( &$sqlData, $row ) {
						$sqlData = $row->revision_count;
					} );

				return $sqlData;
			}
		);

		return $revisionCount;
	}

	/**
	 * Utility function used to filter out users that should not show up on the member's list
	 * @param $user
	 * @return bool
	 */
	private function showMember( $user ) {
		if ( $user->isAnon() ) {
			return false;
		} elseif ( $user->isBlocked() ) {
			return false;
		} elseif ( in_array( $user->getId(), self::getGlobalBotIds() ) ) {
			return false;
		}

		return true;
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

		// Get current user's stats
		$userInfo = $this->wikiService->getUserInfo(
			$currentUserId,
			$wgCityId,
			AvatarService::AVATAR_SIZE_SMALL_PLUS
		);

		if ( $userInfo['lastRevision'] !== null ) {
			// Remove from all users list if present
			// Done manually to make sure current user data is never out of sync due to cache
			foreach ( $allContributorsData as $key => $item ) {
				if ( $item['userId'] === $currentUserId ) {
					unset( $allContributorsData[$key] );
					break;
				}
			}

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

				$userSqlData = ( new WikiaSQL() )
					->SELECT( 'rev_user, rev_timestamp' )
					->FROM( 'revision' )
					->WHERE( 'rev_timestamp > DATE_SUB(now(), INTERVAL 2 YEAR)' )
					->AND_( 'rev_user' )->NOT_EQUAL_TO( 0 )
					->GROUP_BY( 'rev_user' )
					->ORDER_BY( 'rev_timestamp DESC' )
					->LIMIT( self::ALL_CONTRIBUTORS_MODAL_LIMIT )
					->runLoop( $db, function ( &$userSqlData, $row ) {
						$userId = (int) $row->rev_user;
						$user = User::newFromId( $userId );

						if ( $this->showMember( $user ) ) {
							$userName = $user->getName();
							$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS );

							$data = [
								'userId' => $userId,
								'latestRevision' => $row->rev_timestamp,
								'timeAgo' => wfTimeFormatAgo( $row->rev_timestamp ),
								'userName' => $userName,
								'isAdmin' => $this->isAdmin( $userId, $this->getAdmins() ),
								'isCurrent' => false,
								'avatar' => $avatar,
								'profilePage' => $user->getUserPage()->getLocalURL(),
							];

							$userSqlData[] = $data;
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
