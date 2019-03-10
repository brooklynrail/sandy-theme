// Primary Javascript file

var $ = jQuery;

var Sandy = {};

Sandy.lightbox_open = false;
Sandy.image_viewer_open = false;
Sandy.search = $('.menu-item-57');
Sandy.infiniteLastPage = false;

//
// Global Functions
//

Sandy.open_lightbox = function(){
  if(Sandy.lightbox_open === true){
    return;
  }
  Sandy.lightbox_open = true;

  var lightbox = '<div class="lightbox" style="opacity: 0;"><div class="lightbox-content"></div></div>';
  $('body').prepend(lightbox);
  $('body').addClass('lightbox-opening');
  $('.lightbox').transition({opacity: 1}, 600, 'snap', function(){
    $('body').addClass('lightbox-open');
  });

};

Sandy.close_lightbox = function(){
  if(Sandy.lightbox_open === false){
    return;
  }
  Sandy.lightbox_open = false;

  $('body').removeClass('lightbox-open lightbox-opening');
  $('.lightbox').remove();

  if(History.getState().data.state == 'lightbox'){
    History.back();
  }
};

Sandy.open_image_viewer = function(url){
  if(Sandy.image_viewer_open === true){
    return;
  }
  Sandy.image_viewer_open = true;

  var loader = '<h2 class="loader">Loading...</h2>';
  var image_viewer = '<div class="image-viewer" style="opacity: 0;">' + loader + '<div class="close-button"></div><div class="image-viewer-content"></div></div>';
  $('body').prepend(image_viewer);
  $('.image-viewer').transition({opacity: 1}, 600, 'snap', function(){
    var image = '<img src="' + url + '">';
    $('.image-viewer-content').html(image);
    $('body').addClass('image-viewer-open');
  });
  $('.image-viewer').imagesLoaded(function(){
    $('.image-viewer .loader').remove();
  });
};

Sandy.close_image_viewer = function(){
  if(Sandy.image_viewer_open === false){
    return;
  }
  Sandy.image_viewer_open = false;

  $('body').removeClass('image-viewer-open');
  $('.image-viewer').remove();
};

Sandy.open_search = function(){
  if(Sandy.search_open === true){
    return;
  }
  Sandy.search_open = true;

  var search = $('.search-wrapper');
  search.css({height: 'auto'});

  var height = search.height();

  Sandy.search.addClass('active');
  search.css({height: 0}).show();
  search.transition({height: height}, function(){
    $('#search-input').focus();
  });
};

Sandy.close_search = function(){
  if(Sandy.search_open === false){
    return;
  }
  Sandy.search_open = false;

  var search = $('.search-wrapper');

  Sandy.search.removeClass('active');
  search.transition({height: 0}, function(){
    search.hide();
  });
};

//
// On document ready
//

$(function(){

  // History.js event listeners
  History.Adapter.bind(window, 'statechange', function(){
    var state = History.getState();

    // Listen to the History state to check if lightbox is ever open when the History state is not equal to lightbox.
    // This is likely because the lightbox was opened and the back button was used, in which case we should close lightbox.
    if(state.data.state != 'lightbox' && Sandy.lightbox_open === true){
      Sandy.close_lightbox();
      Sandy.close_image_viewer();
    }

    // Then, listen for the opposite case: the History state is equal to lightbox, but the lightbox isn't open.
    // In this case open the lightbox and ajax the post from the current URL that was remembered in History.
    if(state.data.state == 'lightbox' && Sandy.lightbox_open === false){
      Sandy.open_lightbox();
      var url = window.location.href;
      $('.lightbox-content').html(loader).load(url + ' #wrapper', function(){
        $.event.trigger({ type: 'lightbox_load' });
      });
    }
  });

  // Load post via ajax when brick is clicked
  var loader = '<h2 class="loader">Loading...</h2>';

  $(document).on('click', 'a[data-essay="true"]', function(e){
    e.preventDefault();
    Sandy.open_lightbox();
    var url = $(this).attr('href');
    History.pushState({state: 'lightbox'}, null, url);
    $('.lightbox-content').html(loader).load(url + ' #wrapper', function(){
      $.event.trigger({ type: 'lightbox_load' });
    });
  });

  // Close Lightbox
  $(document).on('click', '.lightbox .close-button', function(e){
    e.preventDefault();
    Sandy.close_lightbox();
  });

  $(document).on('click', '.image-viewer, .image-viewer .close-button', function(e){
    e.preventDefault();
    Sandy.close_image_viewer();
  });

  $(document).keyup(function(e){
    if(e.keyCode == 27){
      if(Sandy.image_viewer_open === true){
        Sandy.close_image_viewer();
      } else {
        if(Sandy.lightbox_open === true){
          Sandy.close_lightbox();
        }
      }
    }
  });

  // Image viewer lightbox
  $(document).on('click', '.single-image a, .two-images a', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    Sandy.open_image_viewer(url);
  });

  // Search

  Sandy.search.click(function(e){
    e.preventDefault();
    Sandy.open_search();
  });

  $('.search-close').click(function(){
    Sandy.close_search();
  });

  // Artist index sorting

  $('.index-header .column span').click(function(){
    var filter = $(this).closest('.column').attr('data-filter');

    // Toggle ASC / DESC order with active class
    if($(this).closest('.column').hasClass('active')){
      $('.index-row').tsort(filter, {order:'desc'});
    } else {
      $('.index-row').tsort(filter);
    }

    $('.index-header .column').removeClass('show-bullet');
    $(this).closest('.column').addClass('show-bullet').toggleClass('active');
    $('.index-header .column').not($(this).closest('.column')).removeClass('active');
  });

});

//
// Event listeners, Window resize
//

(function() {
  function ready_and_resize(){
    // Sandy.bricklayer();
  }

  $(window).on('resize', ready_and_resize);
  $(document).on('ready', ready_and_resize);
})();

Sandy.paged = $('.next-post-link a').attr('href');
if(Sandy.paged){
  Sandy.paged = $('.next-post-link a').attr('href').match(/\/\d+/)[0];
  Sandy.paged = parseInt( Sandy.paged.substring(2, Sandy.paged.length - 1) );
}

Sandy.loadingPost = false;

var infiniteScroll = debounce(function() {
  if(!$('body.home').length || !$('.next-post-link a').attr('href')){
    return;
  }
  var st = $(this).scrollTop();
  var docHeight = $(document).height();
  var winHeight = $(window).height();
  var loader = '<h2 class="loader loader-static">Loading...</h2>';
  var url = $('.next-post-link a').attr('href');
  url = url.replace(/\/\d+/, '/' + Sandy.paged);

  if(docHeight - winHeight - st < 500 && Sandy.infiniteLastPage === false && Sandy.loadingPost === false){
    $('.brick-wrapper').append(loader);
    Sandy.loadingPost = true;
    $('<div>').load(url, function() {
      if($(this).find('.brick-wrapper .brick').length === 0){
        Sandy.infiniteLastPage = true;
      }
      $('.brick-wrapper').append($(this).find('.brick-wrapper').html());
      $('.brick-wrapper .loader').remove();
      Sandy.paged++;
      Sandy.loadingPost = false;
    });
  }
}, 200);

window.addEventListener('scroll', infiniteScroll);

function debounce(func, wait, immediate) {
  var timeout;
  return function() {
    var context = this, args = arguments;
    var later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    var callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}
