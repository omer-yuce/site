<?php
/**
 * Plugin Name: Animated SVG icons for Elementor
 * Plugin URI:  http://www.animated-svg.com/
 * Description: Animated SVG effects and icon library for Elementor page builder plugin for WordPress.
 * Version:     1.6.0
 * Requires at least: 4.7
 * Tested up to: 5.4
 * Author:      animatedsvg
 * Author URI:  https://www.animated-svg.com/
 * Text Domain: animatesvg
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/* PLUGIN URL */
define( 'ASVG_URL', plugins_url( '/', __FILE__ ) );

/* PLUGIN PATH */
define( 'ASVG_PATH', plugin_dir_path( __FILE__ ) );
define( 'ASVG_ASTS', ASVG_URL . 'assets' );
define( 'ASVG_CSS', ASVG_ASTS . '/css' );
define( 'ASVG_JS', ASVG_ASTS . '/js' );
define( 'ASVG_IMGS', ASVG_ASTS . '/images' );
define( 'ASVG_INC', ASVG_PATH . 'inc' );
define( 'ASVG_ELEMENTOR', ASVG_INC . '/elementor-widgets' );
define( 'ASVG_PLUGIN_MENU', 'asvg-menu' );

	add_action('elementor/editor/before_enqueue_scripts', function() {
	wp_enqueue_style( 'asvg-editor', ASVG_CSS.'/editor.css');
	
	});

/**
 * Main Elementor Test Extension Class
 *
 *
 * @since 1.0.0
 */


if( !class_exists('Elementor_Animated_Svg') ){ 
	final class Elementor_Animated_Svg {

		/**
		 * Plugin Version
		 *
		 * @since 1.0.0
		 *
		 * @var string The plugin version.
		 */
		const VERSION = '1.6.0';

		/**
		 * Minimum Elementor Version
		 *
		 * @since 1.0.0
		 *
		 * @var string Minimum Elementor version required to run the plugin.
		 */
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

		/**
		 * Minimum PHP Version
		 *
		 * @since 1.0.0
		 *
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '5.6';


		/**
		 * Instance
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @static
		 *
		 * @var Elementor_Animated_Svg The single instance of the class.
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @static
		 *
		 * @return Elementor_Animated_Svg An instance of the class.
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;

		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function __construct() {

			// include files
			$this->init_files();
			// init hook
			add_action( 'init', [ $this, 'i18n' ] );
			add_action( 'plugins_loaded', [ $this, 'init' ] );
			// elementor categories
			add_action( 'elementor/elements/categories_registered', [$this, 'widget_categories'],99 );
			
			add_action('wp_enqueue_scripts',[$this,'load_scripts']);

		}
		

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 *
		 * Fired by `init` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function i18n() {

			load_plugin_textdomain( 'animatesvg', false, ASVG_PATH . 'languages' ); 

		}

		/**
		 *Files Includes
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function init_files(){
			if( file_exists( ASVG_INC . '/helper-function.php' ) ){
				require_once( ASVG_INC . '/helper-function.php' );
				require_once( ASVG_INC . '/options.php' );
			}
			
		}
		
		/**
		 * Initialize the plugin
		 *
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function init() {

			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
				return;
			}

			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
				return;
			}

			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
				return;
			}

			// Add Plugin actions
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {

			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'animatesvg' ),
				'<strong>' . esc_html__( 'Animated SVG for Elementor Page Builder', 'animatesvg' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'animatesvg' ) . '</strong>'
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required Elementor version.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_minimum_elementor_version() {

			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'animatesvg' ),
				'<strong>' . esc_html__( 'Animated SVG for Elementor Page Builder', 'animatesvg' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 'animatesvg' ) . '</strong>',
				 self::MINIMUM_ELEMENTOR_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}

		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function admin_notice_minimum_php_version() {

			if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'animatesvg' ),
				'<strong>' . esc_html__( 'Animated SVG for Elementor Page Builder', 'animatesvg' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 'animatesvg' ) . '</strong>',
				 self::MINIMUM_PHP_VERSION
			);

			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

		}

		/**
		 * Scripts Load
		 *
		 * @since   1.0.0
		 */
		public function load_scripts(){
			$action_elementor = isset($_GET['elementor-preview']) ? true : false;
			wp_enqueue_style( 'asvg-styles', ASVG_CSS.'/styles.css');
			wp_enqueue_script( 'asvg-plugins', ASVG_JS.'/plugins.js', array('jquery'));
			wp_enqueue_script( 'asvg-click', ASVG_JS.'/asvg-click.js', array('jquery'));
			wp_enqueue_script( 'asvg-drwsvg', ASVG_JS.'/draw-svg.js', array('jquery','asvg-plugins'));
			if($action_elementor){
				wp_enqueue_script( 'asvg-backend', ASVG_JS.'/backend-editor.js', array('jquery'));
			}

		}
		
		/**
		 * Widgets elements categories
		 *
		 * @since   1.0.0
		 */
		public function widget_categories($elements_manager){
			$elements_manager->add_category(
				'animated-svg',
				[
					'title' => __( 'Animated SVG Icon Library', 'animatesvg' ),
					'icon' => 'eicon-animation',
				]
			);
			
			$elements_manager->add_category(
				'animatesvg-add',
				[
					'title' => __( 'Animated SVG Icon Add-Ons', 'animatesvg' ),
					'icon' => 'eicon-animation',
				]
			);
		}
	
		/**
		 * Init Widgets
		 *
		 * Include widgets files and register them
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function init_widgets(){

			// Include Widget files
			if( file_exists( ASVG_ELEMENTOR . '/animated-svg.php' ) ){
				require_once( ASVG_ELEMENTOR . '/animated-svg.php' );
				require_once( ASVG_ELEMENTOR . '/arrow-svg.php' );
				require_once( ASVG_ELEMENTOR . '/cta-svg.php' );
				require_once( ASVG_ELEMENTOR . '/finance-svg.php' );
				require_once( ASVG_ELEMENTOR . '/food-svg.php' );
				require_once( ASVG_ELEMENTOR . '/holiday-svg.php' );
				require_once( ASVG_ELEMENTOR . '/medical-svg.php' );
				require_once( ASVG_ELEMENTOR . '/music-svg.php' );
				require_once( ASVG_ELEMENTOR . '/objects-svg.php' );
				require_once( ASVG_ELEMENTOR . '/office-svg.php' );
				require_once( ASVG_ELEMENTOR . '/retail-svg.php' );
				require_once( ASVG_ELEMENTOR . '/smiley-svg.php' );
				require_once( ASVG_ELEMENTOR . '/symbol-svg.php' );
				require_once( ASVG_ELEMENTOR . '/tech-svg.php' );
				require_once( ASVG_ELEMENTOR . '/text-svg.php' );
				require_once( ASVG_ELEMENTOR . '/travel-svg.php' );
				require_once( ASVG_ELEMENTOR . '/weather-svg.php' );
				

			}
			

		}


	} // end Class
} // end condition


if ( ! function_exists( 'animatesvg' ) ) {
    // Create a helper function for easy SDK access.
    function animatesvg() {
        global $animatesvg;

        if ( ! isset( $animatesvg ) ) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/inc/freemius/start.php';

            $animatesvg = fs_dynamic_init( array(
                'id'                  => '5425',
                'slug'                => 'animated-svg',
                'type'                => 'plugin',
                'public_key'          => 'pk_24a3a9d4b3a802615d3a9a60c8a06',
                'is_premium'          => false,
                'has_addons'          => true,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'asvg-menu',
                    'contact'        => false,
                    'support'        => false,
                ),
            ) );
        }

        return $animatesvg;
    }

    // Init Freemius.
    animatesvg();
    // Signal that SDK was initiated.
    do_action( 'animatesvg_loaded' );
}

    function animatesvg_custom_connect_message_on_update(
        $message,
        $user_first_name,
        $plugin_title,
        $user_login,
        $site_link,
        $freemius_link
    ) {
        return sprintf(
           __( 'Hello %1$s' ) . ',<br>' .
            __( 'Don\'t  miss an important update! If you opt-in, you help us improve and deliver even more icons if some data about your usage of %2$s can be shared with %5$s. If you skip this, that\'s okay! %2$s will still work just fine.', 'animated-svg' ),
            $user_first_name,
            '<b>' . $plugin_title . '</b>',
            '<b>' . $user_login . '</b>',
            $site_link,
            $freemius_link
        );
    }

    animatesvg()->add_filter('connect_message_on_update', 'animatesvg_custom_connect_message_on_update', 10, 6);


if( class_exists('Elementor_Animated_Svg') ){
	Elementor_Animated_Svg::instance();
}