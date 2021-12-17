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
					test: /\.tsx?$/,
					loader: 'ts-loader',
					exclude: /node_modules/,
				},
				{
					test: /\.(js|jsx)$/i,
					use: {
						loader: "babel-loader",
					}
				},
				{
					test: /\.(sass|scss|css)$/,
					use: [
						{
							loader: MiniCssExtractPlugin.loader,
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
					type: 'asset/resource',
					generator: {
						filename: '../fonts/[hash][ext]'
					}
				},
				{
					test: /\.(png|je?pg|gif)$/i,
					type: 'asset',
					generator: {
						filename: '../images/[hash][ext]'
					}
				},
				{
					test: /\.svg$/i,
					type: 'asset',
					generator: {
						filename: '../images/[hash][ext]',
						dataUrl: content => svgToMiniDataURI(content.toString())
					},
				}
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
