<?php

namespace Rougin\Dexterity\Message;

use Rougin\Slytherin\Http\Response;

class JsonResponse extends Response
{
    protected $data;

    public function __construct($data, $code = 200)
    {
        $headers = array();

        $headers['Content-Type'] = 'application/json';

        parent::__construct($code, null, $headers, '1.1');

        $this->data = $data;
    }

    public function getBody()
    {
        $stream = parent::getBody();

        $stream->write(json_encode($this->data));

        return $stream;
    }
}
