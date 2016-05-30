<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Collection;

/**
 * Class BaseObject.
 */
abstract class BaseObject extends Collection
{
    /**
     * Builds collection entity.
     *
     * @param array|mixed $data
     */
    public function __construct($data)
    {
        parent::__construct($this->getRawResult($data));

        $this->mapRelatives();
    }

    /**
     * Property relations.
     *
     * @return array
     */
    abstract public function relations();

    /**
     * Map property relatives to appropriate objects.
     *
     * @return array|void
     */
    public function mapRelatives()
    {
        $relations = $this->relations();

        if (empty($relations) || !is_array($relations)) {
            return false;
        }

        $results = $this->all();
        foreach ($results as $key => $data) {
            if (array_key_exists($key, $relations)) {
                $class = $relations[$key];
                $results[$key] = $this->recursiveMapRelatives($class, $data);
            }
        }

        return $this->items = $results;
    }

    protected function recursiveMapRelatives($class, $data)
    {
        if (is_array($data) && array_keys($data) === range(0, count($data) - 1)) {
            $array = [];
            foreach ($data as $item) {
                $array[] = $this->recursiveMapRelatives($class, $item);
            }
            return new Collection($array);
        } else {
            return new $class($data);
        }
    }

    /**
     * Returns raw response.
     *
     * @return array|mixed
     */
    public function getRawResponse()
    {
        return $this->items;
    }

    /**
     * Returns raw result.
     *
     * @param $data
     *
     * @return mixed
     */
    public function getRawResult($data)
    {
        return array_get($data, 'result', $data);
    }

    /**
     * Get Status of request.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return array_get($this->items, 'ok', false);
    }

    /**
     * Magic method to get properties dynamically.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $action = substr($name, 0, 3);

        if ($action === 'get') {
            $property = snake_case(substr($name, 3));
            $response = $this->get($property);

            return $response;
        }

        return false;
    }
}
