({
    appDir:'./',
    baseUrl: './modules/',
    dir:'../js',
    paths: {
        jquery: '../libs/jquery.min',
        underscore: '../libs/underscore-min',
        backbone: '../libs/backbone-min',
        autosuggest: '../libs/jquery.autocomplete.min'
    },
    modules:[{
        name:"./wms"
    }]
})