<?php
/**
 *   Plugin Name: Wordpress plugin to manage contacts
 *   Plugin URI: #
 *   Description: O plug-in do WordPress para gerenciar contatos é um plug-in do WordPress para gerenciar contatos, tudo a partir do painel do WP. O WP Contacts Manager é um CRUD: Crie, leia, atualize e exclua. 
 *   Version: 1.0.0
 *   Author: Naym Mupoia
 *   Author URI: https://www.facebook.com/irvanio.braga/
 *   License: GPL-2.0+
 *   License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *   Text Domain: wp_contacts_manager
 *   Domain Path: /languages/
 */
/**
 *   @package    Wordpress plugin to manage contacts
 *   @author     Naym Mupoia
 */

if (!defined('ABSPATH'))
exit;
if (!defined('WP_CONTACTS_MANAGER_DIR')) :
define('WP_CONTACTS_MANAGER_DIR', plugin_dir_path(__FILE__));
endif;
if (!defined('WP_CONTACTS_MANAGER_LIB')) :
define('WP_CONTACTS_MANAGER_LIB', plugin_dir_path(__FILE__) . 'library/');
endif;
if (!defined('DIRSP')) :define('DIRSP', DIRECTORY_SEPARATOR);
endif;
if (!defined('WP_CONTACTS_MANAGER_URL')) :
define('WP_CONTACTS_MANAGER_URL', plugin_dir_url(__FILE__));
endif;
if (!defined('WP_CONTACTS_MANAGER_ASSETS_PATH')) : define('WP_CONTACTS_MANAGER_ASSETS_PATH', plugin_dir_path(__FILE__) . 'includes/');
endif;
if (!defined('WP_CONTACTS_MANAGER_PLUGIN_BASE_NAME')) :define('WP_CONTACTS_MANAGER_PLUGIN_BASE_NAME', plugin_basename(__FILE__));
endif;

?>