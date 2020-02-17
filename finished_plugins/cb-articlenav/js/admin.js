(function($) {
  $(document).ready(doSetup);

  function doSetup() {
    $('input[name="show_return_menu"]').click(toggle_nav_links);
    get_options();
    $('#save_settings').click(save_options);
  }

  function toggle_nav_links() {
    if ($('input[name="show_return_menu"]').is(':checked')) {

      $('input[name="return_text"], input[name="return_scroll"]').prop('disabled', false);
      $('.toggle_show').removeClass('gray_out');
    } else {
      $('input[name="return_text"], input[name="return_scroll"]').prop('disabled', true);
      $('.toggle_show').removeClass('gray_out').addClass('gray_out');
    }
  }

  function get_options() {
    var data = {
      'action': 'get_options',
      'nonce': cb_articlenav.nonce
    };
    $.post(cb_articlenav.ajax_url, data).done(get_success).fail(oops);
  }

  function get_success(data) {
    data = JSON.parse(data);
    console.log(data);
    $.each(data, function() {
      console.log(this.name + ': ' + this.value);
      if (this.name.checked) {
        console.log('checked!');;
      }
      $('[name="' + this.name + '"]').val(this.value);
      if (this.checked) {
        $('[name="' + this.name + '"]').prop('checked', true);
      }
    });
  }

  function save_options() {
    console.log('%cinside save_options', 'color:green; font-weight:bold;');
    var settings = [];
    $('#toc_settings').find(':input').each(function() {
      var elem_details = {};
      elem_details.name = $(this).attr('name');
      elem_details.value = $(this).val();
      if ($(this).prop('checked')) {
        elem_details.checked = true;
      }
      console.log(elem_details);
      settings.push(elem_details);
    });
    var data = {
      'action': 'save_options',
      'cb_toc_options': settings,
      'nonce': cb_articlenav.nonce
    };
    $.post(cb_articlenav.ajax_url, data ).done(save_success).fail(oops);
  }

  function save_success(data) {
    console.log('saving: ' + data);

    get_options();
  }

  function oops(data) {
    console.log('inside oops');
    console.log(data);
  }
})(jQuery)
