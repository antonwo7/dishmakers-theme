const b4pConf = {
    LocalhostUrl: 'http://localhost/drbronner',
    PATH: {
        src: './src',
        prod: './production',
    },
    sassInclude: [
        './node_modules/bootstrap/scss',
        // './node_modules/@goldenplanet/fontawesome-pro/web-fonts-with-css/scss',
        './node_modules/owl.carousel/src/scss',
        // './node_modules/fancybox/dist/scss',
        // './node_modules/summernote/src/less'
    ],
    prefixBrowser: ['last 2 versions', 'ie >= 9', 'ios >= 7']
}

module.exports = b4pConf;
