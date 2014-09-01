require( ['jquery', 'wikia.globalnavigation.lazyload'], function( $, GlobalNavLazyLoad ){
	'use strict';
	var $entryPoint, $hubLinks, $transparentOut, $verticals;

	$hubLinks = $( '#hubs > .hub-links' );
	$verticals = $( '#hubs > .hubs' );
	$entryPoint = $( '#hubsEntryPoint' );

	function activateSubmenu( row ) {
		var subMenuSelector, vertical;

		vertical = $( row ).addClass( 'active' ).data( 'vertical' );
		subMenuSelector = '.' + vertical + '-links';

		$( subMenuSelector, $hubLinks ).addClass( 'active' );
	}

	function deactivateSubmenu( row ) {
		$( '> section', $hubLinks ).add( row ).removeClass( 'active' );
	}

	/**
	 * menuAim is a method from an external module to handle dropdown menus with very good user experience
	 * @see https://github.com/Wikia/js-menu-aim
	 */
	menuAim(
		$verticals.get( 0 ), {
			activeRow:  $verticals.find( '.active' ).get( 0 ),
			rowSelector: 'nav',
			tolerance: 85,
			activate: activateSubmenu,
			deactivate: deactivateSubmenu
		});

	function openMenu() {
		$entryPoint.addClass( 'active' );
		$transparentOut.addClass( 'visible' );

		if (!GlobalNavLazyLoad.isMenuWorking()) {
			GlobalNavLazyLoad.getHubLinks();
		}
	}

	function closeMenu() {
		$entryPoint.removeClass( 'active' );
		$transparentOut.removeClass( 'visible' );
	}

	$transparentOut = $('<div />').addClass('transparent-out').appendTo('body');
	$transparentOut.click(closeMenu);

	if ( !window.touchstart ) {
		delayedHover(
			$entryPoint.get( 0 ),
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openMenu,
				onDeactivate: closeMenu
			}
		);
	} else {
		$entryPoint.click(openMenu);
	}
});
