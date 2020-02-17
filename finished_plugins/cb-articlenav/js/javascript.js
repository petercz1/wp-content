(function($) {

  var toc_options = cb_articlenav.toc_options;
  var scroll_down_distance = $.grep(toc_options, function(e) {
    return e.name == 'scroll_down_distance';
  });
  var return_scroll_distance = $.grep(toc_options, function(e) {
    return e.name == 'return_scroll_distance';
  });
  var scroll_speed = $.grep(toc_options, function(e) {
    return e.name == 'scroll_speed';
  });

  $(document).ready(doSetup);

  function doSetup() {
    console.log('adding client js for cb-articlenav');
    // toc_options = cb_articlenav.toc_options;
    $('a[href^="#articlenav_id_"], a[href="#cb-articlenav-container"]').click(smooth_scroll);
  }

  function smooth_scroll(click_event) {
    click_event.preventDefault();
    var target = $(this.hash);
    if (target.selector !== '#cb-articlenav-container') {
      $('html, body').animate({
        scrollTop: target.offset().top - scroll_down_distance[0].value * 16
      }, scroll_speed[0].value * 1000);
    } else {
      $('html, body').animate({
        scrollTop: target.offset().top - return_scroll_distance[0].value * 16
      }, scroll_speed[0].value * 1000);
    }
  }
})(jQuery)
