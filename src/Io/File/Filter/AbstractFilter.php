<?php

namespace Gettext\Io\File\Filter;

/**
 * The AbstractFilter provides a skeleton implementation of the FilterInterface
 */
abstract class AbstractFilter implements FilterInterface
{
    /**
     * Applies a logical "AND" operator between this filter and the given filter.
     *
     * @param AbstractFilter $filter The filter to use as second operand.
     * @return AbstractFilter The filter that represent the logical operator.
     */
    public function andFilter(AbstractFilter $filter): AbstractFilter
    {
        return new AndFilter($this, $filter);
    }

    /**
     * Applies a logical "OR" operator between this filter and the given filter.
     *
     * @param AbstractFilter $filter The filter to use as second operand.
     * @return AbstractFilter The filter that represent the logical operator.
     */
    public function orFilter(AbstractFilter $filter): AbstractFilter
    {
        return new OrFilter($this, $filter);
    }

    /**
     * Applies negation, also called logical complement, to this filter.
     *
     * @return AbstractFilter A filter that negates the result of this filter.
     */
    public function notFilter(): AbstractFilter
    {
        return new NotFilter($this);
    }
}
