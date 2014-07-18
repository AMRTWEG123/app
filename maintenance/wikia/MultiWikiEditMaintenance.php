<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( "commandLine.inc" );
require_once( $GLOBALS["IP"]."/extensions/wikia/TaskManager/Tasks/MultiWikiEditTask.php" );

global $wgMaxShellTime, $wgMaxShellFileSize;
$wgMaxShellTime = 0;
$wgMaxShellFileSize = 0;

global $wgExternalSharedDB;
$dbr = wfGetDB( DB_MASTER, array(), $wgExternalSharedDB );
$aCondition = array("task_id" => $options['TASK_ID']);
$oTask = $dbr->selectRow( "wikia_tasks", "*", $aCondition, __METHOD__, array( "ORDER BY" => "task_id") );

if (TaskRunner::isModern('MultiWikiEditTask')) {
	$task = new \Wikia\Tasks\Tasks\MultiTask();
	$task->edit(unserialize($oTask->task_arguments));
} else {
	$Maintenance = new MultiWikiEditTask();
	$Maintenance->execute($oTask);
}

