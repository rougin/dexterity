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

The `Depot` class is a specialized PHP class that provides methods for common CRUD (Create, Read, Update, Delete) operations, such as `create`, `delete`, `find`, and `update`.

``` php
namespace Acme\Depots;

use Rougin\Dexterity\Depot;

class UserDepot extends Depot
{
    // ...
}
```

Utilizing the `Depot` class enhances development productivity by minimizing the need to write repetitive CRUD operation code. Its extensible design allows for flexible use, even without all methods being strictly required.

> [!NOTE]
> In other PHP frameworks and guides, `Depot` is also recognized as a `Repository` within the [Repository pattern](https://designpatternsphp.readthedocs.io/en/latest/More/Repository/README.html).

When a `Depot` class is implemented, specific methods must be defined based on its intended usage:

### `create` method

The `create` method facilitates the creation of a new item based on a provided payload:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var array<string, mixed> */
$data = /** ... */;

/** @var \Acme\Sample\User */
$item = $depot->create($data);
```

When this method is invoked, its underlying logic must be explicitly defined within the `Depot` class:

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

Failure to define the required logic for the `create` method will result in a `LogicError`.

### `delete` method

The `delete` method within the `Depot` class can be utilized for removing specified items:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

$depot->delete(99);
```

Successful execution of the `delete` method necessitates the definition of two additional methods: `deleteRow` and `rowExists`:

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

If the necessary logic for the `delete` method is not defined, a `LogicError` will be thrown.

### `find` method

The `find` method, a core CRUD operation, retrieves an item based on its unique identifier (e.g., `id`):

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var \Acme\Sample\User */
$item = $depot->find(99);
```

To enable the `find` method, its specific logic must be implemented within the `findRow` method:

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

If the specified identifier does not exist, an `UnexpectedValueException` should be thrown. Similarly, a `LogicError` will be thrown if the required logic for the `find` method is not defined.

### `get` method

The `get` method of `Depot` retrieves an array of items, paginated by a specified page number and the number of rows to display per page:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var \Rougin\Dexterity\Result */
$item = $depot->get(1, 10);
```

To utilize the `get` method, the `getItems` and `getTotal` methods must be defined:

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

If the implementation requires an offset instead of a page number, the `getOffset` method from `Depot` can compute the necessary offset value:

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

The `get` method returns a `Result` class instance, which is designed for handling the output from the `Depot`:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var \Rougin\Dexterity\Result */
$item = $depot->get(1, 10);

print_r($item->toArray());
```

Individual items within the `Result` class can also be manually parsed by implementing the `parseRow` method:

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

The `update` method is responsible for modifying the details of a specified item:

``` php
// index.php

use Acme\Depots\UserDepot;

$depot = new UserDepot;

/** @var array<string, mixed> */
$data = /** ... */;

$depot->update(99, $data);
```

When the `update` method is utilized, its corresponding logic must be explicitly defined:

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

Failure to define the logic for the `update` method will result in a `LogicError`.

## Using `Route` traits

The `Route` traits in `Dexterity` offer functionality similar to the `Depot` class. While `Depot` focuses on CRUD operations, `Route` traits adhere closely to the [RESTful software architecture style](https://en.wikipedia.org/wiki/REST) and leverage the [PSR-7](https://www.php-fig.org/psr/psr-7/) standard for consistent HTTP responses:

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

Each `Route` trait includes specific methods for defining its logic:

**`is[METHOD]Valid`**

This trait method is invoked when `[METHOD]` requires prior validation. If not explicitly defined, it defaults to `true`:

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

This trait method is executed if the `is[METHOD]Valid` method returns `false`. It should return an HTTP response with a `4xx` or `5xx` status code:

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

This is the primary trait method where the specific logic for `[METHOD]` is implemented:

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

This approach enhances the code structure of HTTP routes by centralizing the logic for each `Route` trait (e.g., `WithIndexMethod`).

> [!NOTE]
> In other PHP frameworks and guides, `Route` is also commonly referred to as a `Controller`.

### `WithDeleteMethod` trait

The `WithDeleteMethod` trait integrates a `delete` method into an HTTP route, enabling the deletion of a specified item:

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

The `WithIndexMethod` trait enables the use of the `index` method within an HTTP route. This method is expected to return an array of items as its HTTP response:

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

This `Route` trait enables the use of the `show` method, which retrieves and returns an HTTP response for a specified item:

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

This trait enables an HTTP route to utilize the `store` method, which is responsible for creating new items within the specified storage:

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

The `WithUpdateMethod` trait integrates an `update` method into an HTTP route, which facilitates the modification of a specified item's details:

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
