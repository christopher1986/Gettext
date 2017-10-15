<?php

namespace Gettext\Io\Writer;

use Gettext\Io\Exception\IOException;

/**
 * The Writer provides an object oriented interface for writing character bytes to a file.
 */
final class FileWriter implements WriterInterface
{
    /**
     * In memory buffer containing character bytes.
     *
     * @var string $buffer
     */
    private $buffer = '';

    /**
     * The stream to which character bytes are written.
     *
     * @var resource $stream
     */
    private $stream;

    /**
     * Initialize a new FileWriter.
     *
     * @param \SplFileInfo $file The file to which character bytes are written.
     */
    public function __construct(\SplFileInfo $file)
    {
        $this->setFile($file);
    }

    /**
     * Close the underlying stream after the character bytes have been flushed.
     */
    public function close()
    {
        $this->flush();

        fclose($this->stream);
    }

    /**
     * Write remaining character bytes to the underlying stream and clear all buffers.
     */
    public function flush()
    {
        $written = fwrite($this->stream, $this->buffer);

        if ($written !== false) {
            $this->buffer = '';
        }
    }

    /**
     * Write the specified value.
     *
     * @param mixed $value The value to write.
     */
    public function write($value)
    {
        $this->buffer .= $value;
    }

    /**
     * Set the file to which the character bytes will be written.
     *
     * @param \SplFileInfo $file The file to which character bytes are written.
     * @throws IOException If the specified file is not writable.
     */
    private function setFile(\SplFileInfo $file)
    {
        if (!$file->isWritable()) {
            throw new IOException("Unable to write to the specified file ({$file}).");
        }

        $this->stream = fopen($file, 'w');
    }
}