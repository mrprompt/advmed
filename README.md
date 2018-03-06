# AdvMed [![Deploy](https://www.herokucdn.com/deploy/button.svg)](https://heroku.com/deploy?template=https://github.com/mrprompt/advmed/tree/master)

[![Build Status](https://travis-ci.com/mrprompt/advmed.svg?token=wjVH7pqe9uFCdhpp6XdL&branch=master)](https://travis-ci.com/mrprompt/advmed)

Projeto Teste para [AdvMed](http://www.advmed.com.br/).

## Install

```console
composer.phar install
./bin/console doctrine:schema:create
./bin/console doctrine:fixtures:load
```

## Internal Server

```console
./bin/console server:start
./bin/console server:stop
```

## Testing

```console
DATABASE_URL="sqlite:///%kernel.project_dir%/var/test.db" ./bin/console doctrine:schema:create # only 1st time
./bin/phpunit
```
