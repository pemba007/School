<?php
	/**
	 *  Plugin Name: University - Sample Data
	 *  Description: Import demo data for University
	 *  Author: CactusThemes
	 *  Author URI: https://www.cactusthemes.com
	 *  Version: 1.1.1
	 *  Text Domain: university
	 * @since University 2.1
	 */

	if ( ! defined( 'university_UNYSON_BACKUP_DIR' ) ) {
		define( 'university_UNYSON_BACKUP_DIR', plugin_dir_path( __FILE__ ) );
	}

	if ( ! defined( 'university_UNYSON_BACKUP_URI' ) ) {
		define( 'university_UNYSON_BACKUP_URI', plugin_dir_url( __FILE__ ) );
	}

	class university_UNYSON_BACKUP {

		public function __construct() {

			global $pagenow;


			if ( ! defined( 'FW' ) ) :
				add_filter( 'fw_framework_directory_uri', array( $this, '_filter_fw_framework_plugin_directory_uri' ) );
				require university_UNYSON_BACKUP_DIR . '/framework/bootstrap.php';
			endif;
			//add_action( 'admin_menu', array( $this, 'backup_settings' ) );
			add_action( 'university_before_demo_content_install', array( $this, 'notification_before_html' ) );
			add_action( 'university_after_demo_content_install', array( $this, 'notification_after_html' ) );
			add_filter( 'fw_ext_backups_demo_dirs', array( $this, '_filter_theme_fw_ext_backups_demo_dirs' ) );

			add_action( 'admin_enqueue_scripts', array( $this, 'university_unyson_backup_restore_script' ) );
			register_activation_hook( __FILE__, array( $this, 'university_active' ) );
			// $backup = new FW_Extension_Backups_Demo();

			register_activation_hook( __FILE__, array( $this, 'university_activation_sampledata' ) );
			add_action( 'admin_init', array( $this, 'university_activation_sampledata_redirect' ), 10 );

			add_action( 'university_backup_before_install_demo', array( $this, 'download_backup' ), 10, 4 );

			add_filter( 'university_required_plugins', array( $this, 'university_required_plugins' ), 10, 1 );

			add_filter( 'fw_loader_image', array( $this, 'university_fw_loader_image' ) );

		}

		function university_active() {

			$extension                 = get_option( 'fw_active_extensions', null );
			$extension['backups']      = array();
			$extension['backups-demo'] = array();
			update_option( 'fw_active_extensions', $extension );

		}


		function _filter_fw_framework_plugin_directory_uri() {
			return university_UNYSON_BACKUP_URI . '/framework';
		}

		function _filter_theme_fw_ext_backups_demo_dirs( $dirs ) {

			$path          = university_UNYSON_BACKUP_DIR . 'theme-demo/';
			$url           = university_UNYSON_BACKUP_URI . 'theme-demo/';
			$dirs[ $path ] = $url;

			return $dirs;

		}

		function university_unyson_backup_restore_script() {
			wp_enqueue_style( 'truemag-backup-restore', university_UNYSON_BACKUP_URI . 'assets/css/admin.css' );
		}

		function notification_before_html() {
			if ( ! current_user_can( 'manage_options' ) ) {
				global $current_user;
				$msg = sprintf( esc_html__( "I'm sorry, %s I'm afraid I can't do that.", 'university' ), $current_user->display_name );
				echo '<div class="wrap">' . $msg . '</div>';

				return false;
			}
			?>
            <div class="truemag-demo-container">            <div id="primary">
            <div class="import-admin-title">
                <h2>
                    <span class="dashicons dashicons-upload"></span><span class="text"><?php esc_html_e( 'Import Sample Data', 'university' ); ?></span>
                </h2>
            </div>
            <div class="truemag-admin-notice">
                <ul>
                    <li><?php esc_html_e( 'Make sure you only install sample data in a freshly installed website', 'university' ); ?>
                    </li>
                    <li><?php esc_html_e( 'It is recommended to install all required and recommended plugins before installing sample data', 'university' ); ?></li>
                </ul>
            </div>

			<?php
		}


		function notification_after_html() { ?>
            </div>
            <div id="secondary">
				<?php do_action( 'university_unyson_backup_sidebar' ) ?>
            </div>            </div>
		<?php }

		function backup_settings() {
			add_submenu_page( 'tools.php', esc_html__( 'Backup Settings', 'university' ), esc_html__( 'Backup Settings', 'university' ), 'manage_options', 'truemag-backup-settings', array(
				$this,
				'backup_settings_layout'
			) );
		}

		function backup_settings_layout() {
			$options            = get_option( 'university_backup', array() );
			$enable_remote_demo = isset( $options['enable_remote_demo'] ) ? $options['enable_remote_demo'] : 1;
			$remote_link        = isset( $options['remote_link'] ) ? $options['remote_link'] : '';
			?>
            <div class="wrap wp-manga-wrap">
                <h2><?php echo get_admin_page_title(); ?></h2>
                <form method="post">
                    <table class="form-table">
                        <th scope="row"><?php esc_html_e( 'Enable Remote Demo Content', WP_MANGA_TEXTDOMAIN ) ?></th>
                        <td>
                            <p>
                                <input type="checkbox" name="university_backup[enable_remote_demo]" value="1" <?php checked( 1, $enable_remote_demo, true ); ?>>
                            </p>
                        </td>
                        <tr>
                            <th scope="row"><?php esc_html_e( 'Remote Link', 'university' ) ?></th>
                            <td>
                                <p>
                                    <input type="text" class="large-text" name="university_backup[remote_link]" value="<?php echo esc_url( $remote_link ) ?>">
                                </p>
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="button button-primary"><?php esc_attr_e( 'Save Changes', 'university' ) ?></button>
                </form>
            </div>
			<?php
		}

		function backup_settings_save() {
			if ( isset( $_POST['university_backup'] ) ) {
				update_option( 'university_backup', $_POST['university_backup'] );
			}
		}

		function university_required_plugins( $plugins ) {

			$demo = isset( $_GET['demo'] ) ? $_GET['demo'] : null;
			if ( ! $demo ) {
				$demo = get_option( 'unyson_demo_id', null );
				if ( $demo ) {
					$demos = FW_Extension_Backups_Demo::get_demos();
					$info  = isset( $demos[ $demo ] ) ? $demos[ $demo ] : null;

					if ( $info ) {
						$require_plugins = $info->get_require_plugins();
					}
					if ( ! empty( $require_plugins ) ) {
						$plugins = array_merge( $plugins, $require_plugins );
					}
				}
			} else if ( $demo ) {
				$demos = FW_Extension_Backups_Demo::get_demos();

				$info = isset( $demos[ $demo ] ) ? $demos[ $demo ] : null;

				if ( $info ) {
					$require_plugins = $info->get_require_plugins();
				}

				if ( ! empty( $require_plugins ) ) {
					$plugins = array_merge( $plugins, $require_plugins );
				}
			}

			return $plugins;
		}

		function download_backup( $demo, $collection, $id_prefix, $tmp_dir ) {

			$download_link = $demo->download_link;
			if ( $download_link && $download_link != '' ) {
				$src_args = $demo->get_source_args();

				$collection->add_task( new FW_Ext_Backups_Task( $id_prefix . 'remote-download', 'remote-download', array(
					'dir'           => $tmp_dir,
					'download_link' => $download_link,
					'src_args'      => $src_args,
				) ) );
			}
		}

		function university_activation_sampledata() {
			add_option( 'university_activation_sampledata_redirect', true );
		}

		function university_fw_loader_image( $image ) {

			$image = university_UNYSON_BACKUP_URI . 'assets/images/logo.png';

			return $image;
		}

		function university_activation_sampledata_redirect() {

			if ( get_option( 'university_activation_sampledata_redirect', false ) ) {
				delete_option( 'university_activation_sampledata_redirect' );
				if ( ! isset( $_GET['activate-multi'] ) ) {
					wp_redirect( admin_url( 'tools.php?page=fw-backups-demo-content' ) );
				}
			}

		}

	}

	$GLOBALS['university_unyson_backup'] = new university_UNYSON_BACKUP();
