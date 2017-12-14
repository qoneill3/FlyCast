<?php
    /**
     * @package POWr Weather
     * @version 1.6.4
     */
    /*
    Plugin Name: POWr Weather
    Plugin URI: https://www.powr.io/plugins/weather
    Description: Track and display a real-time forecast for any location!  Drop the widget anywhere in your theme. Or use the POWr icon in your WP text editor to add to a page or post. Edit on your live page by clicking the settings icon. More plugins and tutorials at POWr.io.
    Author: POWr.io
    Version: 1.6.4
    Author URI: https://www.powr.io
    */

    ///////////////////////////////////////GENERATE JS IN HEADER///////////////////////////////
    //For local mode (testing)
    if(!function_exists('powr_local_mode')){
        function powr_local_mode(){
          return false;
        }
    }
    //Generates an instance key
    if(!function_exists('generate_powr_instance')){
        function generate_powr_instance() {
          $alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
          $pass = array(); //remember to declare $pass as an array
          $alphaLength = strlen($alphabet) - 1; // Put the length -1 in cache.
          for ($i = 0; $i < 10; $i++) { // Add 10 random characters.
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
          }
          $pass_string = implode($pass) . time(); // Add the current time to avoid duplicate keys.
          return $pass_string; // Turn the array into a string.
        }
    }
    //Adds script to the header if necessary
    if(!function_exists('initialize_powr_js')){
        function initialize_powr_js(){
          //No matter what we want the javascript in the header:
          add_option( 'powr_token', generate_powr_instance(), '', 'yes' );	//Add a global powr token: (This will do nothing if the option already exists)
          $powr_token = get_option('powr_token'); //Get the global powr_token
          if(powr_local_mode()){//Determine JS url:
            $js_url = '//localhost:3000/powr_local.js';
          }else{
            $js_url = '//www.powr.io/powr.js';
          }
          ?>
          <script>
            (function(d){
              var js, id = 'powr-js', ref = d.getElementsByTagName('script')[0];
              if (d.getElementById(id)) {return;}
              js = d.createElement('script'); js.id = id; js.async = true;
              js.src = '<?php echo $js_url; ?>';
              js.setAttribute('powr-token','<?php echo $powr_token; ?>');
              js.setAttribute('external-type','wordpress');
              ref.parentNode.insertBefore(js, ref);
            }(document));
          </script>
          <?php
        }
        //CALL INITIALIZE
        add_action( 'wp_enqueue_scripts', 'initialize_powr_js' );
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////Create Weather widget/////////////////////////////////
    class Powr_Weather extends WP_Widget{
      public $plugin;
      //Create the widget
      public function __construct(){
        parent::__construct( 'powr_weather',
                             __( 'POWr Weather' ),
                             array( 'description' => __( 'Weather by POWr.io') )
        );
        
      }
      //This prints the div
      public function widget( $args, $instance ){
        $label = $instance['label'];
        
        ?>
        <div class='widget powr-weather' label='<?php echo $label; ?>'></div>
        <?php
      }
      public function update( $new_instance, $old_instance ){
        $instance = $old_instance;
        //If no label, then set a label
        if( empty($instance['label']) ){
          $instance['label'] = 'wordpress_'.time();
        }
        
        return $instance;
      }
      public function form( $instance ){
        
        ?>
        <p>
          To edit, visit your live webpage and click the gears icon on your Weather.
        </p>
        <p>
          Learn more at <a href='https://www.powr.io/knowledge-base'>POWr.io</a>
        </p>
        <?php
      }
    }
    //Register Widget With Wordpress
    function register_powr_weather() {
      register_widget( 'Powr_Weather' );
    }
    //Use widgets_init action hook to execute custom function
    add_action( 'widgets_init', 'register_powr_weather' );
    //Create short codes for adding plugins anywhere:
    function powr_weather_shortcode( $atts ){
      if(isset($atts['id'])){
        $id = $atts['id'];
      	return "<div class='powr-weather' id='$id'></div>";
      }else if(isset($atts['label'])){
        $label = $atts['label'];
		    return "<div class='powr-weather' label='$label'></div>";
      }else{
      	"<div class='powr-weather'></div>";
      }
    }
    add_shortcode( 'powr-weather', 'powr_weather_shortcode' );

    /* Add POWr Plug to tiny MCE */
    if( !function_exists('powr_tinymce_button') ){
      add_action( 'admin_init', 'powr_tinymce_button' ); //This calls the function below

      function powr_tinymce_button() {
           if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
                add_filter( 'mce_buttons', 'powr_register_tinymce_button' );
                add_filter( 'mce_external_plugins', 'powr_add_tinymce_button' );
           }
      }
      function powr_register_tinymce_button( $buttons ) {
           array_push( $buttons, 'powr');
           return $buttons;
      }
      function powr_add_tinymce_button( $plugin_array ) {
           $plugin_array['powr'] = plugins_url( '/powr_tinymce.js', __FILE__ ) ;
           return $plugin_array;
      }
      //CSS For icon
      function powr_tinymce_css() {
          wp_enqueue_style('powr_tinymce', plugins_url('/powr_tinymce.css', __FILE__));
      }
      add_action('admin_enqueue_scripts', 'powr_tinymce_css');
    }

    //ADD MENUS
    add_action( 'admin_menu', 'powr_weather_menu' );
    function powr_weather_menu() {
      add_menu_page( 'POWr Weather', 'POWr Weather', 'manage_options', 'powr-weather-settings', 'powr_weather_options', plugins_url('/powr-icon.png',__FILE__));
    }
    function powr_weather_options() {
      if(powr_local_mode()){//Determine JS url:
        $redirect_url = 'https://localhost:3000/wp-create/weather';
      }else{
        $redirect_url = 'https://www.powr.io/wp-create/weather';
      }
      echo '<br><br><br><br><center><h2>Redirecting to POWr Dashboard...</h2></center>';
      echo '<script>';
      echo "window.location.assign('$redirect_url')";
      echo '</script>';
    }
    if( !function_exists('admin_handle_powr_ext_urls') ){
      add_action('in_admin_footer', 'admin_handle_powr_ext_urls');
      function admin_handle_powr_ext_urls(){
		    echo '<script>';
        echo 'if( document.querySelector("a[class*=page_powr-]") ){ ';
	      echo 'document.querySelector("a[class*=page_powr-]").target = "_blank"';
        echo '}';
		    echo '</script>';
      }
	  }
    //Redirecting to landing page when plugin is activated
    register_activation_hook(__FILE__, 'powr_weather_plugin_activate');
      add_action('admin_init', 'powr_weather_plugin_redirect');

      function powr_weather_plugin_activate() {
      add_option('powr_weather_plugin_do_activation_redirect', true);
      }

      function powr_weather_plugin_redirect() {
      if (get_option('powr_weather_plugin_do_activation_redirect', false)) {
          delete_option('powr_weather_plugin_do_activation_redirect');
          if(!isset($_GET['activate-multi']))
          {
            wp_redirect( get_admin_url().'?platform=wordpress&page=powr-weather-settings' );
          }
       }
      }


  ?>