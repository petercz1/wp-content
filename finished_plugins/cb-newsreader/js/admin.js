(function($) {
  $(document).ready(doSetup);

  function doSetup() {
    console.log('adding js for newsreader');

    doSelect();
    $('#add').click(doAdd);
  }

  function doEdit() {
    var parent = $(this).parent().parent();
    var feed_name = parent.children('td:nth-child(1)');
    var feed_url = parent.children('td:nth-child(2)');
    var feed_qty = parent.children('td:nth-child(3)');
    var save_button = parent.children('td:nth-child(4)');
    feed_name.html("<input type='text' class='feed_name' value='" + feed_name.html() + "'/>");
    feed_url.html("<input type='text' class='feed_url' value='" + feed_url.html() + "'/>");
    feed_qty.html("<input type='text' class='feed_qty' value='" + feed_qty.html() + "'/>");
    save_button.html("<button class='button-primary save '>save</button>");
    $('.save').click(doSave);
  }

  function doSave() {
    var parent = $(this).parent().parent();
    var feed_name = parent.children('td:nth-child(1)');
    var feed_url = parent.children('td:nth-child(2)');
    var feed_qty = parent.children('td:nth-child(3)');
    var data = {
      'action': 'update',
      'row': parent.attr('name'),
      'feed_name': feed_name.children("input[type=text]").val(),
      'feed_url': feed_url.children("input[type=text]").val(),
      'feed_qty': feed_qty.children("input[type=text]").val(),
      'nonce': cb_newsfeeds.nonce
    };
    $.post(cb_newsfeeds.ajax_url, data, function(response) {
      console.log('save response: ' + response);
      doSelect();
    });
    var save_button = parent.children('td:nth-child(4)');
    feed_name.html(feed_name.children("input[type=text]").val());
    feed_url.html(feed_url.children("input[type=text]").val());
    feed_qty.html(feed_qty.children("input[type=text]").val());
    save_button.html("<button class='button-primary edit'>edit</button>");
    $('.edit').off().click(doEdit);
  }

  function doDelete() {
    var parent = $(this).parent().parent();
    var data = {
      'action': 'delete',
      'row': parent.attr('name'),
      'nonce': cb_newsfeeds.nonce
    };
    $.post(cb_newsfeeds.ajax_url, data, function(response) {
      console.log('js delete response: ' + response);
      doSelect();
    });
  }

  function doAdd() {
    var parent = $(this).parent().parent();
    var feed_name = parent.children('td:nth-child(1)');
    var feed_url = parent.children('td:nth-child(2)');
    var feed_qty = parent.children('td:nth-child(3)');

    var data = {
      'action': 'insert',
      'feed_name': feed_name.children("input[type=text]").val(),
      'feed_url': feed_url.children("input[type=text]").val(),
      'feed_qty': feed_qty.children("input[type=number]").val(),
      'nonce': cb_newsfeeds.nonce
    };
    $.post(cb_newsfeeds.ajax_url, data, function(response) {
      console.log('add response: ' + response);
      if (response == 'feed error') {
        $('#message').html('<h3>Oops - that feed doesn\'t look like it\'s working at the moment...</h3>');
      }
      doSelect();
    });
    feed_name.children("input[type=text]").val('');
    feed_url.children("input[type=text]").val('');
  }

  function doSelect(response) {
    console.log(response);
    var data = {
      'action': 'select',
      'nonce': cb_newsfeeds.nonce
    };
    $.post(cb_newsfeeds.ajax_url, data, build_table);
  }

  function build_table(response) {
    response = JSON.parse(response);
    var data_table = '';
    for (var row_counter = 0; row_counter < response.length; row_counter++) {
      data_table += '<tr name="' + response[row_counter].id + '" id="row_' + response[row_counter].id + '" class="ui-state-default">';
      data_table += '<td class="feed_name">' + response[row_counter].feed_name + '</td>';
      data_table += '<td class="feed_url">' + response[row_counter].feed_url + '</td>';
      data_table += '<td class="feed_qty">' + response[row_counter].feed_qty + '</td>';
      data_table += "<td><button class='button-primary edit'>edit</button></td>";
      data_table += "<td><button class='button-primary delete'>delete</button></td>";
      data_table += '</tr>';
    }
    $('#add_data').html(data_table);
    var sort_details = {
      axis: "y",
      placeholder: "ui-state-highlight",
      update: new_sort_order
    };
    $('#add_data').sortable(sort_details);
    $('.edit').click(doEdit);
    $('.delete').click(doDelete);
  }

  function new_sort_order(event, ui) {
    console.log('inside new sort order');
    var new_order = $(this).sortable('serialize');
    console.log(new_order);
    var data = {
      'action': 'reorder',
      'new_sort_order': new_order,
      'nonce': cb_newsfeeds.nonce
    };
    //$.post(cb_newsfeeds.ajax_url, data);
    $.post(cb_newsfeeds.ajax_url, data, doSelect);
  }
})(jQuery)
