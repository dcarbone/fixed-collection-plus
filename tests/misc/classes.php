<?php

/**
 * Class FixedCollectionPlusTests
 */
class FixedCollectionPlusTests
{

    /**
     * @param $value
     * @return bool
     */
    public static function _fixed_collection_exists_success_test($value)
    {
        return ($value === 'test');
    }

    /**
     * @param $value
     * @return bool
     */
    public static function _fixed_collection_exists_failure_test($value)
    {
        return ($value === 'sandwich');
    }

    /**
     * @param $value
     * @return null
     */
    public static function _fixed_collection_map_change_odd_values_to_null($value)
    {
        if ($value % 2 === 0)
            return $value;

        return null;
    }

    /**
     * @param $value
     * @return bool
     */
    public static function _fixed_collection_filter_remove_true_values($value)
    {
        return ($value === false);
    }
}

/**
 * Class MySuperAwesomeIteratorClass
 */
class MySuperAwesomeIteratorClass extends \ArrayIterator { }

/**
 * Class MySuperAwesomeFixedCollectionClass
 */
class MySuperAwesomeFixedCollectionClass extends \DCarbone\FixedCollectionPlus { }