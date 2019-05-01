# Sage*
[![devDependency Status](https://david-dm.org/pmbcom/sage.svg?style=flat-square)](https://david-dm.org/pmbcom/sage)
[![Build Status](https://img.shields.io/travis/pmbcom/sage.svg?style=flat-square)](https://travis-ci.org/pmbcom/sage)

Sage is a WordPress starter theme with a modern development workflow developed by [Roots](https://roots.io/).

Sage* is a fork of original theme intended to meet our own need.

## Differences from Sage 9

* [Laravel Mix](https://laravel-mix.com/) for compiling assets, concatenating and minifying files
* [Tailwind CSS 1.0.0-beta.5](https://next.tailwindcss.com/) as an utility CSS framework
* Resources folder matching [Laravel 5.8](https://www.laravel.com) structure


## Features

* Sass for stylesheets
* Modern JavaScript
* [Webpack](https://webpack.github.io/) for compiling assets, optimizing images, and concatenating and minifying files
* [Browsersync](http://www.browsersync.io/) for synchronized browser testing
* [Blade](https://laravel.com/docs/5.6/blade) as a templating engine
* [Controller](https://github.com/soberwp/controller) for passing data to Blade templates
* CSS framework (optional): [Bootstrap 4](https://getbootstrap.com/), [Bulma](https://bulma.io/), [Foundation](https://foundation.zurb.com/), [Tachyons](http://tachyons.io/), [Tailwind](https://tailwindcss.com/)

See a working example at [roots-example-project.com](https://roots-example-project.com/).

## Requirements

Make sure all dependencies have been installed before moving on:

* [WordPress](https://wordpress.org/) >= 4.7
* [PHP](https://secure.php.net/manual/en/install.php) >= 7.1.3 (with [`php-mbstring`](https://secure.php.net/manual/en/book.mbstring.php) enabled)
* [Composer](https://getcomposer.org/download/)
* [Node.js](http://nodejs.org/) >= 8.0.0
* [Yarn](https://yarnpkg.com/en/docs/install)

## Theme installation

Install Sage* using Composer from your WordPress themes directory (replace `your-theme-name` below with the name of your theme):

```shell
$ composer create-project pmbcom/sage your-theme-name
```

## Theme structure

```shell
themes/your-theme-name/   # → Root of your Sage based theme
├── app/                  # → Theme PHP
│   ├── Controllers/      # → Controller files
│   ├── admin.php         # → Theme customizer setup
│   ├── filters.php       # → Theme filters
│   ├── helpers.php       # → Helper functions
│   └── setup.php         # → Theme setup
├── composer.json         # → Autoloading for `app/` files
├── composer.lock         # → Composer lock file (never edit)
├── public/               # → Built theme assets (never edit)
├── node_modules/         # → Node.js packages (never edit)
├── package.json          # → Node.js dependencies and scripts
├── resources/            # → Theme assets and templates
│   │   fonts/            # → Theme fonts
│   │   images/           # → Theme images
│   │   js/               # → Theme JS
│   │   sass/             # → Theme stylesheets
│   ├── functions.php     # → Composer autoloader, theme includes
│   ├── index.php         # → Never manually edit
│   ├── screenshot.png    # → Theme screenshot for WP admin
│   ├── style.css         # → Theme meta information
│   └── views/            # → Theme templates
│       ├── layouts/      # → Base templates
│       └── partials/     # → Partial templates
└── vendor/               # → Composer packages (never edit)
```

## Theme setup

Edit `app/setup.php` to enable or disable theme features, setup navigation menus, post thumbnail sizes, and sidebars.

## Theme development

* Run `yarn` from the theme directory to install dependencies
* Update `webpack.mix.js` settings:

### Build commands

* `yarn watch` — Compile assets when file changes are made, start Browsersync session
* `yarn dev` — Compile and optimize the files in your assets directory
* `yarn production` — Compile assets for production

## Documentation

* [Sage documentation](https://roots.io/sage/docs/)
* [Controller documentation](https://github.com/soberwp/controller#usage)
