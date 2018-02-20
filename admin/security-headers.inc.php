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
        <th scope="row">Strict Transport Security</th>
        <td>
            
            <label><input type="checkbox" name="o10n[headers.hsts.enabled]" data-json-ns="1" value="1"<?php $checked('headers.hsts.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable Strict Transport Security HTTP header to enforce SSL.</p>

            <div class="suboption" data-ns="headers.hsts"<?php $visible('headers.hsts'); ?>>
                <label><input type="checkbox" name="o10n[headers.hsts.includeSubdomains]" value="1"<?php $checked('headers.hsts.includeSubdomains'); ?> /> Enable <code>includeSubdomains</code> to enforce SSL on subdomains.</p>
            </div>

            <div class="suboption" data-ns="headers.hsts"<?php $visible('headers.hsts'); ?>>
                <label><input type="checkbox" name="o10n[headers.hsts.preload]" value="1"<?php $checked('headers.hsts.preload'); ?> /> Enable <code>preload</code> optimization.</p>
            </div>

            <div class="suboption" data-ns="headers.hsts"<?php $visible('headers.hsts'); ?>>
                <h5 class="h">&nbsp;Maximum Age</h5>
                <input type="number" name="o10n[headers.hsts.max-age]" min="1" value="<?php $value('headers.hsts.max-age', 86400); ?>" style="width:120px;max-width:100%;" />
                <p class="description">Enter a time in seconds to cache the HSTS policy in the browser.</p>
            </div>

            <div class="info_yellow" data-ns="headers.hsts"<?php $visible('headers.hsts'); ?>><strong><span class="dashicons dashicons-lightbulb"></span></strong>  <a href="https://www.ssllabs.com/ssltest/analyze.html?d=<?php print urlencode(preg_replace('|^http(s)?://([^/]+)(/.*)?$|Ui', '$2', home_url())); ?>&latest" target="_blank" rel="noopener">Test</a> the quality of your SSL configuration at <a href="https://www.ssllabs.com/" target="_blank" rel="noopener" title="Qualys SSL Labs">SSLLabs.com</a>.</div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Public-Key-Pins (HPKP)</th>
        <td>
            
            <label><input type="checkbox" name="o10n[headers.hpkp.enabled]" data-json-ns="1" value="1"<?php $checked('headers.hpkp.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable HTTP <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/Public_Key_Pinning" target="_blank" rel="noopener">Public Key Pinning</a> (HPKP) to resist impersonation by attackers using mis-issued or otherwise fraudulent certificates.</p>

            <div class="suboption" data-ns="headers.hpkp"<?php $visible('headers.hpkp'); ?>>
                <h5 class="h">&nbsp;pin-sha256</h5>
                <input type="text" name="o10n[headers.hpkp.pin-sha256]" value="<?php $value('headers.hpkp.pin-sha256'); ?>" style="width:500px;max-width:100%;" />
                <p class="description">Enter a Base64 encoded Subject Public Key Information (<a href="https://developer.mozilla.org/en-US/docs/Glossary/SPKI" target="_blank" rel="noopener">SPKI</a>) fingerprint.</p>
            </div>

            <div class="suboption" data-ns="headers.hpkp"<?php $visible('headers.hpkp'); ?>>
                <h5 class="h">&nbsp;pin-sha256 (backup)</h5>
                <input type="text" name="o10n[headers.hpkp.pin-sha256-backup]" value="<?php $value('headers.hpkp.pin-sha256-backup'); ?>" style="width:500px;max-width:100%;" />
                <p class="description">Enter a backup Base64 encoded Subject Public Key Information (<a href="https://developer.mozilla.org/en-US/docs/Glossary/SPKI" target="_blank" rel="noopener">SPKI</a>) fingerprint.</p>
            </div>

            <div class="suboption" data-ns="headers.hpkp"<?php $visible('headers.hpkp'); ?>>
                <label><input type="checkbox" name="o10n[headers.hpkp.includeSubdomains]" value="1"<?php $checked('headers.hpkp.includeSubdomains'); ?> /> Enable <code>includeSubdomains</code> to enforce the HPKP policy on subdomains.</p>
            </div>

            <div class="suboption" data-ns="headers.hpkp"<?php $visible('headers.hpkp'); ?>>
                <h5 class="h">&nbsp;Maximum Age</h5>
                <input type="number" name="o10n[headers.hpkp.max-age]" min="1" value="<?php $value('headers.hpkp.max-age'); ?>" style="width:120px;max-width:100%;" />
                <p class="description">Enter a time in seconds to cache the HPKP policy in the browser.</p>
            </div>

            <div class="suboption" data-ns="headers.hpkp"<?php $visible('headers.hpkp'); ?>>
                <h5 class="h">&nbsp;Report URI</h5>
                <input type="url" name="o10n[headers.hpkp.reportUri]" value="<?php $value('headers.hpkp.reportUri'); ?>" style="width:500px;max-width:100%;" />
                <p class="description">Enter an URL to send violation reports.</p>
            </div>

            <div class="info_yellow" data-ns="headers.hpkp"<?php $visible('headers.hpkp'); ?>><strong><span class="dashicons dashicons-lightbulb"></span></strong> Getting started? Read <a href="https://scotthelme.co.uk/hpkp-toolset/" target="_blank" rel="noopener">this article</a> by Scott Helme, founder of securityheaders.io. A HPKP generator is available on <a href="https://report-uri.io/home/tools" target="_blank" rel="noopener">report-uri.com</a>.</div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">X-Frame-Options</th>
        <td>
            
            <label><input type="checkbox" name="o10n[headers.x-frame-options.enabled]" data-json-ns="1" value="1"<?php $checked('headers.x-frame-options.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable X-Frame-Options HTTP header to control frames.</p>

            <div class="suboption" data-ns="headers.x-frame-options"<?php $visible('headers.x-frame-options'); ?>>
                <h5 class="h">&nbsp;Mode</h5>
                <select name="o10n[headers.x-frame-options.mode]" data-ns-change="headers.x-frame-options" data-json-default="<?php print esc_attr(json_encode('DENY')); ?>">
                    <option value="DENY"<?php $selected('headers.x-frame-options.mode', 'DENY'); ?>>DENY</option>
                    <option value="SAMEORIGIN"<?php $selected('headers.x-frame-options.mode', 'SAMEORIGIN'); ?>>SAMEORIGIN</option>
                    <option value="ALLOW-FROM"<?php $selected('headers.x-frame-options.mode', 'ALLOW-FROM'); ?>>ALLOW-FROM</option>
                </select>
                <div class="clear"></div>
            </div>

            <div class="suboption" data-ns="headers.x-frame-options"<?php $visible('headers.x-frame-options', ($get('headers.x-frame-options.mode') === 'ALLOW-FROM')); ?> data-ns-condition="headers.x-frame-options.mode==ALLOW-FROM">
                <h5 class="h">&nbsp;Allow from URL</h5>
                <input type="url" name="o10n[headers.x-frame-options.allowFrom]" value="<?php $value('headers.x-frame-options.allowFrom'); ?>" style="width:500px;max-width:100%;" />
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">X-XSS-Protection</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.x-xss-protection.enabled]" data-json-ns="1" value="1"<?php $checked('headers.x-xss-protection.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable X-XSS-Protection HTTP header to protect against XSS attacks.</p>

            <div class="suboption" data-ns="headers.x-xss-protection"<?php $visible('headers.x-xss-protection'); ?>>
                <h5 class="h">&nbsp;Mode</h5>
                <select name="o10n[headers.x-xss-protection.mode]" data-ns-change="headers.x-xss-protection" data-json-default="<?php print esc_attr(json_encode('block')); ?>">
                    <option value="0"<?php $selected('headers.x-xss-protection.mode', '0'); ?>>"0" (disabled)</option>
                    <option value="1"<?php $selected('headers.x-xss-protection.mode', '1'); ?>>"1" (enabled)</option>
                    <option value="block"<?php $selected('headers.x-xss-protection.mode', 'block'); ?>>"1; mode=block" (block rendering)</option>
                    <option value="report"<?php $selected('headers.x-xss-protection.mode', 'report'); ?>>"1; mode=report=..." (report violation)</option>
                </select>
                <div class="clear"></div>
            </div>

            <div class="suboption" data-ns="headers.x-xss-protection"<?php $visible('headers.x-xss-protection', ($get('headers.x-xss-protection.mode') === 'report')); ?> data-ns-condition="headers.x-xss-protection.mode==report">
                <h5 class="h">&nbsp;Report URI</h5>
                <input type="url" name="o10n[headers.x-xss-protection.reportUri]" value="<?php $value('headers.x-xss-protection.reportUri'); ?>" style="width:500px;max-width:100%;" />
                <p class="description">Enter an URL to send violation reports.</p>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">X-Content-Type-Options</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.x-content-type-options]" data-json-ns="1" value="1"<?php $checked('headers.x-content-type-options'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable X-Content-Type-Options <code>nosniff</code> HTTP header to disable MIME type sniffing.</p>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Referrer-Policy</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.referrer-policy.enabled]" data-json-ns="1" value="1"<?php $checked('headers.referrer-policy.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable Referrer-Policy HTTP header to control exposure of referrer information.</p>

            <div class="suboption" data-ns="headers.referrer-policy"<?php $visible('headers.referrer-policy'); ?>>
                <h5 class="h">&nbsp;Mode</h5>
                <select name="o10n[headers.referrer-policy.mode]" data-ns-change="headers.referrer-policy" data-json-default="<?php print esc_attr(json_encode('no-referrer')); ?>">
                    <option value="no-referrer"<?php $selected('headers.referrer-policy.mode', 'no-referrer'); ?>>no-referrer</option>
                    <option value="no-referrer-when-downgrade"<?php $selected('headers.referrer-policy.mode', 'no-referrer-when-downgrade'); ?>>no-referrer-when-downgrade</option>
                    <option value="origin"<?php $selected('headers.referrer-policy.mode', 'origin'); ?>>origin</option>
                    <option value="origin-when-cross-origin"<?php $selected('headers.referrer-policy.mode', 'origin-when-cross-origin'); ?>>origin-when-cross-origin</option>
                    <option value="same-origin"<?php $selected('headers.referrer-policy.mode', 'same-origin'); ?>>same-origin</option>
                    <option value="referrer-policy"<?php $selected('headers.referrer-policy.mode', 'referrer-policy'); ?>>referrer-policy</option>
                    <option value="strict-origin-when-cross-origin"<?php $selected('headers.referrer-policy.mode', 'strict-origin-when-cross-origin'); ?>>strict-origin-when-cross-origin</option>
                    <option value="unsafe-url"<?php $selected('headers.referrer-policy.mode', 'unsafe-url'); ?>>unsafe-url</option>
                </select>
                <div class="clear"></div>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">Expect-CT</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.expect-ct.enabled]" data-json-ns="1" value="1"<?php $checked('headers.expect-ct.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable Google's Certificate Transparency HTTP header to enforce SSL reliability.</p>


            <div class="suboption" data-ns="headers.expect-ct"<?php $visible('headers.expect-ct'); ?>>
                <label><input type="checkbox" name="o10n[headers.expect-ct.enforce]" value="1"<?php $checked('headers.expect-ct.enforce'); ?> /> Enable <code>enforce</code> mode.</p>
            </div>

            <div class="suboption" data-ns="headers.expect-ct"<?php $visible('headers.expect-ct'); ?>>
                <h5 class="h">&nbsp;Report URI</h5>
                <input type="url" name="o10n[headers.expect-ct.reportUri]" value="<?php $value('headers.expect-ct.reportUri'); ?>" style="width:500px;max-width:100%;" />
                <p class="description">Enter an URL to send violation reports.</p>
            </div>

            <div class="suboption" data-ns="headers.expect-ct"<?php $visible('expect-ct'); ?>>
                <h5 class="h">&nbsp;Maximum Age</h5>
                <input type="number" name="o10n[headers.expect-ct.max-age]" min="1" value="<?php $value('headers.expect-ct.max-age'); ?>" style="width:120px;max-width:100%;" />
                <p class="description">Enter a time in seconds to cache the Certificate Transparency policy in the browser.</p>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">X-DNS-Prefetch-Control</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.x-dns-prefetch-control]" data-json-ns="1" value="1"<?php $checked('headers.x-dns-prefetch-control'); ?>> Off</label>
            <p class="description" style="margin-bottom:1em;">Disable DNS prefetching.</p>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">X-Permitted-Cross-Domain-Policies</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.x-permitted-cross-domain-policies.enabled]" data-json-ns="1" value="1"<?php $checked('headers.x-permitted-cross-domain-policies.enabled'); ?>> Enable</label>
            <p class="description" style="margin-bottom:1em;">Enable cross-domain policy for Adobe Flash Player and Adobe Acrobat.</p>

            <div class="suboption" data-ns="headers.x-permitted-cross-domain-policies"<?php $visible('headers.x-permitted-cross-domain-policies'); ?>>
                <h5 class="h">&nbsp;Mode</h5>
                <select name="o10n[headers.x-permitted-cross-domain-policies.mode]" data-ns-change="headers.x-permitted-cross-domain-policies" data-json-default="<?php print esc_attr(json_encode('none')); ?>">
                    <option value="none"<?php $selected('headers.x-permitted-cross-domain-policies.mode', 'none'); ?>>none</option>
                    <option value="master-only"<?php $selected('headers.x-permitted-cross-domain-policies.mode', 'master-only'); ?>>master-only</option>
                    <option value="by-content-type"<?php $selected('headers.x-permitted-cross-domain-policies.mode', 'by-content-type'); ?>>by-content-type</option>
                    <option value="by-ftp-filename"<?php $selected('headers.x-permitted-cross-domain-policies.mode', 'by-ftp-filename'); ?>>by-ftp-filename</option>
                    <option value="all"<?php $selected('headers.x-permitted-cross-domain-policies.mode', 'all'); ?>>all</option>
                </select>
                <div class="clear"></div>
            </div>
        </td>
    </tr>
    <tr valign="top">
        <th scope="row">X-Powered-By</th>
        <td>
            <label><input type="checkbox" name="o10n[headers.x-powered-by]" data-json-ns="1" value="1"<?php $checked('headers.x-powered-by'); ?>> Remove</label>
            <p class="description" style="margin-bottom:1em;">Remove X-Powered-By header.</p>
            </div>
        </td>
    </tr>
    </table>
<hr />
<?php
    submit_button(__('Save'), 'primary large', 'is_submit', false);

// print form header
$this->form_end();
