# Installation

Install using composer:

```bash
composer install
```
or 
```bash
php composer install
```
## Routing
Initial application in `app/core/Application.php`.\
Create new route in `public/index.php`.

I'm using `blade tamplate` for rendering view.
# Project tree
```bash
.
├── app
│   ├── controllers
│   │   ├── admin
│   │   └── api
│   ├── core
│   ├── migrations
│   ├── models 
│   └── views 
│   
├── public
│   ├── index.php
│   ├── app-assets
│   ├── assets
│   ├── css
│   ├── js
│   └── assests
│
├── index.php
├── migrations.php
└── README.md

```