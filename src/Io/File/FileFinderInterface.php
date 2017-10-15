<?php

namespace Gettext\Io\File;

use Gettext\Io\File\Filter\FilterInterface;

/**
 * The FileFinder is responsible for finding specific files in one or more directories.
 */
interface FileFinderInterface
{
    /**
     * Add the specified pathname to a queue of paths that will be traversed.
     *
     * @param string|\SplFileInfo $pathname The path to enqueue.
     * @throws \LogicException If the specified path is not a directory.
     */
    public function enqueue($pathname);
    
    /**
     * Removes and returns the path at the beginning of the queue of paths to traverse.
     *
     * @return \SplFileInfo The path that was removed from the queue.
     * @throws \UnderflowException If the queue is empty.
     */
    public function dequeue(): \SplFileInfo;
   
    /**
     * Find files in one or more directories using the specified filter.
     *
     * The specified filter is a predicate (boolean-valued function) that either
     * accepts or rejects a file found in a directory.
     *
     * @param FilterInterface $filter The filter that specifies which files will be found.
     * @return \SplFileInfo[] A collection of files that were found.
     */
    public function find(FilterInterface $filter): array;
}
