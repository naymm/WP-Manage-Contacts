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

class WP_Contacts_Manager {

    public $text_domain = '';
    public $currency = '';
    public $company_details = '';
    public $company_logo = '';
    public $people = '';
    public $invoice = '';
    
    public function __construct() {
        global $wpdb;
        $this->wpcm = $wpdb->prefix . "wpcm";
        add_action('init', array(&$this, 'WP_Contacts_Manager_Text_Domain'));
        register_activation_hook(WP_CONTACTS_MANAGER_PLUGIN_BASE_NAME, array(&$this, 'WP_Contacts_Manager_Installation'));
        add_action('admin_enqueue_scripts', array(&$this, 'WP_Contacts_Manager_Assets_Scripts'), 1);
        add_action('admin_menu', array(&$this, 'WP_Contacts_Manager_Assets_Menu'), 1);
        
        add_action('wp_ajax_WP_Contacts_Manager_call', array(&$this, 'WP_Contacts_Manager_Call'));
        add_action('wp_ajax_nopriv_WP_Contacts_Manager_call', array(&$this, 'WP_Contacts_Manager_Call'));
    }

    public function WP_Contacts_Manager_Text_Domain() {
        $this->text_domain = 'wp_contacts_manager';
        load_plugin_textdomain($this->text_domain, false, basename(dirname(__FILE__)) . '/languages');
        $this->WP_Contacts_Manager_Invoice_Object_Start();
    }

   
    public function WP_Contacts_Manager_Assets_Scripts() {
        wp_enqueue_media();
        ?>
        <style> .toplevel_page_wp_contacts_manager .wp-menu-name{font-size: 12px;} .toplevel_page_wp_contacts_manager img{width: 25px;margin-top: -4px; }</style><?php
        wp_enqueue_style('font-awesome-style-css', 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
        wp_register_style('admin-style-css', WP_CONTACTS_MANAGER_URL . 'includes/css/admin-style.css');
        wp_enqueue_script('wp-contacts-manager-min-js', WP_CONTACTS_MANAGER_URL . 'includes/js/angular-1.4.9.min.js');
        wp_register_script('ui-bootstrap-tpls-min-js', WP_CONTACTS_MANAGER_URL . 'includes/js/ui-bootstrap-tpls-0.10.0.min.js');
        wp_enqueue_script('wp-contacts-manager-js', WP_CONTACTS_MANAGER_URL . 'includes/js/app.js');        
    }

 

    public function WP_Contacts_Manager_Installation() {
        global $wpdb;
        $this->wpcm = $wpdb->prefix . "wpcm";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        if ($wpdb->get_var("SHOW TABLES LIKE '$this->wpcm'") != $this->wpcm) :
            $sql = "CREATE TABLE `$this->wpcm` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `name` varchar(30) CHARACTER SET latin1 NOT NULL,
                `lastname` varchar(50) NOT NULL,
                `phone` varchar(15) NULL,
                `email` varchar(50) NOT NULL,
                `two_phone` varchar(15) NULL,
				`job` varchar(50) NULL,
                `company` varchar(100) NULL,
                `web` varchar(50)  NULL,
				`two_address` varchar(255) NULL,
                PRIMARY KEY (`id`)
              ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            dbDelta($sql);
            endif;
    }
   

    public function WP_Contacts_Manager_Assets_Menu() {
        $icon = plugins_url("includes/images/icon.png", __FILE__);
        add_menu_page('WP Contacts', __('WP Contacts', $this->text_domain), '' . $this->text_domain . '-contacts', $this->text_domain, 'dashicons-visibilit', '' . $icon . '', 10, 5 );
        add_submenu_page($this->text_domain, __('Contacts', $this->text_domain), __('Contacts', $this->text_domain), 'manage_options', '' . $this->text_domain . '-contacts', array($this, 'WP_Contacts_Manager_Contact_Area'));
        remove_submenu_page($this->text_domain, $this->text_domain);
    }

    

    public function WP_Contacts_Manager_Invoice_Object_Start() {
        if (!in_array('ob_gzhandler', ob_list_handlers())) {
            ob_start();
        } else {
            ob_start();
        }
        if (!session_id()) {
            session_name('wp-payment-init');
            @session_start();
        }
        if (isset($_SESSION['success_msg']) && !empty($_SESSION['success_msg'])) {
            unset($_SESSION['success_msg']);
        }
        if (isset($_SESSION['error_msg']) && !empty($_SESSION['error_msg'])) {
            unset($_SESSION['error_msg']);
        }
    }

    

    public function WP_Contacts_Manager_Contact_Area() {
        if (file_exists(WP_CONTACTS_MANAGER_DIR . 'templates' . DIRSP . 'wp-contacts-manager-contact.php')) {
            include(WP_CONTACTS_MANAGER_DIR . 'templates' . DIRSP . 'wp-contacts-manager-contact.php');
        }
    }

    public function WP_Contacts_Manager_Call() {
        $postdata = file_get_contents("php://input");
        if ($_REQUEST['type'] == 'get-results') {
            $this->WP_Contacts_Manager_Get_Results();
        } else if ($_REQUEST['type'] == 'form-save') {
            $this->WP_Contacts_Manager_Save($postdata);
        } else if ($_REQUEST['type'] == 'edit-form-save') {
            $this->WP_Contacts_Manager_Contact_Edit_Save($postdata);
        } else if ($_REQUEST['type'] == 'delete') {
            $this->WP_Contacts_Manager_Row_Delete($postdata);
        } else if ($_REQUEST['type'] == 'get-contact') {
            $this->WP_Contacts_Manager_Get_Contact($postdata);
        }
    }

  

    public function WP_Contacts_Manager_Get_Results() {
        global $wpdb;
        $people = array();
        $result_load = $wpdb->get_results("SELECT * FROM $this->wpcm ORDER BY `id` DESC");
        
        $cr = 1;
        foreach ($result_load as $result_fetch) {
            $result_fetch->address_new = (isset($result_fetch->address) && !empty($result_fetch->address)) ? esc_html($result_fetch->address) : '';
            $result_fetch->address = (isset($result_fetch->address) && !empty($result_fetch->address)) ? esc_html(mb_strimwidth($result_fetch->address, 0, 29, '..')) : '';

            $people[] = $result_fetch;
            $cr++;
        }
        echo json_encode($people);
        exit();
    }

  

    public function WP_Contacts_Manager_Get_Contact($postdata) {
        global $wpdb;
        $result_load = array();
        if (isset($postdata) && !empty($postdata)) {
            $request = json_decode($postdata);
            $id = isset($request->id) ? $request->id : '';
            $result_load = $wpdb->get_row("SELECT * FROM $this->wpcm WHERE `id`='" . $id . "'");
        }
        echo json_encode($result_load);
        exit();
    }

    public function WP_Contacts_Manager_Save($postdata) {
        global $wpdb;
        $result = array();
        if (isset($postdata) && !empty($postdata)) {
            $request = json_decode($postdata);
			$newName = isset($request->newName) ? $request->newName : '';
            $newPhone = isset($request->newPhone) ? $request->newPhone : '';
            $newWeb = isset($request->newWeb) ? $request->newWeb : '';
			$newCompany = isset($request->newCompany) ? $request->newCompany : '';
			$newTwo_Phone = isset($request->newTwo_Phone) ? $request->newTwo_Phone : '';
			$newJob = isset($request->newJob) ? $request->newJob : '';
			$newTwo_Address = isset($request->newTwo_Address) ? $request->newTwo_Address : '';
			$newEmail = isset($request->newEmail) ? $request->newEmail : '';
            $newLastname = isset($request->newLastname) ? $request->newLastname : '';
            $result_load = $wpdb->get_results("SELECT * FROM $this->wpcm WHERE `email`='" . $newEmail . "'");
            if (!empty($newName) && !empty($newLastname) && !empty($newEmail)) {
                if (!empty($result_load)) {
                    $result['success'] = __('Email already exist!', $this->text_domain);
                    $result['status'] = false;
                    echo json_encode($result);
                    exit();
                }
                 $wpdb->insert($this->wpcm, array('name' => sanitize_text_field($newName), 'lastname' => sanitize_text_field($newLastname), 'phone' => sanitize_text_field($newPhone), 'company' => sanitize_text_field($newCompany), 'web' => sanitize_text_field($newWeb), 'email' => sanitize_text_field($newEmail), 'two_phone' => sanitize_text_field($newTwo_Phone), 'two_address' => sanitize_text_field($newTwo_Address), 'job' => sanitize_text_field($newJob), 'notes' => sanitize_textarea_field($notes)));
                $result['success'] = __('Contact has been successfully saved.', $this->text_domain);
                $result['status'] = true;
            }
            echo json_encode($result);
            exit();
        }
    }

    public function WP_Contacts_Manager_Contact_Edit_Save($postdata) {
        global $wpdb;
        $result = array();
        if (isset($postdata) && !empty($postdata)) {
            $request = json_decode($postdata);
			$newName = isset($request->editnewName) ? $request->editnewName : '';
			$newLastname = isset($request->editnewLastname) ? $request->editnewLastname : '';
            $newPhone = isset($request->editnewPhone) ? $request->editnewPhone : '';
			$newCompany = isset($request->editnewCompany) ? $request->editnewCompany : '';
			$newWeb = isset($request->editnewWeb) ? $request->editnewWeb : '';
			$newTwo_Phone = isset($request->editnewTwo_Phone) ? $request->editnewTwo_Phone : '';
			$newJob = isset($request->editnewJob) ? $request->editnewJob : '';
			$newTwo_Address = isset($request->editnewTwo_Address) ? $request->editnewTwo_Address : '';
            $newEmail = isset($request->editnewEmail) ? $request->editnewEmail : '';
            $id = isset($request->editcontactID) ? $request->editcontactID : '';

            if (!empty($newName) && !empty($newLastname) && !empty($newEmail)) {
                $wpdb->update($this->wpcm, array('name' => sanitize_text_field($newName), 'lastname' => sanitize_text_field($newLastname), 'phone' => sanitize_text_field($newPhone), 'company' => sanitize_text_field($newCompany), 'web' => sanitize_text_field($newWeb), 'email' => sanitize_text_field($newEmail), 'two_email' => sanitize_text_field($newTwo_Email), 'two_phone' => sanitize_text_field($newTwo_Phone), 'two_address' => sanitize_text_field($newTwo_Address), 'job' => sanitize_text_field($newJob),'notes' => $notes), array('id' => $id));

                $result['success'] = __('Contact has been successfully updated.', $this->text_domain);
                $result['status'] = true;
            }
            echo json_encode($result);
            exit();
        }
    }
    

    public function WP_Contacts_Manager_Row_Delete($postdata) {
        global $wpdb;
        $result = array();
        if (isset($postdata) && !empty($postdata)) {
            $request = json_decode($postdata);
            $id = (int) $request->recordId;
            $wpdb->delete($this->wpcm, array('id' => $id));
            $result['success'] = __('Contact has been successfully deleted.', $this->text_domain);
            $result['status'] = true;
        } else {
            $result['success'] = __('Something went wrong!', $this->text_domain);
            $result['status'] = false;
        }
        echo json_encode($result);
        exit();
    }

    

}

$WP_Contacts_Manager = new WP_Contacts_Manager();

?>