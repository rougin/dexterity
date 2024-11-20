<?php

namespace Rougin\Dexterity\Message;

use Rougin\Slytherin\Http\Response;

class ErrorResponse extends Response
{
    public function withError($value)
    {
        $this->getBody()->write($value);

        return $this;
    }
}
