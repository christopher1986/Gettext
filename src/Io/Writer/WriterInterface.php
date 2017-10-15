<?php

namespace Gettext\Io\Writer;

/**
 * The Writer provides an object oriented interface for writing to character streams.
 */
interface WriterInterface
{
    /**
     * Close the underlying stream after the character bytes have been flushed.
     */
    public function close();

    /**
     * Write remaining character bytes to the underlying stream and clear all buffers.
     */
    public function flush();

    /**
     * Write the specified value.
     *
     * @param mixed $value The value to write.
     */
    public function write($value);
}