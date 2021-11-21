const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require('terser-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const WebpackCleanPlugin = require('webpack-clean');
const svgToMiniDataURI = require('mini-svg-data-uri');
const combineMediaQuery = require('postcss-combine-media-query');

const config = require('./config.json');

module.exports = (env, argv) => {
	let isDev = argv.mode !== 'production';

	let plugins = [];

	plugins.push(new MiniCssExtractPlugin({
		filename: "../css/[name].css"
	}));

	plugins.push(new BrowserSyncPlugin({
		proxy: config.proxyURL
	}));

	plugins.push(new WebpackCleanPlugin(config.cleanFiles))

	let webpackConfig = {
		entry: config.entryPoints,
		output: {
			path: path.resolve(__dirname, './assets/js'),
			filename: '[name].js'
		},
		devtool: isDev ? 'eval-source-map' : false,
		module: {
			rules: [
				{
					test: /\.(js|jsx)$/i,
					use: {
						loader: "babel-loader",
						options: {
							presets: [
								'@babel/preset-env',
								'@babel/preset-react'
							],
							plugins: [
								['@babel/plugin-proposal-class-properties'],
								['@babel/plugin-proposal-private-methods'],
								['@babel/plugin-proposal-object-rest-spread'],
							]
						}
					}
				},
				{
					test: /\.(sass|scss|css)$/,
					use: [
						{
							loader: isDev ? "style-loader" : MiniCssExtractPlugin.loader,
							options: isDev ? {} : {publicPath: ''}
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
										['postcss-preset-env'],
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
								outputPath: (url, resourcePath) => {
									if (/@fortawesome\/fontawesome-free/.test(resourcePath)) {
										return `../fonts/${url}`;
									}
									return `../images/${url}`;
								},
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
				new CssMinimizerPlugin()
			]
		},
		resolve: {
			modules: [
				path.resolve('./node_modules'),
			],
			extensions: ['*', '.js', '.jsx', '.json']
		},
		plugins: plugins
	}

	// `jQuery`, `React`, `ReactDOM` will be loaded from WordPress
	webpackConfig.externals = {
		"jquery": "jQuery",
		"react": "React",
		"react-dom": "ReactDOM",
	}

	return webpackConfig;
};
