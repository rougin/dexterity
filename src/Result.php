<?php

namespace Rougin\Dexterity;

class Result
{
    /**
     * @var mixed[]
     */
    protected $items = array();

    /**
     * @var integer
     */
    protected $limit = 0;

    /**
     * @var integer
     */
    protected $total = 0;

    /**
     * @param mixed[] $items
     * @param integer $total
     * @param integer $limit
     */
    public function __construct($items, $total, $limit)
    {
        $this->limit = (int) $limit;

        $this->items = $items;

        $this->total = (int) $total;
    }

    /**
     * Returns the result as an associative array.
     *
     * @return array<string, integer|mixed[]>
     */
    public function toArray()
    {
        $output = array('pages' => 1);

        $limit = $this->limit();

        $total = $this->total();

        $output['limit'] = $limit;

        $output['total'] = $total;

        $output['items'] = $this->itemsAsArray();

        $rounded = ceil($total / $limit);

        $rounded = $rounded ? $rounded : 1;

        $output['pages'] = (int) $rounded;

        return (array) $output;
    }

    /**
     * Returns the number of rows per page.
     *
     * @return integer
     */
    public function limit()
    {
        return $this->limit;
    }

    /**
     * Returns the result.
     *
     * @return mixed[]
     */
    public function items()
    {
        return $this->items;
    }

    /**
     * Returns the result in array format, if available.
     *
     * @return mixed[]
     */
    public function itemsAsArray()
    {
        $contract = 'Illuminate\Contracts\Support\Arrayable';

        $items = array();

        foreach ($this->items() as $item)
        {
            if (is_object($item) && is_a($item, $contract))
            {
                /** @var \Illuminate\Contracts\Support\Arrayable */
                $object = $item;

                $item = $object->toArray();
            }

            $items[] = $item;
        }

        return $items;
    }

    /**
     * Returns the total rows.
     *
     * @return integer
     */
    public function total()
    {
        return $this->total;
    }
}
