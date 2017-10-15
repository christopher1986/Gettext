<?php

namespace Gettext\Generator\Collection;

/**
 * The StringTableEntry holds a single string and it's relative offset within the string table.
 */
class StringTableEntry
{
    /**
     * The string this entry encapsulates.
     *
     * @var string $string
     */
    private $string;

    /**
     * The string offset in bytes.
     *
     * @var int $offset;
     */
    private $offset;

    /**
     * The that contains this entry.
     *
     * @var StringTable $table
     */
    private $table;

    /**
     * The computed string length.
     *
     * @var int|null $length
     */
    private $length;

    /**
     * Initialize a new StringTableEntry.
     *
     * @param string $string The string for this table entry.
     * @param int $offset The relative offset in bytes for the specified string.
     * @param StringTable $table The table that contains this entry.
     */
    public function __construct(string $string, int $offset, StringTable $table)
    {
        $this->string = $string;
        $this->offset = $offset;
        $this->table = $table;
    }

    /**
     * Returns the string contained by this entry.
     *
     * @return string The string contained by this entry.
     */
    public function getString(): string
    {
        return $this->string;
    }

    /**
     * Returns the length in bytes of the string.
     *
     * @return int the string length in bytes.
     */
    public function getLength(): int
    {
        if ($this->length === null) {
            $this->length = strlen($this->string);
        }

        return $this->length;
    }

    /**
     * Returns the absolute offset in bytes.
     *
     * @return int the absolute offset in bytes.
     */
    public function getOffset(): int
    {
        return $this->offset + $this->table->getOffset();
    }

    /**
     * Returns the relative offset in bytes.
     *
     * The offset of the string is relative to the table that contains it.
     *
     * @return int the relative offset in bytes.
     */
    public function getRelativeOffset(): int
    {
        return $this->offset;
    }
}