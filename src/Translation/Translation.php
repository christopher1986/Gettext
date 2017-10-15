<?php

namespace Gettext\Translation;

/**
 * The Translation class is a high-level object oriented interface for an individual translation.
 */
final class Translation implements TranslationInterface
{
    /**
     * The original string.
     *
     * @var string $translatedString
     */
    private $originalString;

    /**
     * The translated string.
     *
     * @var string $translatedString
     */
    private $translatedString;

    /**
     * The translation context.
     *
     * @var string $context
     */
    private $context;

    /**
     * Initialize a new Translation.
     *
     * @param string $originalString The original string.
     * @param string $translatedString The translated string.
     * @param string $context (optional) The translation context.
     */
    public function __construct(string $originalString, string $translatedString, string $context = '')
    {
        $this->originalString = $originalString;
        $this->translatedString = $translatedString;
        $this->context = $context;
    }

    /**
     * Returns the original string.
     *
     * @return string The original string.
     */
    public function getOriginalString(): string
    {
        return $this->originalString;
    }

    /**
     * Returns the translated string.
     *
     * @return string The translated string.
     */
    public function getTranslatedString(): string
    {
        return $this->translatedString;
    }

    /**
     * Returns if present the context associated with this translation.
     *
     * @return string The context if present, otherwise empty string.
     */
    public function getContext(): string
    {
        return $this->context;
    }

    /**
     * Returns true if a context is associated with this translation.
     *
     * @return bool True if a context is present for this translation.
     */
    public function hasContext(): bool
    {
        return ($this->context !== '');
    }
}