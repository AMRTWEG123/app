<?php
class InfoIconTemplate {
	/**
	 * @desc sanitize infoicon template content, that is remove all non-images
	 * from it's wikitext. Then, parse them and add to stripState with
	 * handlerParams[template-type] set to TEMPLATE_INFOICON.
	 *
	 * @param string $wikitext
	 * @param \Parser $parser
	 * @return string wikitext containing strip markers. Each strip marker represents parsed markup of an infoicon
	 * @throws \MWException
	 */
	public static function handle( $wikitext, Parser $parser ) {
		global $wgContLang;
		$images = FileNamespaceSanitizeHelper::getInstance()->getCleanFileMarkersFromWikitext( $wikitext, $wgContLang );
		
		if ( !$images ) {
			return $wikitext;
		}
		
		$output = '';
		foreach ( $images as $image ) {
			$output .= self::makeIconLink( $image );
		}
		$stripMarker = $parser->insertStripItem( $output );
		return $stripMarker;
	}

	/**
	 * @desc for a given wikitext image mark, create imagelink
	 *
	 * @param $image
	 * @return String
	 * @throws \MWException
	 */
	private static function makeIconLink( $image ) {
		$link = '';
		$title = Title::newFromText( $image );
		if ( $title ) {
			$file = wfFindFile( $title );
			if ( $file ) {
				$link = Linker::makeImageLink2(
					$title,
					$file,
					[],
					[ 'template-type' => AutomaticTemplateTypes::TEMPLATE_INFOICON ]
				);
			}
		}

		return $link;
	}
}
