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
     * @param array<string, mixed> $data
     * @param boolean              $parsed
     *
     * @return \Rougin\Slytherin\Http\ServerRequest
     */
    protected function setRequest($data = array(), $parsed = false)
    {
        $server = array();

        $server['REQUEST_METHOD'] = 'GET';
        $server['REQUEST_URI'] = '/';
        $server['SERVER_NAME'] = 'localhost';
        $server['SERVER_PORT'] = '8000';

        $request = new ServerRequest($server);

        if ($parsed)
        {
            $request = $request->withParsedBody($data);
        }
        else
        {
            /** @var array<string, string> */
            $params = $data;

            $request = $request->withQueryParams($params);
        }

        return $request;
    }
}
