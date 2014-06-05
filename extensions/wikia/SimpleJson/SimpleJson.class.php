<?php

class SimpleJson extends WikiaService {
	static $media = [];
	static $users = [];

	const CACHE_VERSION = '0.0.0';

	private static function createMarker($galleryId = NULL){
		$id = count(self::$media) - 1;
		$dataRef = "data-ref={$id}";
		$galleryId = !is_null( $galleryId ) ? " id='gallery-{$galleryId}'" : "";

		return "<script class='article-media' {$dataRef}{$galleryId}></script>";
	}

	private static function createMediaObj($details, $imageName, $caption = "") {
		return [
			'type' => $details['mediaType'],
			'url' => $details['rawImageUrl'],
			'fileUrl' => $details['fileUrl'],
			'title' => $imageName,
			'caption' => ParserPool::parse(
					$caption,
					RequestContext::getMain()->getTitle(),
					new ParserOptions(),
					false
				)->getText(),
			'user' => (int) $details['userId'],
			'embed' => $details['videoEmbedCode'],
			'views' => (int) $details['videoViews']
		];
	}

	private static function addUserObj($details){
		self::$users[(int) $details['userId']] = [
			'name' => $details['userName'],
			'avatar' => $details['userThumbUrl'],
			'url' => Title::newFromText($details['userName'], NS_USER)->getLocalURL()
		];
	}

	public static function onGalleryBeforeProduceHTML($data, &$out){
		global $wgSimpleJson;

		if ( $wgSimpleJson ) {
			$media = [];

			foreach($data['images'] as $image) {
				$details = WikiaFileHelper::getMediaDetail(Title::newFromText( $image['name'], NS_FILE ));
				$media[] = self::createMediaObj($details, $image['name'], $image['caption']);

				self::addUserObj($details);
			}

			self::$media[] = $media;

			$out = self::createMarker($data['id']);

			return false;
		}

		return true;
	}

	public static function onImageBeforeProduceHTML(&$dummy,Title &$title, &$file, &$frameParams, &$handlerParams, &$time, &$res){
		global $wgSimpleJson;

		if ( $wgSimpleJson ) {
			$details = WikiaFileHelper::getMediaDetail( $title );

			self::$media[] = self::createMediaObj($details, $title->getText(), $frameParams['caption']);

			self::addUserObj($details);

			$res = self::createMarker();

			return false;
		}

		return true;
	}

	public static function onPageRenderingHash( &$confstr ){
		global $wgSimpleJson;

		if ( $wgSimpleJson ) {
			$confstr .= '!simpleJson:' . self::CACHE_VERSION;
		}

		return true;
	}

	public static function getData( Article $article ){

		$revisionId = $article->getRevIdFetched();
		$userId = $article->getUser();
		$user = User::newFromId( $userId );

		self::addUserObj([
			'userId' => $userId,
			'userName' => $user->getName(),
			'userThumbUrl' => AvatarService::getAvatarUrl($user, AvatarService::AVATAR_SIZE_MEDIUM),
			'userPageUrl' => $user->getUserPage()->getLocalURL()
		]);

		if ( !empty(self::$media) && !empty(self::$users)) {
			F::app()->wg->Memc->set(
				wfMemcKey('SimpleJson', $revisionId),
				[self::$media, self::$users, $userId],
				0*60*24*14*2 //twice as long as ParserCache
			);

			return [self::$media, self::$users, $userId];
		} else {
			return F::app()->wg->Memc->get(wfMemcKey('SimpleJson', $revisionId));
		}
	}
}
