<?php
namespace O10n;

/**
 * Security Optimization Admin View Controller
 *
 * @package    optimization
 * @subpackage optimization/controllers/admin
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH')) {
    exit;
}

class AdminViewSecurity extends AdminViewBase
{
    protected static $view_key = 'security'; // reference key for view
    protected $module_key = 'security';

    // default tab view
    private $default_tab_view = 'intro';

    /**
     * Load controller
     *
     * @param  Core       $Core Core controller instance.
     * @param  string     $View View key.
     * @return Controller Controller instance.
     */
    public static function &load(Core $Core)
    {
        // instantiate controller
        return parent::construct($Core, array(
            'json',
            'file',
            'AdminClient'
        ));
    }
    
    /**
     * Setup controller
     */
    protected function setup()
    {
        // WPO plugin
        if (defined('O10N_WPO_VERSION')) {
            $this->default_tab_view = 'optimization';
        }

        // set view etc
        parent::setup();
    }

    /**
     * Setup view
     */
    public function setup_view()
    {
        // process form submissions
        add_action('o10n_save_settings_verify_input', array( $this, 'verify_input' ), 10, 1);

        // enqueue scripts
        add_action('admin_enqueue_scripts', array( $this, 'enqueue_scripts' ), $this->first_priority);
    }

    /**
     * Return help tab data
     */
    final public function help_tab()
    {
        $data = array(
            'name' => __('Security Header Optimization', 'o10n'),
            'github' => 'https://github.com/o10n-x/wordpress-security-header-optimization',
            'wordpress' => 'https://wordpress.org/support/plugin/security-header-optimization',
            'docs' => 'https://github.com/o10n-x/wordpress-security-header-optimization/tree/master/docs'
        );

        return $data;
    }

    /**
     * Enqueue scripts and styles
     */
    final public function enqueue_scripts()
    {
        // skip if user is not logged in
        if (!is_admin() || !is_user_logged_in()) {
            return;
        }
    }


    /**
     * Return view template
     */
    public function template($view_key = false)
    {
        // template view key
        $view_key = false;

        $tab = (isset($_REQUEST['tab'])) ? trim($_REQUEST['tab']) : $this->default_tab_view;
        switch ($tab) {
            case "csp":
            case "headers":
            case "access":
            case "reporting":
            case "intro":
                $view_key = 'security-' . $tab;
            break;
            default:
                throw new Exception('Invalid view ' . esc_html($view_key), 'core');
            break;
        }

        return parent::template($view_key);
    }
    
    /**
     * Verify settings input
     *
     * @param  object   Form input controller object
     */
    final public function verify_input($forminput)
    {
        // Security Optimization

        $tab = (isset($_REQUEST['tab'])) ? trim($_REQUEST['tab']) : 'csp';
        switch ($tab) {
            case "csp":

                $forminput->type_verify(array(
                    'csp.enabled' => 'bool'
                ));

                if ($forminput->bool('csp.enabled')) {
                    $forminput->type_verify(array(
                        'csp.reportOnly' => 'bool',
                        'csp.legacy' => 'bool',
                        'csp.precsp10' => 'bool',
                        'csp.meta' => 'bool',
                        'csp.reportUri' => 'string',
                        'csp.report-to.enabled' => 'bool',
                        'csp.report-to.group' => 'string',
                        'csp.directives' => 'json'
                    ));
                }
            break;
            case "headers":

                $forminput->type_verify(array(
                    'headers.hsts.enabled' => 'bool',
                    'headers.hpkp.enabled' => 'bool',
                    'headers.x-frame-options.enabled' => 'bool',
                    'headers.x-xss-protection.enabled' => 'bool',
                    'headers.x-content-type-options' => 'bool',
                    'headers.referrer-policy.enabled' => 'bool',
                    'headers.expect-ct.enabled' => 'bool',
                    'headers.x-permitted-cross-domain-policies.enabled' => 'bool',
                    'headers.x-dns-prefetch-control' => 'bool',
                    'headers.x-powered-by' => 'bool'
                ));

                // strict transport security
                if ($forminput->bool('headers.hsts.enabled')) {
                    $forminput->type_verify(array(
                        'headers.hsts.includeSubdomains' => 'bool',
                        'headers.hsts.preload' => 'bool',
                        'headers.hsts.max-age' => 'int'
                    ));
                }

                // HTTP Public Key Pinning (HPKP)
                if ($forminput->bool('headers.hpkp.enabled')) {
                    $forminput->type_verify(array(
                        'headers.hpkp.pin-sha256' => 'string',
                        'headers.hpkp.pin-sha256-backup' => 'string',
                        'headers.hpkp.includeSubdomains' => 'bool',
                        'headers.hpkp.max-age' => 'int',
                        'headers.hpkp.reportUri' => 'string'
                    ));
                }

                // x-frame-options
                if ($forminput->bool('headers.x-frame-options.enabled')) {
                    $forminput->type_verify(array(
                        'headers.x-frame-options.mode' => 'string',
                        'headers.x-frame-options.allowFrom' => 'string'
                    ));
                }

                // x-xss-protection
                if ($forminput->bool('headers.x-xss-protection.enabled')) {
                    $forminput->type_verify(array(
                        'headers.x-xss-protection.mode' => 'string',
                        'headers.x-xss-protection.reportUri' => 'string'
                    ));
                }

                // referrer-policy
                if ($forminput->bool('headers.referrer-policy.enabled')) {
                    $forminput->type_verify(array(
                        'headers.referrer-policy.mode' => 'string'
                    ));
                }

                // expect-ct
                if ($forminput->bool('headers.expect-ct.enabled')) {
                    $forminput->type_verify(array(
                        'headers.expect-ct.enforce' => 'bool',
                        'headers.expect-ct.reportUri' => 'string',
                        'headers.expect-ct.max-age' => 'int'
                    ));
                }

                // X-Permitted-Cross-Domain-Policies
                if ($forminput->bool('headers.x-permitted-cross-domain-policies.enabled')) {
                    $forminput->type_verify(array(
                        'headers.x-permitted-cross-domain-policies.mode' => 'string'
                    ));
                }

            break;
            case "access":

                $forminput->type_verify(array(
                    'headers.access-control-allow-origin.enabled' => 'bool',
                    'headers.access-control-allow-credentials' => 'bool',
                    'headers.access-control-max-age.enabled' => 'bool',
                    'headers.access-control-allow-methods.enabled' => 'bool',
                    'headers.access-control-allow-headers.enabled' => 'bool',
                    'headers.access-control-expose-headers.enabled' => 'bool'
                ));

                // Access-Control-Allow-Origin
                if ($forminput->bool('headers.access-control-allow-origin.enabled')) {
                    $forminput->type_verify(array(
                        'headers.access-control-allow-origin.all' => 'bool',
                        'headers.access-control-allow-origin.origins' => 'json-array'
                    ));
                }

                // Access-Control-Allow-Origin
                if ($forminput->bool('headers.access-control-max-age.enabled')) {
                    $forminput->type_verify(array(
                        'headers.access-control-max-age.max-age' => 'int'
                    ));
                }

                // Access-Control-Allow-Origin
                if ($forminput->bool('headers.access-control-allow-methods.enabled')) {
                    $forminput->type_verify(array(
                        'headers.access-control-allow-methods.GET' => 'bool',
                        'headers.access-control-allow-methods.POST' => 'bool',
                        'headers.access-control-allow-methods.OPTIONS' => 'bool',
                        'headers.access-control-allow-methods.HEAD' => 'bool',
                        'headers.access-control-allow-methods.PUT' => 'bool',
                        'headers.access-control-allow-methods.DELETE' => 'bool',
                        'headers.access-control-allow-methods.TRACE' => 'bool',
                        'headers.access-control-allow-methods.CONNECT' => 'bool',
                        'headers.access-control-allow-methods.PATCH' => 'bool'
                    ));
                }

                // Access-Control-Allow-Headers
                if ($forminput->bool('headers.access-control-allow-headers.enabled')) {
                    $forminput->type_verify(array(
                        'headers.access-control-allow-headers.headers' => 'json-array'
                    ));
                }

                // Access-Control-Allow-Headers
                if ($forminput->bool('headers.access-control-expose-headers.enabled')) {
                    $forminput->type_verify(array(
                        'headers.access-control-expose-headers.headers' => 'json-array'
                    ));
                }
            break;
            case "reporting":

                $forminput->type_verify(array(
                    'headers.report-to.enabled' => 'bool'
                ));

                // Reporting API
                if ($forminput->bool('headers.report-to.enabled')) {
                    $forminput->type_verify(array(
                        'headers.report-to.endpoints' => 'json-array'
                    ));
                }
            break;
        }
    }
}
