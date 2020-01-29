const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const TerserPlugin = require('terser-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const autoprefixer = require('autoprefixer');

const config = require('./config.json');
const entryPoints = {
	'main': [
		'./assets/src/scss/style.scss',
		'./assets/src/public/main.js',
	],
	'admin': [
		'./assets/src/scss/admin.scss',
	],
	'blocks': [
		'./assets/src/scss/blocks.scss',
	],
	'carousel-slider': [
		'./assets/src/scss/carousel-slider.scss',
	],
	'customizer': [
		'./assets/src/scss/customizer.scss',
		'./assets/src/customize/background.js',
		'./assets/src/customize/color.js',
		'./assets/src/customize/radio-buttonset.js',
		'./assets/src/customize/radio-image.js',
		'./assets/src/customize/slider.js',
		'./assets/src/customize/toggle.js',
		'./assets/src/customize/typography.js',
	],
	'editor-style': [
		'./assets/src/scss/editor-style.scss',
	],
	'woocommerce': [
		'./assets/src/scss/woocommerce.scss',
	]
};

let plugins = [];

plugins.push(new MiniCssExtractPlugin({
	filename: "../css/[name].css"
}));

plugins.push(new BrowserSyncPlugin({
	proxy: config.proxyURL
}));

module.exports = (env, argv) => {
	let isDev = argv.mode !== 'production';
	return {
		"entry": entryPoints,
		"output": {
			"path": path.resolve(__dirname, './assets/js'),
			"filename": '[name].js'
		},
		"devtool": isDev ? 'eval-source-map' : false,
		"module": {
			"rules": [
				{
					"test": /\.js$/,
					"exclude": /node_modules/,
					"use": {
						"loader": "babel-loader",
						"options": {
							presets: ['@babel/preset-env']
						}
					}
				},
				{
					"test": /\.(sass|scss|css)$/,
					"use": [
						{
							loader: isDev ? "style-loader" : MiniCssExtractPlugin.loader
						},
						{
							loader: "css-loader",
							options: {
								sourceMap: isDev,
								importLoaders: 1
							}
						},
						{
							loader: "postcss-loader",
							options: {
								sourceMap: isDev,
								plugins: () => [autoprefixer()],
							},
						},
						{
							loader: "sass-loader",
							options: {
								sourceMap: isDev,
							},
						}
					]
				},
				{
					test: /\.svg/,
					use: {
						loader: 'svg-url-loader',
						options: {}
					}
				},
				{
					test: /\.(png|je?pg|gif|eot|ttf|woff|woff2)$/,
					use: [
						{
							loader: 'file-loader',
							options: {},
						},
					],
				},
			]
		},
		optimization: {
			minimizer: [
				new TerserPlugin(),
				new OptimizeCSSAssetsPlugin({})
			]
		},
		resolve: {
			modules: [
				path.resolve('./node_modules'),
				path.resolve(path.join(__dirname, 'assets/src/')),
			],
			extensions: ['*', '.js', '.vue', '.json']
		},
		"plugins": plugins
	}
};
