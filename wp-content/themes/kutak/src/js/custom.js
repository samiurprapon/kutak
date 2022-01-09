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
  $(window).on("load", function () {
    if (devMode) {
      console.log("Jquery is working in development mode");
    } 
  });
})(jQuery);
