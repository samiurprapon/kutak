/**
 *
 * @package surge
 * @version 2.0.0
 * @author Samiur Prapon
 * @link https://samiurprapon.github.io/
 *
 * @ref https://api.jquery.com/
 * @ref http://es6-features.org/
 *
 * @summary All jQuery codes should be inside the following block
 *              but it has also support for ES6
 *
 */

const jQuery = require("jquery");

const devMode = process.env.NODE_ENV !== "production";

(function ($) {
  //default number of initial posts
  var latestOffset = $("#posts").data("offset");

  $("body").on("click", "#hamburger-menu", function () {
    if ($("nav").hasClass("search-active")) {
      $("nav").removeClass("search-active");
    }

    // change header background color
    if ($("nav").hasClass("hamburger-active")) {
      $(this).closest(".header-background").removeClass("white-background");
      $(this).closest(".header-background").addClass("smokey-background");
    } else {
      $(this).closest(".header-background").removeClass("smokey-background");
      $(this).closest(".header-background").addClass("white-background");
    }

    $("#hamburger-menu").toggleClass("active");
    $("nav").toggleClass("hamburger-active");
  });

  $("body").on("click", "#search-button", function () {
    if ($("nav").hasClass("hamburger-active")) {
      $("#hamburger-menu").removeClass("active");
      $("nav").removeClass("hamburger-active");
    }

    // change header background color
    if ($("nav").hasClass("search-active")) {
      $(this).closest(".header-background").removeClass("white-background");
      $(this).closest(".header-background").addClass("smokey-background");
    } else {
      $(this).closest(".header-background").removeClass("smokey-background");
      $(this).closest(".header-background").addClass("white-background");
    }

    $("nav").toggleClass("search-active");
  });

  $("body").on("click", "#latest-load-more", function () {
    let $this = $(this);

    // console.log("latestOffset", latestOffset);

    $this.addClass("loading");
    $this.find(".load").css({
      display: "inline-block",
    });

    //data set for ajax request
    var posts = {
      offset: latestOffset,
      action: "LOAD_MORE_LATEST_POSTS",
      security: surge.latest_load_more_nonce,
    };

    //make ajax request
    $.post(surge.ajax_url, posts, function (response) {
      let scrollFromTop = $(document).scrollTop();

      //append new posts
      $("#posts").append(response);

      $this.removeClass("loading");
      $this.find(".load").css({
        display: "none",
      });

      // total number of posts
      let totalPosts = $("#posts").data("total");

      console.log("totalPosts", totalPosts);

      // console.log("JQ: ", latestOffset);

      //update loaded posts count
      latestOffset += 3;

      if (totalPosts <= latestOffset) {
        $("#latest-load-more").hide();
      }

      $(document).scrollTop(scrollFromTop);
    });
  });
})(jQuery);
