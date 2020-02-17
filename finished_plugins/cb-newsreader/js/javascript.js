(function($) {
  var topic_html;
  $(document).ready(doSetup);

  function doSetup() {
    console.log('adding js for feeds');

    getAllFeeds();
  }

  function getAllFeeds() {
    var data = {
      'action': 'loadallfeeds'
    };
    $.post(newsfeed.ajax_url, data, processAllFeeds);
  }

  function processAllFeeds(feeds) {
    feeds = JSON.parse(feeds);
    console.log(feeds);

    $.each(feeds, getSingleFeed);
  }

  function getSingleFeed(index, singleFeed) {
    topic_html = '<div class="topic">';
    topic_html += '<h2>' + singleFeed.feed_name + '</h2>';
    topic_html += '<div class="topic-container" id="' + singleFeed.id + '">';
    topic_html += '</div></div>';
    $('#feeds-container').append(topic_html);
    var data = {
      'action': 'loadsinglefeed',
      'feed_id': singleFeed.id,
      'feed_url': singleFeed.feed_url,
      'feed_qty': singleFeed.feed_qty
    };
    $.post(newsfeed.ajax_url, data, processSingleFeed);
  }

  function processSingleFeed(singleFeed) {
    singleFeed = JSON.parse(singleFeed);
    if ( typeof singleFeed !== 'object') {
      console.log('blow up...');
      $('#' + parseInt(singleFeed)).append('<h3>Oops - doesn\'t look like this feed is working...</h3>');
      return;
    } else {
      $.each(singleFeed, processSingleStoryInFeed);
    }
  }

  function processSingleStoryInFeed(index, singleStory) {
    var item_html = '<div class="topic-item">';
    item_html += '<h3><a target="_blank" href="' + singleStory.url + '">' + singleStory.title + '</a> <span class="item-date">' + singleStory.date + '</span></h3>';
    item_html += '<div>';
    if (singleStory.thumbnail) {
      item_html += '<img class="item-thumbnail" src="' + singleStory.thumbnail + '">'
    }
    item_html += singleStory.description;
    item_html += '</div></div>';
    $('#' + singleStory.feed_id).append(item_html);
  }
})(jQuery)
