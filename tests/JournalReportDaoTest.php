<?php

import('lib.pkp.tests.PKPTestCase');
import('plugins.reports.journalsReport.JournalReportDao');

class JournalReportDaoTest extends PKPTestCase
{
    public function testJournalIdRetrieval()
    {
        $contextId = rand();
        $journalReportDao = new JournalReportDao($contextId);

        $this->assertEquals($contextId, $journalReportDao->getId());
    }
}
