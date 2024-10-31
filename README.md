# SUIVI PROJET

<!-- [![Go Reference](https://pkg.go.dev/badge/github.com/hantsaniala/hStream.svg)](https://pkg.go.dev/github.com/hantsaniala/hStream) -->

A simple project management with Laravel

## Requirements

- php >= 8.1
- PostgreSQL

## Install

First clone the project with:

```sh
git git@github.com:VaniahNomenjanahary/SuiviProjet.git
```

Create you own postgresql database from given .env.example and insert baserevision.sql in your satabse

<!-- build docker & install all dependencies with:

```sh
docker compose build 
``` -->

install all dependencies
```sh
composer install
```

Then edit it to match your existing credentials.

## Run

<!-- You can run the project using docker compose:

```sh
docker compose up
``` -->

generate your JWTkey with
```sh
php artisan jwt:secret
```

then you can run your app with: 

```sh
php artisan serve
```

It will build necessary dependencies and run your app under http://localhost:800


To generate key necessary for the project, run:

## TODO

- [ ] Add guard in where it's necessary
- [ ] Add soft delete for task & user as unactive