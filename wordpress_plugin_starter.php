<?php
/**
 * Plugin Name: WordPress Plugin Starter
 * Plugin URI: https://github.com/
 * Description: This is a basic starter for writing a plugin for WordPress
 * Version: 1.0.0
 * Author: Jagjeet Khalsa
 * Author URI: https://github.com/Jagjeet
 * PHP version 5
 * 
 * @category  WordPressPlugin
 * @package   WordPress_Plugin_Starter
 * @author    Jagjeet Khalsa <jagjeet.khalsa@gmail.com>
 * @copyright 2018 - Present Jagjeet Khalsa
 * @license   MIT License
 * @link      https://github.com
 **/

/*
* Place includes, constant defines and $_GLOBAL settings here.
* Make sure they have appropriate docblocks to avoid phpDocumentor
* construing they are documented by the page-level docblock.
*/

/******************************************************************************
 * WordPress_Plugin_Starter - Main Class for the WordPress_Plugin_Starter plugin
 *
 * @category  WordPressPlugin
 * @package   WordPress_Plugin_Starter
 * @author    Jagjeet Khalsa <jagjeet.khalsa@gmail.com>
 * @copyright 2018 - Present Jagjeet Khalsa
 * @license   MIT License
 * @link      https://github.com
 *****************************************************************************/
class WordPress_Plugin_Starter
{

    private $_plugin_options;
    private $_script_data;

    /************************************************
     * __construct - Constructor
     *************************************************/
    public function __construct()
    {

        //Get options or create if it doesn't exist
        $this->_plugin_options = get_option('wordpress_plugin_starter_options');

        if ($this->_plugin_options) {
            //Check for all individual parameters
            $wordpress_plugin_starter_dummy_data 
                = $this->_initializeSetting(
                    $this->_plugin_options,
                    'wordpress_plugin_starter_dummy_data', 
                    'Hello World'
                );
            $new_values = array(
                'wordpress_plugin_starter_dummy_data' 
                    => $wordpress_plugin_starter_dummy_data,
            );

            update_option('wordpress_plugin_starter_options', $new_values);

        } else {
            //We should only run this the first time the plugin is installed.
            add_option(
                'wordpress_plugin_starter_options', array(
                'wordpress_plugin_starter_dummy_data' => '',
                )
            );
        } //else

        $this->_plugin_options = get_option('wordpress_plugin_starter_options');

        add_action('admin_enqueue_scripts', array($this, 'scriptEnqueue'));
        add_action('admin_menu', array($this, 'pluginPageAdd'));

    } //__construct

    /**************************************************************************
     * _initializeSetting Returns the initial value for the setting if is set 
     * otherwise returning the new value
     * 
     * @param string $options       Reference to the theme options 
     * @param string $setting_name  Name of the setting 
     * @param string $initial_value Initial value if not already set
     * 
     * @return - returns the value of the settings
     *************************************************************************/
    private function _initializeSetting( &$options, $setting_name, $initial_value) 
    {
        if (!array_key_exists($setting_name, $options)) {
            return htmlentities($initial_value, ENT_QUOTES);
        } else {
            return $options[$setting_name];
        }
    } //_initializeSetting

    /**************************************************************************
     * ScriptEnqueue Returns the initial value for the setting if is set 
     * otherwise returning the new value
     * 
     * @param string $hook the name of the page 
     * 
     * @return N/A
     *************************************************************************/
    public function scriptEnqueue($hook) 
    {
        global $pagenow;

        if ($pagenow == 'post.php' 
            || $hook == 'settings_page_site-header-meta-plugin-options'
        ) {

            wp_enqueue_script(
                'wordpress-plugin-starter-js',
                plugins_url('/js/wordpress-plugin-starter.js', __FILE__),
                array()
            );

        } //if

        //Site settings are localized in the options page handler due to a timing 
        //issue causing the data to output the previous values.
        if ($pagenow == 'post.php') {
            global $post;
            wp_localize_script(
                'wordpress-plugin-starter-js',
                'wordpress_plugin_starter_data',
                array(
                    'wordpress_plugin_starter_dummy_data' 
                        => get_post_meta(
                            $post->ID,
                            "wordpress_plugin_starter_dummy_data",
                            true
                        ),
                )
            );
        } //if
    } //scriptEnqueue

    /**************************************************************************
     * PluginPageAdd() Adds the options page for the plugin 
     * 
     * @return N/A
     *************************************************************************/
    public function pluginPageAdd() 
    {
        add_submenu_page(
            'options-general.php',
            'WordPress Plugin Starter Plugin Options',
            'WordPress Starter Plugin',
            'administrator',
            'wordpress-plugin-starter-plugin-options',
            array($this, 'pluginPageOptions')
        );
    } //pluginPageAdd


    /**************************************************************************
     * PluginPageOptions() option page handler 
     * 
     * @return N/A
     *************************************************************************/
    public function pluginPageOptions()
    {
        $messages = "";

        if (isset($_POST['dummy-data'])) {
            // Check if our nonce is set.
            if (!isset($_POST['wordpress_plugin_starter_config_nonce_field'])) {
                echo "<h2>Error: Nonce is not set</h2>";
                return;
            }

            $nonce = $_POST['wordpress_plugin_starter_config_nonce_field'];

            // Verify that the nonce is valid.
            if (!wp_verify_nonce(
                $nonce, 
                'wordpress_plugin_starter_config_nonce_action'
            )
            ) {
                echo "<h2>Error: Nonce is invalid</h2>";
                return;
            }

            $messages = "Options Saved!";

            $this->_plugin_options = get_option('wordpress_plugin_starter_options');

            $new_values = array(
                'wordpress_plugin_starter_dummy_data' 
                    => htmlentities($_POST['dummy-data'], ENT_QUOTES),
            );

            $success 
                = update_option(
                    'wordpress_plugin_starter_options', 
                    $new_values
                );
            $this->_plugin_options = $new_values;
        } //if

        $this->_script_data = array(
            'wordpress_plugin_starter_dummy_data' 
                => $this->_plugin_options['wordpress_plugin_starter_dummy_data'],
        );

        wp_localize_script(
            'wordpress-plugin-starter-js',
            'wordpress_plugin_starter_data',
            $this->_script_data
        );

        include 'views/wordpress_plugin_starter_config_page.php';
    } //pluginPageOptions

} //WordPress_Plugin_Starter

new WordPress_Plugin_Starter();
?>
