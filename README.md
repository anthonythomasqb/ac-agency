# My Movie Project

This project is a test project to list dynamically many movies.

## Running locally

### Prerequisites

In order to run the project locally, you need to :

1. Install [docker](https://docs.docker.com/engine/install/) and [docker-compose](https://docs.docker.com/compose/install/) on your computer.
2. Install [yarn](https://yarnpkg.com/getting-started/install) on your computer.

### Launch project locally

1. Create a `.env` file based on `.env.dist`

Make sure you have the value `mysql://root:root@mysql/ac-agency` for the `DATABASE_URL` parameter

2. Launch docker : `docker-compose up -d`
3. Create database : `docker-compose exec -T php bin/console d:s:u --force`
3. Load fake datas : `docker-compose exec -T php bin/console ac-agency:load:datas`

> When last command is launched these datas are loaded in database
> - 11 movies picked in [sens critique website](https://www.senscritique.com/films/tops/top100-des-top10)
> - 2 default users with same roles : anthomas63@gmail.com and contact@acwebagency.fr with password "test"