# Recruitment backend task2


## how to run

1) `docker compose up -d --build --force-recreate`
2) `docker compose exec php-fpm bash -c "composer install"`
3) `docker-compose exec php-fpm bash -c "make install-database"`

or simply 

`make`


## Commands

To run generating summary posts we need run

```shell
docker compose exec php-fpm exec php app:generate-summary-post
```


To set up cron on 12pm use this to you crontab

```
59 23 * * * docker compose exec php-fpm exec php app:generate-summary-post
```
