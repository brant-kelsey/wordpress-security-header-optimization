<?php
namespace O10n;

/**
 * Security Header Optimization
 *
 * Advanced security header optimization toolkit. Content-Security-Policy, Strict Transport Security (HSTS), Public-Key-Pins (HPKP), X-XSS-Protection and CORS.
 *
 * @link              https://github.com/o10n-x/
 * @package           o10n
 *
 * @wordpress-plugin
 * Plugin Name:       Security Header Optimization
 * Description:       Advanced security header optimization toolkit. Content-Security-Policy, Strict Transport Security (HSTS), Public-Key-Pins (HPKP), X-XSS-Protection and CORS.
 * Version:           0.0.2
 * Author:            Optimization.Team
 * Author URI:        https://optimization.team/
 * Text Domain:       o10n
 * Domain Path:       /languages
 */

if (! defined('WPINC')) {
    die;
}

// abort loading during upgrades
if (defined('WP_INSTALLING') && WP_INSTALLING) {
    return;
}

// settings
$module_version = '0.0.2';
$minimum_core_version = '0.0.6';
$plugin_path = dirname(__FILE__);

// load the optimization module loader
if (!class_exists('\O10n\Module')) {
    require $plugin_path . '/core/controllers/module.php';
}

// load module
new Module(
    'security',
    'Security Header Optimization',
    $module_version,
    $minimum_core_version,
    array(
        'core' => array(
            'shutdown',
            'tools',
            'http',
            'securityheaders',
            'csp'
        ),
        'admin' => array(
            'AdminSecurity'
        )
    ),
    false,
    array(),
    __FILE__
);

// load public functions in global scope
require $plugin_path . '/includes/global.inc.php';
