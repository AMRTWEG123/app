<?php
namespace Wikia\UI;

/**
 * Wikia\UI\Factory handles building component which means loading
 * assets and component configuration file
 *
 * @author Andrzej Łukaszewski <nandy@wikia-inc.com>
 * @author Bartosz Bentkowski <bartosz.bentkowski@wikia-inc.com>
 * @author mech <mech@wikia-inc.com>
 */
class Factory {

	/**
	 * @desc Component's configuration file suffix
	 * Example buttons component config file should be named buttons_config.json
	 *
	 * @var String
	 */
	const CONFIG_FILE_SUFFIX = '_config.json';

	/**
	 * @desc Component's directory path from docroot
	 */
	const DEFAULT_COMPONENTS_PATH = "/resources/wikia/ui_components/";

	/**
	 * @desc Component's template directory's name
	 */
	const TEMPLATES_DIR_NAME = 'templates';

	/**
	 * @desc How long are components memcached? Both specific and all (different memc keys)
	 */
	const MEMCACHE_EXPIRATION = 900; // 15 minutes

	/**
	 * @desc Version passed to memcache key
	 */
	const MEMCACHE_VERSION = '1.0';
	
	/**
	 * @var \Wikia\UI\Factory
	 */
	private static $instance = null;

	/**
	 * @desc AssetsManager/ResourceLoader
	 * @var $loaderService
	 */
	private $loaderService;

	/**
	 * @desc Private constructor because it's a singleton
	 */
	private function __construct() {
		$this->loaderService = \AssetsManager::getInstance();
	}

	/**
	 * @desc Returns the path to component's directory
	 *
	 * @return null|String
	 */
	public static function getComponentsDir() {
		global $IP;
		return $IP . self::DEFAULT_COMPONENTS_PATH;
	}

	/**
	 * @desc Returns the only instnace of the class; singleton
	 *
	 * @return \Wikia\UI\Factory
	 */
	static public function getInstance() {
		if( is_null(static::$instance) ) {
			static::$instance = new self();
		}
		
		return static::$instance;
	}

	/**
	 * @desc Returns full config file's path
	 *
	 * @param string $name component's name
	 *
	 * @return string full file path
	 */
	public function getComponentConfigFileFullPath( $name ) {
		return static::getComponentsDir() .
			$name .
			DIRECTORY_SEPARATOR .
			$name .
			self::CONFIG_FILE_SUFFIX;
	}

	/**
	 * @desc Checks if a file exists, if true: loads its content and returns it
	 *
	 * @param string $path Path to file
	 *
	 * @return Array
	 * @throws \Exception
	 */
	public function loadFileContent( $path ) {
		if ( false === $fileContent = file_get_contents( $path ) ) {
			throw new \Exception( 'File not found (' . $path . ').' );
		} else {
			return $fileContent;
		}
	}

	/**
	 * @desc Loads data from JSON file content and returns in an array
	 *
	 * @param string $inputString JSON String
	 *
	 * @see Wikia\UI\Factory::loadComponentConfigFromFile() for example usage
	 * @see
	 *
	 * @return Array
	 * @throws \Exception
	 */
	public function loadFromJSON( $inputString ) {
		$outputJson = json_decode( $inputString, true );

		if ( !is_null( $outputJson ) ) {
			return $outputJson;
		} else {
			throw new \Exception( 'Invalid JSON.' );
		}
	}

	public function loadComponentConfigAsArray( $componentName ) {
		wfProfileIn( __METHOD__ );

		$configFile = $this->getComponentConfigFileFullPath( $componentName );
		$configFileContent = $this->loadFileContent( $configFile );
		$configInArray = $this->loadFromJSON( $configFileContent );

		wfProfileOut( __METHOD__ );
		return $configInArray;
	}

	/**
	 * @desc Gets the raw template contents for a given component type
	 *
	 * @param $component Component
	 * @param $type String component type
	 * @return String
	 */
	public function loadComponentTemplateContent( $component, $type ) {
		wfProfileIn( __METHOD__ );
		//@todo what about devbox development and wgStyleVersion? should we include it in memcache key?
		$memcKey = wfMemcKey( __CLASS__, 'component', $component->getName(), $type, static::MEMCACHE_VERSION );
		$content = \WikiaDataAccess::cache(
			$memcKey,
			self::MEMCACHE_EXPIRATION,
			function() use ( $component, $type ) {
				$component->setType( $type );
				return $this->loadFileContent( $component->getTemplatePath() );
			}
		);
		wfProfileOut( __METHOD__ );
		return $content;
	}

	/**
	 * Generate component assets url. The result is a dictionary containing 'js' and 'css' keys, each of those
	 * pointing to array of urls;
	 *
	 * @param $component Component
	 * @return array assets links
	 */
	public function getComponentAssetsUrls( $component ) {
		wfProfileIn( __METHOD__ );
		$result =  array( 'js' => array(), 'css' => array() );
		foreach( $component->getAssets() as $assets ) {
			$type = false;
			$sources = \AssetsManager::getInstance()->getURL( $assets, $type );
			foreach($sources as $src){
				switch ( $type ) {
					case \AssetsManager::TYPE_CSS:
					case \AssetsManager::TYPE_SCSS:
						$result[ 'css' ] = $src;
						break;
					case \AssetsManager::TYPE_JS:
						$result[ 'js' ] = $src;
						break;
				}
			}
		}
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * @desc Gets configuration file contents, decodes it to array and returns it; uses caching layer
	 * 
	 * @param String $componentName
	 * @return string
	 */
	protected function loadComponentConfig( $componentName ) {
		wfProfileIn( __METHOD__ );

		$memcKey = wfMemcKey( __CLASS__, 'component', $componentName, static::MEMCACHE_VERSION );
		$data = \WikiaDataAccess::cache(
			$memcKey,
			self::MEMCACHE_EXPIRATION,
			function() use ( $componentName ) {
				$configInArray = $this->loadComponentConfigAsArray( $componentName );

				return $configInArray;
			}
		);
		wfProfileOut( __METHOD__ );
		return $data;
	}

	/**
	 * @desc Adds asset to load
	 *
	 * @param $assetName
	 */
	private function addAsset( $assetName ) {
		wfProfileIn( __METHOD__ );

		\Wikia::addAssetsToOutput( $assetName );

		wfProfileOut( __METHOD__ );
	}

	/**
	 * @desc It uses MW Sanitizer to remove unwanted characters, builds
	 * and returns the base path to a component's templates directory
	 *
	 * @param String $name component's name
	 * @return string
	 */
	public function getComponentsBaseTemplatePath( $name ) {
		$name = \Sanitizer::escapeId( $name, 'noninitial' );
		return static::getComponentsDir() .
			$name .
			DIRECTORY_SEPARATOR .
			self::TEMPLATES_DIR_NAME .
			DIRECTORY_SEPARATOR .
			$name;
	}

	/**
	 * @desc Loads JS/CSS dependencies, creates and configurates an instance of \Wikia\UI\Component object which is returned
	 *
	 * @param string|array $componentNames
	 *
	 * @throws \Wikia\UI\DataException
	 * @return array - @todo - shouldn't it return a componentName indexed dictionary?
	 */
	public function init( $componentNames ) {
		if ( !is_array($componentNames ) ) {
			$componentNames = (array)$componentNames;
		}
		
		$components = [];
		$assets = [];

		// iterate $componentNames, read configs, write down dependencies
		foreach ( $componentNames as $name ) {
			$componentConfig = $this->loadComponentConfig( $name );

			// if there are some components, put them in the $assets
			$assetsTypes = [ 'js', 'css' ];
			foreach( $assetsTypes as $assetType ) {
				$dependenciesCfg = !empty( $componentConfig['dependencies'][$assetType] ) ? $componentConfig['dependencies'][$assetType] : [];
				if( is_array( $dependenciesCfg ) ) {
					$assets = array_merge( $assets, $dependenciesCfg );
				} else {
					$exceptionMessage = sprintf( DataException::EXCEPTION_MSG_INVALID_ASSETS_TYPE, $assetType );
					throw new DataException( $exceptionMessage );
				}
			}

			// init component, put config inside and set base template path
			$component = $this->getComponentInstance();
			$component->setName( $name );
			if ( !empty($componentConfig['templateVars']) ) {
				$component->setTemplateVarsConfig( $componentConfig['templateVars'] );
			}
			$component->setBaseTemplatePath( $this->getComponentsBaseTemplatePath( $name ) );

			$component->setAssets( $componentConfig['dependencies'] );

			$components[] = $component;
		}

		// add merged assets
		foreach ( array_unique( $assets ) as $asset ) {
			//@todo why do we have to add assets to output if there is a chance we won't render the components
			$this->addAsset( $asset );
		}

		// return components
		return (sizeof($components) == 1) ? $components[0] : $components;
	}

	/**
	 * @return Component
	 */
	protected function getComponentInstance() {
		return new Component;
	}

	/**
	 * @throws \Exception
	 */
	public function __clone() {
		throw new \Exception( 'Cloning instances of this class is forbidden.' );
	}

	/**
	 * @throws \Exception
	 */
	public function __wakeup() {
		throw new \Exception( 'Unserializing instances of this class is forbidden.' );
	}
}

