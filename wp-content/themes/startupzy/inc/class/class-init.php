<?php
/**
 * Init Configuration
 *
 * @author Jegstudio
 * @package startupzy
 * @since 1.0.0
 */

namespace Startupzy;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Startupzy\Block_Patterns;
use Startupzy\Block_Styles;

/**
 * Init Class
 *
 * @package startupzy
 */
class Init {

	/**
	 * Instance variable
	 *
	 * @var $instance
	 */
	private static $instance;

	/**
	 * Class instance.
	 *
	 * @return Init
	 */
	public static function instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	/**
	 * Class constructor.
	 */
	private function __construct() {
		$this->load_hooks();
	}

	/**
	 * Load initial hooks.
	 */
	private function load_hooks() {
		// actions.
		add_action( 'init', array( $this, 'add_theme_templates' ) );
		add_action( 'after_setup_theme', array( $this, 'theme_setup' ) );
		add_action( 'after_theme_setup', array( $this, 'content_width' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_notices', array( $this, 'notice_install_plugin' ) );
		add_action( 'wp_ajax_startupzy_set_admin_notice_viewed', array( $this, 'notice_closed' ) );
		add_action( 'admin_init', array( $this, 'load_editor_styles' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'init', array( $this, 'register_block_patterns' ), 9 );
		add_action( 'init', array( $this, 'register_block_styles' ), 9 );
		add_action( 'admin_enqueue_scripts', array( $this, 'dashboard_scripts' ) );

		// filters.
		add_filter( 'the_category', array( $this, 'render_categories' ) );
		add_filter( 'excerpt_length', array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', array( $this, 'excerpt_elipsis' ) );
	}

	/**
	 * Register Block Pattern.
	 */
	public function register_block_patterns() {
		new Block_Patterns();
	}

	/**
	 * Register Block Style.
	 */
	public function register_block_styles() {
		new Block_Styles();
	}

	/**
	 * Excerpt Elipsis.
	 *
	 * @param string $more .
	 *
	 * @return string
	 */
	public function excerpt_elipsis( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		return '';
	}

	/**
	 * Excerpt Length.
	 *
	 * @param int $length .
	 *
	 * @return int
	 */
	public function excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		return 100;
	}

	/**
	 * Render Categories.
	 *
	 * @param String $thelist String rendered.
	 *
	 * @return string
	 */
	public function render_categories( $thelist ) {
		return "<div>{$thelist}</div>";
	}

	/**
	 * Notice Closed
	 */
	public function notice_closed() {
		update_user_meta( get_current_user_id(), 'gutenverse_install_notice', 'true' );
		die;
	}

	/**
	 * Show notification to install Gutenverse Plugin.
	 */
	public function notice_install_plugin() {
		// Skip if gutenverse block activated.
		if ( defined( 'GUTENVERSE' ) ) {
			return;
		}

		// Skip if gutenverse pro activated.
		if ( defined( 'GUTENVERSE_PRO' ) ) {
			return;
		}

		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}

		if ( 'true' === get_user_meta( get_current_user_id(), 'gutenverse_install_notice', true ) ) {
			return;
		}

		$button_text = __( 'Check it Now!', 'startupzy' );
		$button_link = wp_nonce_url( self_admin_url( 'themes.php?page=startupzy-dashboard' ), 'install-plugin_gutenverse' );
		?>
	<style>
		.install-gutenverse-plugin-notice {
			border: 1px solid #E6E6EF;
			border-radius: 5px;
			padding: 20px;
			position: relative;
			overflow: hidden;
			background-image: url(<?php echo esc_url( STARTUPZY_URI . '/assets/images/mockup-2x.png' ); ?>);
			background-position: right top;
			background-repeat: no-repeat;
			border-left: 4px solid #5e81f4;
		}

		.install-gutenverse-plugin-notice .notice-dismiss {
			top: 20px;
			right: 20px;
			padding: 0;
		}

		.install-gutenverse-plugin-notice .notice-dismiss:before {
			content: "\f335";
			font-size: 17px;
			width: 25px;
			height: 25px;
			line-height: 25px;
			border: 1px solid #E6E6EF;
			border-radius: 3px;
		}

		.install-gutenverse-plugin-notice h3 {
			margin-top: 5px;
			font-weight: 700;
			font-size: 18px;
		}

		.install-gutenverse-plugin-notice p {
			font-size: 14px;
			font-weight: 300;
		}

		.install-gutenverse-plugin-notice .gutenverse-bottom {
			display: flex;
			align-items: center;
			margin-top: 20px;
		}

		.install-gutenverse-plugin-notice a {
			text-decoration: none;
			margin-right: 20px;
		}

		.install-gutenverse-plugin-notice a.gutenverse-button {
			font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
			text-decoration: none;
			cursor: pointer;
			font-size: 12px;
			line-height: 18px;
			border-radius: 17px;
			background: #5e81f4;
			color: #fff;
			padding: 8px 30px;
			font-weight: 300;
		}
	</style>
	<script>
	jQuery( function( $ ) {
		$( 'div.notice.install-gutenverse-plugin-notice' ).on( 'click', 'button.notice-dismiss', function( event ) {
			event.preventDefault();

			$.post( ajaxurl, {
				action: 'startupzy_set_admin_notice_viewed'
			} );
		} );
	} );
	</script>
	<div class="notice is-dismissible install-gutenverse-plugin-notice">
		<div class="gutenverse-notice-inner">
			<div class="gutenverse-notice-content">
				<h3><?php esc_html_e( 'Thank you for installing Startupzy!', 'startupzy' ); ?></h3>
				<p><?php esc_html_e( 'Startupzy theme work best with Gutenverse plugin. By installing Gutenverse plugin you may access Startupzy templates built with Gutenverse and get access to more than 40 free blocks.', 'startupzy' ); ?></p>
				<div class="gutenverse-bottom">
					<a class="gutenverse-button" href="<?php echo esc_url( $button_link ); ?>">
						<?php echo esc_html( $button_text ); ?>
					</a>
					<a target="__blank" href="https://gutenverse.com/">
						<?php esc_html_e( 'More Info', 'startupzy' ); ?>
						<span class="dashicons dashicons-arrow-right-alt"></span>
					</a>
				</div>
			</div>
		</div>
	</div>
		<?php
	}

	/**
	 * Add Menu
	 */
	public function admin_menu() {
		add_theme_page(
			'Startupzy Template',
			'Startupzy Template',
			'manage_options',
			'startupzy-dashboard',
			array( $this, 'load_startupzy_dashboard' ),
			1
		);
	}

	/**
	 * Startupzy Template page
	 */
	public function load_startupzy_dashboard() {
		?>
		<?php if ( defined( 'GUTENVERSE_VERSION' ) && version_compare( GUTENVERSE_VERSION, '1.1.1', '<=' ) ) { ?>
		<div class="notice is-dismissible">
			<span>
			<?php echo esc_html_e( 'Please install newer version of Gutenverse plugin! (v1.1.2 and above)', 'startupzy' ); ?>
			</span>
		</div>
		<?php } ?>
		<?php do_action( 'gutenverse_after_install_notice' ); ?>
		<div id="gutenverse-theme-dashboard"></div>
		<?php
	}

	/**
	 * Add theme template
	 */
	public function add_theme_templates() {
		add_editor_style( 'block-style.css' );
	}

	/**
	 * Theme setup.
	 */
	public function theme_setup() {
		load_theme_textdomain( 'startupzy', STARTUPZY_DIR . '/languages' );

		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'editor-styles' );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'startupzy' ),
			)
		);

		add_editor_style(
			array(
				'./assets/css/core-add.css',
			)
		);

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_theme_support( 'customize-selective-refresh-widgets' );
	}

	/**
	 * Set the content width.
	 */
	public function content_width() {
		$GLOBALS['content_width'] = apply_filters( 'gutenverse_content_width', 960 );
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'startupzy-style', get_stylesheet_uri(), array(), STARTUPZY_VERSION );
		wp_add_inline_style( 'startupzy-style', $this->load_font_styles() );

		// enqueue additional core css.
		wp_enqueue_style( 'startupzy-core-add', STARTUPZY_URI . '/assets/css/core-add.css', array(), STARTUPZY_VERSION );

		// enqueue core animation.
		wp_enqueue_script( 'startupzy-animate', STARTUPZY_URI . '/assets/js/index.js', array(), STARTUPZY_VERSION, true );
		wp_enqueue_style( 'startupzy-animate', STARTUPZY_URI . '/assets/css/animation.css', array(), STARTUPZY_VERSION );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Enqueue scripts and styles.
	 */
	public function dashboard_scripts() {
		$screen = get_current_screen();

		if ( $screen->id === 'appearance_page_startupzy-dashboard' ) {
			// enqueue css.
			wp_enqueue_style(
				'startupzy-dashboard',
				STARTUPZY_URI . '/assets/css/dashboard.css',
				array(),
				STARTUPZY_VERSION
			);

			// enqueue js.
			wp_enqueue_script(
				'startupzy-dashboard',
				STARTUPZY_URI . '/assets/js/dashboard.js',
				array( 'wp-api-fetch' ),
				STARTUPZY_VERSION,
				true
			);

			wp_localize_script( 'startupzy-dashboard', 'GutenThemeConfig', $this->theme_config() );
		}
	}

	/**
	 * Register static data to be used in theme's js file
	 */
	public function theme_config() {
		return array(
			'images'       => STARTUPZY_URI . '/assets/img/',
			'title'        => esc_html__( 'Get Advanced Templates for Free!', 'startupzy' ),
			'description'  => esc_html__( 'Install and activate Gutenverse plugin now to be able to use this theme\'s advanced templates. With Gutenverse plugin installed, you gain access to both advance version of templates and block patterns for free which all built using Gutenverse blocks.', 'startupzy' ),
			'title2'       => esc_html__( 'Comparison using Gutenverse vs WordPress Core', 'startupzy' ),
			'title3'       => esc_html__( 'Benefits for Installing Startupzy\'s Gutenverse Version', 'startupzy' ),
			'description3' => esc_html__( 'You can customize your website instantly with powerful and lightweight add-ons plugin for Gutenberg/FSE.', 'startupzy' ),
			'note'         => esc_html__( 'Note: Clicking the button will both install and activate Gutenverse plugin and templates for this theme. Please first backup your current templates if you have any changes to it.', 'startupzy' ),
			'demo'         => esc_html__( 'View Live Demo →', 'startupzy' ),
			'demoUrl'      => esc_url( 'https:/gutenverse.com/demo?name=startupzy' ),
			'install'      => wp_nonce_url( self_admin_url( 'themes.php?page=startupzy-dashboard&install-template=gutenverse' ), 'install-template_gutenverse' ),
			'installText'  => get_option( 'startupzy_gutenverse_template_installed', false ) ? esc_html__( 'Reinstall Advanced Template', 'startupzy' ) : esc_html__( 'Install Advanced Template', 'startupzy' ),
			'pages'        => array(
				'home'     => STARTUPZY_URI . '/assets/img/page-home.webp',
				'about'    => STARTUPZY_URI . '/assets/img/page-about.webp',
				'services' => STARTUPZY_URI . '/assets/img/page-services.webp',
				'contact'  => STARTUPZY_URI . '/assets/img/page-contact.webp',
				'blog'     => STARTUPZY_URI . '/assets/img/page-blog.webp',
			),
			'table'        => array(
				'titles'   => array(
					null,
					esc_html__( 'Gutenverse (FREE)', 'startupzy' ),
					esc_html__( 'WordPress Core', 'startupzy' ),
				),
				'features' => array(
					esc_html__( 'Advanced Templates', 'startupzy' ),
					esc_html__( 'Responsive Styling', 'startupzy' ),
					esc_html__( 'Variety of Fonts', 'startupzy' ),
					esc_html__( 'Icon Library', 'startupzy' ),
					esc_html__( 'Animation Effects', 'startupzy' ),
					esc_html__( 'Form Builder', 'startupzy' ),
				),
			),
			'benefits'     => array(
				'title'    => esc_html__( 'Features', 'startupzy' ),
				'features' => array(
					esc_html__( 'Modern and clean design', 'startupzy' ),
					esc_html__( '5+ Ready to use templates', 'startupzy' ),
					esc_html__( '15+ template parts', 'startupzy' ),
					esc_html__( 'Fully responsive layout', 'startupzy' ),
					esc_html__( 'Fully customizable', 'startupzy' ),
				),
			),
		);
	}

	/**
	 * Load Font Styles
	 */
	public function load_font_styles() {
		$font_families = array(
			'Heebo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;1,100;1,200;1,300;1,400;1,500;1,600',
		);

		$fonts_url = add_query_arg(
			array(
				'family'  => implode( '&family=', $font_families ),
				'display' => 'swap',
			),
			'https://fonts.googleapis.com/css2'
		);

		$contents = wptt_get_webfont_url( esc_url_raw( $fonts_url ), 'woff' );

		return "@import url({$contents});";
	}

	/**
	 * Load Editor Styles
	 */
	public function load_editor_styles() {
		wp_add_inline_style( 'wp-block-library', $this->load_font_styles() );
	}
}
