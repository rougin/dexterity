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

The `Depot` class is a special PHP class which provides methods related to CRUD operations (e.g., `create`, `delete`, `find`, `update`):

``` php
namespace Acme\Depots;

use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...
}
```

Using the `Depot` class improves development productivity as it reduces writing of code relating to CRUD operations. As it is also designed to be extensible, it can be used freely without the required methods.

> [!NOTE]
> In other PHP frameworks and other guides, `Depot` is also known as `Repository` from the [Repository pattern](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html).

If a `Depot` class is used, the following methods should be defined depending on its usage:

### `create` method

The `create` method will be used for creating an item based on the provided payload:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var array<string, mixed> */
$data = /** ... */;

/** @var \Acme\Sample\User */
$item = $depot->create($data);
```

If the specified method is being called, its logic must be defined from the `Depot` class:

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

If the required logic for the `create` method is not defined, it will throw a `LogicError`.

### `delete` method

When deleting specified items, the `delete` method can be used from the `Depot` class:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

$depot->delete(99);
```

Using the `delete` method also requires other methods `deleteRow` and `rowExists` to be defined:

``` php
namespace Acme\Depots;

use Acme\Sample\UserDeleter;
use Acme\Sample\UserReader;
use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...

    /**
     * Checks if the specified item exists.
     *
     * @param integer $id
     *
     * @return boolean
     */
    public function rowExists($id)
    {
        return UserReader::exists($id);
    }

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
}
```

If the required logic for the `delete` method is not defined, a `LogicError` will be thrown.

### `find` method

The `find` method is one of the CRUD operations that tries to find an item based on the given unique identifier (e.g., `id`):

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
     * @return \Acme\Sample\User
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

If the specified identifier does not exists, it should throw an `UnexpectedValueException`. Likewise, if the required logic for the `find` method is not defined, it will throw a `LogicError`.

### `get` method

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
     * Returns the total number of items.
     *
     * @return integer
     */
    public function getTotal()
    {
        return UserReader::totalRows();
    }

    /**
     * Returns the items with filters.
     *
     * @param integer $page
     * @param integer $limit
     *
     * @return \Acme\Sample\User[]
     */
    protected function getItems($page, $limit)
    {
        return UserReader::getByLimit($limit, $page);
    }
}
```

If the logic requires an offset instead of a page number, the `getOffset` method from `Depot` can be used to compute the said offset value:

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
     * @return \Acme\Sample\User[]
     */
    protected function getItems($page, $limit)
    {
        $offset = $this->getOffset($page, $limit);

        return UserReader::items($offset, $limit);
    }

    // ...
}
```

Using the `get` method returns a `Result` class, which can be used for handling the result from the `Depot`:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var \Rougin\Dexterity\Result */
$item = $depot->get(1, 10);

print_r($item->toArray());
```

Each item from the `Result` class can also be parsed manually using the `parseRow` class:

``` php
namespace Acme\Depots;

use Acme\Sample\User;
use Acme\Sample\UserReader;
use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...

    /**
     * Returns the parsed item.
     *
     * @param \Acme\Sample\User $row
     *
     * @return array<string, mixed>
     */
    protected function parseRow(User $row)
    {
        $data = array('id' => $row->id);

        $data['name'] = $row->name;

        $data['age'] = $row->age + 10;

        return $data;
    }

    // ...
}
```

If the required logic for the `get` method is not defined, a `LogicError` will be thrown.

### `update` method

The `update` method is used to update details of the specified item:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var array<string, mixed> */
$data = /** ... */;

$depot->update(99, $data);
```

When using the `update` method, its required logic must also be defined:

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

If the logic for the `update` method is not defined, it will throw a `LogicError`.

## Using `Route` traits

The `Route` traits in `Dexterity` is similar to the previously discussed `Depot` class. While the `Depot` class conforms to the [CRUD operations](https://en.wikipedia.org/wiki/Create,_read,_update_and_delete), the `Route` traits closely follows the [RESTful software architecture style](https://en.wikipedia.org/wiki/REST) and uses the [PSR-07](https://www.php-fig.org/psr/psr-7/) standard for standardization of its HTTP responses:

``` php
namespace Acme\Routes;

use Acme\Depots\UserDepot;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithIndexMethod;

class Users
{
    use WithIndexMethod;

    protected $user;

    public function __construct(UserDepot $user)
    {
        $this->user = $user;
    }

    protected function setIndexData($params)
    {
        $result = $this->user->get($params['page'], $params['limit']);

        return new JsonResponse($result->toArray());
    }
}
```

``` php
// index.php

use Acme\Depots\UserDepot;
use Acme\Routes\Users;

$depot = new UserDepot;

$route = new Users($depot);

/** @var \Psr\Http\Message\ResponseInterface */
$request = /** ... */

$response = $route->index($request);
```

For each `Route` trait contains the following methods for writing their logic:

**`is[METHOD]Valid`**

This trait method will be triggered if `[METHOD]` requires to be validated first. If not specified, it always return to `true` by default:

``` php
namespace Acme\Routes;

use Rougin\Dexterity\Route\WithIndexMethod;

class Users
{
    use WithIndexMethod;

    // ...

    /**
     * Checks if the items are allowed to be returned.
     *
     * @param array<string, mixed> $params
     *
     * @return boolean
     */
    protected function isIndexValid($params)
    {
        return true;
    }
}
```

**`invalid[METHOD]`**

This trait method will be triggered if the `is[METHOD]Valid` trait method returns to `false`. This should return an HTTP response with an HTTP code between `4xx` to `5xx`:

``` php
namespace Acme\Routes;

use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Route\WithIndexMethod;

class Users
{
    use WithIndexMethod;

    // ...

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidIndex()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }
}
```

**`set[METHOD]Data`**

This is the main trait method that requires to write its logic based on `[METHOD]`:

``` php
namespace Acme\Routes;

use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithIndexMethod;

class Users
{
    use WithIndexMethod;

    // ...

    /**
     * Executes the logic for returning an array of items.
     *
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        $result = $this->user->get($params['page'], $params['limit']);

        return new JsonResponse($result->toArray());
    }
}
```

Using this kind of approach improves the code structure of HTTP routes as it only requires to write the logic for each `Route` trait being used (e.g., `WithIndexMethod`).

> [!NOTE]
> In other PHP frameworks and other guides, `Route` is also known as `Controller`.

### `WithDeleteMethod` trait

The `WithDeleteMethod` trait adds a `delete` method in an HTTP route which can be used for deleting a specified item:

``` php
namespace Acme\Routes;

use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithDeleteMethod;

class Users
{
    use WithDeleteMethod;

    // ...

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidDelete()
    {
        return new ErrorResponse(HttpResponse::NOT_FOUND);
    }

    /**
     * Checks if the specified item can be deleted.
     *
     * @param integer $id
     *
     * @return boolean
     */
    protected function isDeleteValid($id)
    {
        return true;
    }

    /**
     * Executes the logic for deleting the specified item.
     *
     * @param integer $id
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setDeleteData($id)
    {
        $this->user->delete($id);

        return new JsonResponse('Deleted!', 204);
    }
}
```

``` php
// index.php

// ...

/** @var \Acme\Depots\UserDepot */
$route = /** ... */;

$response = $route->delete($id);
```

### `WithIndexMethod` trait

The `WithIndexMethod` trait allows to use the `index` method from an HTTP route. The specified method should return an array of items as its HTTP response:

``` php
namespace Acme\Routes;

use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithIndexMethod;

class Users
{
    use WithIndexMethod;

    // ...

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidIndex()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    /**
     * Checks if the items are allowed to be returned.
     *
     * @param array<string, mixed> $params
     *
     * @return boolean
     */
    protected function isIndexValid($params)
    {
        return true;
    }

    /**
     * Executes the logic for returning an array of items.
     *
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        $result = $this->user->get($params['page'], $params['limit']);

        return new JsonResponse($result->toArray());
    }
}
```

``` php
// index.php

// ...

/** @var \Psr\Http\Message\ResponseInterface */
$request = /** ... */

/** @var \Acme\Depots\UserDepot */
$route = /** ... */;

$response = $route->index($request);
```

### `WithShowMethod` trait

This `Route` trait allows to use the `show` method which returns an HTTP response for the specified item:

``` php
namespace Acme\Routes;

use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithShowMethod;

class Users
{
    use WithShowMethod;

    // ...

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidShow()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    /**
     * Checks if the specified item is allowed to be returned.
     *
     * @param integer $id
     * @param array<string, mixed> $params
     *
     * @return boolean
     */
    protected function isShowValid($id, $params)
    {
        return true;
    }

    /**
     * Executes the logic for returning the specified item.
     *
     * @param integer              $id
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setShowData($id, $params)
    {
        $item = $this->user->find($id);

        return new JsonResponse($item);
    }
}
```

``` php
// index.php

// ...

/** @var \Psr\Http\Message\ResponseInterface */
$request = /** ... */

/** @var \Acme\Depots\UserDepot */
$route = /** ... */;

$response = $route->show(99, $request);
```

### `WithStoreMethod` trait

This trait enables the specified HTTP route to use the `store` method. The specified method should be responsible for creating new items to the specified storage:

``` php
namespace Acme\Routes;

use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithStoreMethod;

class Users
{
    use WithStoreMethod;

    // ...

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidStore()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    /**
     * Checks if it is allowed to create a new item.
     *
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isStoreValid($parsed)
    {
        return true;
    }

    /**
     * Executes the logic for creating a new item.
     *
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setStoreData($parsed)
    {
        $this->user->create($parsed);

        return new JsonResponse('Created!', 201);
    }
}
```

``` php
// index.php

// ...

/** @var \Psr\Http\Message\ResponseInterface */
$request = /** ... */

/** @var \Acme\Depots\UserDepot */
$route = /** ... */;

$response = $route->store($request);
```

### `WithUpdateMethod` trait

The `WithUpdateMethod` trait adds an `update` method to an HTTP route which updates the details of the specified item:

``` php
namespace Acme\Routes;

use Rougin\Dexterity\Message\ErrorResponse;
use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithUpdateMethod;

class Users
{
    use WithUpdateMethod;

    // ...

    /**
     * Returns a response if the validation failed.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function invalidUpdate()
    {
        return new ErrorResponse(HttpResponse::UNPROCESSABLE);
    }

    /**
     * Checks if the specified item can be updated.
     *
     * @param integer $id
     * @param array<string, mixed> $parsed
     *
     * @return boolean
     */
    protected function isUpdateValid($id, $parsed)
    {
        return true;
    }

    /**
     * Executes the logic for updating the specified item.
     *
     * @param integer              $id
     * @param array<string, mixed> $parsed
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setUpdateData($id, $parsed)
    {
        $this->user->update($id, $parsed);

        return new JsonResponse('Updated!', 204);
    }
}
```

``` php
// index.php

// ...

/** @var \Psr\Http\Message\ResponseInterface */
$request = /** ... */

/** @var \Acme\Depots\UserDepot */
$route = /** ... */;

$response = $route->update(99, $request);
```

## Changelog

Please see [CHANGELOG][link-changelog] for more information what has changed recently.

## Contributing

See [CONTRIBUTING](link-contributing) on how to contribute.

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-build]: https://img.shields.io/github/actions/workflow/status/rougin/dexterity/build.yml?style=flat-square
[ico-coverage]: https://img.shields.io/codecov/c/github/rougin/dexterity?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/dexterity.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-version]: https://img.shields.io/packagist/v/rougin/dexterity.svg?style=flat-square

[link-build]: https://github.com/rougin/dexterity/actions
[link-changelog]: https://github.com/rougin/dexterity/blob/master/CHANGELOG.md
[link-contributing]: https://github.com/rougin/dexterity/blob/master/CONTRIBUTING.md
[link-contributors]: https://github.com/rougin/dexterity/contributors
[link-coverage]: https://app.codecov.io/gh/rougin/dexterity
[link-downloads]: https://packagist.org/packages/rougin/dexterity
[link-license]: https://github.com/rougin/dexterity/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/dexterity
