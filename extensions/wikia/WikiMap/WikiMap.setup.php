<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
    'path' => __FILE__,
    'name' => '[[Special:WikiMap|WikiMap]]',
    'author' => 'Piotr Ożga',
    'descriptionmsg' => 'wikiMap-desc'
);

$wgExtensionMessagesFiles['WikiMapAliases'] = $dir . 'WikiMap.alias.php';

$wgAutoloadClasses['WikiMapModel'] =  $dir . 'WikiMapModel.class.php';
$wgAutoloadClasses['WikiMapSpecialController'] =  $dir . 'WikiMapSpecialController.class.php';
$wgSpecialPages['WikiMap'] = 'WikiMapSpecialController';
$app->registerExtensionMessageFile('WikiMap', $dir . 'WikiMap.i18n.php');