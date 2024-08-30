<?php

import('lib.pkp.tests.PKPTestCase');
import('plugins.reports.journalsReport.report.JournalMetadata');

class JournalMetadataTest extends PKPTestCase
{
    private $journal;
    private $journalReport;
    private const JOURNAL_URL = "http://localhost:8000/index.php/middleearth";

    protected function setUp(): void
    {
        parent::setUp();
        $this->journal = $this->createMockedJournal();
        $this->journalReport = new JournalMetadata($this->journal, self::JOURNAL_URL);
    }

    protected function getMockedDAOs()
    {
        return [
            'JournalDAO'
        ];
    }

    private function createMockedJournal()
    {
        import('classes.journal.Journal');
        $journal = new Journal();
        $journal->setId(rand());
        $journal->setName('Middle Earth papers', 'pt_BR');
        $journal->setPath('middleearth');
        $journal->setData('publisherInstitution', 'Lepidus Tecnologia');
        $journal->setContactName('Ramiro Vaca');
        $journal->setContactEmail('rvaca@mailinator.com');
        $journal->setData('supportPhone', '987362537492');
        $journal->setData('onlineIssn', '0000-0001');
        $journal->setData('printIssn', '0000-0002');
        $journal->setData('licenseUrl', 'https://creativecommons.org/licenses/by-nc-sa/4.0/deed.pt_BR ');

        $mockJournalDAO = $this->getMockBuilder(JournalDAO::class)
            ->setMethods(['getById'])
            ->getMock();

        $mockJournalDAO->expects($this->any())
            ->method('getById')
            ->will($this->returnValue($journal));

        DAORegistry::registerDAO('JournalDAO', $mockJournalDAO);

        return $journal;
    }

    public function testJournalTitleRetrieval()
    {
        $this->assertEquals($this->journal->getLocalizedName(), $this->journalReport->getTitle());
    }

    public function testJournalAffiliationRetrieval()
    {
        $this->assertEquals($this->journal->getData('publisherInstitution'), $this->journalReport->getAffiliation());
    }

    public function testJournalSupportPhoneRetrieval()
    {
        $this->assertEquals($this->journal->getData('supportPhone'), $this->journalReport->getSupportPhone());
    }

    public function testJournalContactNameRetrieval()
    {
        $this->assertEquals($this->journal->getContactName(), $this->journalReport->getContactName());
    }

    public function testJournalContactEmailRetrieval()
    {
        $this->assertEquals($this->journal->getContactEmail(), $this->journalReport->getContactEmail());
    }

    public function testJournalOnlineIssnRetrieval()
    {
        $this->assertEquals($this->journal->getData('onlineIssn'), $this->journalReport->getOnlineIssn());
    }

    public function testJournalPrintIssnRetrieval()
    {
        $this->assertEquals($this->journal->getData('printIssn'), $this->journalReport->getPrintIssn());
    }

    public function testJournalLicenseRetrieval()
    {
        $this->assertEquals($this->journal->getData('licenseUrl'), $this->journalReport->getLicenseUrl());
    }

    public function testJournalUrlRetrieval()
    {
        $this->assertEquals(self::JOURNAL_URL, $this->journalReport->getUrl());
    }
}
