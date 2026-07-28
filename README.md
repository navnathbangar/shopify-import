# Shopify CSV Product Import

## Overview

This project is built using Laravel 12.

It imports Shopify products from a CSV file using Shopify GraphQL API.

Products are processed in the background using Laravel Queue.

If a product already exists, it is updated automatically.

Products are also added into the configured Shopify Collection.

---

## Features

- Laravel 12
- CSV Upload
- Background Queue Processing
- Shopify GraphQL Integration
- Product Create
- Product Update
- Add Product to Collection
- Dashboard
- Product Status
- Error Handling
- Logging
- Pagination

---

## Requirements

- PHP 8.2+
- Composer
- MySQL
- NodeJS
- Laravel 12

---

## Installation

```bash
git clone <repository>

composer install

cp .env.example .env

php artisan key:generate

php artisan migrate

php artisan storage:link

npm install

npm run dev

php artisan queue:work

php artisan serve
```

---

## Shopify Configuration

```
SHOPIFY_STORE=

SHOPIFY_ACCESS_TOKEN=

SHOPIFY_COLLECTION_ID=
```

---

## Queue

```
php artisan queue:work
```

---

## Testing

1 Upload CSV

2 Queue processes records

3 Dashboard shows status

4 Product created in Shopify

5 Existing product updated

6 Product added to Collection

---

## Author

Navnath Bangar