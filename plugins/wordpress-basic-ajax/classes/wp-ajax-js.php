<?php
namespace chipbug\basic\ajax;

/*
 * The JavaScript for our AJAX call
 */
class WP_Ajax_Js
{
    public function init()
    {
        ?>
<script type="text/javascript">
	console.log('ready...');
	jQuery(document).ready(function($) {

		$('#WP-ajax-button').click(function() {
			var id = $('#WP-ajax-option-id').val();
			$.ajax({
					method: "POST",
					url: ajaxurl,
					data: {
						'action': 'WP_ajax_handler',
						'id': id
					}
				})
				.done(function(data) {
					console.log('Successful AJAX Call! /// Return Data: ' + data);
					data = JSON.parse(data);
					$('#WP-ajax-table').append('<tr><td>' + data.option_id + '</td><td>' + data
						.option_name + '</td><td>' + data.option_value + '</td><td>' + data
						.autoload + '</td></tr>');
				})
				.fail(function(data) {
					console.log('Failed AJAX Call :( /// Return Data: ' + data);
				});
		});

	});
</script>
<?php
    }
}
