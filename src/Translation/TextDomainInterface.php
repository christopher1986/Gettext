<?php

namespace Gettext\Translation;

/**
 * The TextDomain class associates a text domain with a collection of translations.
 */
interface TextDomainInterface
{
    /**
     * Returns the name of this domain.
     *
     * @return string The domain name.
     */
    public function getDomainName(): string;

    /**
     * Returns a collection of translations associated with this domain.
     *
     * @return TranslationInterface[] A collection of translations.
     */
    public function getTranslations(): array;

    /**
     * Returns the number of translations associated with this domain.
     *
     * @return int The number of translations.
     */
    public function getTranslationCount(): int;
}