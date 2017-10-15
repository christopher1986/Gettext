<?php

namespace Gettext\Io\File\Filter;

use Gettext\Io\File\FileFinderInterface;

/**
 * The FilenameFilter is used to filter files based on their filename.
 */
class FilenameFilter extends AbstractFilter
{
    /**
     * The filename to accept.
     *
     * @var string $filename
     */
    private $filename;

    /**
     * Initialize a new ExtensionFilter.
     *
     * @param string $filename The filename to accept.
     */
    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    /**
     * Tests if the given file of directory should be included in the file list.
     *
     * @param \SplFileInfo $file The file or directory to test.
     * @param FileFinderInterface $finder The file finder that invoked this filter.
     * @return bool True if the file or directory should be included, otherwise false.
     */
    public function accepts(\SplFileInfo $file, FileFinderInterface $finder): bool
    {
        return ($file->isFile() && $file->getBasename() === $this->filename);
    }
}
