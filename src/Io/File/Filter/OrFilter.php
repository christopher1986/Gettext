<?php

namespace Gettext\Io\File\Filter;

use Gettext\Io\File\FileFinderInterface;

/**
 * The OrFilter applies a logical "OR" operand between two file filters.
 */
class OrFilter extends AbstractFilter
{
    /**
     * The first filter.
     *
     * @var FilterInterface $first
     */
    private $first;

    /**
     * The other filter.
     *
     * @var FilterInterface $other
     */
    private $other;

    /**
     * Initialize a new OrFilter.
     *
     * @param FilterInterface $first The filter to use as first operand.
     * @param FilterInterface $other The filter to use as second operand.
     */
    public function __construct(FilterInterface $first, FilterInterface $other)
    {
        $this->first = $first;
        $this->other = $other;
    }

    /**
     * {@inheritDoc}
     */
    public function accepts(\SplFileInfo $file, FileFinderInterface $finder): bool
    {
        $first = $this->first;
        $other = $this->other;

        return ($first->accepts($file, $finder) || $other->accepts($file, $finder));
    }
}
