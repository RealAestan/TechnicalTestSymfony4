const Encore = require('@symfony/webpack-encore');

Encore
	.setOutputPath('public/build/')
	.setPublicPath('/build')
	.cleanupOutputBeforeBuild()
	.autoProvidejQuery()
	.enableTypeScriptLoader()
	.enableSassLoader()
	.enableVersioning()
	.addEntry('js/app', './assets/ts/app.ts')
	.addStyleEntry('css/app', ['./assets/scss/app.scss'])
	.splitEntryChunks()
	.enableSingleRuntimeChunk()
;

module.exports = Encore.getWebpackConfig();