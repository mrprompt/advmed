# AdvMed

[![Build Status](https://travis-ci.com/mrprompt/advmed.svg?token=wjVH7pqe9uFCdhpp6XdL&branch=master)](https://travis-ci.com/mrprompt/advmed)

Projeto Teste.

[![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/mrprompt/advmed/tree/master)

## Install

1 - Install dependencies

```console
composer.phar install
```

2 - Create database

```console
./bin/console doctrine:schema:create
```

## Running

```console
./bin/console server:start
```

## Stoping

```console
./bin/console server:stop
```

## Testing

1 - Create database structure

```console
DATABASE_URL="sqlite:///%kernel.project_dir%/var/test.db" ./bin/console doctrine:schema:create
```

2 - Run tests

```console
./bin/phpunit
```
