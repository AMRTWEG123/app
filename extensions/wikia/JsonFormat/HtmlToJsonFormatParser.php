<?php
/**
 * User: artur
 * Date: 21.05.13
 * Time: 14:36
 */

class HtmlToJsonFormatParser {
	/**
	 * @param string $html
	 * @return JsonFormatNode
	 */
	public function parse( $html ) {
		$doc = new DOMDocument();

		libxml_use_internal_errors(true);
		$doc->loadHTML("<?xml encoding=\"UTF-8\">\n<html><body>" . $html . "</body></html>");
		libxml_clear_errors();
		$body = $doc->getElementsByTagName('body')->item(0);

		//$this->visit( $body, 0 );
		//die();

		$jsonFormatTraversingState = new JsonFormatBuilder();
		$visitor = $this->createVisitor( $jsonFormatTraversingState );
		$visitor->visit( $body );
		return $jsonFormatTraversingState->getJsonRoot();
	}

	protected function visit( DOMNode $node, $indent ) {
		for ( $i = 0; $i < $indent; $i++ ) echo ' ';
		if( $node instanceof DOMText ) {
			echo "text {$node->textContent}\n";
		} else if ($node instanceof DOMElement and $node->tagName == 'div') {

		} else {
			echo $node->tagName . "\n";
			for( $i = 0; $i < $node->childNodes->length; $i++ ) {
				$child = $node->childNodes->item($i);
				$this->visit( $child, $indent+1 );
			}
		}
	}

	protected function createVisitor( $jsonFormatTraversingState ) {
		$compositeVisitor = new CompositeVisitor();

		$compositeVisitor->addVisitor( new TextNodeVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new BodyVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new HeaderVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new QuoteVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new PVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new ListVisitor($compositeVisitor, $jsonFormatTraversingState) );


		$compositeVisitor->addVisitor( new TableOfContentsVisitor($compositeVisitor, $jsonFormatTraversingState) );
		//$compositeVisitor->addVisitor( new TableVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new TableVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new ImageFigureVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new AVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new BrVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new BVisitor($compositeVisitor, $jsonFormatTraversingState) );
		$compositeVisitor->addVisitor( new IVisitor($compositeVisitor, $jsonFormatTraversingState) );

		$compositeVisitor->addVisitor( new InlineVisitor($compositeVisitor, $jsonFormatTraversingState, ['span', 'center']) );


		return $compositeVisitor;
	}
}
