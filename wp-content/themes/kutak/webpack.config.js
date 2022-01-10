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
 * @summary Webpack Configuration
 *
 */

const path = require("path");

const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyWebpackPlugin = require("copy-webpack-plugin");

/*
 * @ref : https://webpack.js.org/api/cli/#node-env
 */
const devMode = process.env.NODE_ENV !== "production";

module.exports = {
  target: "web",
  mode: devMode ? "development" : "production",
  entry: [
    path.resolve(__dirname, "src/index.js"),
    path.resolve(__dirname, "src/scss/main.scss"),
  ],
  devtool: false,
  output: {
    path: path.resolve(__dirname, "assets"),
    assetModuleFilename: "images/[name][ext]",
    filename: "bundle.js",
    clean: true,
  },
  module: {
    rules: [
      /**
       * No Module
       * Add Support for JS
       * Note: Babel loader is expensive
       */
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        exclude: /node_modules/,
        type: "asset", // need to discussion: `asset/resource` keeps the file in the assets folder, only `asset` keeps in resources folder and inline as well based on scenerio.
      },
      /**
       * Modules : npm i -D css-loader sass-loader node-sass postcss-loader  postcss-preset-env style-loader
       * Add Support for CSS, SASS, SCSS and CSS Minification (Production)
       */
      {
        test: /\.(s[ac]|c)ss$/i,
        use: [
          /**
           *  For production mode, use MiniCssExtractPlugin to extract CSS into a separate file.
           *  For development mode, use style-loader to inject CSS into the DOM.
           */
          {
            loader: devMode ? "style-loader" : MiniCssExtractPlugin.loader,
          },
          "css-loader",
          "postcss-loader",
          "sass-loader",
        ],
      },
      /**
       * No Module
       * Add Support for JS
       * Note: Babel loader is expensive
       */
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
        },
      },
      /**
       * Modules : npm i -D url-loader file-loader
       * Add Support for fonts
       */
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
        exclude: /node_modules/,
        use: [
          {
            loader: devMode ? "url-loader" : "file-loader",
            options: {
              name: "[name].[ext]",
              outputPath: "fonts/",
              publicPath: "../fonts/",
            },
          },
        ],
      },
    ],
  },
  plugins: [
    new CopyWebpackPlugin({
      patterns: [
        {
          from: path.resolve(__dirname, "src/images"),
          to: path.resolve(__dirname, "assets/images"),
        },
      ],
    }),
  ].concat(
    devMode
      ? []
      : [
          new MiniCssExtractPlugin({
            filename: "bundle.css",
          }),
        ]
  ),
  externals: {
    jquery: ["jQuery"],
  },
  devServer: {
    /*
     * @ref: https://webpack.js.org/configuration/dev-server/#devserver
     */
    open: devMode ? true : false, // open browser in a new tab
    liveReload: true, // enable live reload
    client: {
      logging: devMode ? "verbose" : "none",
      reconnect: false, // don't reconnect when disconnected
    },
    proxy: {
      "*": {
        target: "http://localhost:8080",
      },
    },
    port: "8081",
    static: [path.resolve(__dirname, "src"), path.resolve(__dirname, "assets")],
  },
};
