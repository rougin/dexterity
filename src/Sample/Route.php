<?php

namespace Rougin\Dexterity\Sample;

use Rougin\Dexterity\Message\JsonResponse;
use Rougin\Dexterity\Route\WithIndexMethod;

class Route
{
    use WithIndexMethod;

    protected $depot;

    public function __construct(Depot $depot)
    {
        $this->depot = $depot;
    }

    protected function setIndexData($params)
    {
        return new JsonResponse('hello');
    }
}
