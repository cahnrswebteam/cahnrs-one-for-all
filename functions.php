<?php
class init_cahnrs_flex {
	public $theme_model;
	
	public function __construct(){
		$this->theme_model = new cf_theme_model();
		$this->theme_view = new cf_theme_view( $this->theme_model );
		\add_action( 'wp_enqueue_scripts', array( $this , 'add_scripts' ) );
		\add_action( 'customize_register', array( $this->theme_view, 'add_custom_settings' ) );
		\add_action( 'init', array( $this, 'add_menu_locations' ) );
		\add_action( 'init', array( $this, 'add_image_sizes' ) );
		\add_filter( 'image_size_names_choose', array( $this, 'add_image_size_names' ) );
	}
	
	public function add_scripts(){
		\wp_enqueue_style( 
			'cahnrs-flex-'.$this->theme_model->t_css ,  
			get_stylesheet_directory_uri().'/css/style-'.$this->theme_model->t_css.'.css', 
			array(), 
			'0.0.1' 
			);
	}
	
	public function add_menu_locations() {
		register_nav_menu( 'cahnrs_horizontal', 'Horizontal' );
	}
	
	public function add_image_sizes(){
		 add_image_size( '4x3-medium', 400, 300, true );
		 add_image_size( '3x4-medium', 300, 400, true );
		 add_image_size( '16x9-medium', 400, 225, true );
		 add_image_size( '16x9-large', 800, 450, true );
		 add_image_size( '16x9-extra-large', 800, 450, true );
		 add_image_size( 'extra-large' );
	}
	
	public function add_image_size_names( $sizes ) {
		return array_merge( $sizes, array(
			'4x3-medium' => __('4x3 Medium'),
			'3x4-medium' => __('3X4 Medium'),
			'16x9-medium' => __('16x9 Medium'),
			'16x9-large' => __('16x9 Large'),
			'16x9-extra-large' => __('16x9 Extra Large'),
			'extra-large' => __('Extra Large'),
		) );
	}
}

class cf_theme_model {
	public $t_header;
	public $t_footer;
	public $t_css;
	public $show_banner;
	
	public function __construct(){
		$opts_default = 'default'; // Default options 
		$opts = get_theme_mod( 'cahnrs_flex_subtheme' , $opts_default  ); // Get the options from theme
		switch( $opts ){
			case 'department':
				$opts = array( 'header' => 'default', 'footer' => false , 'css' => 'department' );
				break;
			case 'default':
			default:
				$opts = array( 'header' => 'default','footer' => false , 'css' => 'default' );
		}
		$this->t_header = $opts['header'];
		$this->t_footer = $opts['footer'];
		$this->t_css = $opts['css'];
		$this->show_banner = get_theme_mod( 'cahnrs_flex_featured' , false  ); // Get the options from theme
	}
}

class cf_theme_view {
	private $cf_theme_model;
	
	public function __construct( $cf_theme_model ){
		$this->cf_theme_model = $cf_theme_model;
	}
	
	public function add_custom_settings( $wp_customize ){
		$wp_customize->add_setting( 'cahnrs_flex_subtheme' , array(
			'default'     => 'default',
			'transport'   => 'refresh',
		) );
		$wp_customize->add_setting( 'cahnrs_flex_featured' , array(
			'default'     => '1',
			'transport'   => 'refresh',
		) );
		$wp_customize->add_section( 'cahnrs_flex_theme' , array(
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
					'default'  => 'Standard',
					'department' => 'Department'
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
	}
}
$cahnrs_flex = new init_cahnrs_flex();