<?php
namespace chipbug\basic\ajax;

/*
 *
 */
function WP_ajax_adminpage()
{
    error_log('loading admin page');
    $html = '<div class="wrap">';
    $html .= '<h2>WP WordPress AJAX Tester</h2><br />';
    $html .= '<table id="WP-ajax-table">
    <thead class="stuff">
      <tr>
        <th>Option ID</th>
        <th>Option Name</th>
        <th>Option Value</th>
        <th>Autoload</th>
      </tr>
    </thead>
    <tbody>';
    $html .= '</tbody></table>';
    $html .= '<input type="text" size="4" id="WP-ajax-option-id" />';
    $html .= '<button id="WP-ajax-button">Get Option</button>';
    $html .= '</div>';
    echo $html;
}
