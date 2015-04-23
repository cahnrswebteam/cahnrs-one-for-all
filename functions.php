<?php
class init_cahnrs_flex {
	public $theme_model;
	public $theme_controller;
	public $theme_view;

	public function __construct() {
		$this->theme_model = new cf_theme_model();
		$this->theme_controller = new cf_theme_controller( $this->theme_model );
		$this->theme_view = new cf_theme_view( $this->theme_controller, $this->theme_model );
		\add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 11 );
		\add_action( 'customize_register', array( $this->theme_view, 'add_custom_settings' ) );
		\add_action( 'init', array( $this, 'add_menu_locations' ) );
		\add_action( 'init', array( $this, 'add_image_sizes' ) );
		\add_action( 'init', array( $this, 'add_site_taxonomy' ), 0 );
		\add_filter( 'image_size_names_choose', array( $this, 'add_image_size_names' ) );
		\add_action( 'admin_init', array( $this, 'admin_init' ) );
		\add_filter( 'body_class', array( $this, 'spine_theme_images_classes' ) );
	}

	public function add_scripts() {
		\wp_enqueue_style(
			'cahnrs-flex-'.$this->theme_model->t_css,
			get_stylesheet_directory_uri().'/css/style-'.$this->theme_model->t_css.'.css',
			array( 'wsu-spine' ),
			'0.0.1'
			);
		\wp_enqueue_script(
			'cahnrs-flex-js',
			get_stylesheet_directory_uri().'/js/flex.js',
			array( 'jquery' ),
			'0.0.1'
			);
		if ( 'department' == $this->theme_model->t_css || 'unit' == $this->theme_model->t_css ) {
			wp_dequeue_style( 'spine-theme-extra' );
			if ( is_front_page() ) {
				wp_enqueue_style(
					'cahnrs-department-home',
					get_stylesheet_directory_uri().'/css/style-department-home.css'
				);
				if ( true == spine_get_option( 'crop' ) && true == spine_get_option( 'spineless' ) ) {
					wp_enqueue_style(
						'spineless',
						get_stylesheet_directory_uri().'/css/spineless.css'
					);
				}
			}
		}
		$active_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
		if ( in_array( 'all-in-one-event-calendar/all-in-one-event-calendar.php', $active_plugins ) ) {
  		wp_enqueue_style(
				'ai1ec-overrides',
				get_stylesheet_directory_uri().'/css/ai1ec-overrides.css'
			);
		}
		if ( in_array( 'the-events-calendar/the-events-calendar.php', $active_plugins ) ) {
			wp_enqueue_style(
				'tec-overrides',
				get_stylesheet_directory_uri().'/css/tec-overrides.css'
			);
		}
	}

	public function add_menu_locations() {
		//if ( 'department' != $this->theme_model->t_css ) {
			register_nav_menu( 'cahnrs_horizontal', 'Horizontal' );
		//}
	}

	public function add_image_sizes() {
		set_post_thumbnail_size( 300, 300, true );
		add_image_size( '4x3-medium', 400, 300, true );
		add_image_size( '3x4-medium', 300, 400, true );
		add_image_size( '16x9-medium', 400, 225, true );
		add_image_size( '16x9-large', 800, 450, true );
		add_image_size( '16x9-extra-large', 800, 450, true );
		add_image_size( 'extra-large' );
	}

	public function add_image_size_names( $sizes ) {
		return array_merge( $sizes, array(
			'4x3-medium'       => __( '4x3 Medium' ),
			'3x4-medium'       => __( '3X4 Medium' ),
			'16x9-medium'      => __( '16x9 Medium' ),
			'16x9-large'       => __( '16x9 Large' ),
			'16x9-extra-large' => __( '16x9 Extra Large' ),
			'extra-large'      => __( 'Extra Large' ),
		) );
	}

	public function admin_init() {
		/** Register default taxonomies for pages **/
		\register_taxonomy_for_object_type( 'post_tag', 'page' );
		\register_taxonomy_for_object_type( 'category', 'page' );
	}

	public function add_site_taxonomy() {
		$labels = array(
			'name'              => _x( 'Sites', 'taxonomy general name' ),
			'singular_name'     => _x( 'Site', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Sites' ),
			'all_items'         => __( 'All Sites' ),
			'parent_item'       => __( 'Parent Site' ),
			'parent_item_colon' => __( 'Parent Site:' ),
			'edit_item'         => __( 'Edit Site' ),
			'update_item'       => __( 'Update Site' ),
			'add_new_item'      => __( 'Add New Site' ),
			'new_item_name'     => __( 'New Site Name' ),
			'menu_name'         => __( 'Sites' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'public'            => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'sites' ),
		);
		
		register_taxonomy( 'site', array( 'page' ), $args );
	}

	public function check_post_thumbnail() {
		if ( $this->theme_model->show_home_banner && is_front_page() ) return false;
		if ( $this->theme_model->show_banner && has_post_thumbnail() ) return true;
		return false;
	}

	public function get_query( $args = array(), $size = 'full' ) {
		$posts = array();
		$the_query = new WP_Query( $args );
		if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$posts[] = $the_query->post;
			}
		}
		wp_reset_postdata();
		return $posts;
	}

	/**
	 * From Spine 0.16.0 - add classes indicating which theme images are available.
	 */
	public function spine_theme_images_classes( $classes ) {
		if ( has_post_thumbnail() && is_singular() ) {
			$classes[] = 'has-featured-image';
		}
		if ( 'extension' == get_theme_mod( 'cahnrs_flex_subtheme' ) ) {
			$classes[] = 'extension-signature';
		}
		return $classes;
	}

}

class cf_theme_model {
	public $t_header;
	public $t_footer;
	public $t_css;
	public $show_banner;
	public $show_home_banner;
	public $menu;
	public $orderd_nav;
	public $tertiary_nav;

	public function __construct() {
		$opts_default = 'default'; // Default options
		$opts = get_theme_mod( 'cahnrs_flex_subtheme', $opts_default ); // Get the options from theme
		switch ( $opts ) {
			case 'sdc':
				$opts = array( 'header' => 'sdc', 'footer' => false, 'css' => 'sdc' );
				break;
			case 'department':
				$opts = array( 'header' => 'department', 'footer' => false, 'css' => 'department' );
				break;
			case 'extension':
				$opts = array( 'header' => 'department', 'footer' => false, 'css' => 'department' );
				break;
			case 'unit':
				$opts = array( 'header' => 'department', 'footer' => false, 'css' => 'unit' );
				break;
			case 'default':
			default:
				$opts = array( 'header' => 'default', 'footer' => false, 'css' => 'default' );
		}
		$this->t_header = $opts['header'];
		$this->t_footer = $opts['footer'];
		$this->t_css = $opts['css'];
		
		
		$this->show_banner = get_theme_mod( 'cahnrs_flex_featured', false ); // Get the options from theme
		
		$this->show_home_banner = get_theme_mod( 'cahnrs_flex_ex_feature', false ); // Get the options from theme
	}

	public function set_tertiary_nav( $post_id ) {

		$nav = array();
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'site' ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ 'site' ] ); // GET THE MENU OBJECT FROM LOCATION
			$menu_items = wp_get_nav_menu_items( $menu->term_id ); // GET MENU ITEMS FROM OBJECT ID
			$current = false;
			foreach ( $menu_items as $menu_item ) {
				if ( $post_id == $menu_item->object_id ) $current = $menu_item;
				$this->menu[$menu_item->ID] = $menu_item;
			}
			if ( $current && $current->menu_item_parent ) {
				if ( $this->menu[ $current->menu_item_parent ]->menu_item_parent ) { // Third Level
					$current = $this->menu[ $current->menu_item_parent ];
				}
				foreach ( $this->menu as $menu_id => $menu ) {
					if ( $current->ID == $menu->ID && 'custom' != $menu->type ) {
						$menu->title = 'Overview';
						$nav[] = $menu;
					} else if ( $current->ID == $menu->menu_item_parent ) {
						$nav[] = $menu;
					}
				}
			}
		}
		$this->tertiary_nav = $nav;
	}
}

class cf_theme_controller {
	private $ct_theme_model;

	public function __construct( $cf_theme_model ) {
		$this->cf_theme_model = $cf_theme_model;
	}

	public function set_tertiary( $post_id ) {
		$this->cf_theme_model->set_tertiary_nav( $post_id );
	}
}

class cf_theme_view {
	private $cf_theme_model;
	private $cf_theme_controller;

	public function __construct( $cf_theme_controller, $cf_theme_model ) {
		$this->cf_theme_model = $cf_theme_model;
		$this->cf_theme_controller = $cf_theme_controller;
	}

	public function add_custom_settings( $wp_customize ) {
		$wp_customize->add_setting( 'cahnrs_flex_subtheme', array(
			'default'     => 'default',
			'transport'   => 'refresh',
		) );
		$wp_customize->add_setting( 'cahnrs_flex_featured', array(
			'default'     => '',
			'transport'   => 'refresh',
		) );
		$wp_customize->add_setting( 'cahnrs_flex_ex_feature', array(
			'default'     => '',
			'transport'   => 'refresh',
		) );
		$wp_customize->add_section( 'cahnrs_flex_theme', array(
			'title'      => __( 'CAHNRS: Flex Theme' ),
			'priority'   => 99,
			) );
		$wp_customize->add_control(
			'cahnrs_flex_theme_control',
			array(
				'label'    => __( 'Site Sub-Theme' ),
				'section'  => 'cahnrs_flex_theme',
				'settings' => 'cahnrs_flex_subtheme',
				'type'     => 'select',
				'choices'  => array(
					'default'    => 'Standard',
					'department' => 'Department',
					'extension'  => 'Extension Unit',
					'unit'       => 'Unit',
					'sdc'        => 'SDC',
				),
			)
		);
		$wp_customize->add_control(
			'cahnrs_flex_featured_control',
			array(
				'label'    => __( 'Display Featured Image Banner' ),
				'section'  => 'cahnrs_flex_theme',
				'settings' => 'cahnrs_flex_featured',
				'type'     => 'checkbox',
			)
		);
		$wp_customize->add_control(
			'cahnrs_flex_exclude_feature_control',
			array(
				'label'    => __( 'Exclude Front Page: Image Banner' ),
				'section'  => 'cahnrs_flex_theme',
				'settings' => 'cahnrs_flex_ex_feature',
				'type'     => 'checkbox',
			)
		);
	}
}
$cahnrs_flex = new init_cahnrs_flex();