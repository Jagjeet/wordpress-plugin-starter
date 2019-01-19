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
?>
<div class="wrap">
<?php
foreach($messages as $m) {
    echo "<p>$m</p>";
}
?>
  <h1>WordPressPluginStarter Options</h1>

  <form action="" method="post">
    <?php
    wp_nonce_field(
        'wordpress_plugin_starter_config_nonce_action',
        'wordpress_plugin_starter_config_nonce_field' 
    );
    ?>
    <table class="form-table">
      <tr>
        <th><label for="dummy-data-id">Dummy Data:</label></th>
        <td><input 
              type="text"
              name='dummy-data' 
              id='dummy-data-id' 
              value="<?php echo $this->_plugin_options['wordpress_plugin_starter_dummy_data'];?>" />
        </td>
      </tr>
    </table>
    <p class="submit">
      <input 
          type="submit" 
          name="submit" 
          id="submit" 
          class="button button-primary" 
          value="Save Changes">
    </p>
  </form>
</div>
