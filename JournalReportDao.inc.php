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
}
