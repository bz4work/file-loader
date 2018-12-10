Http file loader.
=================
Loading files from url.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist bz4work/file-loader "*"
```

or add

```
"bz4work/file-loader": "*"
```

to the require section of your `composer.json` file.


Configure config.ini file.

Usage
-----

In your controller:
```php
//Create component container:
$loader = Yii::$container->get('FileLoaderComponent');


$url = 'http://www.vsedela.info/gallery/201409151019eng0000003.jpeg';
$path = $loader->loadAndSave($url);

//Pass value into the view:
return $this->render('index', [
    'path' => $path
]);
```

In your view file:
```html
<img src="<?php echo $path; ?>" alt="some alt">
```

Run tests:
```php
...
```