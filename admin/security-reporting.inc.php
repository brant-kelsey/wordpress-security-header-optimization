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
$this->form_start(__('Reporting API Configuration', 'optimization'), 'security');

?>

<table class="form-table">

    <tr valign="top">
        <th scope="row">Reporting API</th>
        <td>
            
            <label><input type="checkbox" name="o10n[headers.report-to.enabled]" data-json-ns="1" value="1"<?php $checked('headers.report-to.enabled'); ?>> Enable
</label>
            <p class="description" style="margin-bottom:1em;">Enable <a href="https://wicg.github.io/reporting/" target="_blank" rel="noopener">Reporting API</a> <code>Report-To</code> endpoint management.</p>

            <div class="suboption" data-ns="headers.report-to"<?php $visible('headers.report-to'); ?>>
                <h5 class="h">&nbsp;Report API Endpoints</h5>
                <div id="headers-report-to-endpoints"><div class="loading-json-editor"><?php print __('Loading JSON editor...', 'optimization'); ?></div></div>
                <input type="hidden" class="json" name="o10n[headers.report-to.endpoints]" data-json-type="json-array" data-json-editor-height="auto" data-json-editor-init="1" value="<?php print esc_attr($json('headers.report-to.endpoints')); ?>" />

                <div class="info_yellow"><strong>Example:</strong> <code class="clickselect" title="<?php print esc_attr('Click to select', 'o10n'); ?>" style="cursor:copy;">{"url": "https://report-uri.io/endpoint", "group": "report-group", "includeSubdomains": true, "max-age": 86400}</code></div>
            </div>
        </td>
    </tr>
    </table>

    <div><strong>Tip: </strong>  Use a <a href="https://encrypted.google.com/search?q=report+uri+service" target="_blank" rel="noopener">online reporting service</a> to receive email or SMS notifications.</div>
<hr />
<?php
    submit_button(__('Save'), 'primary large', 'is_submit', false);

// print form header
$this->form_end();
