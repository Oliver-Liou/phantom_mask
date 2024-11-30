<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Phantom Mask
You are building a backend service and a database for a pharmacy platform with the following two raw datasets:

## API
### List all pharmacies open at a specific time and on a day of the week if requested.
- Method：GET
- Url：/pharmacy

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
- Url：/mask

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
- Url：/pharmacy

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
- Url：/user

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
## A. Raw Data
### A.1. Pharmacy Data
Link: [data/pharmacies.json](data/pharmacies.json)

This dataset contains a list of pharmacies with their names, opening hours, cash balances, and mask products. The cash balance represents the amount of money a pharmacy holds in the merchant account on this platform. In addition, it increases the mask price whenever a user purchases masks from the pharmacy.

> Please be careful at processing pharmacies.json's openingHours value; it contains different time formats.

### A.2. User data
Link: [data/users.json](data/users.json)

This dataset contains a list of users with their names, cash balances, and purchasing histories. The cash balance represents the amount of money a user holds in his wallet on this platform. In addition, it decreases the mask price whenever the user buys masks.

These are all raw data, which means you can process and transform the data before you load it into your database.

## B. The Task Requirments
The task is to build an API server with documentation and a backing relational database that will allow a front-end client to navigate through that sea of data quickly and intuitively. In addition, the front-end team will build the front-end client based on the documentation.

The operations the frontend team would need you to support are:

* List all pharmacies open at a specific time and on a day of the week if requested.
* List all masks sold by a given pharmacy, sorted by mask name or price.
* List all pharmacies with more or less than x mask products within a price range.
* The top x users by total transaction amount of masks within a date range.
* The total amount of masks and dollar value of transactions within a date range.
* Search for pharmacies or masks by name, ranked by relevance to the search term.
* Process a user purchases a mask from a pharmacy, and handle all relevant data changes in an atomic transaction.

In your repository, you would need to document the API interface, the commands to run the ETL (extract, transform, and load) script that takes in the raw data sets as input and outputs to your database, and the command to set up your server and database.

> If you think the description requirement is not detailed, please try to make your design as close to the living and make sense.

## C. Response Your Job **(Importmant)**
1. Fork this repository to your GitHub account, and set the repository as **private**.
2. Add [redtear1115](https://github.com/redtear1115) and [william-eth](https://github.com/william-eth) to your private repository as a collaborator.
3. Write an introduction to all your works on [response.md](response.md).
4. Write an email to let HR know you are all done. Don't forget the necessary information, such as your GitHub account and the repository URL.

### C.1. Common Mistakes You Should Avoid

1. Missing documentation.
2. Project does not work.
3. Provided solution does not meet the requirements.
4. Poor knowledge of version control systems.
    - Temporary/redundant/binary files (.DS_Store, .idea, .vscode) are in repository or result archive. Choose a good [.gitignore](https://gist.github.com/octocat/9257657)

## D. How We Review

Your project will be reviewed by at least one of our backend engineers.
### D.1. Main Standards
1. (40%) How familiar with your programming language and framework.
    - Code Quality
        - Is the code simple, easy to understand/extend, reusable and maintainable?
        - Is polluted with nasty comments or redundant code blocks inside?
        - Is the coding style consistent with the language guidelines?
        - Are there any apparent vulnerabilities in security?
    - Logic Design
        - Is the database design match the requirements, and is it easy to understand/extend?
        - The way you import and clean the raw data to your database.
        - Is the API logic design match the requirements and be close to the living?
    - MVC Architecture (optional)
        - Is the design pattern consistent with the framework guidelines?
        - Don't forget the rule `Stop trying to reinvent the wheel` if you uses the framework.
2. (30%) Finish rate of the task requirements.
3. (20%) API Quality
    - API should be able to evolve and add functionality independently from client applications. As the API grows, existing client applications should continue functioning without modification.
    - All functionality should be discoverable so client applications can fully use it.
4. (10%) Communication
    - Is the API document easy to understand for front-end engineers?
### D.2. Bonus
> This is optional and serves as additional proof points. We will consider it complete even without this functionality. **If you are applying for Senior Back-End Engineer, you MUST do all bonus task requirements.**

1. (5%) Testing
    - Write appropriate tests with a proper coverage report.
2. (5%) Dockerize
    - You may use docker to ensure a uniform setup across environments.
3. (5%) Deploy
    - It'd be great if you could deploy this on the free tier of any cloud hosting platform (e.g., [fly.io](https://fly.io/docs/speedrun/), or [render](https://render.com/docs/web-services)) so that we can easily access the application via an URL.


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
