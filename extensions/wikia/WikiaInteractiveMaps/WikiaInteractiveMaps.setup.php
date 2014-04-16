<?php
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'specialpage' ][] = [
	'name' => 'Wikia Interactive Maps',
	'authors' => [
		'Andrzej "nAndy" Łukaszewski',
		'Evgeniy "aquilax" Vasilev',
	],
	'description' => 'Create your own maps with point of interest or add your own point of interest into a real world map',
	'version' => 0.1
];

// controller classes
$wgAutoloadClasses[ 'WikiaInteractiveMapsController' ] = $dir . 'WikiaInteractiveMapsController.class.php';

// model classes
$wgAutoloadClasses[ 'WikiaMaps' ] = $dir . '/models/WikiaMaps.class.php';

// special pages
$wgSpecialPages[ 'InteractiveMaps' ] = 'WikiaInteractiveMapsController';
$wgSpecialPageGroups[ 'InteractiveMaps' ] = 'wikia';

// i18n mapping
$wgExtensionMessagesFiles[ 'WikiaInteractiveMaps' ] = $dir . 'WikiaInteractiveMaps.i18n.php';
