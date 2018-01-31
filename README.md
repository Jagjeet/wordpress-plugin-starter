# WordPress Plugin Starter README

## About

This project is a starter project for building WordPress Plugins. It is motivated by having more modern tool availability for WordPress development. This includes:

* Using VS Code as development/debug environment
* Debugging in JavaScript or PHP (using XDebug)
* ESLint config file for linting JavaScript
* WebPack for most of your modern programming needs
* Hot reloading accomplished using webpack-dev-server and BrowserSync proxied as described [here](https://matmunn.me/post/webpack-browsersync-php/)

It is usable as is, but is still a work in progress.

## To Do

The big outstanding tasks for this are:

* Add Minifying
* Add production build
* Add React boilerplate?
* Add Jest support and/or PHP Unit support?

## Installation

Clone the repo.

To install for development run the following:

 1. Install npm dependencies by running the following command:
    * 'yarn install'
 2. Install php dependencies using composer:
    * 'composer install'
 3. Install VS Code and the following plugins:
    * ESLint
    * PHP Debug (Requires setting up XDebug if not already installed)
    * PHP IntelliSense
    * phpcs
 4. Verify PHP and JS debugging works by attempting to set breakpoints in each.
 5. Start to customize for your own needs!