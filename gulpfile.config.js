const b4pConf = {
    LocalhostUrl: 'http://dishmakers.loc/',
    PATH: {
        src: './src',
        prod: './production',
    },
    sassInclude: [
        './node_modules/bootstrap/scss',
        './node_modules/owl.carousel/src/scss',
    ],
    prefixBrowser: ['last 2 versions', 'ie >= 9', 'ios >= 7']
}

module.exports = b4pConf;
