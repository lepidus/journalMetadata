<?php

import('plugins.reports.journalMetadata.report.CsvBuilder');
import('plugins.reports.journalMetadata.report.estratoQualis.Client');

class JournalMetadata
{
    private $journal;
    private $journalUrl;
    private const QUALIS_URL = 'https://cambirela.emnuvens.com.br:9999';

    public function __construct($journal, $journalUrl)
    {
        $this->journal = $journal;
        $this->journalUrl = $journalUrl;
    }

    public function getCsv()
    {
        CsvBuilder::generate($this);
    }

    public function getTitle(): string
    {
        return $this->journal->getLocalizedName();
    }

    public function getAffiliation(): ?string
    {
        return $this->journal->getData('publisherInstitution');
    }

    public function getContactPhone(): ?string
    {
        return $this->journal->getData('contactPhone');
    }

    public function getSupportPhone(): ?string
    {
        return $this->journal->getData('supportPhone');
    }

    public function getContactName(): ?string
    {
        return $this->journal->getContactName();
    }

    public function getContactEmail(): ?string
    {
        return $this->journal->getContactEmail();
    }

    public function getOnlineIssn(): ?string
    {
        return $this->journal->getData('onlineIssn');
    }

    public function getPrintIssn(): ?string
    {
        return $this->journal->getData('printIssn');
    }

    public function getLicenseUrl(): ?string
    {
        return $this->journal->getData('licenseUrl');
    }

    public function getUrl(): string
    {
        return $this->journalUrl;
    }

    public function getEstratoQualis($httpClient, $baseUrl = null): ?string
    {
        $estratoQualisUrl = $baseUrl ?? self::QUALIS_URL;

        if (empty($this->getOnlineIssn()) && empty($this->getPrintIssn())) {
            return "";
        }
        $issn = !empty($this->getOnlineIssn()) ? $this->getOnlineIssn() : $this->getPrintIssn();
        return Client::getByIssn($issn, $httpClient, $estratoQualisUrl)['estrato'];
    }

    public function getDoiPrefix()
    {
        $doiPrefix = null;
        $pubIdPlugins = PluginRegistry::loadCategory('pubIds', true, $this->journal->getId());
        if (isset($pubIdPlugins['doipubidplugin'])) {
            $doiPubIdPlugin = $pubIdPlugins['doipubidplugin'];
            if (!$doiPubIdPlugin->getSetting($this->journal->getId(), 'enabled')) {
                return null;
            }
            $doiPrefix = $doiPubIdPlugin->getSetting($this->journal->getId(), 'doiPrefix');
        }
        return $doiPrefix;
    }
}
