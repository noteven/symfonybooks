# Symfony Books
Book/Author API and dashboard utilizing Symfony 5 and PHP 8.1 in satisfaction of code challenge.

## Running
A docker-compose stack is provided for developer and end-user convenience.
```
docker-compose -d up
```
Then simply visit `localhost:8080`.

## Testing
```
composer install
./bin/phpunit --verbose tests
```

## Contributing
Execute `composer check` before pushing commits to run code-quality tools.
