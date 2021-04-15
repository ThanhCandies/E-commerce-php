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

#Upload images

Change your `upload_tmp_dir` in `php.ini` to `your_folder_location/xampp/img` if your folder's disk 
is different with php's folder disk