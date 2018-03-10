<?php
namespace O10n;

/**
 * Security Header Optimization Controller
 *
 * @package    optimization
 * @subpackage optimization/controllers
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH')) {
    exit;
}

class Securityheaders extends Controller implements Controller_Interface
{

    // set headers
    private $headers = array();
    private $unset_headers = array(); // removed headers
    
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
            'options',
            'env',
            'json'
        ));
    }

    /**
     * Setup controller
     */
    protected function setup()
    {

        // add to last position in HTTP headers hook
        add_action('send_headers', array($this, 'send_headers'), PHP_INT_MAX);
    }


    /**
     * Send security headers
     */
    final public function send_headers()
    {
        if (headers_sent()) {
            return;
        }

        // Report API endpoints
        if ($this->options->bool('headers.report-to.enabled')) {

            // endpoints
            $endpoints = $this->options->get('headers.report-to.endpoints');
            if ($endpoints) {
                if ($endpoints && !empty($endpoints)) {
                    $endpoint_header = array();
                    foreach ($endpoints as $endpoint) {
                        $endpoint_header[] = json_encode($endpoint);
                    }
                    $this->header('Report-To', implode(',', $endpoint_header));
                }
            }
        }

        // Strict Transport Security HTTP
        if ($this->options->bool('headers.hsts.enabled')) {
            $hsts = array();
            
            // max age
            $maxAge = $this->options->get('headers.hsts.max-age', false);
            if ($maxAge && is_numeric($maxAge) && $maxAge > 0) {
                $hsts[] = sprintf('max-age=%u', $maxAge);
            }

            // include subdomains
            if ($this->options->bool('headers.hsts.includeSubdomains')) {
                $hsts[] = 'includeSubDomains';
            }

            // preload
            if ($this->options->bool('headers.hsts.preload')) {
                $hsts[] = 'preload';
            }

            $this->header('Strict-Transport-Security', join('; ', $hsts));
        }

        // Public-Key-Pins (HPKP)
        if ($this->options->bool('headers.hpkp.enabled')) {
            $hpkp = array();
            
            // sha256
            $sha256 = $this->options->get('headers.hpkp.pin-sha256');
            if ($sha256) {
                $hpkp[] = sprintf('pin-sha256="%s"', $sha256);
            }

            // sha256 backup
            $sha256 = $this->options->get('headers.hpkp.pin-sha256-backup');
            if ($sha256) {
                $hpkp[] = sprintf('pin-sha256="%s"', $sha256);
            }

            // max age
            $maxAge = $this->options->get('headers.hpkp.max-age', false);
            if ($maxAge && is_numeric($maxAge) && $maxAge > 0) {
                $hpkp[] = sprintf('max-age=%u', $maxAge);
            }

            // include subdomains
            if ($this->options->bool('headers.hpkp.includeSubdomains')) {
                $hpkp[] = 'includeSubDomains';
            }

            // report uri
            $reportUri = $this->options->get('headers.hpkp.reportUri', false);
            if ($reportUri) {
                $hpkp[] = sprintf('report-uri=%s', $reportUri);
            }

            $this->header('Public-Key-Pins', join('; ', $hpkp));
        }

        // X-Frame-Options
        if ($this->options->bool('headers.x-frame-options.enabled')) {

            // mode
            $mode = $this->options->get('headers.x-frame-options.mode', 'DENY');
            if (strtoupper($mode) === 'ALLOW-FROM') {
                $allowFrom = $this->options->get('headers.x-frame-options.allowFrom');
                if (!$allowFrom) {
                    $mode = false;
                } else {
                    $mode .= ' ' . $allowFrom;
                }
            }

            if ($mode) {
                $this->header('X-Frame-Options', $mode);
            }
        }

        // X-XSS-Protection
        if ($this->options->bool('headers.x-xss-protection.enabled')) {

            // mode
            $mode = (string)$this->options->get('headers.x-xss-protection.mode', '1');
            if (strtolower($mode) === 'report') {
                $reportUri = $this->options->get('headers.x-xss-protection.reportUri');
                if (!$reportUri) {
                    $mode = '1';
                } else {
                    $mode = '1; report=' . $reportUri;
                }
            } else {
                if ($mode === 'block') {
                    $mode = '1; mode=block';
                } else {
                    $mode = ($mode === '0') ? '0' : '1';
                }
            }

            $this->header('X-XSS-Protection', $mode);
        }

        // X-Content-Type-Options
        if ($this->options->bool('headers.x-content-type-options')) {
            $this->header('X-Content-Type-Options', 'nosniff');
        }

        // Referrer-Policy
        if ($this->options->bool('headers.referrer-policy.enabled')) {

            // mode
            $mode = $this->options->get('headers.referrer-policy.mode', 'no-referrer-when-downgrade');
            
            $this->header('Referrer-Policy', $mode);
        }

        // Expect-CT
        if ($this->options->bool('headers.expect-ct.enabled')) {
            $expectct = array();
            
            // enforce policy
            if ($this->options->bool('headers.expect-ct.enforce')) {
                $expectct[] = 'enforce';
            }
            
            // max age
            $maxAge = $this->options->get('headers.expect-ct.max-age', false);
            if ($maxAge && is_numeric($maxAge) && $maxAge > 0) {
                $expectct[] = sprintf('max-age=%u', $maxAge);
            }

            // report uri
            $reportUri = $this->options->get('headers.expect-ct.reportUri', false);
            if ($reportUri) {
                $expectct[] = sprintf('report-uri="%s"', $reportUri);
            }

            $this->header('Expect-CT', join('; ', $expectct));
        }

        // X-DNS-Prefetch-Control
        if ($this->options->bool('headers.x-dns-prefetch-control')) {
            $this->header('X-DNS-Prefetch-Control', 'off');
        }

        // X-Permitted-Cross-Domain-Policies
        if ($this->options->bool('headers.x-permitted-cross-domain-policies.enabled')) {

            // mode
            $mode = $this->options->get('headers.x-permitted-cross-domain-policies.mode', 'none');
            
            $this->header('X-Permitted-Cross-Domain-Policies', $mode);
        }

        // X-Powered-By
        if ($this->options->bool('headers.x-powered-by')) {
            $this->remove_header('X-Powered-By');
        }

        // Access-Control-Allow-Origin
        if ($this->options->bool('headers.access-control-allow-origin.enabled')) {

            // wildcard *
            if ($this->options->bool('headers.access-control-allow-origin.all')) {
                $origin = '*';
            } else {
                $origin = false;

                // origins
                $origins = $this->options->get('headers.access-control-allow-origin.origins');
                if (isset($_SERVER['HTTP_ORIGIN'])) {
                    foreach ($origins as $str) {
                        if (stripos($_SERVER['HTTP_ORIGIN'], $str) === 0) {
                            $origin = $str;
                            break 1;
                        }
                    }
                }
            }

            if ($origin) {
                $this->header('Access-Control-Allow-Origin', $origin);
            }
        }

        // Access-Control-Allow-Credentials
        if ($this->options->bool('headers.access-control-allow-credentials')) {
            $this->header('Access-Control-Allow-Credentials', 'true');
        }

        // Access-Control-Max-Age
        if ($this->options->bool('headers.access-control-max-age.enabled')) {
            $maxAge = $this->options->get('headers.access-control-max-age.max-age', false);
            if ($maxAge && is_numeric($maxAge) && $maxAge > 0) {
                $this->header('Access-Control-Max-Age', $maxAge);
            }
        }

        // Access-Control-Allow-Methods
        if ($this->options->bool('headers.access-control-allow-methods.enabled')) {
            $methods = array('GET','POST','OPTIONS','HEAD','PUT','DELETE','TRACE','CONNECT','PATCH');
            $allowed = array();
            foreach ($methods as $method) {
                if ($this->options->bool('headers.access-control-allow-methods.' . $method)) {
                    $allowed[] = $method;
                }
            }

            if (!empty($allowed)) {
                $this->header('Access-Control-Allow-Methods', implode(', ', $allowed));
            }
        }

        // Access-Control-Allow-Headers
        if ($this->options->bool('headers.access-control-allow-headers.enabled')) {
            $headers = $this->options->get('headers.access-control-allow-headers.headers');
            if (is_array($headers) && !empty($headers)) {
                $this->header('Access-Control-Allow-Headers', implode(', ', $headers));
            }
        }

        // Access-Control-Expose-Headers
        if ($this->options->bool('headers.access-control-expose-headers.enabled')) {
            $headers = $this->options->get('headers.access-control-expose-headers.headers');
            if (is_array($headers) && !empty($headers)) {
                $this->header('Access-Control-Expose-Headers', implode(', ', $headers));
            }
        }
    }

    /**
     * Output HTTP header
     */
    final private function header($name, $value, $replace = true)
    {
        header(sprintf('%s: %s', $name, $value), $replace);
    }

    /**
     * Remove HTTP header
     */
    final private function remove_header($name)
    {
        if (function_exists('header_remove')) {
            header_remove($name);
        } else {
            header(sprintf('%s: ', $name), true);
        }
    }
}
