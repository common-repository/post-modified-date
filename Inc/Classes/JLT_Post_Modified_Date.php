<?php
namespace JLTPMD\Inc\Classes;

/**
* @package JWT_Post_Modified_Date
* @author Jewel Theme
*/
class JLT_Post_Modified_Date{
    private static $instance = false;

    public function __construct(){
        load_plugin_textdomain('jt-pmd', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        add_action('init', array($this, 'jwt_pmd_init'));

        // Menu
        add_action('admin_menu', array($this,'jwt_pmd_add_options'));
        add_action('admin_init', array($this,'jwt_pmd_register_settings'));
    }


    //Add options page
    public function jwt_pmd_add_options() {
            add_options_page(
            esc_html__( 'Post Update Date - Jewel Theme', 'jt-pmd' ),
            esc_html__( 'Post Update Date', 'jt-pmd' ),
            'manage_options',
            'jwt_pmd',
            array( $this, 'jwt_pmd_setting_functions' )
        );
    }

    public function jwt_pmd_register_settings(){
        register_setting('jwt_pmd_settings','jwt_pmd_text');
    }

public function jwt_pmd_setting_functions(){?>
        <div class="wrap">
            <div class="icon32" id="icon-options-general"><br></div>
            <h2><?php echo esc_html__('Post Modified Date Settings', 'jt-pmd');?></h2>
            <p><?php echo esc_html__('Post Modified Date Options Settings', 'jt-pmd');?></p>
                <form method="post" action="options.php">
                    <?php settings_fields('jwt_pmd_settings'); ?>

                    <table class="form-table">
                        <tr><th>
                            <label><?php echo esc_html__('Post Updated Text', 'jt-pmd');?></label>
                        </th><td>
                        <input type="text" name="jwt_pmd_text" value="<?php echo get_option('jwt_pmd_text'); ?>" />
                    </td></tr>

                    <tr><td>
                        <input type="submit" class="button-primary" value="<?php echo esc_html__('Save Changes', 'jt-pmd');?>" />
                    </td></tr>

                </table>
            </form>
        </div>
    <?php
    }


    public static function get_instance(){
        if( !self::$instance ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function jwt_pmd_init(){
        add_filter('the_content', array($this,'jwt_post_last_modified_date'), 10,1);
        add_filter('wp_head', array($this,'jwt_post_last_style'));
    }

    public function jwt_post_last_modified_date(){
        $u_time = get_the_time('U');
        $u_modified_time = get_the_modified_time('U');

        //if ( is_single() && 'post' == get_post_type() ) {
            if ($u_modified_time >= $u_time + 86400) {
                $updated_date = get_the_modified_time('F jS, Y');
                $updated_time = get_the_modified_time('h:i a');
                $modified_date = (get_option('jwt_pmd_text'))? get_option('jwt_pmd_text') : esc_html__('Last Updated on', 'jt-pmd');
                $custom_content .= '<p class="last-updated"><span>' . $modified_date . '</span>' . $updated_date . ' '. $updated_time .'</p>';
                $custom_content .= $content;
                return $custom_content;
            }
        //}
    }

    public function jwt_post_last_style(){ ?>
        <style>
            .last-updated {
                background-color: #E8FFD7;
                border: 1px dashed red;
            }
            .last-updated span{
                padding: 0 10px;
            }
        </style>
        <?php }
    }