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

<table class="form-table">
    <tr valign="top">
        <th scope="row">Content Security Policy</th>
        <td>
            
            <label><input type="checkbox" name="o10n[csp.enabled]" data-json-ns="1" value="1"<?php $checked('csp.enabled'); ?>> Enable
</label>
            <p class="description" style="margin-bottom:1em;">Enable <a href="https://developers.google.com/web/fundamentals/security/csp/" target="_blank" rel="noopener">Content Security Policy (CSP)</a> management.</p>

            <div class="suboption" data-ns="csp"<?php $visible('csp'); ?>>

            <h5 class="h">&nbsp;Content Security Policy Directives</h5>
            <div id="csp-directives"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'optimization'); ?></div></div>
            <input type="hidden" class="json" name="o10n[csp.directives]" data-json-editor-compact="1" data-json-editor-height="auto" data-json-editor-init="1" value="<?php print esc_attr($json('csp.directives')); ?>" />
            </div>
        </td>
    </tr>
    <tr valign="top" data-ns="csp"<?php $visible('csp'); ?>>
        <th scope="row">&nbsp;</th>
        <td style="padding-top:0px;">
            
            
                <label><input type="checkbox" name="o10n[csp.legacy]" data-json-ns="1" value="1"<?php $checked('csp.legacy'); ?> /> Add legacy headers</label>
                <p class="description">Check this option if you want to include the legacy headers <code>X-WebKit-CSP</code> and <code>X-Content-Security-Policy</code> based on user-agent sniffing.</p>
            

            <div class="suboption" data-ns="csp.legacy"<?php $visible('csp.legacy'); ?>>
                <label><input type="checkbox" name="o10n[csp.precsp10]" value="1"<?php $checked('csp.precsp10'); ?> /> Enable pre CSP 1.0 directives</label>
                <p class="description">Convert directives to pre CSP 1.0 directives based on user-agent sniffing.</p>
            </div>

            <div class="suboption">
                <label><input type="checkbox" name="o10n[csp.meta]" value="1"<?php $checked('csp.meta'); ?> /> Include CSP meta</label>
                <p class="description">Include the CSP policy as <code>&lt;meta http-equiv="Content-Security-Policy" content="..." /&gt;</code> in the page header.</p>
            </div>

            <div class="suboption">
                <label><input type="checkbox" name="o10n[csp.reportTo.enabled]" data-json-ns="1" value="1"<?php $checked('csp.reportTo.enabled'); ?> /> Enable new Reporting API <code>report-to</code> directive.</p>
            </div>

            <div class="suboption" data-ns="csp.reportTo"<?php $visible('csp.reportTo'); ?>>
                <h5 class="h">&nbsp;Reporting API group name</h5>
                <input type="text" name="o10n[csp.reportTo.group]" value="<?php $value('csp.reportTo.group'); ?>" style="width:200px;max-width:100%;" />
                <p class="description">Enter a Reporting API group name to send violation reports. You can create a <code>Report-To</code> header in the <a href="<?php print esc_url(add_query_arg(array('page' => 'o10n-security', 'tab' => 'reporting'), admin_url('admin.php'))); ?>">Reporting API</a> tab.</p>
            </div>

            <div class="suboption">
                <h5 class="h">&nbsp;Report URI</h5>
                <input type="url" name="o10n[csp.reportUri]" value="<?php $value('csp.reportUri'); ?>" style="width:500px;max-width:100%;" />
                <p class="description">Enter an URL to send violation reports using the old <code>report-uri</code> directive.</p>
            </div>

            <div class="info_yellow"><strong><span class="dashicons dashicons-lightbulb"></span></strong>  Use a <a href="https://encrypted.google.com/search?q=report+uri+service" target="_blank" rel="noopener">online reporting service</a> to receive email or SMS notifications.</div>

            <div class="suboption">
            <label><input type="checkbox" name="o10n[csp.reportOnly]" value="1"<?php $checked('csp.reportOnly'); ?> /> Report only</label>
            <p class="description">Check this option if you want browsers to report errors, not block them.</p>
            </div>
        </td>
    </tr>
    </table>
<hr />
<?php
    submit_button(__('Save'), 'primary large', 'is_submit', false);

// print form header
$this->form_end();
