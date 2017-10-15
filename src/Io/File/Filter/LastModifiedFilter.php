<?php

namespace Gettext\Io\File\Filter;

use Gettext\Io\File\FileFinderInterface;

/**
 * The LastModifiedFilter is used to filter files based on their last modification time.
 */
class LastModifiedFilter extends AbstractFilter
{
    /**
     * Compare timestamps using the equal to operator.
     *
     * @var string COMPARISON_EQ
     */
    const COMPARISON_EQ = '===';

    /**
     * Compare timestamps using the greater than operator.
     *
     * @var string COMPARISON_GT
     */
    const COMPARISON_GT = '>';

    /**
     * Compare timestamps using the less than operator.
     *
     * @var string COMPARISON_LT
     */
    const COMPARISON_LT = '<';

    /**
     * Compare timestamps using the greater than or equal to operator.
     *
     * @var string COMPARISON_GTE
     */
    const COMPARISON_GTE = '>=';

    /**
     * Compare timestamps using the less than or equal to operator.
     *
     * @var string COMPARISON_LTE
     */
    const COMPARISON_LTE = '<=';

    /**
     * Compare timestamps using the not equal to operator.
     *
     * @var string COMPARISON_NEQ
     */
    const COMPARISON_NEQ = '!==';

    /**
     * The Unix timestamp to compare against.
     *
     * @var int $timestamp
     */
    private $timestamp;

    /**
     * The comparison operator.
     *
     * @var string $operator
     */
    private $operator;

    /**
     * Initialize a new ExtensionFilter.
     *
     * @param int $timestamp The timestamp to compare against.
     * @param string $operator The comparison operator.
     */
    public function __construct(int $timestamp, string $operator)
    {
        $this->setTimestamp($timestamp);
        $this->setOperator($operator);
    }

    /**
     * Returns the Unix timestamp to compare against.
     *
     * @return int The Unix timestamp to compare against.
     */
    private function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * Set the Unix timestamp to compare against.
     *
     * @param int $timestamp The Unix timestamp to compare against.
     * @throws \InvalidArgumentException If the given Unix timestamp is smaller than zero.
     */
    private function setTimestamp(int $timestamp)
    {
        if ($timestamp < 0) {
            throw new \InvalidArgumentException("Illegal timestamp ({$timestamp}) provided.");
        }

        $this->timestamp = $timestamp;
    }

    /**
     * Returns the comparison operator.
     *
     * @return string The comparison operator.
     */
    private function getOperator(): string
    {
        return $this->operator;
    }

    /**
     * Set the comparison operator.
     *
     * @param string $operator The comparison operator.
     * @throws \InvalidArgumentException If the given operator is not supported.
     */
    private function setOperator(string $operator)
    {
        if (!in_array($operator, ['===', '>', '<', '>=', '<=', '!=='])) {
            throw new \InvalidArgumentException("Unknown operator({$operator}) provided.");
        }

        $this->operator = $operator;
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
        $operator = $this->getOperator();
        $timestamp = $this->getTimestamp();

        switch ($operator) {
            case self::COMPARISON_EQ:
                $accepts = ($file->getMTime() === $timestamp);
                break;
            case self::COMPARISON_GT:
                $accepts = ($file->getMTime() > $timestamp);
                break;
            case self::COMPARISON_LT:
                $accepts = ($file->getMTime() < $timestamp);
                break;
            case self::COMPARISON_GTE:
                $accepts = ($file->getMTime() >= $timestamp);
                break;
            case self::COMPARISON_LTE:
                $accepts = ($file->getMTime() <= $timestamp);
                break;
            case self::COMPARISON_NEQ:
                $accepts = ($file->getMTime() !== $timestamp);
                break;
            default:
                $accepts = false;
                break;
        }

        return $accepts;
    }
}
