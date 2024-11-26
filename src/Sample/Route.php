<?php

namespace Rougin\Dexterity\Sample;

use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithIndexMethod;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Route
{
    use WithIndexMethod;

    /**
     * @var \Rougin\Dexterity\Sample\Depot
     */
    protected $depot;

    /**
     * @param \Rougin\Dexterity\Sample\Depot $depot
     */
    public function __construct(Depot $depot)
    {
        $this->depot = $depot;
    }

    /**
     * @param array<string, mixed> $params
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function setIndexData($params)
    {
        return new JsonResponse('hello');
    }
}
