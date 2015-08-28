<?php

/**
 * BlogLockdown extension - implements restrictions on blog namespaces
 *
 * @file
 * @ingroup Extensions
 *
 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
 *
 * @copyright Copyright © 2008 Krzysztof Krzyżaniak, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0
 *
 * Based on Lockdown extension from Daniel Kinzler, brightbyte.de
 */
$wgHooks['userCan'][] = 'BlogLockdown::userCan';

class BlogLockdown {

	/**
	 * @static
	 * @param Title $title
	 * @param User $user
	 * @param $action
	 * @param $result
	 * @return bool
	 */
	public static function userCan( Title $title, User $user, $action, &$result ) {

		$namespace = $title->getNamespace();
		// Only handle blog articles
		if ( $namespace !== NS_BLOG_ARTICLE ) {
			$result = null;
			return true;
		}

		/**
		 * check if default blog post was passed (BugId:8331)
		 */
		if ( $namespace == NS_BLOG_ARTICLE && $title->mTextform == '' ) {
			return true;
		}

		$username = $user->getName();
		$owner = BlogArticle::getOwner( $title );
		$isOwner = (bool)( $username == $owner );

		/**
		 * returned values
		 */
		$result = [];
		$return = false;

		switch( $action ) {
			case "move":
			case "move-target":
				if ( $user->isAllowed( "blog-articles-move" ) || $isOwner ) {
					$result = true;
					$return = true;
				}
				break;

			case "read":
				$result = true;
				$return = true;
				break;

			/**
			 * creating permissions:
			 * 	-- article can be created only by blog owner
			 *	-- comment can be created by everyone
			 */
			case "create":
				$return = ( $username == $owner );
				$result = ( $username == $owner );
				break;

			/**
			 * edit permissions -- owner of blog and one who has
			 *	 "blog-articles-edit" permission
			 */
			case "edit":
				if ( $user->isAllowed( "blog-articles-edit" ) || $isOwner ) {
					$result = true;
					$return = true;
				}
				break;

			case "delete":
				if ( $user->isAllowed( 'delete' ) ) {
					$result = true;
					$return = true;
				}
				break;

			case "protect":
				if ( $user->isAllowed( "blog-articles-protect" ) ) {
					$result = true;
					$return = true;
				}
				break;

			case "autopatrol":
			case "patrol":
				$result = true;
				$return = true;
				break;

			default:
				/**
				 * for other actions we demand that user has to be logged in
				 */
				if ( $user->isAnon( ) ) {
					$result = array( "{$action} is forbidden for anon user" );
					$return = false;
				}
				else {
					if ( isset( $owner ) && ( $username != $owner ) ) {
						$result = array();
					}
					$return = ( isset( $owner ) && ( $username == $owner ) );
				}
		}

		return $return;
	}
}
