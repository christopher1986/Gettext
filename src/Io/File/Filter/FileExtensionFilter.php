<?php

namespace Gettext\Io\File\Filter;

use Gettext\Io\File\FileFinderInterface;

/**
 * The FileExtensionFilter is used to filter files based on their file extension.
 */
class FileExtensionFilter extends AbstractFilter
{
    /**
     * The file extension to accept.
     *
     * @var string $extension
     */
    private $extension;

    /**
     * Initialize a new ExtensionFilter.
     *
     * @param string $extension The file extension to accept.
     */
    public function __construct(string $extension)
    {
        $this->extension = ltrim($extension, '.');
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
        return ($file->isFile() && $file->getExtension() === $this->extension);
    }
}
