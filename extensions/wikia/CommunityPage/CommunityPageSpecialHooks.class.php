<?php

class CommunityPageSpecialHooks {

	const SYSOP = 'sysop';

	/**
	 * Cache key invalidation when an article is edited
	 *
	 * @param $article
	 * @param User $user
	 * @param $text
	 * @param $summary
	 * @param $minoredit
	 * @param $watchthis
	 * @param $sectionanchor
	 * @param $flags
	 * @param $revision
	 * @param $status
	 * @param $baseRevId
	 * @return bool
	 */
	public static function onArticleSaveComplete(
		$article, User $user, $text, $summary, $minoredit, $watchthis,
		$sectionanchor, $flags, $revision, $status, $baseRevId
	) {
		// Early exit for edits that do not affect any cached item
		if ( $user->isAnon() ) {
			return true;
		}

		// Purge Top Contributors (users)
		// Fixme: only purge if this user's save affects the top list
		$key = wfMemcKey( CommunityPageSpecialUsersModel::TOP_CONTRIB_MCACHE_KEY, 50, true, false );
		WikiaDataAccess::cachePurge( $key );

		// Purge Top Contributors (admins)
		// Fixme: only purge if this user's save affects the top list, and if the user is an admin on this community
		$key = wfMemcKey( CommunityPageSpecialUsersModel::TOP_CONTRIB_MCACHE_KEY, 10, false, true );
		WikiaDataAccess::cachePurge( $key );

		// Purge User Contributions
		$key = wfMemcKey( CommunityPageSpecialUsersModel::CURR_USER_CONTRIBUTIONS_MCACHE_KEY, $user->mId, true );
		WikiaDataAccess::cachePurge( $key );

		$key = wfMemcKey( CommunityPageSpecialUsersModel::CURR_USER_CONTRIBUTIONS_MCACHE_KEY, $user->mId, false );
		WikiaDataAccess::cachePurge( $key );

		// Purge Recently Joined Users
		// fixme: This should only be purged if this user making this edit is not already a member
		// i.e. this his first edit to this community
		$key = wfMemcKey( CommunityPageSpecialUsersModel::RECENTLY_JOINED_MCACHE_KEY, 14 );
		WikiaDataAccess::cachePurge( $key );

		// Purge All Members List
		$key = wfMemcKey( CommunityPageSpecialUsersModel::ALL_MEMBERS_MCACHE_KEY );
		WikiaDataAccess::cachePurge( $key );

		// Purge Member Count
		// fixme: Remove this once getMemberCount has been removed
		$key = wfMemcKey( CommunityPageSpecialUsersModel::MEMBER_COUNT_MCACHE_KEY );
		WikiaDataAccess::cachePurge( $key );

		if ( in_array( self::SYSOP, $user->getGroups() ) ) {
			WikiaDataAccess::cachePurge(
				wfMemcKey( CommunityPageSpecialUsersModel::ALL_ADMINS_MCACHE_KEY )
			);
		}

		return true;
	}

	/**
	 * Add community page entry point to article page right rail module
	 *
	 * @param array $railModuleList
	 * @return bool
	 */
	public static function onGetRailModuleList( array &$railModuleList ) {
		global $wgTitle, $wgUser;

		if ( ( $wgUser->isLoggedIn() && $wgTitle->inNamespace( NS_MAIN ) ) || $wgTitle->isSpecial( 'WikiActivity' ) ) {
			$railModuleList[1342] = [ 'CommunityPageEntryPoint', 'Index', null ];
		}

		return true;
	}

	/**
	 * Purge admins list on user rights change
	 * @param User $user
	 * @param array $validGroupsToAdd
	 * @param array $validGroupsToRemove
	 * @return bool
	 */
	public static function onUserRights( User $user, array $validGroupsToAdd, array $validGroupsToRemove ) {
		if ( in_array( self::SYSOP, $validGroupsToAdd ) || in_array( self::SYSOP, $validGroupsToRemove ) ) {
			WikiaDataAccess::cachePurge(
				wfMemcKey( CommunityPageSpecialUsersModel::ALL_ADMINS_MCACHE_KEY )
			);
		}

		return true;
	}
}
