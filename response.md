# Response
> The Current content is an **example template**; please edit it to fit your style and content.
## A. Required Information
### A.1. Requirement Completion Rate
- [x] List all pharmacies open at a specific time and on a day of the week if requested.
  - Implemented at /api/pharmacy API.
- [x] List all masks sold by a given pharmacy, sorted by mask name or price.
  - Implemented at /api/mask API.
- [x] List all pharmacies with more or less than x mask products within a price range.
  - Implemented at /api/pharmacy API.
- [x] The top x users by total transaction amount of masks within a date range.
  - Implemented at /api/user API.
- [x] The total number of masks and dollar value of transactions within a date range.
  - Implemented at /api/sold_report API.
- [x] Search for pharmacies or masks by name, ranked by relevance to the search term.
  - Implemented at /api/search API.
- [x] Process a user purchases a mask from a pharmacy, and handle all relevant data changes in an atomic transaction.
  - Implemented at /api/user/purchase API.
### A.2. API Document
> Please describe how to use the API in the API documentation. You can edit by any format (e.g., Markdown or OpenAPI) or free tools (e.g., [hackMD](https://hackmd.io/), [postman](https://www.postman.com/), [google docs](https://docs.google.com/document/u/0/), or  [swagger](https://swagger.io/specification/)).

### List all pharmacies open at a specific time and on a day of the week if requested.
- Method：GET
- Url：/api/pharmacy

#### request

- time: `String` open time (09:00)
- day_of_week `String` 星期(Mon, Tue, Wed, Thur, Fri, Sat, Sun)

example: `/pharmacy?day_of_week=Sun&time=09:00`

#### response
- result:`String`
- pharmacies:`array`
    - id
    - name
    - cashBalance
    - openingHours
    - masks `array`
        - id
        - name
        - price
``` json
{
  "result": "success",
  "pharmacies": [
    {
      "id": 4,
      "name": "Welltrack",
      "cashBalance": 507.29,
      "openingHours": "Mon, Thu - Wed, Fri 08:00 - 17:00 / Sat - Sun 08:00 - 12:00",
      "masks": [
        {
          "id": 16,
          "name": "Second Smile (blue) (6 per pack)",
          "price": 8.66
        },
        {
          "id": 17,
          "name": "True Barrier (green) (10 per pack)",
          "price": 20.58
        },
        {
          "id": 18,
          "name": "Masquerade (blue) (6 per pack)",
          "price": 21.87
        },
        {
          "id": 19,
          "name": "MaskT (green) (10 per pack)",
          "price": 48.76
        },
        {
          "id": 20,
          "name": "Cotton Kiss (black) (10 per pack)",
          "price": 16.31
        },
        {
          "id": 21,
          "name": "Masquerade (blue) (10 per pack)",
          "price": 24.89
        }
      ]
    },
    //....
  ]
}
```
---
### List all masks sold by a given pharmacy, sorted by mask name or price.
- Method：GET
- Url：/api/mask

#### request

- pharmacy_id: `int` pharmacy's id.
- name_sort: `String` name sort. (DESC,ASC)
- price_sort: `String` price sort. (DESC,ASC)


example: `/mask?pharmacy_id=1&price_sort=ASC`

#### response
- result:`String`
- masks:`array`
    - id
    - name
    - price
```json
{
  "result": "success",
  "masks": [
    {
      "id": 4,
      "name": "Second Smile (black) (3 per pack)",
      "price": 5.84
    },
    {
      "id": 5,
      "name": "Masquerade (green) (3 per pack)",
      "price": 9.4
    },
    {
      "id": 1,
      "name": "True Barrier (green) (3 per pack)",
      "price": 13.7
    },
    {
      "id": 3,
      "name": "Second Smile (black) (10 per pack)",
      "price": 31.98
    },
    {
      "id": 2,
      "name": "MaskT (green) (10 per pack)",
      "price": 41.86
    }
  ]
}
```
---
### List all pharmacies with more or less than x mask products within a price range.
- Method：GET
- Url：/api/pharmacy

#### request

- mask_count: `int` 
- mask_condition `String` (more,less)
- mask_price_min `int` 
- mask_price_max `int` 

example: `/pharmacy?mask_count=2&mask_condition=less&mask_price_min=10&mask_price_max=30`

#### response
- result:`String`
- pharmacies:`array`
    - id
    - name
    - cashBalance
    - openingHours
    - masks `array`
        - id
        - name
        - price
``` json
{
  "result": "success",
  "pharmacies": [
     {
      "id": 1,
      "name": "DFW Wellness",
      "cashBalance": 328.41,
      "openingHours": "Mon, Wed, Fri 08:00 - 12:00 / Tue, Thur 14:00 - 18:00",
      "masks": [
        {
          "id": 1,
          "name": "True Barrier (green) (3 per pack)",
          "price": 13.7
        },
        {
          "id": 2,
          "name": "MaskT (green) (10 per pack)",
          "price": 41.86
        },
        {
          "id": 3,
          "name": "Second Smile (black) (10 per pack)",
          "price": 31.98
        },
        {
          "id": 4,
          "name": "Second Smile (black) (3 per pack)",
          "price": 5.84
        },
        {
          "id": 5,
          "name": "Masquerade (green) (3 per pack)",
          "price": 9.4
        }
      ]
    },
    //....
  ]
}
```
---
### The top x users by total transaction amount of masks within a date range.
- Method：GET
- Url：/api/user

#### request

- transaction_rank: `int` The top x
- transaction_start `dateTime`  YYYY-mm-dd HH:ii:ss
- transaction_end `dateTime`  YYYY-mm-dd HH:ii:ss

example: `/user?transaction_rank=2&transaction_start=2021-01-17%2005:41:10&transaction_end=2021-01-18%2005:41:10`

#### response
- result:`String`
- users:`array`
    - id
    - name
    - cashBalance
    - openingHours
    - purchaseHistories `array`
        - id
        - pharmacyName
        - maskName
        - transactionAmount
        - transactionDate
``` json
{
  "result": "success",
  "users": [
    {
      "id": 17,
      "name": "Wilbert Love",
      "cashBalance": 796.2,
      "purchaseHistories": [
        {
          "id": 87,
          "pharmacyName": "Foundation Care",
          "maskName": "Masquerade (green) (10 per pack)",
          "transactionAmount": 29.87,
          "transactionDate": "2021-01-02 02:38:09"
        },
        {
          "id": 88,
          "pharmacyName": "First Care Rx",
          "maskName": "Second Smile (black) (3 per pack)",
          "transactionAmount": 14.24,
          "transactionDate": "2021-01-03 07:30:30"
        },
        {
          "id": 89,
          "pharmacyName": "Carepoint",
          "maskName": "Masquerade (blue) (6 per pack)",
          "transactionAmount": 6.44,
          "transactionDate": "2021-01-07 05:07:21"
        },
        {
          "id": 90,
          "pharmacyName": "RX Universal",
          "maskName": "True Barrier (blue) (3 per pack)",
          "transactionAmount": 7.16,
          "transactionDate": "2021-01-07 15:18:41"
        },
        {
          "id": 91,
          "pharmacyName": "Keystone Pharmacy",
          "maskName": "True Barrier (green) (3 per pack)",
          "transactionAmount": 11.3,
          "transactionDate": "2021-01-13 00:19:32"
        },
        {
          "id": 92,
          "pharmacyName": "First Pharmacy",
          "maskName": "Cotton Kiss (green) (10 per pack)",
          "transactionAmount": 17.5,
          "transactionDate": "2021-01-13 01:18:23"
        },
        {
          "id": 93,
          "pharmacyName": "Medlife",
          "maskName": "True Barrier (green) (10 per pack)",
          "transactionAmount": 36.25,
          "transactionDate": "2021-01-17 19:50:27"
        },
        {
          "id": 94,
          "pharmacyName": "Prescription Hope",
          "maskName": "Cotton Kiss (black) (3 per pack)",
          "transactionAmount": 5.61,
          "transactionDate": "2021-01-18 02:47:27"
        },
        {
          "id": 95,
          "pharmacyName": "RX Universal",
          "maskName": "True Barrier (blue) (3 per pack)",
          "transactionAmount": 6.79,
          "transactionDate": "2021-01-28 23:17:21"
        }
      ]
    },
    {
      "id": 1,
      "name": "Yvonne Guerrero",
      "cashBalance": 191.83,
      "purchaseHistories": [
        {
          "id": 1,
          "pharmacyName": "Keystone Pharmacy",
          "maskName": "True Barrier (green) (3 per pack)",
          "transactionAmount": 12.35,
          "transactionDate": "2021-01-04 15:18:51"
        },
        {
          "id": 2,
          "pharmacyName": "Medlife",
          "maskName": "True Barrier (green) (10 per pack)",
          "transactionAmount": 38.43,
          "transactionDate": "2021-01-17 05:41:10"
        },
        {
          "id": 3,
          "pharmacyName": "RX Universal",
          "maskName": "True Barrier (blue) (3 per pack)",
          "transactionAmount": 6.99,
          "transactionDate": "2021-01-20 12:23:09"
        },
        {
          "id": 4,
          "pharmacyName": "Keystone Pharmacy",
          "maskName": "Second Smile (blue) (6 per pack)",
          "transactionAmount": 14.52,
          "transactionDate": "2021-01-20 13:20:43"
        },
        {
          "id": 5,
          "pharmacyName": "Welltrack",
          "maskName": "True Barrier (green) (10 per pack)",
          "transactionAmount": 20.91,
          "transactionDate": "2021-01-26 20:37:13"
        },
        {
          "id": 6,
          "pharmacyName": "Prescription Hope",
          "maskName": "Cotton Kiss (green) (10 per pack)",
          "transactionAmount": 42.63,
          "transactionDate": "2021-01-30 18:58:57"
        }
      ]
    }
  ]
}
```
---
### The total amount of masks and dollar value of transactions within a date range.
- Method：GET
- Url：/api/sold_report

#### request

- date_start `dateTime`  YYYY-mm-dd HH:ii:ss
- date_end `dateTime`  YYYY-mm-dd HH:ii:ss

example: `/sold_report?date_start=2021-01-17%2005:41:10&date_end=2021-01-18%2005:41:10`

#### response
- result:`String`
- reports:`array`
    - count `int` pack count
    - dollar `double` total dollar
    - totalMasks `int` total amount
``` json
{
  "result": "success",
  "reports": {
    "count": 4,
    "dollar": 116.93,
    "totalMasks": 33
  }
}
```
---
### Search for pharmacies or masks by name, ranked by relevance to the search term.
- Method：GET
- Url：/api/search

#### request

- term `string`

example: `/search?term=ca`

#### response
- result:`String`
- data:`array`
    - id `int`
    - name `string` 
    - type `string` (pharmacy,mask)
    - relevance `double` relevance rate
``` json
{
  "result": "success",
  "data": [
    {
      "id": 2,
      "name": "Carepoint",
      "type": "pharmacy",
      "relevance": 36.3636363636364
    },
    {
      "id": 3,
      "name": "First Care Rx",
      "type": "pharmacy",
      "relevance": 26.6666666666667
    },
    {
      "id": 13,
      "name": "Foundation Care",
      "type": "pharmacy",
      "relevance": 23.5294117647059
    }
  ]
}
```
---
### Process a user purchases a mask from a pharmacy, and handle all relevant data changes in an atomic transaction.
- Method：POST
- Url：/api/user/purchase
- content-type: application/json

#### request

- user_id `int`
- pharmacy_id `int`
- mask_id `int`

example: `{
    "user_id": 1,
    "pharmacy_id": 1,
    "mask_id": 1
}`

#### response
- result:`String`
- message:`String`
``` json
{
    "result": "success",
    "message": "purchase completed！"
}
```
#### error response
``` json
{
    "result": "failed",
    "message": "User cash balance not enough！"
}
```
---

<!-- Import [this](#api-document) json file to Postman. -->

### A.3. Import Data Commands
Please run these two script commands to migrate the data into the database.

1. Install [composer](https://getcomposer.org/download/).
2. Create database in MySql.
    ```sql
    CREATE DATABASE `phantom_mask` /*!40100 COLLATE 'utf8_general_ci' */
    ```
3. Duplicate `.env.example` to `.env` in project.
4. Set database Setting in `.env`.
    ```
    DB_HOST=<your database ip>
    DB_PORT=<your database port>
    DB_DATABASE=<your database name>
    DB_USERNAME=<your database username>
    DB_PASSWORD=<your database password>
    ```
5. Move to root in project.
6. Input cmd `composer install` to init laravel.
7. Input cmd `php artisan migrate` to create database and input json data.
8. Input cmd `php artisan key:generate` to update `.env` APP_KEY.
9. If not have server, input cmd `php artisan serve` to simulate sever.
    ```log
     INFO  Server running on [http://127.0.0.1:8000].
    ```
## B. Bonus Information

>  If you completed the bonus requirements, please fill in your task below.
### B.1. Test Coverage Report

I wrote down the 20 unit tests for the APIs I built. Please check the test coverage report at [here](#test-coverage-report).

You can run the test script by using the command below:

```bash
bundle exec rspec spec
```

### B.2. Dockerized
Please check my Dockerfile / docker-compose.yml at [here](#dockerized).

On the local machine, please follow the commands below to build it.

```bash
$ docker build --build-arg ENV=development -p 80:3000 -t my-project:1.0.0 .  
$ docker-compose up -d

# go inside the container, run the migrate data command.
$ docker exec -it my-project bash
$ rake import_data:pharmacies[PATH_TO_FILE] 
$ rake import_data:user[PATH_TO_FILE]
```

### B.3. Demo Site Url

The demo site is ready on [my AWS demo site](#demo-site-url); you can try any APIs on this demo site.

## C. Other Information

### C.1. ERD

My ERD [erd-link](#erd-link).

### C.2. Technical Document

For frontend programmer reading, please check this [technical document](technical-document) to know how to operate those APIs.

- --
