<?php

namespace Rougin\Dexterity\Message;

use Rougin\Slytherin\Http\Response;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class JsonResponse extends Response
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param mixed   $data
     * @param integer $code
     */
    public function __construct($data, $code = 200)
    {
        $types = array('application/json');

        $headers = array('Content-Type' => $types);

        parent::__construct($code, null, $headers);

        $this->data = $data;
    }

    /**
     * @return \Psr\Http\Message\StreamInterface
     */
    public function getBody()
    {
        $stream = parent::getBody();

        /** @var string */
        $encoded = json_encode($this->data);

        $stream->write($encoded);

        return $stream;
    }
}
