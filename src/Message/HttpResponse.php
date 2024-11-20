<?php

namespace Rougin\Dexterity\Message;

use Rougin\Slytherin\Http\Response;

class HttpResponse extends Response
{
    const NOT_FOUND = 404;

    const UNPROCESSABLE = 422;
}
