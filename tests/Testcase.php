<?php

namespace Rougin\Dexterity;

use Illuminate\Database\Capsule\Manager;
use LegacyPHPUnit\TestCase as Legacy;
use Rougin\Slytherin\Http\ServerRequest;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Testcase extends Legacy
{
    /**
     * @param string $exception
     *
     * @return void
     */
    public function doSetExpectedException($exception)
    {
        if (method_exists($this, 'expectException'))
        {
            /** @phpstan-ignore-next-line */
            $this->expectException($exception);

            return;
        }

        /** @phpstan-ignore-next-line */
        $this->setExpectedException($exception);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function doExpectExceptionMessage($message)
    {
        if (! method_exists($this, 'expectExceptionMessage'))
        {
            $exception = 'Exception';

            /** @phpstan-ignore-next-line */
            $this->setExpectedException($exception, $message);

            return;
        }

        $this->expectExceptionMessage($message);
    }

    /**
     * @return void
     */
    protected function loadEloquent()
    {
        $root = __DIR__ . '/Fixture';

        $config = array('driver' => 'sqlite');
        $path = $root . '/Storage/dxtr.s3db';
        $config['database'] = (string) $path;

        $capsule = new Manager;

        $capsule->addConnection($config);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();
    }

    /**
     * @param string $method
     * @param string $uri
     *
     * @return \Rougin\Slytherin\Http\ServerRequest
     */
    protected function setRequest($method, $uri)
    {
        $server = array();

        $server['REQUEST_METHOD'] = $method;
        $server['REQUEST_URI'] = $uri;
        $server['SERVER_NAME'] = 'localhost';
        $server['SERVER_PORT'] = '8000';

        return new ServerRequest($server);
    }
}
