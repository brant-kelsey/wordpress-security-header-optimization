<?php
/**
 * Intro admin template
 *
 * @package    optimization
 * @subpackage optimization/admin
 * @author     Optimization.Team <info@optimization.team>
 */

if (!defined('ABSPATH')) {
    exit;
}

$module_name = $view->module->name();
$module_version = $view->module->version();

?>
<style>
/* https://securityheaders.io/?q=securityheaders.io */
.score_lightgreen {
	background-color: #34af00;
    border: 2px solid #309d00;
    border-radius: 12px;
    font-family: Arial,Helvetica,sans-serif;
    text-align: center;
    margin: auto;
    width: 180px;
    height: 180px;
    font-size: 90px;
    line-height: 180px;
    color: #fff;
    font-weight: 700;

}
</style>
<div class="wrap">

	<div class="metabox-prefs">
		<div class="wrap about-wrap" style="position:relative;">
			<div style="float:right;">
				<div class="score_lightgreen"><span>A+</span></div>
			</div>
			<h1><?php print $module_name; ?> <?php print $module_version; ?></h1>

			<p class="about-text" style="min-height:inherit;">Thank you for using the <?php print $module_name; ?> plugin by <a href="https://github.com/o10n-x/" target="_blank" rel="noopener" style="color:black;text-decoration:none;">Optimization.Team</a></p>
			
			<p class="about-text" style="min-height:inherit;">This plugin is a toolkit for advanced HTTP Security Header optimization for WordPress. <!--The plugin can be used stand alone or as a module for the <a href="#">Performance Optimization plugin</a>.--></p>

			<p class="about-text info_yellow" style="min-height:inherit;"><strong>Warning:</strong> This plugin is intended for optimization professionals and advanced WordPress users.</p>

			<p class="about-text" style="min-height:inherit;">Getting started? Read <a href="https://developers.google.com/web/fundamentals/security/csp/" target="_blank">this article</a> about Content Security Policy by Google and <a href="https://www.smashingmagazine.com/2016/09/content-security-policy-your-future-best-friend/" target="_blank">this extensive guide</a> by <a href="https://www.smashingmagazine.com/" target="_blank" style="color:#d33a2c;font-weight:bold;">Smashing Magazine</a>. Test your security header configuration at <a href="https://securityheaders.io/?q=<?php print urlencode(home_url()); ?>&followRedirects=on" target="_blank" rel="noopener">securityheaders.io</a>.</p>

			<p class="about-text" style="min-height:inherit;">If you are happy with the plugin, please consider to <a href="https://wordpress.org/support/plugin/security-header-optimization/reviews/#new-post" target="_blank" rel="noopener">write a review</a> and <span class="star" style="display:inline-block;vertical-align:middle;"><a class="github-button" data-manual="1" data-size="large" href="https://github.com/o10n-x/wordpress-security-header-optimization" data-icon="octicon-star" data-show-count="true" aria-label="Star o10n-x/wordpress-security-header-optimization on GitHub">Star</a></span> on Github.</p>
			</div>

		</div>
	</div>

</div>