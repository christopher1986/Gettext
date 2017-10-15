<?php

namespace Gettext\Translation;

/**
 * The Translation class is a high-level object oriented interface for an individual translation.
 */
interface TranslationInterface
{
    /**
     * Returns the original string.
     *
     * @return string The original string.
     */
    public function getOriginalString(): string;

    /**
     * Returns the translated string.
     *
     * @return string The translated string.
     */
    public function getTranslatedString(): string;

    /**
     * Returns if present the context associated with this translation.
     *
     * @return string The context if present, otherwise empty string.
     */
    public function getContext(): string;

    /**
     * Returns true if a context is associated with this translation.
     *
     * @return bool True if a context is present for this translation.
     */
    public function hasContext(): bool;
}