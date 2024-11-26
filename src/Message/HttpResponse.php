<?php

namespace Rougin\Dexterity\Message;

use Rougin\Slytherin\Http\Response;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class HttpResponse extends Response
{
    const NOT_FOUND = 404;

    const UNPROCESSABLE = 422;
}
