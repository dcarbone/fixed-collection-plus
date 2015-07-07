<?php

/**
 * @param $value
 * @return bool
 */
function _fixed_collection_exists_success_test($value)
{
    return ($value === 'test');
}

/**
 * @param $value
 * @return bool
 */
function _fixed_collection_exists_failure_test($value)
{
    return ($value === 'sandwich');
}

/**
 * @param $value
 * @return null
 */
function _fixed_collection_map_change_odd_values_to_null($value)
{
    if ($value % 2 === 0)
        return $value;

    return null;
}

/**
 * @param $value
 * @return bool
 */
function _fixed_collection_filter_remove_true_values($value)
{
    return ($value === false);
}