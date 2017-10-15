<?php

namespace Gettext\Io\File\Filter;

use Gettext\Io\File\FileFinderInterface;

/**
 * The Filter determines which files will be added to the list of accepted files by a finder.
 */
interface FilterInterface
{
    /**
     * Tests whether the specified file should added to the list of accepted files.
     *
     * @param \SplFileInfo $file The file that will be tested by this filter.
     * @param FileFinderInterface $finder The finder that invoked this filter.
     * @return bool True to add to the specified file to the file list.
     */
    public function accepts(\SplFileInfo $file, FileFinderInterface $finder): bool;
}
