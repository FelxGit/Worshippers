
const appConfig = {
    development_mode: true,
}

if(appConfig.development_mode) {
    appConfig.SERVER_URL = process.env.APP_URL
    // appConfig.SERVER_URL = 'http://laravel-vue.test'
}

export default appConfig