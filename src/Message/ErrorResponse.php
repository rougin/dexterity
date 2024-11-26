<?php

namespace Rougin\Dexterity\Message;

use Rougin\Slytherin\Http\Response;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ErrorResponse extends Response
{
    /**
     * @param string $value
     *
     * @return self
     */
    public function withError($value)
    {
        $this->getBody()->write($value);

        return $this;
    }
}
