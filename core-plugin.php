<?php

register_activation_hook( __FILE__, array( 'RimDiary', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'RimDiary', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'RimDiary', 'uninstall' ) );

add_action( 'plugins_loaded', array( 'RimDiary', 'plugins_loaded' ) );
add_action( 'init', array( 'RimDiary', 'init' ) );
add_action( 'widgets_init', array( 'RimDiaryWidget', 'register' ) );
add_action( 'wp_enqueue_scripts', array( 'RimDiary', 'wp_enqueue_scripts' ) );

class RimDiary {
	const version = '1.0.1';
	const slug = 'rim-diary';

	private static $config = null;

	static function config( $key = null ) {
		if( ! self::$config )
			return null;

		if( $key !== null )
			return @self::$config[$key];
		else
			return self::$config;
	}

	static function plugins_loaded() {
		self::$config = get_option( self::slug );
		load_plugin_textdomain( self::slug, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	static function init() {
		RimDiaryWidget::register();

		if( isset( $_POST[ 'rim-rolled' ] ) && check_admin_referer( 'log-rim-diary', 'log-rim-diary-nonce' ) )
			self::updateRimDiary( $_POST[ 'rim-rolled' ] );
	}

	static function wp_enqueue_scripts() {
		wp_enqueue_style( 'rim-diary-styles', plugins_url( '/resources/css/styles.css', __FILE__ ) );
		//wp_enqueue_script( 'rim-diary-scripts', plugins_url( '/resources/js/scripts.js', __FILE__ ), array( 'jQuery' ) );
	}

	static function getPrizes() {
		static $prizes = array(
			'play-again' => 'Please Play Again',
			'coffee' => 'Free Coffee',
			'donut' => 'Free Donut',
			'tim-card' => '$100 Tim card',
			'prepaid-visa' => '5k Prepaid Visa',
			'corolla' => '2014 Toyota Corolla S'
		);
		return $prizes;
	}

	static function getRimDiary() {
		$winnings = self::config( 'winnings' ) or $winnings = array();
		return array_filter( $winnings );
	}

	static function updateRimDiary( $tag ) {
		$prizes = self::getPrizes();

		if( isset( $prizes[ $tag ] ) )
			@ ++self::$config[ 'winnings' ][ $tag ];
		elseif( 'reset-rims' == $tag )
			self::$config[ 'winnings' ] = array();
		else
			return;

		update_option( self::slug, self::$config );
	}

	static function activate() {
		add_option( self::slug, array( version => self::version, 'winnings' => array() ) );
	}

	static function deactivate() {}

	static function uninstall() {
		delete_option( self::slug );
	}
}

//Rim Diary widget
class RimDiaryWidget extends WP_Widget {

	static function register() {
		register_widget( __CLASS__ );
	}

	function __construct() {
		parent::__construct( 'rim-diary', __( 'Rim Diary Widget', 'rim-diary' ), array(
			'classname' => 'rim-diary-widget',
			'description' => 'Track your Tim Hortons rim rolls and share your winnings with the world.'
		) );
	}

	function form( $instance ) {}

	function update( $new_instance, $old_instance ) {
		return array();
	}
	 
	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );

		$winnings = array_merge( array( 'play-again' => 0, 'coffee' => 0, 'donut' => 0 ), RimDiary::getRimDiary() );
		$prizes = RimDiary::getPrizes();

		include( 'views/widgetview.php' );
	}
}

?>