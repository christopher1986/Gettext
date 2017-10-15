<?php

namespace Gettext\Generator\Collection;

/**
 * The StringTableBuilder provides a fluent interface with which to create immutable string tables.
 */
class StringTableBuilder
{
    /**
     * The strings the table will contain.
     *
     * @var string[] $strings
     */
    private $strings = [];

    /**
     * The offset of the table in bytes.
     *
     * @var int $offset
     */
    private $offset = 0;

    /**
     * Append the specified string to the table.
     *
     * @param string $string The string to append.
     * @return StringTableBuilder A reference to this builder that allows for method chaining.
     */
    public function add(string $string): StringTableBuilder
    {
        $this->strings[] = $string;

        return $this;
    }

    /**
     * The offset in bytes at which the table starts.
     *
     * @param int $offset The offset in bytes.
     * @return StringTableBuilder A reference to this builder that allows for method chaining.
     */
    public function offset(int $offset): StringTableBuilder
    {
        $this->offset = $offset;

        return $this;
    }

    /**
     * Build a new StringTable.
     *
     * @return StringTable A newly initialized StringTable.
     */
    public function build(): StringTable
    {
        return new StringTable($this->strings, $this->offset);
    }
}