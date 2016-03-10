# Redis component for Yii2

## Description

This component is wrapper, it based on really powerful [php-redis](https://github.com/phpredis/phpredis) extension.  
Please, install those php-extension before use this.

Documentation can be found at [here](https://github.com/phpredis/phpredis#table-of-contents)

Feel free to let me know what else you want added via:

- [Issues](https://github.com/ancor-dev/yii2-redis/issues)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ php composer.phar require ancor/yii2-redis
```

or add

```
"ancor/yii2-redis": "dev-master"
```

to the `require` section of your `composer.json` file.

## Configuration

Configuration is easy. Add this to your `main-local.php` config

```php
'components' => [
    'redis' => \redis\redis\Redis::build(),
],
```

Or with settings

```php
'components' => [
    'redis' => \redis\redis\Redis::build([
        // 'host'    => '127.0.0.1',
        // 'port'    => 6379,
        // 'timeout' => 0,

        // 'retryInterval' => null,

        // 'password' => null,
        // 'database' => 0, // default database number
    ]),
],
```

## Usage

```php
$redis = Yii::$app->redis;

$redis->set('my:key', 'some-value');
$res = $redis->get('my:key');
```
