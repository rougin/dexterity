# Dexterity

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

"Ready-to-eat" and framework-agnostic CRUD controllers.

## Installation

Install `Dexterity` via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/dexterity
```

## Basic Usage

``` php
use Acme\Common\Models\PatientModel;
use Acme\Repositories\OrmRepository;
use Acme\Http\Message\ServerRequest;
use Rougin\Dexterity\Controller\CrudController;

$repository = new OrmRepository;

$request = new ServerRequest;

$controller = new CrudController($repository, $request);

$controller->model(PatientModel::class);

// Returns an array of PatientModel objects
$patients = $controller->index();

// Returns a specific PatientModel object
$patient = $controller->find(10);
```

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

``` bash
$ vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/dexterity.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/dexterity.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/dexterity.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/dexterity/master.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/dexterity.svg?style=flat-square

[link-changelog]: https://github.com/rougin/dexterity/CHANGELOG.md
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/dexterity
[link-contributors]: https://github.com/rougin/dexterity/contributors
[link-downloads]: https://packagist.org/packages/rougin/dexterity
[link-license]: https://github.com/rougin/dexterity/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/dexterity
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/dexterity/code-structure
[link-travis]: https://travis-ci.org/rougin/dexterity