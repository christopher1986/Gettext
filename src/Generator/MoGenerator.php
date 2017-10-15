<?php

namespace Gettext\Generator;

use Gettext\Generator\Collection\StringTable;
use Gettext\Generator\Collection\StringTableBuilder;
use Gettext\Io\Writer\MoWriter;
use Gettext\Translation\PluralTranslationInterface;
use Gettext\Translation\TextDomainInterface;
use Gettext\Translation\Translation;

/**
 * The MoGenerator builds a Machine Object (MO) file from a text domain.
 *
 * @link https://www.gnu.org/software/gettext/manual/html_node/MO-Files.html
 * @link https://github.com/oscarotero/Gettext/blob/master/src/Generators/Mo.php
 */
final class MoGenerator
{
    /**
     * ASCII character for end of transmission byte.
     */
    const EOT_BYTE = "\x04";

    /**
     * ASCII character for a NUL byte.
     */
    const NUL_BYTE = "\x00";

    /**
     * The little-endian format.
     *
     * @var string PACK_FORMAT
     */
    const PACK_FORMAT = 'V';

    /**
     * Magic number for little endian format.
     *
     * @var int MAGIC_NUMBER
     */
    const MAGIC_NUMBER = 0x950412de;

    /**
     * The file format revision number.
     *
     * @var int REVISION_NUMBER
     */
    const REVISION_NUMBER = 0;

    /**
     * Generate a MO file for translation contained by specified text domain.
     *
     * @param TextDomainInterface $textDomain The text domain containing translations.
     * @param \SplFileInfo $file The file to which the generated contents will be written.
     */
    public function generateFile(TextDomainInterface $textDomain, \SplFileInfo $file)
    {
        $translations = $textDomain->getTranslations();
        $translationCount = $textDomain->getTranslationCount();

        $originalTableOffset = 7 * 4;
        $originalTable = $this->getOriginalTable($translations, $originalTableOffset);
        $originalTableSize = $translationCount * (4 + 4);

        $translationTableOffset = $originalTableOffset + $originalTableSize;
        $translationTable = $this->getTranslationTable($translations, $translationTableOffset);
        $translationTableSize = $translationCount * (4 + 4);

        $hashingTableOffset = $translationTableOffset + $translationTableSize;
        $hashingTableSize = 0;

        $writer = new MoWriter($file);

        $this->writeMagicNumber(self::MAGIC_NUMBER, $writer);
        $this->writeRevisionNumber(self::REVISION_NUMBER, $writer);
        $this->writeNumberOfStrings($translationCount, $writer);
        $this->writeTableOffset($originalTableOffset, $writer);
        $this->writeTableOffset($translationTableOffset, $writer);
        $this->writeTableSize($hashingTableSize, $writer);
        $this->writeTableOffset($hashingTableOffset, $writer);
        $this->writeTableDescriptor($originalTable, $writer);
        $this->writeTableDescriptor($translationTable, $writer);
        $this->writeTable($originalTable, $writer);
        $this->writeTable($translationTable, $writer);

        $writer->close();
    }

    /**
     * Write the magic number for this MO file.
     *
     * The magic number can be used to determine if this MO file was generated
     * using big endian or little endian byte order.
     *
     * @param int $number The magic number (0x950412de or 0xde120495).
     * @param MoWriter $writer The writer with which to write the magic number.
     */
    private function writeMagicNumber(int $number, MoWriter $writer)
    {
        $writer->writeBinaryString($number, self::PACK_FORMAT);
    }

    /**
     * Writer the current revision of the file format.
     *
     * @param int $number The revision number.
     * @param MoWriter $writer The writer with which to write the revision number.
     */
    private function writeRevisionNumber(int $number, MoWriter $writer)
    {
        $writer->writeBinaryString($number, self::PACK_FORMAT);
    }

    /**
     * Write the number of translation string contained in this MO file.
     *
     * @param int $count The number of translation strings.
     * @param MoWriter $writer The writer with which to write the translation count.
     */
    private function writeNumberOfStrings(int $count, MoWriter $writer)
    {
        $writer->writeBinaryString($count, self::PACK_FORMAT);
    }

    /**
     * Write the offset in bytes at which a string table starts.
     *
     * @param int $offset The table offset in bytes.
     * @param MoWriter $writer The writer with which to write the offset.
     */
    private function writeTableOffset(int $offset, MoWriter $writer)
    {
        $writer->writeBinaryString($offset, self::PACK_FORMAT);
    }

    /**
     * Write the size of a string table in bytes.
     *
     * @param int $size The table size in bytes.
     * @param MoWriter $writer The writer with which to write the size.
     */
    private function writeTableSize(int $size, MoWriter $writer)
    {
        $writer->writeBinaryString($size, self::PACK_FORMAT);
    }

    /**
     * Write a table descriptor for the specified string table.
     *
     * The table descriptor contains the offset and length for each string
     * contained in a string table.
     *
     * @param StringTable $table The table for who to write the descriptor.
     * @param MoWriter $writer The writer with which to write the descriptor.
     */
    private function writeTableDescriptor(StringTable $table, MoWriter $writer)
    {
        foreach ($table->getEntries() as $entry) {
            $writer->writeBinaryString($entry->getLength(), self::PACK_FORMAT);
            $writer->writeBinaryString($entry->getOffset(), self::PACK_FORMAT);
        }
    }

    /**
     * Writer the strings contained within the specified string table.
     *
     * @param StringTable $table The table whose strings to write.
     * @param MoWriter $writer The writer with which to write the strings.
     */
    private function writeTable(StringTable $table, MoWriter $writer)
    {
        $writer->write($table->toString());
    }

    /**
     * Returns a StringTable object containing the original strings.
     *
     * @param Translation[] $translations The translations to append to the string table.
     * @param int $offset The offset in bytes at which the string table starts.
     * @return StringTable The string table containing the original strings.
     */
    private function getOriginalTable(array $translations, int $offset): StringTable
    {
        $tableBuilder = new StringTableBuilder();
        $tableBuilder->offset($offset);

        foreach ($translations as $translation) {
            $originalString = $translation->getOriginalString();

            if ($translation->hasContext()) {
                $originalString  = $translation->getContext();
                $originalString .= self::EOT_BYTE;
                $originalString .= $translation->getOriginalString();
            }

            if ($translation instanceof PluralTranslationInterface) {
                $originalString .= self::NUL_BYTE;
                $originalString .= $translation->getTranslatedString();
            }

            $tableBuilder->add($originalString);
        }

        return $tableBuilder->build();
    }

    /**
     * Returns a StringTable object containing the translation strings.
     *
     * @param Translation[] $translations The translations to append to the string table.
     * @param int $offset The offset in bytes at which the string table starts.
     * @return StringTable The string table containing the translations.
     */
    private function getTranslationTable(array $translations, int $offset): StringTable
    {
        $tableBuilder = new StringTableBuilder();
        $tableBuilder->offset($offset);

        foreach ($translations as $translation) {
            $translatedString = $translation->getTranslatedString();

            if ($translation instanceof PluralTranslationInterface) {
                $translatedString .= self::NUL_BYTE;
                $translatedString .= join(self::NUL_BYTE, $translation->getPluralForms());
            }

            $tableBuilder->add($translatedString);
        }

        return $tableBuilder->build();
    }
}