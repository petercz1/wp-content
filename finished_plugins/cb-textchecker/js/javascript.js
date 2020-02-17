(function($) {
  $(document).ready(doSetup);

  function doSetup() {
    console.log('adding js for textchecker');

    doSelect();
    $('#add').click(doAdd);
  }

  function doEdit() {
    var parent = $(this).parent().parent();
    var find_text = parent.children('td:nth-child(1)');
    var replace_text = parent.children('td:nth-child(2)');
    var save_button = parent.children('td:nth-child(3)');
    find_text.html("<input type='text' class='find_text' value='" + find_text.html() + "'/>");
    replace_text.html("<input type='text' class='replace_text' value='" + replace_text.html() + "'/>");
    save_button.html("<button class='button-primary save '>save</button>");
    $('.save').click(doSave);
  }

  function doSave() {
    var parent = $(this).parent().parent();
    var find_text = parent.children('td:nth-child(1)');
    var replace_text = parent.children('td:nth-child(2)');
    var data = {
      'action': 'update',
      'row': parent.attr('name'),
      'find_text': find_text.children("input[type=text]").val(),
      'replace_text': replace_text.children("input[type=text]").val(),
      'nonce': cb_textcheck.nonce
    };
    $.post(cb_textcheck.ajax_url, data, function(response) {
      console.log('save response: ' + response);
      doSelect();
    });
    var save_button = parent.children('td:nth-child(3)');
    find_text.html(find_text.children("input[type=text]").val());
    replace_text.html(replace_text.children("input[type=text]").val());
    save_button.html("<button class='button-primary edit'>edit</button>");
    $('.edit').off().click(doEdit);
  }

  function doDelete() {
    var parent = $(this).parent().parent();
    var data = {
      'action': 'delete',
      'row': parent.attr('name'),
      'nonce': cb_textcheck.nonce
    };
    $.post(cb_textcheck.ajax_url, data, function(response) {
      console.log('js delete response: ' + response);
      doSelect();
    });
  }

  function doAdd() {
    var parent = $(this).parent().parent();
    var find_text = parent.children('td:nth-child(1)');
    var replace_text = parent.children('td:nth-child(2)');

    var data = {
      'action': 'insert',
      'find_text': find_text.children("input[type=text]").val(),
      'replace_text': replace_text.children("input[type=text]").val(),
      'nonce': cb_textcheck.nonce
    };
    $.post(cb_textcheck.ajax_url, data, function(response) {
      console.log('add response: ' + response);
      doSelect();
    });
    find_text.children("input[type=text]").val('');
    replace_text.children("input[type=text]").val('');
  }

  function doSelect() {
    var data = {
      'action': 'select',
      'nonce': cb_textcheck.nonce
    };
    $.post(cb_textcheck.ajax_url, data, build_table);
  }

  function build_table(response) {
    response = JSON.parse(response);
    var data_table = '';
    for (var row_counter = 0; row_counter < response.length; row_counter++) {
      data_table += '<tr name="' + response[row_counter].id + '">';
      data_table += '<td class="find_text">' + response[row_counter].find_text + '</td>';
      data_table += '<td class="replace_text">' + response[row_counter].replace_text + '</td>';
      data_table += "<td><button class='button-primary edit'>edit</button></td>";
      data_table += "<td><button class='button-primary delete'>delete</button></td>";
      data_table += '</tr>';
    }
    $('#add_data').html(data_table);
    $('.edit').click(doEdit);
    $('.delete').click(doDelete);
  }
})(jQuery)
