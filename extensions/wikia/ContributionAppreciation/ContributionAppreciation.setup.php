<?php
$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'ContributionAppreciationController' ] = $dir . 'ContributionAppreciationController.class.php';

// i18n mapping
$wgExtensionMessagesFiles[ 'ContributionAppreciation' ] = $dir . 'ContributionAppreciation.i18n.php';
