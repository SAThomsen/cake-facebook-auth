# CakePHP Facebook Authentication plugin

## Intro
The plugin allows for easy authorization via facebook using the auth component of CakePHP. The plugin includes an AuthComponent authentication class as well as a facebook wrapper component. The facebook token is transmitted to the application via the authorization header.

## Requirements

* CakePHP 3.1+

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```sh
composer require SAThomsen/FacebookAuth v0.0.2
```

##Configuration

### Bootstrap
The plugin reads app details via the config/boostrap.php file in your application. Add the following lines to your bootstrap and fill in the details from your facebook app. The fields specify the information you are requesting from the graph. When generating the token frontend the same fields should be requested.

```php
Configure::write('facebook.appId', 'REPLACE WITH APP ID');
Configure::write('facebook.appSecret', 'REPLACE WITH APP SECRET');
Configure::write('facebook.graphVersion', 'v2.8'); //The api version you intend to use.
Configure::write('facebook.fields', 'id,name,first_name,middle_name,last_name,gender,email');
```
To run the tests agains you're own facebook account, you will have to enter the account identifier in your bootstrap too:
```php
Configure::write('facebook.identifier', 'REPLACE WITH FACEBOOK IDENTIFIER'));
```
You can also go declare environment variables using the .env file in the /tests/config. Alternatively, you declare them globally in you local environemnt.

### Association:
In order for the authentication to work, an association should be added to the table representing a user. It defaults to "Users".
```php
$this->hasMany('SocialProfiles', [
    'className' => 'SAThomsen/FacebookAuth.SocialProfiles',
    'foreignKey' => 'user_id',
    'dependent' => true,
]);
```

### Component config:
The component should be added to the authentication config of your AppController.

```php
$this->loadComponent('Auth', [
    'authenticate' => [
        'SAThomsen/FacebookAuth.Facebook',
    ],
]);
```
The plugin works out of the box. Below is shown the available fields with their defaults:
```php
// Specifies the username field of the finder
'fields' => [
    'username' => 'email'
],
// Specifies the finder method
'finder' => 'authFB',
// Specifies the header used to transfer token
'header' => 'authorization',
// specifies the identifying prefix used
'prefix' => 'facebook',
// specifies the query parameter to look for in the URL, will be ignored if empty
'parameter' => '',
// specifies the exeption to throw
'unauthenticatedException' => '\Cake\Network\Exception\UnauthorizedException',
// specifies where to find the finder method
'userModel' => 'SAThomsen/FacebookAuth.SocialProfiles',
```
If in doubt on how the configuration works, here is an example of how you would configure the field the finder looks for:

```php
$this->loadComponent('Auth', [
    'authenticate' => [
        'SAThomsen/FacebookAuth.Facebook' => [
            'fields' => [
                'username' => 'username'
            ],
        ],
    ],
]);
```

### Load facebook component:
The facebook component can be loaded in controllers via the following line. This is useful when adding a new user, or linking an already existing user account with a social profile.
```php
$this->loadComponent('SAThomsen/FacebookAuth.Facebook');
```

### Migrate
The database schema of SocialData can be imported via the migration file.
```sh
cake migrations migrate -p SAThomsen/FacebookAuth
```
## Testing
To execute tests successfully make sure to be authenticated with the app that you wish to test against.
Furthermore you should modify tests/bootstrap.php, with the credentials of your app and your own account.


