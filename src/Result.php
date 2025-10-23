<?php

namespace Rougin\Dexterity;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @package Dexterity
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
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
        $this->limit = $limit;

        $this->items = $items;

        $this->total = $total;
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
        $items = array();

        foreach ($this->items() as $item)
        {
            if (! $item instanceof Arrayable)
            {
                $items[] = $item;

                continue;
            }

            $items[] = $item->toArray();
        }

        return $items;
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
     * Returns the result as an associative array.
     *
     * @return array<string, mixed>
     */
    public function toArray()
    {
        $limit = $this->limit();

        $total = $this->total();

        // Set default pages to "0" or "1" ---
        $pages = $total === 0 ? 0 : 1;

        $item = array('pages' => $pages);
        // -----------------------------------

        $item['limit'] = $limit;

        $item['total'] = $total;

        $item['items'] = $this->itemsAsArray();

        $round = ceil($total / $limit);

        $round = $round ? $round : $pages;

        $item['pages'] = floor($round);

        return $item;
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
