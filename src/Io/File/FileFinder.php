<?php

namespace Gettext\Io\File;

use Gettext\Io\File\Filter\FilterInterface;

/**
 * The FileFinder is responsible for finding specific files in one or more directories.
 */
class FileFinder implements FileFinderInterface
{
    /**
     * The directories to search.
     *
     * @var \SplQueue $paths
     */
    private $paths;

    /**
     * Initialize a new FileFinder.
     *
     * @param string|\SplFileInfo $pathname The pathname to add.
     */
    public function __construct($pathname)
    {
        $this->paths = new \SplQueue();
        $this->enqueue($pathname);
    }

    /**
     * {@inheritDoc}
     */
    public function enqueue($pathname)
    {
        $path = (is_string($pathname)) ? new \SplFileInfo($pathname) : $pathname;

        if (!($path instanceof \SplFileInfo)) {
            throw new \InvalidArgumentException(sprintf(
                'Expected a string or SplFileInfo object; received %s instead.',
                (is_object($pathname)) ? get_class($pathname) : gettype($pathname)
            ));
        } elseif (!$path->isDir()) {
            throw new \InvalidArgumentException("The given pathname ($pathname) is not a directory.");
        }

        $this->paths->enqueue($pathname);
    }

    /**
     * {@inheritDoc}
     */
    public function dequeue(): \SplFileInfo
    {
        if ($this->paths->isEmpty()) {
            throw new \UnderflowException('Unable to dequeue from an empty data structure.');
        }

        return $this->paths->dequeue();
    }

    /**
     * {@inheritDoc}
     */
    public function find(FilterInterface $filter): array
    {
        $files = [];
        $paths = $this->paths;

        while (!$paths->isEmpty()) {
            $files = $files + $this->search($filter, $paths->dequeue());
        }

        return $files;
    }

    /**
     * Search the provided path for files that are accepted by the specified filter.
     *
     * @param FilterInterface $filter The filter to determine what files should be accepted.
     * @param \SplFileInfo $path The directory whose files and directories will be tested.
     * @return \SplFileInfo[] A collection of files and directory that were found.
     */
    private function search(FilterInterface $filter, \SplFileInfo $path): array
    {
        $found = [];
        $files = new \FilesystemIterator($path);

        foreach ($files as $file) {
            if ($filter->accepts($file, $this)) {
                $found[] = $file;
            }
        }

        return $found;
    }
}
