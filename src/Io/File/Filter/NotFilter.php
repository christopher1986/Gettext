<?php

namespace Gettext\Io\File\Filter;

use Gettext\Io\File\FileFinderInterface;

/**
 * The NotFilter negates the result of a file filter.
 */
class NotFilter extends AbstractFilter
{
    /**
     * The filter whose result to negate.
     *
     * @var FilterInterface $filter
     */
    private $filter;

    /**
     * Initialize a new NotFilter.
     *
     * @param FilterInterface $filter The filter whose result to negate.
     */
    public function __construct(FilterInterface $filter)
    {
        $this->filter = $filter;
    }

    /**
     * {@inheritDoc}
     */
    public function accepts(\SplFileInfo $file, FileFinderInterface $finder): bool
    {
        return !$this->filter->accepts($file, $finder);
    }
}
