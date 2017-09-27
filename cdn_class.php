<?php

class WP_CDNRewrites
{
    var $host;
    var $cdn;
    var $options = array();
	
    /**
    * The CDN_URL is taken from wp-config
    */
    function __construct()
    {   
        $this -> host  = 'http://'.$_SERVER['HTTP_HOST'];
        $this -> cdn   = CDN_URL;
    }
    
    /**
	 * Function to activate the plugin
	 */ 
    function activate() {
        $pluginOptions = get_option('wpcdn_options');
    
        if ( !$pluginOptions ) {
            add_option ( 'wpcdn_options' , $this -> options );
        }
    }
    
	/**
	 * Erase options data when deactivate 
	 */
    function deactivation() {
        delete_option ( 'wpcdn_options' );
        unregister_setting ( 'wpcdn_settings' , 'wpcdn_options' );
    }
	
	/**
	 * Create the admin page options
	 */ 
    function adminmenu() {
        add_options_page('Imgmin Subdomain', 'Imgmin Subdomain', 'manage_options', 'wpcdn', array($this,'configPage'));
    }
	
	/**
	 * Set the errors options
	 */ 
    function addNotices() {
        settings_errors('wpcdn_errors');
    }
	
	/**
	 * Define the set of options
	 */
    function init(){        
        register_setting ( 'wpcdn_settings' , 'subdomain' );

    }
	
	/**
     *  Function to clean the inputs
     *  @param array $input from the form
     *  @return array with clean inputs
     */
    function sanitize($input){               
        add_settings_error(
            'wpcdn_errors',
            'wpcdn_success',
            'Your configuration is saved',
            'updated'
        );
		
        return $input;
    }

	/**
     *  Function to create the page with form to config plugin
     */
    function configPage(){
        ?>
        <div class="wrap">
        <h2>Imgmin Image Optimizer CDN</h2> 
        
        <form method="post" action="options.php" id="wpcdn_form" >        
         <?php
            settings_fields('wpcdn_settings');
            $this -> options = get_option('wpcdn_options');
            if (!is_array($this->options))
                $this -> options = array();
         ?>
                    
            <div id="poststuff" class="ui-sortable">
            <p>To enable wich content will be retrieved from CDN, check the following options</p>
            <div class="postbox">
                <h3 class="hndle"><span>Set Subdomain</span></h3>
                <div class="inside">                
                                                            
                    <input type="text" name="subdomain" value="<?php echo esc_attr( get_option('subdomain') ); ?>" />
                    <p>
                        Example : blabla
                    </p>
                    <div class="submit"><input type="submit" name="prof_options" id="prof_options" value="Update Options" /></div>
                </div>
            </div>            
            </div>
        </form>
    </div>
        <?php
    }

    /**
    * Start the buffer to get the content
    */
    function pre_content()
    {
        ob_start();
		
    }
    
    /**
    * Get the content from the buffer and parse it
    */
    function post_content()
    { 
        $html = ob_get_contents();
        ob_end_clean();

        echo $this->parse($html);
    }
    
    /**
    * @param string $html
    * Parse the original host into CDN host
    */
    function parse($html)
    {    	
        $this -> subdomain = get_option('subdomain');
        if( $this -> subdomain != "" )
        $regex['img']  = '/' . preg_quote($this->host , '/') . '\/(((?!gallery\.php)(?![\w-]+\/gallery-image))\S+\.(png|jpg|jpeg|gif|ico))/i';
        $html = preg_replace( $regex , "//".$this -> subdomain.'.imgmin.co/$1' , $html);
        return $html;        
    }
}