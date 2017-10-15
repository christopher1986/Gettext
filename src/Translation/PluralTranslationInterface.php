<?php

namespace Gettext\Translation;

/**
 * The PluralTranslation class maintains a list of plural forms for an individual translation.
 */
interface PluralTranslationInterface extends TranslationInterface
{
    /**
     * Returns a collection of plural forms for this translation.
     *
     * @return string[] A collection of plural forms.
     */
    public function getPluralForms(): array;
}