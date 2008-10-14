<?php
/**
 * GlobalWatchlistBot execute script - part of GlobalWatchlist extension
 * 
 * @addto maintenance
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * 
 */
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once('commandLine.inc');

$bDebugMode = (isset($options['d']) || isset($options['debug'])) ? true : false;
$aUserNames = (isset($options['users'])) ? explode(',', $options['users']) : array();
$bDbExistsCheck = (isset($options['checkdb']) ? true : false);
$bClearMode = (isset($options['clear']) ? true : false);

if(class_exists('GlobalWatchlistBot')) {
	$oWatchlistBot = new GlobalWatchlistBot($bDebugMode, $aUserNames);
	$oWatchlistBot->setDbExistsCheck($bDbExistsCheck);
	if($bClearMode) {
		$oWatchlistBot->clear();
	}
	else {
		$oWatchlistBot->run();	
	}
}
else {
	print "GlobalWatchlist extension is not installed.\n";
	exit(1);
}
