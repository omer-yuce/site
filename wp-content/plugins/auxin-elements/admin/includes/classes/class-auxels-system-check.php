<?php
class Auxels_System_Check {

    /**
     * Instance of this class.
     *
     * @var      object
     */
    protected static $instance = null;

    function __construct(){
        add_filter( 'site_status_tests', array( $this, 'auxin_system_status_check' ) );
    }

    /**
     * Add checking maximum execution time test
     */
    public function auxin_system_status_check( $tests ) {
        $tests['direct']['auxin_system_check'] = array(
            'label' => __( 'System Status Check By Averta', 'auxin-elements' ),
            'test'  => array( $this, 'check_php_ini_settings' )
        );
    
        return $tests;
    }
    
    /**
     * Maximum execution time test
     */
    public function check_php_ini_settings() {
    
        $result = array(
            'label'       => __( 'Required and recommended php ini settings passed successfully' ),
            'status'      => 'good',
            'badge'       => array(
                'label' => __( 'Performance' ),
                'color' => 'blue',
            ),
            'actions'     => '',
            'test'        => 'auxin_check_php_ini_settings',
            'description' => __( 'Maximum execution time test passed', 'auxin-elements' )
        );
    
        if ( ! $this->check_maximum_execution_time() ) {
            $result['status'] = 'warning';

            $class         = 'warning';
            $screen_reader = __( 'Warning', 'auxin-elements' );
            $message       = __( 'We recommend setting max execution time to at least 60.', 'auxin-elements' );
            $message       = "<span class='dashicons $class'><span class='screen-reader-text'>$screen_reader</span></span> $message";

            $output = '<ul>';
            $output .= sprintf(
                '<li></li>',
                $message
            );
            $output .= '</ul>';

            $result['description'] = $output;
    
            if ( 'good' !== $result['status'] ) {
                if ( 'recommended' === $result['status'] ) {
                    $result['label'] = __( 'We recommend setting max execution time to at least 60.', 'auxin-elements' );
                }
                
            }
        }
    
        return $result;
    }

    public function check_maximum_execution_time() {
        if ( function_exists( 'ini_get' ) ) {
            $time_limit = ini_get('max_execution_time');
            //should add the condition
            if ( $time_limit < 60 && $time_limit != 0 ) {
                return false;
            }
        }
        
        return true;
    }
    /**
     * Get num of system notices
     */
    public function get_num_of_notices() {
        
        $system_notices = ! $this->check_maximum_execution_time() ? 1 : 0;

        if ( ! extension_loaded( 'imagick' ) ) {
            ++$system_notices;
        }

        return $system_notices;    
    
    }

    /**
     * Return an instance of this class.
     *
     * @return    object    A single instance of this class.
     */
    public static function get_instance() {

        // If the single instance hasn't been set, set it now.
        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
?>