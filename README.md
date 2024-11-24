# Dexterity

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-build]][link-build]
[![Coverage Status][ico-coverage]][link-coverage]
[![Total Downloads][ico-downloads]][link-downloads]

`Dexterity` is a utility PHP package that provides extensible PHP classes for handling [CRUD operations](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete). It can also create HTTP routes that conforms to the [PSR-07](https://www.php-fig.org/psr/psr-7/) standard.

## Installation

Install the `Dexterity` package via [Composer](https://getcomposer.org/):

``` bash
$ composer require rougin/dexterity
```

## Using `Depot`

The `Depot` class is a abstract class which provides methods related to CRUD operations (e.g., `create`, `delete`, `find`, `update`):

``` php
namespace Acme\Depots;

use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...
}
```

If used, the specified methods may be defined depending on the usage from the `Depot`:

### `create`

A method that will be used for creating an item based on the provided payload:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var array<string, mixed> */
$data = /** ... */;

/** @var \Acme\Sample\User */
$item = $depot->create($data);
```

If the said method is being called, its logic must be defined from the `Depot` class:

``` php
namespace Acme\Depots;

use Acme\Sample\UserFactory;
use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    /**
     * Creates a new item.
     *
     * @param array<string, mixed> $data
     *
     * @return \Acme\Sample\User
     */
    public function create($data)
    {
        return UserFactory::create($data);
    }

    // ...
}
```

### `find`

This method is one of the [CRUD operations](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete) that tries to find an item based on the given unique identifier (e.g., `id`):

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var \Acme\Sample\User */
$item = $depot->find(99);
```

To use the `find` method, kindly write its logic in the `findRow` method:

``` php
namespace Acme\Depots;

use Acme\Sample\UserReader;
use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...

    /**
     * Returns the specified item.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \UnexpectedValueException
     */
    protected function findRow($id)
    {
        $item = UserReader::find($id);

        if (! $item)
        {
            throw new \UnexpectedValueException('Item not found');
        }

        return $item;
    }
}
```

If the specified identifier does not exists, it should throw an `UnexpectedValueException`.

> [!NOTE]
> In other PHP frameworks and other guides, `Depot` is also known as `Repository` from the [Repository pattern](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html).

### `get`

One of the methods of `Depot` that returns an array of items based on the specified page number and its rows to be shown per page:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var \Rougin\Dexterity\Result */
$item = $depot->get(1, 10);
```

To use the `get` method, the methods `getItems` and `getTotal` should be defined:

``` php
namespace Acme\Depots;

use Acme\Sample\UserReader;
use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...

    /**
     * Returns the items with filters.
     *
     * @param integer $page
     * @param integer $limit
     *
     * @return mixed[]
     */
    protected function getItems($page, $limit)
    {
        return UserReader::getByLimit($limit, $page);
    }

    /**
     * Returns the total number of items.
     *
     * @return integer
     */
    protected function getTotal()
    {
        return UserReader::totalRows();
    }
}
```

If the logic requires an offset instead of a page number, the `getOffset` method from `Depot` can be used:

``` php
namespace Acme\Depots;

use Acme\Sample\UserReader;
use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...

    protected function getItems($page, $limit)
    {
        $offset = $this->getOffset($page, $limit);

        return UserReader::withOffset($offset, $limit);
    }

    // ...
}
```

Using the `get` method returns a `Result` class, which can be used to for handling the result from the `Depot`:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var \Rougin\Dexterity\Result */
$item = $depot->get(1, 10);

print_r($item->toArray());
```

### `update`

The `Depot` class also provide a method to update details of the specified item using `update`:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var array<string, mixed> */
$data = /** ... */;

$depot->update(99, $data);
```

When using the `update` method, its logic must also be defined:

``` php
namespace Acme\Depots;

use Acme\Sample\UserUpdater;
use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...

    /**
     * Updates the specified item.
     *
     * @param integer              $id
     * @param array<string, mixed> $data
     *
     * @return boolean
     */
    public function update($id, $data)
    {
        return UserUpdater::update($id, $data);
    }
}
```

### `delete`

When deleting specified items, the `delete` method can be used from the `Depot` class:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

$depot->delete(99);
```

Using this method requires other methods `deleteRow` and `rowExists` to be defined:

``` php
namespace Acme\Depots;

use Acme\Sample\UserDeleter;
use Acme\Sample\UserReader;
use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...

    /**
     * Deletes the specified item.
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function deleteRow($id)
    {
        return UserDeleter::delete($id);
    }

    /**
     * Checks if the specified item exists.
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function rowExists($id)
    {
        return UserReader::exists($id);
    }
}
```

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Testing

If there is a need to check the source code of `Dexterity` for development purposes (e.g., creating fixes, new features, etc.), kindly clone this repository first to a local machine:

``` bash
$ git clone https://github.com/rougin/dexterity.git "Sample"
```

After cloning, use `Composer` to install its required packages:

``` bash
$ cd Sample
$ composer update
```

> [!NOTE]
> Please see also the [build.yml](https://github.com/rougin/dexterity/blob/master/.github/workflows/build.yml) of `Dexterity` to check any packages that needs to be installed based on the PHP version.

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/dexterity/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/dexterity?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/dexterity.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/dexterity.svg?style=flat-square

[link-build]: https://github.com/rougin/dexterity/actions
[link-changelog]: https://github.com/rougin/dexterity/blob/master/CHANGELOG.md
[link-contributors]: https://github.com/rougin/dexterity/contributors
[link-coverage]: https://app.codecov.io/gh/rougin/dexterity
[link-downloads]: https://packagist.org/packages/rougin/dexterity
[link-license]: https://github.com/rougin/dexterity/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/dexterity
