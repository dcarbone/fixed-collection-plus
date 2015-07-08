<?php namespace DCarbone;

/**
 * Class AbstractFixedCollectionPlus
 * @package DCarbone
 */
abstract class AbstractFixedCollectionPlus extends \SplFixedArray implements FixedCollectionInterface
{
    /**
     * Append a value
     *
     * @param mixed $value
     * @return void
     */
    public function append($value)
    {
        $size = count($this);
        $this->setSize($size + 1);
        $this->offsetSet($size, $value);
    }

    /**
     * Try to determine if an identical element is already in this collection
     *
     * @param mixed $element
     * @return bool
     */
    public function contains($element)
    {
        foreach($this as $v)
        {
            if ($v === $element)
                return true;
        }

        return false;
    }

    /**
     * Custom "contains" method
     *
     * @param callable $func
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function exists($func)
    {
        if (is_callable($func, false, $callable_name))
        {
            // If this is a method on an object (except for \Closure), parse and continue
            if (strpos($callable_name, '::') !== false && strpos($callable_name, 'Closure') === false)
            {
                $exp = explode('::', $callable_name);
                foreach($this as $v)
                {
                    if ($exp[0]::$exp[1]($v))
                        return true;
                }
            }
            // Else, execute raw $func value as function
            else
            {
                foreach($this as $v)
                {
                    if ($func($v))
                        return true;
                }
            }

            return false;
        }

        throw new \InvalidArgumentException(vsprintf(
            '%s::exists - Un-callable "$func" value seen.',
            array(get_class($this)))
        );
    }

    /**
     * Clones the functionality of array_map and applies it to this collection, returning a new object.
     *
     * @link http://us1.php.net/array_map
     *
     * They scope "static" is used so that an instance of the extended class is returned.
     *
     * @param callable $func
     * @throws \InvalidArgumentException
     * @return \DCarbone\AbstractFixedCollectionPlus
     */
    public function map($func)
    {
        if (is_callable($func, false, $callable_name))
        {
            /** @var \DCarbone\AbstractFixedCollectionPlus $new */
            // Create new instance
            $new = new static(parent::getSize());

            // If this is a method on an object (except for \Closure), parse and continue
            if (strpos($callable_name, '::') !== false && strpos($callable_name, 'Closure') === false)
            {
                $exp = explode('::', $callable_name);
                foreach($this as $i=>$v)
                {
                    $new[$i] = $exp[0]::$exp[1]($v);
                }
            }
            else
            {
                foreach($this as $i=>$v)
                {
                    $new[$i] = $func($v);
                }
            }

            return $new;
        }

        throw new \InvalidArgumentException(get_class($this).'::map - Un-callable "$func" value seen!');
    }

    /**
     * Applies array_filter to internal collection, returns new instance with resulting values.
     *
     * @link http://www.php.net/manual/en/function.array-filter.php
     *
     * Inspired by:
     *
     * @link http://www.doctrine-project.org/api/common/2.3/source-class-Doctrine.Common.Collections.ArrayCollection.html#377-387
     *
     * @param callable $func
     * @throws \InvalidArgumentException
     * @return \DCarbone\AbstractFixedCollectionPlus
     */
    public function filter($func = null)
    {
        $new = new static(parent::getSize());
        $newSize = 0;
        if (null === $func)
        {
            foreach($this as $i=>$v)
            {
                if ($v)
                    $new[$newSize++] = $v;
            }
        }
        else if (is_callable($func, false, $callable_name))
        {
            // If this is a method on an object (except for \Closure), parse and continue
            if (strpos($callable_name, '::') !== false && strpos($callable_name, 'Closure') === false)
            {
                $exp = explode('::', $callable_name);
                foreach($this as $i=>$v)
                {
                    if ($exp[0]::$exp[1]($v))
                        $new[$newSize++] = $v;
                }
            }
            else
            {
                foreach($this as $i=>$v)
                {
                    if ($func($v))
                        $new[$newSize++] = $v;
                }
            }
        }
        else
        {
            throw new \InvalidArgumentException(vsprintf(
                '%s::filter - Argument 1 expected to be null or callable.',
                array(get_class($this))
            ));
        }

        $new->setSize($newSize);
        return $new;
    }

    /**
     * Return index of desired key
     *
     * @param mixed $value
     * @return int
     */
    public function indexOf($value)
    {
        foreach($this as $i=>$v)
        {
            if ($value === $v)
                return $i;
        }
        return -1;
    }

    /**
     * Is this collection empty?
     *
     * @return bool
     */
    public function isEmpty()
    {
        return count($this) === 0;
    }

    /**
     * Return the first item in the collection
     *
     * @return mixed
     */
    public function first()
    {
        if ($this->isEmpty())
            return null;

        return $this[0];
    }

    /**
     * Return the last element in the collection
     *
     * @return mixed
     */
    public function last()
    {
        if ($this->isEmpty())
            return null;

        return $this[count($this)-1];
    }
}