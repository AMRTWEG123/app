/*!
 * VisualEditor DataModel Annotation class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic DataModel annotation.
 *
 * This is an abstract class, annotations should extend this and call this constructor from their
 * constructor. You should not instantiate this class directly.
 *
 * Annotations in the linear model are instances of subclasses of this class. Subclasses should
 * only override static properties and functions.
 *
 * @class
 * @extends ve.dm.Model
 * @constructor
 * @param {Object} element Linear model annotation
 */
ve.dm.Annotation = function VeDmAnnotation( element ) {
	// Parent constructor
	ve.dm.Model.call( this, element );
	// Properties
	this.name = this.constructor.static.name; // For ease of filtering
};

/* Inheritance */

OO.inheritClass( ve.dm.Annotation, ve.dm.Model );

/* Static properties */

/**
 * About grouping is not supported for annotations; setting this to true has no effect.
 *
 * @static
 * @property {boolean}
 * @inheritable
 */
ve.dm.Annotation.static.enableAboutGrouping = false;

/**
 * Automatically apply annotation to content inserted after it.
 *
 * @property {boolean}
 */
ve.dm.Annotation.static.applyToAppendedContent = true;

/**
 * Abandon continuation when a wordbreak is generated
 *
 * @type {boolean}
 */
ve.dm.Annotation.static.splitOnWordbreak = false;

/**
 * Annotations which are removed when this one is applied
 *
 * @type {string[]}
 */
ve.dm.Annotation.static.removes = [];

/**
 * Static function to convert a linear model data element for this annotation type back to
 * a DOM element.
 *
 * As special facilities for annotations, the annotated content that the returned element will
 * wrap around is passed in as childDomElements, and this function may return an empty array to
 * indicate that the annotation should produce no output. In that case, the child DOM elements will
 * not be wrapped in anything and will be inserted directly into this annotation's parent.
 *
 * @abstract
 * @static
 * @inheritable
 * @method
 * @param {Object|Array} dataElement Linear model element or array of linear model data
 * @param {HTMLDocument} doc HTML document for creating elements
 * @param {ve.dm.Converter} converter Converter object to optionally call .getDomSubtreeFromData() on
 * @param {Node[]} childDomElements Children that will be appended to the returned element
 * @returns {HTMLElement[]} Array of DOM elements; only the first element is used; may be empty
 */
ve.dm.Annotation.static.toDomElements = function () {
	throw new Error( 've.dm.Annotation subclass must implement toDomElements' );
};

/* Methods */

/**
 * Convenience wrapper for .toDomElements() on the current annotation
 * @method
 * @param {HTMLDocument} [doc] HTML document to use to create elements
 * @see ve.dm.Model#toDomElements
 */
ve.dm.Annotation.prototype.getDomElements = function ( doc ) {
	return this.constructor.static.toDomElements( this.element, doc || document );
};

/**
 * Get an object containing comparable annotation properties.
 *
 * This is used by the converter to merge adjacent annotations.
 *
 * @returns {Object} An object containing a subset of the annotation's properties
 */
ve.dm.Annotation.prototype.getComparableObject = function () {
	var hashObject = this.getHashObject();
	delete hashObject.htmlAttributes;
	return hashObject;
};

/**
 * HACK: This method strips data-parsoid from HTML attributes for comparisons.
 *
 * This should be removed once similar annotation merging is handled correctly
 * by Parsoid.
 *
 * @returns {Object} An object all HTML attributes except data-parsoid
 */
ve.dm.Annotation.prototype.getComparableHtmlAttributes = function () {
	var comparableAttributes, attributes = this.getHtmlAttributes();

	if ( attributes[0] ) {
		comparableAttributes = ve.copy( attributes[0].values );
		delete comparableAttributes['data-parsoid'];
		return comparableAttributes;
	} else {
		return {};
	}
};

/**
 * HACK: This method adds in HTML attributes so comparable objects aren't serialized
 * together if they have different HTML attributes.
 *
 * This method needs to be different from #getComparableObject which is
 * still used for editing annotations.
 *
 * @returns {Object} An object containing a subset of the annotation's properties and HTML attributes
 */
ve.dm.Annotation.prototype.getComparableObjectForSerialization = function () {
	var object = this.getComparableObject(),
		htmlAttributes = this.getComparableHtmlAttributes();

	if ( !ve.isEmptyObject( htmlAttributes ) ) {
		object.htmlAttributes = htmlAttributes;
	}
	return object;
};

/**
 * HACK: Check if the annotation was generated by the converter
 *
 * Used by compareToForSerialization to avoid merging generated annotations.
 *
 * @returns {boolean} The annotation was generated
 */
ve.dm.Annotation.prototype.isGenerated = function () {
	var attributes = this.getHtmlAttributes();
	return attributes[0] && attributes[0].values && attributes[0].values['data-parsoid'];
};

/**
 * Compare two annotations using #getComparableObject
 */
ve.dm.Annotation.prototype.compareTo = function ( annotation ) {
	return ve.compare(
		this.getComparableObject(),
		annotation.getComparableObject()
	);
};

/**
 * HACK: Compare to another annotation for serialization
 *
 * Compares two annotations using #getComparableObjectForSerialization, unless
 * they are both generated annotations, in which case they must be identical.
 *
 * @param {ve.dm.Annotation} annotation Annotation to compare to
 * @returns {boolean} The other annotation is similar to this one
 */
ve.dm.Annotation.prototype.compareToForSerialization = function ( annotation ) {
	// If both annotations were generated
	if ( this.isGenerated() && annotation.isGenerated() ) {
		return ve.compare( this.getHashObject(), annotation.getHashObject() );
	}

	return ve.compare(
		this.getComparableObjectForSerialization(),
		annotation.getComparableObjectForSerialization()
	);
};