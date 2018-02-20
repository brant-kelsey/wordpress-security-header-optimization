<?php
namespace O10n;

/**
 * Security optimization admin template
 *
 * @package    optimization
 * @subpackage optimization/admin
 * @author     Optimization.Team <info@optimization.team>
 */
if (!defined('ABSPATH') || !defined('O10N_ADMIN')) {
    exit;
}

// print form header
$this->form_start(__('Security Optimization', 'optimization'), 'security');

?>
<style>
.allow-methods label {
    margin-right:.5em;
}
</style>
<h3 style="margin-bottom:0.5em;">Access-Control Headers</h3>
<p class="description">The following headers enable to configure <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS" target="_blank">Cross-Origin Resource Sharing (CORS)</a>.</p>
<div class="inside">
<table class="form-table">
    <tr valign="top">
        <th scope="row">Allow-Origin</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.access-control-allow-origin.enabled]" data-json-ns="1" value="1"<?php $checked('headers.access-control-allow-origin.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable the <code>Access-Control-Allow-Origin</code> header to enable Cross-Origin Resource Sharing.</p>

            <label><input type="checkbox" name="o10n[headers.access-control-allow-origin.all]" data-json-ns="1" value="1"<?php $checked('headers.access-control-allow-origin.all'); ?>> All origins (wildcard *)</label>

            <div class="suboption" data-ns-hide="headers.access-control-allow-origin.all"<?php $invisible('headers.access-control-allow-origin.all'); ?>>
                <h5 class="h">&nbsp;Origins</h5>
                <div id="headers-access-control-allow-origin-origins"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'optimization'); ?></div></div>
                <input type="hidden" class="json" name="o10n[headers.access-control-allow-origin.origins]" data-json-type="json-array" data-json-editor-height="auto" data-json-editor-init="1" value="<?php print esc_attr($json('headers.access-control-allow-origin.origins')); ?>" />
                <p class="description">Enter a JSON array with origin URI's, e.g. <code>["https://origin-a.com", "https://origin-b.com"]</code>.</p>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Allow-Credentials</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.access-control-allow-credentials]" data-json-ns="1" value="1"<?php $checked('headers.access-control-allow-credentials'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable the <code>Access-Control-Allow-Credentials</code> header.</p>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Max-Age</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.access-control-max-age.enabled]" data-json-ns="1" value="1"<?php $checked('headers.access-control-max-age.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable the <code>Access-Control-Max-Age</code> header..</p>

            <div class="suboption" data-ns="headers.access-control-max-age"<?php $visible('headers.access-control-max-age'); ?>>
                <h5 class="h">&nbsp;Maximum Age</h5>
                <input type="number" name="o10n[headers.access-control-max-age.max-age]" min="1" value="<?php $value('headers.access-control-max-age.max-age', 600); ?>" style="width:120px;max-width:100%;" />
                <p class="description">Enter a time in seconds to cache the preflight request in the browser.</p>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Allow-Methods</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.enabled]" data-json-ns="1" value="1"<?php $checked('headers.access-control-allow-methods.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable the <code>Access-Control-Allow-Methods</code> header to inform the browser about the HTTP methods that can be used.</p>

            <div class="allow-methods suboption" data-ns="headers.access-control-allow-methods"<?php $visible('headers.access-control-allow-methods'); ?>>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.GET]"value="1"<?php $checked('headers.access-control-allow-methods.GET'); ?>> GET</label>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.POST]"value="1"<?php $checked('headers.access-control-allow-methods.POST'); ?>> POST</label>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.OPTIONS]"value="1"<?php $checked('headers.access-control-allow-methods.OPTIONS'); ?>> OPTIONS</label>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.HEAD]"value="1"<?php $checked('headers.access-control-allow-methods.HEAD'); ?>> HEAD</label>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.PUT]"value="1"<?php $checked('headers.access-control-allow-methods.PUT'); ?>> PUT</label>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.DELETE]"value="1"<?php $checked('headers.access-control-allow-methods.DELETE'); ?>> DELETE</label>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.TRACE]"value="1"<?php $checked('headers.access-control-allow-methods.TRACE'); ?>> TRACE</label>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.CONNECT]"value="1"<?php $checked('headers.access-control-allow-methods.CONNECT'); ?>> CONNECT</label>
                <label><input type="checkbox" name="o10n[headers.access-control-allow-methods.PATCH]"value="1"<?php $checked('headers.access-control-allow-methods.PATCH'); ?>> PATCH</label>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Allow-Headers</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.access-control-allow-headers.enabled]" data-json-ns="1" value="1"<?php $checked('headers.access-control-allow-headers.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable the <code>Access-Control-Allow-Headers</code> header to indicate which headers can be used in a request.</p>

            <div class="suboption" data-ns="headers.access-control-allow-headers"<?php $visible('headers.access-control-allow-headers'); ?>>
                <h5 class="h">&nbsp;Header Names</h5>
                <div id="headers-access-control-allow-headers-headers"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'optimization'); ?></div></div>
                <input type="hidden" class="json" name="o10n[headers.access-control-allow-headers.headers]" data-json-type="json-array" data-json-editor-height="auto" data-json-editor-init="1" value="<?php print esc_attr($json('headers.access-control-allow-headers.headers')); ?>" />
                <p class="description">Enter a JSON array with header names, e.g. <code>["Accept", "Accept-Language"]</code>.</p>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Expose-Headers</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.access-control-expose-headers.enabled]" data-json-ns="1" value="1"<?php $checked('headers.access-control-expose-headers.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable the <code>Access-Control-Expose-Headers</code> header to indicate which headers to expose in a request.</p>

            <div class="suboption" data-ns="headers.access-control-expose-headers"<?php $visible('headers.access-control-expose-headers'); ?>>
                <h5 class="h">&nbsp;Header Names</h5>
                <div id="headers-access-control-expose-headers-headers"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'optimization'); ?></div></div>
                <input type="hidden" class="json" name="o10n[headers.access-control-expose-headers.headers]" data-json-type="json-array" data-json-editor-height="auto" data-json-editor-init="1" value="<?php print esc_attr($json('headers.access-control-expose-headers.headers')); ?>" />
                <p class="description">Enter a JSON array with header names, e.g. <code>["Accept", "Accept-Language"]</code>.</p>
            </div>
        </td>
    </tr>
</table>
</div>
<!--table class="form-table">
    <tr valign="top">
        <th scope="row">P3P</th>
        <td>
            
            <label><input type="checkbox" name="o10n[headers.access-control-allow-.enabled]" data-json-ns="1" value="1"<?php $checked('headers.access-control-allow-.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable the <a href="https://www.w3.org/P3P/" target="_blank">Platform for Privacy Preferences Project (P3P)</a> HTTP header to declare the intended use of information collected about web browser users.</p>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Timing-Allow-Origin</th>
        <td>
            
            <label><input type="checkbox" name="o10n[headers.access-control-allow-.enabled]" data-json-ns="1" value="1"<?php $checked('headers.access-control-allow-.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable Strict Transport Security HTTP header to enforce SSL.</p>

        </td>
    </tr>
    </table-->
<hr />
<?php
    submit_button(__('Save'), 'primary large', 'is_submit', false);

// print form header
$this->form_end();
