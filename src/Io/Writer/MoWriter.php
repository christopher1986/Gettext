<?php

namespace Gettext\Io\Writer;

/**
 * The MoWriter provides additional methods for writing character bytes to a Machine Object (MO) file.
 */
final class MoWriter implements WriterInterface
{
    /**
     * The 'NUL' byte symbol for MO files.
     *
     * @var string NUL_BYTE
     */
    const NUL_BYTE = '\x00';

    /**
     * The underlying file writer.
     *
     * @var FileWriter $writer
     */
    private $writer;

    /**
     * Initialize a new MoWriter.
     *
     * @param \SplFileInfo $file The file to which character bytes are written.
     */
    public function __construct(\SplFileInfo $file)
    {
        $this->writer = new FileWriter($file);
    }

    /**
     * Close the underlying stream after the character bytes have been flushed.
     */
    public function close()
    {
        $this->writer->close();
    }

    /**
     * Write remaining character bytes to the underlying stream and clear all buffers.
     */
    public function flush()
    {
        $this->writer->flush();
    }

    /**
     * Write the specified value.
     *
     * @param mixed $value The value to write.
     */
    public function write($value)
    {
        $this->writer->write($value);
    }

    /**
     * Write the specified value by packing it into a binary string.
     *
     * @param mixed $value The value to write.
     * @param string $format The packing format.
     * @link http://php.net/manual/en/function.pack.php
     */
    public function writeBinaryString($value, string $format)
    {
        $this->write(pack($format, $value));
    }
}