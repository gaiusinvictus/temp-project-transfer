const path = require('path');
module.exports = {
	entry: {
		'public': './src/scripts/public.js',
		'admin': './src/scripts/admin.js',
	},
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, 'assets' )
	},
	mode: "production",
	module : {
		rules : [
			{
				test: /.js$/,
				exclude: /(node_modules)/,
				use : {
					loader : 'babel-loader',
					options: {
						presets: [ "@wordpress/babel-preset-default" ]
					}
				}
			}
		]
	}
};