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

  $("body").on("click", "#feature-1", function () {
    // tab click
    $("#feature-2").removeClass("is-active");
    $("#feature-1").addClass("is-active");

    // change sidebar content
  });

  $("body").on("click", "#feature-2", function () {
    // tab click
    $("#feature-1").removeClass("is-active");
    $("#feature-2").addClass("is-active");

    // change sidebar content
  });

  var filterFlag = true;
  $("body").on("click", "#filter [class*=dropdown-menu-] .items", function () {
    $("#filter ul").hide();

    if (filterFlag) {
      $(this).parent().find("ul").show();
      filterFlag = false;
    } else {
      $(this).parent().find("ul").hide();
      filterFlag = true;
    }
  });

  $("body").on("click", "#filter [class*=dropdown-menu] ul", function () {
    //post data object
    let postData = {
      action: "SURGE_FILTERED_CONTENT",
      filter: {
        category: $("#filter .dropdown-menu-1 .item-name").data("name"),
        tags: $("#filter .dropdown-menu-2 .item-name").data("name"),
      },
      security: surge.surge_filtered_content,
    };

    //post the data to admin-ajax.php file
    $.post(surge.ajax_url, postData, function (response) {
      //set the filter
      let filter =
        "category=" +
        $("#filter .dropdown-menu-1 .item-name").data("name") +
        "&tag=" +
        $("#filter .dropdown-menu-2 .item-name").data("name");
      $("#posts").attr("data-filter", filter);

      let total = $("#posts").data("total");
      var Offset = $("#posts").data("offset");

      //update the total
      $("#filtered-articles #posts").attr("data-total", total);

      //check if no content found
      setTimeout(function () {
        if (parseInt(total) === 0) {
          $("#posts")
            .append(
              '<div class="col-md-12 text-center"><h2>Nothing found for this criteria.</h2></div>'
            )
            .fadeIn();
        }
      }, 100);

      if (total) {
        if (total < Offset) {
          $("#latest-load-more").hide();
        } else {
          $("#latest-load-more").show();
        }
      }
      //append new posts
      $("#posts").html(response);
    });
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
