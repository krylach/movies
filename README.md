## Use PHP >=8.0

# Installation

### Clone repository:
```bash
git clone https://github.com/krylach/movies
```

### Install dependies:
```bash
composer install
```

### Import database
##### be in the project directory (```https://github.com/krylach/movies/blob/main/test.sql ```)

### Setting database in configs
##### \configs\database.php (```https://github.com/krylach/movies/blob/main/configs/database.php```)

### !!! If run on unix:
#### create next dirs in the project dir:

```bash 
mkdir -m 755 tmp/
```
```bash 
mkdir -m 755 tmp/compile
```
```bash 
mkdir -m 755 tmp/cache
```
```bash 
mkdir -m 755 tmp/config
```


#

### Run application in the project dir:
```bash 
php -S localhost:9000
```