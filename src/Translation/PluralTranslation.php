<?php

namespace Gettext\Translation;

/**
 * The PluralTranslation class maintains a list of plural forms for an individual translation.
 *
 * @link https://www.gnu.org/software/gettext/manual/html_node/Translating-plural-forms.html
 */
final class PluralTranslation implements PluralTranslationInterface
{
    /**
     * The translation for which plural forms are provided.
     *
     * @var TranslationInterface $translation
     */
    private $translation;

    /**
     * The plural forms for an individual translation.
     *
     * @var string[] $pluralForms
     */
    private $pluralForms;

    /**
     * Initialize a new PluralTranslation.
     *
     * @param TranslationInterface $translation The translation to associate with plural forms.
     * @param string[] $pluralForms The plural forms for the specified translation.
     */
    public function __construct(TranslationInterface $translation, array $pluralForms)
    {
        $this->translation = $translation;
        $this->pluralForms = $pluralForms;
    }

    /**
     * Returns a collection of plural forms for this translation.
     *
     * @return string[] A collection of plural forms.
     */
    public function getPluralForms(): array
    {
        return $this->pluralForms;
    }

    /**
     * Returns the singular form of the original string.
     *
     * @return string The original string.
     */
    public function getOriginalString(): string
    {
        return $this->translation->getOriginalString();
    }

    /**
     * Returns the general form of the translated string.
     *
     * @return string The translated string.
     */
    public function getTranslatedString(): string
    {
        return $this->translation->getTranslatedString();
    }

    /**
     * Returns if present the context associated with this translation.
     *
     * @return string The context if present, otherwise empty string.
     */
    public function getContext(): string
    {
        return $this->translation->getContext();
    }

    /**
     * Returns true if a context is associated with this translation.
     *
     * @return bool True if a context is present for this translation.
     */
    public function hasContext(): bool
    {
        return $this->translation->hasContext();
    }
}