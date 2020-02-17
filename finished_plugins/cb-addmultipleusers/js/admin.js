(function($) {
  $(document).ready(doSetup);

  function doSetup() {
    get_users();
    $('#create_users').click(create_users);
  }

  function get_users() {
    var data = {
      'action': 'get_users',
    };
    $.post(cb_addbulkusers.ajax_url, data).done(get_users_success).fail(get_users_fail);
  }

  function get_users_success(data) {
    data = JSON.parse(data);
    console.log(data);
    $('#results tbody').html('');
    $.each(data, build_user_table);
    $('#results').tablesorter();

  }

  function build_user_table(i, user) {
    var tr = '<tr><td>';
    tr += user.display_name + '</td><td>';
    tr += user.login + '</td><td>';
    tr += user.roles[0] + '</td><td>';
    tr += user.email + '</td></tr>';
    $('#results tbody').append(tr);
  }

  function create_users() {
    var user_list = $('#user_list').val();
    var password_ext = $('#password_text').val();
    var wp_role = $('#wp_role').find(':selected').val();
    var force_password_change = $('input[name="force_password_change"]').val();
    var data = {
      'action': 'create_users',
      'cb_addbulkusers_userlist': user_list,
      'cb_wp_role': wp_role,
      'cb_password_ext': password_ext,
      'cb_force_password_change': force_password_change,
      'nonce': cb_addbulkusers.nonce
    };
    $.post(cb_addbulkusers.ajax_url, data).done(created_users).fail(create_users_fail);
  }

  function created_users(data) {
    data = JSON.parse(data);
    console.log(data);
    if(data){
      var error_message = 'Oops, these users exist: ';
      $.each(data, function(i, user){
        error_message += user.user + ' ';
      })
    $('#user_errors').append(error_message);
    }
    get_users();
  }

  function get_users_fail(data) {
    console.log('failed to get users - bummer...');
    console.log(data);
  }

  function create_users_fail(data) {
    console.log('inside create_users_fail');
    console.log(data);

  }
})(jQuery)
