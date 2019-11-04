# Chiven
![codecov](https://img.shields.io/badge/coverage-98%25-green)
![GitHub](https://img.shields.io/github/license/pixaye/chiven)
![GitHub repo size](https://img.shields.io/github/repo-size/pixaye/chiven)
![PHP from Packagist](https://img.shields.io/packagist/php-v/pixaye/chiven)
![Packagist](https://img.shields.io/packagist/dm/pixaye/chiven)

Simple library which allows you to build RESTful API fast, easy and flexible

# Installation
Install it via composer  
```composer require pixaye/chiven```

# Usage
For start using Chiven\`s functionality, you should initialize its Request class as early, as you can (for example, you can init it in index.php)

Initializating from globals
```php
$request = new \Chiven\Http\Request();
$request->fromGlobals();
```

Initializating from custom variables
```php
$request = new \Chiven\Http\Request();

$files = array(
  'file' => array (
    'tmp_name' => '/tmp/df23fr32,
    'name' => 'file.jpg',
    'type' => 'image/jpeg',
    'size' => 335057,
    'error' => 0,
  )
);
        
$headers = array(
  'X-Test-Header: 1',
  'X-Test-Header: 2',
);

$get = array(
  'key' => 'value'
);

$post = array(
  'key' => 'value'
);

$request->initialize($files, $get, $post, $headers)
```

Chiven allows you to work with files and headers in object oriented style. It builds objects of them and puts it in repositories: **FileRepostiory** and **HeaderRepository**

You can get them by calling **$request->getFiles()** and **$request->getHeaders()**

```php
$filesRepository = $request->getFiles();

$testFile = $filesRepository->findBy('name', 'test');
```

```php
$headersRepository = $request->getHeaders();

$testHeader = $filesRepository->findBy('name', 'X-Test-Header');
```

Both repositories have methods:
* findBy(**$criteria**, **$value**)
* findLast()
* findFirst()
* findAll()
* insert(*Insertable* **$object**)
* remove(**$criteria**, **$value**)
* set(*array* **$objects**)

To make Chiven process the request correctly and display the result in the desired format, there are **format classes**. At the moment, only JSON format is available to use.

```php
$request = new \Chiven\Http\Request();
$request->fromGlobals();

(new \Chiven\Bootstrap())->setFormat(new \Chiven\Format\Json());


//Request handling...

echo $chiven->getFormat()->responseDecorator(new \Chiven\Http\Response\Response());
```

This is how Chiven works, you can use example above and start creating your API with Chiven.
