/**
 *
 * @package surge
 * @version 2.0.0
 * @author Samiur Prapon
 * @link https://samiurprapon.github.io/
 *
 * @summary All surge default functionality using jQuery
 *
 */

const jQuery = require("jquery");

(function ($) {
  let SCREEN_WIDTH =
    window.innerWidth ||
    document.documentElement.clientWidth ||
    document.body.clientWidth;

  let SCREEN_HEIGHT =
    window.innerHeight ||
    document.documentElement.clientHeight ||
    document.body.clientHeight;

  /**
   * This will resize all youtube & vimeo videos in single.php file to make responsive by
   * changing the size ratio
   *
   * @type {*|HTMLElement}
   */

  if ($("body").hasClass("single") || $("body").hasClass("home")) {
    // Find all YouTube & Vimeo videos
    const $allVideos = $(
        ".entry-content iframe[src^='http://player.vimeo.com'], .entry-content iframe[src^='https://player.vimeo.com'], .entry-content iframe[src^='http://www.youtube.com'], .entry-content iframe[src^='https://www.youtube.com'], #video-popup iframe"
      ),
      // The element that is fluid width
      $fluidEl = $("#single .entry-content, #video-popup");

    // Figure out and save aspect ratio for each video
    $allVideos.each(function () {
      $(this)
        .data("aspectRatio", this.height / this.width)
        // and remove the hard coded width/height
        .removeAttr("height")
        .removeAttr("width");
    });
  }
})(jQuery);
