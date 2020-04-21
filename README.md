# Url Shortener
This is a simple PHP application (Symfony 5) for test assignment.

## How to run
### Prerequisites
- PHP 7.4
- Composer
- Yarn
- Register at [MaxMind](https://maxmind.com) and get [MaxMind License key](https://support.maxmind.com/account-faq/license-keys/how-do-i-generate-a-license-key/) (for Docker) or [city database](https://dev.maxmind.com/geoip/geoip2/geolite2/) (for local)

### Docker
- `GEOIP_LICENSE=%YOUR_LICENSE% docker-compose up -d`  
- Wait for app initialization
- App starts  at `localhost:4250` (or `d.sh:4250`)

### Local 
- Get MaxMind License key: https://support.maxmind.com/account-faq/license-keys/how-do-i-generate-a-license-key/
- Configure browscap for PHP
- Create empty MySQL database
- Copy `.env` to `.env.local` and fill it with correct MySQL credentials and path to GeoIP database
- Install dependencies: `composer install`
- Build static: `yarn install --ignore-optional && yarn encore production`
- Configure nginx, example: `docker/nginx.conf`  
- Configure host: `127.0.0.1 u.sh` 
- Run doctrine migrations: `bin/console doctrine:migrations:migrate`
- Application url: `u.sh`

## Tests
Run tests command: `docker exec -it shortener-php vendor/bin/codecept run functional --coverage -d`

## Further improvements
- Increase code coverage by tests
- Sortable columns in stat
- Ajax requests
- Unique url for stat
- Replace ip parser and user-agent parser with better ones libraries
- Add translations
