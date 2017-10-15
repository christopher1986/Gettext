<?php

namespace Gettext\Translation;

/**
 * The TextDomain class associates a text domain with a collection of translations.
 */
final class TextDomain implements TextDomainInterface
{
    /**
     * The name of this domain.
     *
     * @var string $domainName
     */
    private $domainName;

    /**
     * The translations associated with this text domain.
     *
     * @var TranslationInterface[] $translations
     */
    private $translations;

    /**
     * Initialize a new TextDomain.
     *
     * @param string $domainName The name of this domain.
     * @param array $translations The translations associated with this domain.
     */
    public function __construct(string $domainName, array $translations)
    {
        $this->domainName = $domainName;
        $this->translations = $translations;
    }

    /**
     * Returns the name of this domain.
     *
     * @return string The domain name.
     */
    public function getDomainName(): string
    {
        return $this->domainName;
    }

    /**
     * Returns a collection of translations associated with this domain.
     *
     * @return TranslationInterface[] A collection of translations.
     */
    public function getTranslations(): array
    {
        return $this->translations;
    }

    /**
     * Returns the number of translations associated with this domain.
     *
     * @return int The number of translations.
     */
    public function getTranslationCount(): int
    {
        return count($this->translations);
    }
}