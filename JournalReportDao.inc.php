<?php

class JournalReportDao
{
    private $journal;

    public function __construct($journal)
    {
        $this->journal = $journal;
    }

    public function getId(): int
    {
        return $this->journal->getId();
    }

    public function getTitle(): string
    {
        return $this->journal->getLocalizedName();
    }

    public function getAffiliation(): string
    {
        return $this->journal->getData('publisherInstitution');
    }

    public function getSupportPhone(): string
    {
        return $this->journal->getData('supportPhone');
    }
}
