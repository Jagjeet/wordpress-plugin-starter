const webpack = require('webpack'); 
const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

// Constant with our paths
const paths = {
    DIST: path.resolve(__dirname, 'dist'),
    JS: path.resolve(__dirname, 'js'),
  };
  
// Webpack configuration
module.exports = {
  entry: path.join(paths.JS, 'wordpress-plugin-starter.js'),
  output: {
    path: paths.DIST,
    filename: 'wordpress-plugin-starter.bundle.js'
  },

  plugins: [
    //See BrowserSync proxying for wordpress post for more details
    //https://matmunn.me/post/webpack-browsersync-php/
    new BrowserSyncPlugin(
      {
          proxy: 'http://localhost:8888/',
          files: [
              {
                  match: [
                      '**/*.php',
                      '**/*.js'
                  ],
                  fn: function(event, file) {
                      if (event === "change") {
                          const bs = require('browser-sync').get('bs-webpack-plugin');
                          bs.reload();
                      }
                  }
              }
          ]
      },
      {
          reload: false
      })
  ],

  // We are telling webpack to use "babel-loader" for .js and .jsx files
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: [
          'babel-loader',
        ],
      },
    ],
  },
  // Enable importing JS files without specifying their's extenstion
  //
  // So we can write:
  // import MyComponent from './my-component';
  //
  // Instead of:
  // import MyComponent from './my-component.jsx';
  resolve: {
    extensions: ['.js', '.jsx'],
  }, 
  devServer: {
      proxy: {
          '/': {
              target: {
                  host: "localhost",
                  protocol: "http:",
                  port: 8888
              },
              changeOrigin: true,
              secure: false
          }
      }
  }
};
