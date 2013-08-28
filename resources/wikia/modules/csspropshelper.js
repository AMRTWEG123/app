/**
 * Helper module for checking if CSS3 property is supported by the browser and returning this property in JS
 * camel case style formatting. Useful when you set CSS properties in javascript.
 *
 * Example: you want to set 'transform-origin' in JS
 *
 *          calling 'getCSSPropName(transform-origin)' returns 'transformOrigin'
 *          with or without browser prefix based on the current browser
 *          (WebkitTransformOrigin, MozTransformOrigin, msTransformOrigin, OTransformOrigin)
 *
 * @author: Rafal Leszczynski <rafal(at)wikia-inc.com>
 */


define('wikia.csspropshelper', ['wikia.document'], function(document) {
	'use strict';

	var prefixArray = ['Moz', 'webkit', 'ms', 'O'];

	/**
	 * Find CSS3 property name supported by browser
	 *
	 * @param {[]} propArray - Array CSS3 property names for different browsers
	 *
	 * @return {string||boolean} CSS3 property name
	 */

	function getSupportedProp(propArray) {
		var root = document.documentElement,
			i;

		for (i = 0; i < propArray.length; i++) {
			if (root.style.hasOwnProperty(propArray[i])) {
				return propArray[i];
			}
		}
		return false;
	}


	/**
	 * Create an array with browser prefixed CSS property names
	 *
	 * @param {string} prop - JS camel case style property name
	 *
	 * @return {[]} array of prefixed CSS properties
	 */

	function createPropArray(prop) {
		var i = 0,
			a = [prop],
			formattedProp = prop.charAt(0).toUpperCase() + prop.slice(1);

		for (i; i < prefixArray.length; i++) {
			var str = prefixArray[i] + formattedProp;
			a.push(str);
		}

		return a;
	}

	/**
	 * Public API method fo converting CSS property name to JS camel case style
	 *
	 * @param {string} prop - CSS style property name
	 *
	 * @return {string} JS camel case styleproperty name
	 */

	function convertPropName(prop) {
		var a = [],
			tempArray = prop.split('-');

		for (var i = 0; i < tempArray.length; i++) {
			var str = tempArray[i];
			if (i !== 0) {
				str = tempArray[i].charAt(0).toUpperCase() + tempArray[i].slice(1);
			}
			a.push(str)
		}
		return a.join('');
	}

	/**
	 * Public API method for getting CSS property name supported by current browser
	 *
	 * @param {string} prop - CSS style property name
	 *
	 * @return {string} JS camel case style property name supported by current browser
	 */

	function getCSSPropName(prop) {
		var formatedProp = convertPropName(prop),
			prefixedPropArray = createPropArray(formatedProp),
			supportedProp = getSupportedProp(prefixedPropArray);

		if (supportedProp === false) {
			throw new Error('Requested CSS property - ' + prop + ' is not supported by your browser!');
		}
		return supportedProp;

	}

	/** @public **/

	return {
		convertPropName: convertPropName,
		getCSSPropName: getCSSPropName
	}

});