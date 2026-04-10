const path = require('path');

module.exports = {
  entry: './assets/src/js/main.js',
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'assets/dist/js'),
    clean: true
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  },
  mode: 'production'
};
