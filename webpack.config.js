const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const TerserPlugin = require('terser-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const WebpackCleanPlugin = require('webpack-clean');
const svgToMiniDataURI = require('mini-svg-data-uri');
const combineMediaQuery = require('postcss-combine-media-query');

const config = require('./config.json');

let plugins = [];

plugins.push(new MiniCssExtractPlugin({
	filename: "../css/[name].css"
}));

plugins.push(new BrowserSyncPlugin({
	proxy: config.proxyURL
}));

plugins.push(new WebpackCleanPlugin(config.cleanFiles))

module.exports = (env, argv) => {
	let isDev = argv.mode !== 'production';
	return {
		"entry": config.entryPoints,
		"output": {
			"path": path.resolve(__dirname, './assets/js'),
			"filename": '[name].js'
		},
		"devtool": isDev ? 'eval-source-map' : false,
		"module": {
			"rules": [
				{
					"test": /\.js$/,
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
								postcssOptions: {
									plugins: [
										'postcss-preset-env',
										combineMediaQuery(),
									],
								},
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
					test: /\.(eot|ttf|woff|woff2)$/i,
					use: [
						{
							loader: 'file-loader',
							options: {
								outputPath: '../fonts',
							},
						},
					],
				},
				{
					test: /\.(png|je?pg|gif)$/i,
					use: [
						{
							loader: 'url-loader',
							options: {
								limit: 8192, // 8KB
								outputPath: '../images',
							},
						},
					],
				},
				{
					test: /\.svg$/i,
					use: [
						{
							loader: 'url-loader',
							options: {
								limit: 20480, // 20KB
								outputPath: '../images',
								generator: (content) => svgToMiniDataURI(content.toString()),
							},
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
