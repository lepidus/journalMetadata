<?php

class JournalReport
{
    private $journal;
    private $baseUrl;

    public function __construct($journal, $baseUrl)
    {
        $this->journal = $journal;
        $this->baseUrl = $baseUrl;
    }

    public function getId(): int
    {
        return $this->journal->getId();
    }

    public function getTitle(): string
    {
        return $this->journal->getLocalizedName();
    }

    public function getAffiliation(): ?string
    {
        return $this->journal->getData('publisherInstitution');
    }

    public function getSupportPhone(): ?string
    {
        return $this->journal->getData('supportPhone');
    }

    public function getContactName(): string
    {
        return $this->journal->getContactName();
    }

    public function getContactEmail(): string
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
        return $this->baseUrl . "/" . $this->journal->getPath();
    }
}
