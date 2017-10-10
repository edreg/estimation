# estimation
plain tool to estimate costs of developing packages

# installation

If composer is not installed, download composer.phar (https://getcomposer.org/download/) and run "php composer.phar install".
If node.js is not installed, download https://nodejs.org/en/download/ and install.

Steps to start:

* first initialize global npm packages
* * npm install gulp bower typings typescript -g

* install all dependencies
* * composer install (backend)
* * npm install (Do not forget global dependency)
* * bower install (frontend)
* * gulp ts-estimation-typings-concat (This compiles all typings into one file)
* * typings install (typescript definition (https://www.npmjs.com/package/typings))
* * gulp
