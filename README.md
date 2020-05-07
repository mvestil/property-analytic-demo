A property-analytic simple project demo :)

#### Requirements
- Docker (I used v2.2.*, but should work for future versions)

#### Installation
1. Clone this repository
2. Run `./setup.sh` in the root directory (builds Laradock containers with PHP7.3, Mysql, Nginx, etc.)
3. Grab a coffee
4. Visit http://localhost:90/

#### Post Installation
From the project root directory
1. Login to the workspace container via `cd laradock && docker-compose exec workspace bash`
2. Login to the  mysql container via `cd laradock && docker-compose exec mysql bash -c "mysql -u root -proot"`
    * DB name : archistar

#### Quirks
1. Logging - Centralized logging in app/Handler.php which supports logging of different types of severity 
    * Helps to make Controller/Service/Repository cleaner
2. API Authentication - Not fully implemented but added a middleware CustomAuthenticate.php (with comments) to show how it works


#### Tests
Includes
* Basic Feature Tests
* Basic Unit Tests

Run the test by executing `./runtest.sh`

#### Travis
Latest Build : https://travis-ci.org/github/mvestil/property-analytic-demo/jobs/684131230


