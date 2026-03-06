
const appConfig = {
    development_mode: true,
}

if(appConfig.development_mode) {
    appConfig.SERVER_URL = 'http://100.28.198.15'
    // appConfig.SERVER_URL = 'http://laravel-vue.test'
}

export default appConfig