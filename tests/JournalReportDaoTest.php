<?php

import('lib.pkp.tests.PKPTestCase');
import('plugins.reports.journalsReport.JournalReportDao');

class JournalReportDaoTest extends PKPTestCase
{
    private $journal;
    private $journalReportDao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->journal = $this->createMockedJournal();
        $this->journalReportDao = new JournalReportDao($this->journal);
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

    public function testJournalIdRetrieval()
    {
        $this->assertEquals($this->journal->getId(), $this->journalReportDao->getId());
    }

    public function testJournalTitleRetrieval()
    {
        $this->assertEquals($this->journal->getLocalizedName(), $this->journalReportDao->getTitle());
    }

    public function testJournalAffiliationRetrieval()
    {
        $this->assertEquals($this->journal->getData('publisherInstitution'), $this->journalReportDao->getAffiliation());
    }

    public function testJournalSupportPhoneRetrieval()
    {
        $this->assertEquals($this->journal->getData('supportPhone'), $this->journalReportDao->getSupportPhone());
    }

    public function testJournalContactNameRetrieval()
    {
        $this->assertEquals($this->journal->getContactName(), $this->journalReportDao->getContactName());
    }

    public function testJournalContactEmailRetrieval()
    {
        $this->assertEquals($this->journal->getContactEmail(), $this->journalReportDao->getContactEmail());
    }

    public function testJournalOnlineIssnRetrieval()
    {
        $this->assertEquals($this->journal->getData('onlineIssn'), $this->journalReportDao->getOnlineIssn());
    }

    public function testJournalPrintIssnRetrieval()
    {
        $this->assertEquals($this->journal->getData('printIssn'), $this->journalReportDao->getPrintIssn());
    }

    public function testJournalLicenseRetrieval()
    {
        $this->assertEquals($this->journal->getData('licenseUrl'), $this->journalReportDao->getLicenseUrl());
    }
}
