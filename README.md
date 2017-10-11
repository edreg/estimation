# Estimation

Tiny tool to compare different approaches for estimating costs of developing packages.

# Implemented so far
 
* Simple average: (optimistic + realistic + pessimistic) / 3
* PERT: (optimistic + 4 * realistic + pessimistic) / 6
* 3P with probability and an uncertainty factor: please look up the formula inside the code (path/to/estimation/module/Estimation/Helper/EstimationHelper.php)

# Dependencies

* slim framework, composer, node.js, bower, gulp, typescript
    
# Installation

1. If composer is not installed, download composer.phar (https://getcomposer.org/download/) and run "php composer.phar install".

2. If node.js is not installed, download https://nodejs.org/en/download/ and install.

3. Initialize global npm packages
    * npm install gulp bower typings typescript -g

4. Install all dependencies
    * composer install (backend)
    * npm install (do not forget global dependency)
    * bower install (frontend)
    * gulp ts-estimation-typings-concat (This compiles all typings into one file)
    * typings install (typescript definition (https://www.npmjs.com/package/typings))
    * gulp

# To be done

* Local configurations in estimation/config 
* Maybe a database connection
* Documentation on how to add another estimation approach 
* bower migration to yarn?
* remove code smell