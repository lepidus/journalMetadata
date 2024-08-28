<?php

class JournalReportDao
{
    private $journalId;

    public function __construct(int $journalId)
    {
        $this->journalId = $journalId;
    }

    public function getId(): int
    {
        return $this->journalId;
    }
}
