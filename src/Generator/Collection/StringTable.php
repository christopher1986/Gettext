<?php

namespace Gettext\Generator\Collection;

/**
 * The StringTable is an immutable list of translation strings.
 */
final class StringTable implements \Countable
{
    /**
     * ASCII character for a NUL byte.
     */
    const NUL_BYTE = "\x00";

    /**
     * The string entries contained by this table.
     *
     * @var StringTableEntry[] $entries
     */
    private $entries;

    /**
     * The offset in bytes at which this table starts.
     *
     * @var int $offset
     */
    private $offset;

    /**
     * The number of strings contained within this table.
     *
     * @var int|null $size
     */
    private $size;

    /**
     * The length in bytes of this table.
     *
     * @var int|null $length
     */
    private $length;

    /**
     * Initialize a new StringTable.
     *
     * @param string[] $strings The strings that will be placed into this table.
     * @param int $offset The offset in bytes at which table starts.
     */
    public function __construct(array $strings, int $offset)
    {
        $this->setOffset($offset);
        $this->setStrings($strings);
    }

    /**
     * Returns the number of strings contained within this table.
     *
     * @return int The number of strings within this table.
     */
    public function count()
    {
        if ($this->size === null) {
            $this->size = count($this->entries);
        }

        return $this->size;
    }

    /**
     * Returns a collection of string entries contained within this table.
     *
     * @return StringTableEntry[] A collection of string entries.
     */
    public function getEntries(): array
    {
        return $this->entries;
    }

    /**
     * Returns the offset in bytes at which this table starts.
     *
     * @return int The offset at which this table starts in bytes.
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * Returns the length in bytes of this table.
     *
     * @return int The length of this table in bytes.
     */
    public function getLength(): int
    {
        if ($this->length === null) {
            $this->length = 0;

            foreach ($this->getEntries() as $entry) {
                $this->length += $entry->getLength();
            }
        }

        return $this->length;
    }

    /**
     * Returns a string representation of this table.
     *
     * @return string The string representation of this.
     */
    public function toString(): string
    {
        $string = '';

        foreach ($this->getEntries() as $entry) {
            $string .= $entry->getString() . self::NUL_BYTE;
        }

        return $string;
    }

    /**
     * Set the offset in bytes at which this table starts.
     *
     * @param int $offset The offset at which this table starts in bytes.
     * @throws \LogicException If the specified offset is a negative value.
     */
    private function setOffset(int $offset)
    {
        if ($offset < 0) {
            throw new \LogicException('The table offset cannot be a negative value.');
        }

        $this->offset = $offset;
    }

    /**
     * Append the specified collection of strings to this table.
     *
     * @param string[] $strings The strings to append to this table.
     */
    private function setStrings(array $strings)
    {
        $offset = 0;
        $entries = [];

        foreach ($strings as $string) {
            $entry = new StringTableEntry($string, $offset, $this);

            $offset += $entry->getOffset();
            $entries[] = $entry;
        }

        $this->entries = $entries;
    }
}