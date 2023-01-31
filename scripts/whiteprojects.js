$(document).ready(function() {
  functions.hookHover();
  functions.setToggleMore();
  functions.setImageView();
  functions.changeEmail();
  functions.animateIndex();
});


// ネームスペース
function functions() {}

//GETリクエストを取得
functions.getRequest = function(){
  if(location.search.length > 1) {
    var get = new Object();
    var ret = location.search.substr(1).split("&");
    for(var i = 0; i < ret.length; i++) {
      var r = ret[i].split("=");
      get[r[0]] = r[1];
    }
    return get;
  } else {
    return false;
  }
}


functions.changeEmail = function(){
  $('span.email').each(function(){
    $(this).text($(this).text().replace('_at_', '@'));
  });
}


//リンク画像のマウスオーバー
functions.hookHover = function () {
  $('dl.content-navigation dd ul li a.hover').each(function(){
    var originalSrc = $(this).children('img').attr('src');
    if ($(this).hasClass('current')) {
      var currentSrc = originalSrc.split('.');
      currentSrc[currentSrc.length - 2] = currentSrc[currentSrc.length - 2] + '_c';
      currentSrc = currentSrc.join('.');
      $(this).children('img').attr('src', currentSrc);
    } else {
      var hoverSrc = originalSrc.split('.');
      hoverSrc[hoverSrc.length - 2] = hoverSrc[hoverSrc.length - 2] + '_o';
      hoverSrc = hoverSrc.join('.');
      $(this).hover(function(){
        $(this).children('img').attr('src', hoverSrc);
      }, function(){
        $(this).children('img').attr('src', originalSrc);
      });
      $('<img src="' + hoverSrc + '" />');
    }
  });

  $('a').each(function(){
    if (!$(this).hasClass('hover') && $(this).children('img').length) {
      $(this).hover(function(){
        $(this).fadeTo(0, 0.75);
      }, function(){
        $(this).fadeTo(0, 1);
      });
    }
  });
}


// トップページのアニメーション
functions.animateIndex = function(){
  if ($('body').hasClass('index')) {
    $('div#header h1').css('opacity', '0');
    $(window).load(function() {
      setTimeout(function(){
        $('div#header h1').css('opacity', '1').hide().fadeIn(1000);
      }, 1000);
      setTimeout(function(){
        $('div#main_image img.slide-in').fadeIn(1000);
      }, 2500);
    });
  }
}


// MOREで詳細を開く
functions.setToggleMore = function(){
  $('div.schedule').each(function(){
    var contentBox = $(this).children('div.content');
    if (!contentBox.length) {
      return;
    }
    var moreButton = $(this).children('div.buttons').children('a.more');
    var closeButton = $(this).children('div.buttons').children('a.close');
    contentBox.hide();
    closeButton.hide();
    moreButton.click(function(event){
      event.preventDefault();
      closeButton.show();
      moreButton.hide();
      contentBox.slideDown(150);
    });
    closeButton.click(function(event){
      event.preventDefault();
      contentBox.hide();
      closeButton.hide();
      moreButton.show();
    });
  });
}


// サムネールクリックでメイン画像の切り替え
functions.setImageView = function(){
  $('body.shiro div.shiro').each(function(){
    var largeImage = $(this).children('div.large-image').children('img');
    var thumbnails = $(this).children('ul.images').children('li').children('a');
    //thumbnails.eq(0).parent('li').fadeTo(0, 0.5);
    largeImage.attr('src', thumbnails.eq(0).attr('href'));
    thumbnails.click(function(event){
      event.preventDefault();
      largeImage.attr('src', $(this).attr('href'));
/*
      thumbnails.parent('li').fadeTo(0, 1);
      $(this).parent('li').fadeTo(0, 0.5);
    }).hover(function(){
      $(this).parent('li').fadeTo(0, 0.75);
    }, function(){
      if (largeImage.attr('src') != $(this).attr('href')) {
        $(this).parent('li').fadeTo(0, 1);
      }
*/
    });
  });
}
