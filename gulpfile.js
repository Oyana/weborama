var elixir = require('laravel-elixir');

elixir(function(mix) {
    mix.sass('../../scss/style.scss')
       .webpack('../../js/script.js');
});
