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
  $("body").on("click", "#hamburger-menu", function () {
    if ($("nav").hasClass("search-active")) {
      $("nav").removeClass("search-active");
    }

    $("#hamburger-menu").toggleClass("active");
    $("nav").toggleClass("hamburger-active");

    // change header background color
    $("nav").toggleClass("white-background");
  });

  $("body").on("click", "#search-button", function () {
    if ($("nav").hasClass("hamburger-active")) {
      $("#hamburger-menu").removeClass("active");
      $("nav").removeClass("hamburger-active");
    }

    $("nav").toggleClass("search-active");

    // change header background color
    $("nav").toggleClass("white-background");
  });

  $("body").on("click", "#latest-load-more", function () {
    let $this = $(this);

    //default number of initial posts
    var latestOffset = $("#posts").data("offset");
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
      $("#allPosts").append(response);

      $this.removeClass("loading");
      $this.find(".load").css({
        display: "none",
      });

      // total number of posts
      let totalPosts = $("#posts").data("total");

      console.log("totalPosts", totalPosts);

      // console.log("JQ: ", latestOffset);

      //update loaded posts count
      latestOffset += 6;

      if (totalPosts <= latestOffset) {
        $("#latest-load-more").hide();
      }

      $(document).scrollTop(scrollFromTop);
    });
  });

  $("body").on("click", "#archive-load-more", function () {
    let $this = $(this);

    //default number of initial posts
    var archiveOffset = $("#posts").data("offset");

    $this.addClass("loading");
    $this.find(".load").css({
      display: "inline-block",
    });

    let category = $("#posts").data("category");

    //data set for ajax request
    var posts = {
      offset: archiveOffset,
      action: "LOAD_MORE_ARCHIVE_POSTS",
      category: category,
      security: surge.archive_load_more_nonce,
    };

    //make ajax request
    $.post(surge.ajax_url, posts, function (response) {
      let scrollFromTop = $(document).scrollTop();

      //append new posts
      $("#allPosts").append(response);

      console.log("RESPONSE", response);

      $this.removeClass("loading");
      $this.find(".load").css({
        display: "none",
      });

      // total number of posts
      let totalPosts = $("#posts").data("total");

      // console.log("totalPosts", totalPosts);

      //update loaded posts count
      archiveOffset += 6;

      if (totalPosts <= archiveOffset) {
        $("#archive-load-more").hide();
      }

      $(document).scrollTop(scrollFromTop);
    });
  });
})(jQuery);
