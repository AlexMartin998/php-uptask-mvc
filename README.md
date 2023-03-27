# UpTask PHP MVC

## Getting Started

### Run the development server with Docker 🐳 :

```bash
# install pnpm
npm i -g pnpm

# run docker contaniers
docker compose -f docker-compose.dev.yml up --build

# stop and remove containers & networks
docker compose -f docker-compose.dev.yml down
```

```bash
# isntall deps
pnpm i

pnpm run dev

# install composer deps
composer install

# serve app with php server
php -S localhost:3000

```

```bash
# HTTP Get request

curl http://localhost:3000/api/dev/u-seed
```
