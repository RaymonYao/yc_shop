module.exports = {
    devServer: {
        proxy: {
            '/api': {
                target: 'http://my.ycshop.local',
                ws: true,
                changeOrigin: true
            },
        }
    },
    publicPath: './'
}