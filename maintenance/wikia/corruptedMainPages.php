<?php

require_once( dirname( __FILE__ ) . '/../commandLine.inc' );

global $wgDBname;

function isCorrupted() {
	$title = Title::newFromText( 'Main_Page' );
	if ( empty ($title) || !$title->exists() ) {
		return false;
	}

	$mainPage = Article::newFromID( $title->getArticleID() );
	if ( empty ($mainPage) || !$mainPage->exists() ) {
		return false;
	}

	$pattern = '/<hero description="My description" imagename="" cropposition="" \/>/';
	$raw = $mainPage->getContent();

	return preg_match($pattern, $raw) === 1;
}

if ( isCorrupted() ) {
	$today = date( 'd-m-Y' );
	echo( "\n" . $today );
	echo( "\n" .  $wgDBname);
}
