# CakePHP Facebook Authentication plugin


## Requirements

* CakePHP 3.1+

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```sh
composer require SAThomsen/FacebookAuth dev-master
```

## Usage

### Association:
```php
$this->hasMany('SocialProfiles', [
    'className' => 'SAThomsen/FacebookAuth.SocialProfiles',
    'foreignKey' => 'user_id',
    'dependent' => true,
]);
```

### Component config:
```php
$this->loadComponent('Auth', [
    'authenticate' => [
        'SAThomsen/FacebookAuth.Facebook' => [
            'userModel' => 'SAThomsen/FacebookAuth.SocialProfiles',
            'finder' => 'authFB',
            'fields' => [
                'username' => 'email',
            ]
        ],
    ],
]);
```
### Load facebook component:
```php
$this->loadComponent('SAThomsen/FacebookAuth.Facebook');
```

### Migrate
```sh
cake migrations migrate -p SAThomsen/FacebookAuth
```
