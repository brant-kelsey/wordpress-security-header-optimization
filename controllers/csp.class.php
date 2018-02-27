<?php
namespace O10n;

/**
 * Content Security Policy Controller
 *
 * @package    optimization
 * @subpackage optimization/controllers
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH')) {
    exit;
}

class Csp extends Controller implements Controller_Interface
{

    // CSP policy string
    private $policy;

    /**
     * Load controller
     *
     * @param  Core       $Core Core controller instance.
     * @return Controller Controller instance.
     */
    public static function &load(Core $Core)
    {
        // instantiate controller
        return parent::construct($Core, array(
            'env',
            'options'
        ));
    }

    /**
     * Setup controller
     */
    protected function setup()
    {
        // disabled
        if (!$this->env->is_optimization()) {
            return;
        }

        if ($this->options->bool('csp')) {

            // add to HTTP headers hook
            add_action('send_headers', array($this, 'apply_policy'), PHP_INT_MAX);

            if ($this->options->bool('csp.meta')) {

                // add CSP meta
                add_action('wp_head', array($this, 'add_meta'), $this->first_priority);
            }
        }
    }

    /**
     * Add CSP meta to header
     */
    final public function add_meta()
    {
        if (!$this->policy) {
            return;
        }
        print '<meta http-equiv="Content-Security-Policy'.(($this->options->bool('csp.reportOnly')) ? '-Report-Only' : '').'" content="'.esc_attr($this->policy).'">';
    }

    /**
     * Apply Content Security Policy
     */
    final public function apply_policy()
    {

        // policy directives
        $directives = apply_filters('o10n_csp_directives', $this->options->get('csp.directives'));

        // CSP headers
        $headers = apply_filters('o10n_csp_headers', array(
            'Content-Security-Policy'
        ));

        // add legacy headers or pre CSP 1.0 transormation of rules
        if ($this->options->bool('csp.legacy')) {
            $legacy_config = $this->legacy_browser_config($directives);

            if ($legacy_config !== false) {

                // disable CPS headers for device
                if (!$legacy_config[0]) {
                    return;
                }
                
                // custom headers
                $headers = $legacy_config[0];
                if (is_string($headers)) {
                    $headers = array($headers);
                }

                // pre 1.0 directives
                if ($this->options->bool('csp.precsp10') && $legacy_config[1]) {
                    $directives = $legacy_config[1];
                }
            }
        } else {
            $legacy_config = false;
        }

        // construct CSP
        $csp = array();
        foreach ($directives as $directive => $value) {
            $directive = strtolower(preg_replace('/([a-z])([A-Z])/s', '$1-$2', $directive));

            if (is_array($value)) {
                $value = implode(' ', $value);
            } elseif ($value === true) {
                $value = false;
            } else {
                continue 1;
            }
            $csp[$directive] = ($value) ? $directive . ' ' . $value : $directive;
        }

        // apply policy filter
        $csp = apply_filters('o10n_csp_policy', array_values($csp));

        // CSP policy string
        $this->policy = implode('; ', $csp);

        // headers already sent
        if (headers_sent()) {
            return;
        }

        // report only?
        $reportOnly = $this->options->bool('csp.reportOnly');

        foreach ($headers as $header) {
            if ($reportOnly) {
                $header .= '-Report-Only';
            }
            header("$header: " . $this->policy, true);
        }
    }

    /**
     * Detect legacy browser
     *
     * @param  array $directives CPS directives to optionally transform
     * @return array Optional legacy browser config (headers and pre CSP 1.0 directives)
     */
    final private function legacy_browser_config($directives)
    {
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        // apply filter
        $custom_legacy_config = apply_filters('o10n_csp_legacy_browser_config', null, $user_agent);
        if (!is_null($custom_legacy_config)) {
            return $custom_legacy_config;
        }

        // chrome mobile on Android
        // @todo confirm Android <4.4 CSP bug
        // @link https://github.com/helmetjs/helmet/pull/82
        if (strpos($user_agent, 'Chrome Mobile') !== false && strpos($user_agent, 'iOS') === false) {
            $os_version = preg_match('/android\s([0-9\.]*)/i', $user_agent);

            // disable CPS on Android <4.4
            if (version_compare($os_version, '4.4', '<')) {
                return array(
                    false // disable CSP on old Android due to bugs
                );
            }
        } elseif (strpos($user_agent, 'Microsoft Edge') !== false || strpos($user_agent, 'Firefox for iOS') !== false) {
            return false; // no legacy config
        } elseif (stripos($user_agent, 'Firefox Mobile') !== false) {

            // get browser
            $browser = get_browser(null, true);

            if (
                // Firefox OS
                (stripos($browser['platform'], 'Firefox OS') && version_compare($browser['version'], '32', '<'))
                || (stripos($browser['platform'], 'Android') && version_compare($browser['version'], '25', '<'))
                ) {
                if ($this->options->bool('csp.precsp10')) {
                    $basePolicy = array();
                    $basePolicy['defaultSrc'] = array('*');

                    return array(
                        'X-Content-Security-Policy',
                        $this->transform_directives_firefox_precsp10(array_merge($basePolicy, $directives)) // pre CSP 1.0 rules
                    );
                } else {
                    return array(
                        'X-Content-Security-Policy'
                    );
                }
            }
        } elseif (stripos($user_agent, 'Chrome/') !== false && preg_match('/Chrome\/([0-9]+)/i', $user_agent, $out)) {
            $version = $out[1];

            if (version_compare($version, '14', '<')) {
                return array(false);
            } elseif (version_compare($version, '25', '<')) {
                return array(
                    'X-WebKit-CSP'
                );
            }
        } elseif (stripos($user_agent, 'Firefox/') !== false && preg_match('/Firefox\/([0-9]+)/i', $user_agent, $out)) {
            $version = $out[1];

            if (version_compare($version, '4', '<')) {
                return array(false);
            } elseif (version_compare($version, '23', '<')) {
                if ($this->options->bool('csp.precsp10')) {
                    $basePolicy = array();
                    if (version_compare($version, '5', '<')) {
                        $basePolicy['allow'] = array('*');
                        if (isset($directives['defaultSrc'])) {
                            $basePolicy['allow'] = $directives['defaultSrc'];
                            unset($directives['defaultSrc']);
                        }
                    } else {
                        $basePolicy['defaultSrc'] = array('*');
                    }

                    return array(
                        'X-Content-Security-Policy',
                        $this->transform_directives_firefox_precsp10(array_merge($basePolicy, $directives)) // pre CSP 1.0 rules
                    );
                } else {
                    return array(
                        'X-Content-Security-Policy'
                    );
                }
            }
        } else {

            // get browser
            $browser = get_browser(null, true);

            // IE
            if ($browser['browser'] === 'IE') {
                if (version_compare($browser['version'], '12', '<')) {
                    return array(
                        'X-Content-Security-Policy'
                    );
                }
            }

            // Opera
            if ($browser['browser'] === 'Opera') {
                if (version_compare($browser['version'], '15', '<')) {
                    return array(
                        false
                    );
                }
            }

            // Safari
            if ($browser['browser'] === 'Safari') {
                if (version_compare($browser['version'], '6', '<')) {
                    return array(
                        false
                    );
                } elseif (version_compare($browser['version'], '7', '>=')) {
                    return false; // no legacy config
                } elseif (version_compare($browser['version'], '6', '>=')) {
                    return array(
                        'X-WebKit-CSP'
                    );
                }
            }
        }

        return false; // no legacy config
    }

    /**
     * Convert CSP directives to Firefox pre v1.0
     */
    final private function transform_directives_firefox_precsp10($directives)
    {
        $precsp10_directives = array();
        foreach ($directives as $key => $directive) {
            switch (strtolower($key)) {
                case "connectsrc":
                    $precsp10_directives['xhrSrc'] = $directive;
                break;
                case "scriptsrc":
                    $optionsValues = array();

                  if (in_array("'unsafe-inline'", $directive)) {
                      $optionsValues[] = 'inline-script';
                  }
                  if (in_array("'unsafe-eval'", $directive)) {
                      $optionsValues[] = 'eval-script';
                  }

                  if (count($optionsValues) > 0) {
                      $precsp10_directives['options'] = $optionsValues;
                  }
                    $precsp10_directives[$key] = $directive;
                break;
                default:

                    $precsp10_directives[$key] = $directive;
                break;
            }
        }

        return $precsp10_directives;
    }
}
