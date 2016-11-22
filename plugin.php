<?php
/*
Plugin Name: TKD Layout Builder
Plugin URI: tektondev.com
Description: Builds customizable layouts
Author: Danial Bleile
Author URI: tektondev.com
Version: 0.0.1
*/

class TKD_Layout_Builder {
	
	public static $version = '0.0.2';
	
	public static $instance;
	

	/**
	 * Get the current instance or set it an return
	 * @return object current instance of CAHNRSWP_Forester_Directory
	 */
	 public static function get_instance(){
		 
		 if ( null == self::$instance ) {
			 
            self::$instance = new self;
			
			self::$instance->init();
			
        } // end if
 
        return self::$instance;
		 
	 } // end get_instance
	
	
	protected function init(){
		
		require_once 'classes/class-tkd-form-fields.php';
		require_once 'items/class-tkd-item.php';
		
		require_once 'classes/class-tkd-forms.php';
		$forms = new TKD_Forms();
		
		require_once 'classes/class-tkd-items-factory.php';
		$items_factory = new TKD_Items_Factory( $forms );
		
		require_once 'classes/class-tkd-shortcode.php';
		$shortcode = new TKD_Shortcode( $items_factory );
		$shortcode->init();
		
		require_once 'classes/class-tkd-post-editor.php';
		$editor = new TKD_Post_Editor( $items_factory , $forms );
		$editor->init();
		
		require_once 'classes/class-tkd-ajax.php';
		$ajax = new TKD_Ajax( $items_factory , $editor );
		$ajax->init();
		
		add_action( 'init' , array( $this , 'add_tkd_the_content' ), 1 );
		
		if ( is_admin() ){
			
			if ( isset( $_POST[ $forms->get_prefix() ] ) ){
			
				require_once 'classes/class-tkd-save.php';
				$save = new TKD_Save( $items_factory );
				$save->init();
			
			} // end if
			
		} // end if
		
		
		add_filter( 'the_content', array( $this , 'remove_empty_p' ) , 1 );
		
		add_action( 'wp_enqueue_scripts', array( $this , 'add_public_scripts' ), 11, 1 );
		
	} // end init
	
	/**
	 * Create custom filter to mirror the_content
	 */
	public function add_tkd_the_content(){
		
		add_filter( 'tkd_the_content', 'wptexturize'        );
		add_filter( 'tkd_the_content', 'convert_smilies'    );
		add_filter( 'tkd_the_content', 'convert_chars'      );
		add_filter( 'tkd_the_content', 'wpautop'            );
		add_filter( 'tkd_the_content', 'shortcode_unautop'  );
		add_filter( 'tkd_the_content', 'prepend_attachment' );
		
	} // end add_tk_the_content
	
	
	public function remove_empty_p( $content){
		
		$content = do_shortcode( $content );
		
		return do_shortcode( $content );
		
		//$post_object->post_content = do_shortcode( $post_object->post_content );
		
		//return $content;
		
	} // end remove_empty_p
	
	
	public function add_public_scripts(){
				
			wp_enqueue_style( 
				'tkd_public_style' , 
				plugin_dir_url( __FILE__ ) . 'css/public.css', 
				array() , 
				TKD_Layout_Builder::$version 
				);
			wp_enqueue_script( 
				'tkd_public_script' , 
				plugin_dir_url( __FILE__ ) . 'js/public.js', 
				array() , 
				TKD_Layout_Builder::$version,
				true 
				);
			
		} // end if
	
} // end TKD_Layout_Builder

$tk_builder = TKD_Layout_Builder::get_instance();