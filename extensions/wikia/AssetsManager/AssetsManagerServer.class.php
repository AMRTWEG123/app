<?php

/**
 * @author Inez Korczyński <korczynski@gmail.com>
 */

use \Wikia\Logger\WikiaLogger;

class AssetsManagerServer {

	public static function serve(WebRequest $request) {

		$type = $request->getText('type');

		try {
			switch($type) {
				case 'one':
					$builder = new AssetsManagerOneBuilder($request);
					break;

				case 'group':
					$builder = new AssetsManagerGroupBuilder($request);
					break;

				case 'groups':
					$builder = new AssetsManagerGroupsBuilder($request);
					break;

				case 'sass':
					$builder = new AssetsManagerSassBuilder($request);
					break;

				case 'sasses':
					$builder = new AssetsManagerSassesBuilder($request);
					break;

				default:
					throw new InvalidArgumentException( "Unknown type: {$type}" );
			}

		} catch (Exception $e) {
			header('HTTP/1.1 404 Not Found');
			header('Content-Type: text/plain;  charset=UTF-8');
			echo $e->getMessage();

			WikiaLogger::instance()->error( __METHOD__, [
				'type' => $type,
				'exception' => $e
			] );

			return;
		}

		// do not log illegal request type (one/group/groups/sass supported only) - not to pollute
		// logs
		Transaction::setEntryPoint(Transaction::ENTRY_POINT_ASSETS_MANAGER);
		if ( function_exists( 'newrelic_disable_autorum') ) {
			newrelic_disable_autorum();
		}

		$headers = array();

		if($builder->getContentType()) {
			$headers['Content-Type'] = $builder->getContentType();
		}

		// BugId:31327
		$headers['Vary'] = $builder->getVary();
		$cacheDuration = $builder->getCacheDuration();

		// render the response
		try {
			$content = $builder->getContent();
		} catch(Exception $e) {
			// return HTTP 503 in case of SASS processing error (BAC-592)
			// Varnish will cache such response for 5 seconds
			header('HTTP/1.1 503');
			header('Content-Type: text/plain;  charset=UTF-8');

			// log exception messages
			WikiaLogger::instance()->error( __METHOD__, [
				'type' => $type,
				'exception' => $e
			]);

			// emit full message on devboxes only
			global $wgDevelEnvironment;
			$content = !empty( $wgDevelEnvironment ) ? $msg = $e->getMessage() : '/* SASS processing failed! */';
		}

		if($cacheDuration > 0) {
			$headers['Cache-Control'] = 'public, max-age=' . $cacheDuration['server'];
			$headers['X-Pass-Cache-Control'] = 'public, max-age=' . $cacheDuration['client'];
		}

		$headers['Last-Modified'] = gmdate('D, d M Y H:i:s \G\M\T');

		// Add X-Served-By and X-Backend-Response-Time response headers to MediaWiki pages
		// See BAC-550 for details
		// @macbre
		global $wgRequestTime;
		$headers['X-Served-By'] = wfHostname();
		$headers['X-Backend-Response-Time'] = round(microtime( true ) - $wgRequestTime, 3);

		foreach($headers as $k => $v) {
			header($k . ': ' . $v);
		}

		echo $content;
	}
}
