<?php

use GuzzleHttp\Psr7\Response;

import('lib.pkp.tests.PKPTestCase');
import('plugins.reports.journalsReport.report.JournalMetadata');
import('plugins.reports.journalsReport.tests.helpers.ClientInterfaceForTests');

class JournalMetadataTest extends PKPTestCase
{
    private $journal;
    private $journalMetadata;
    private const JOURNAL_URL = "http://localhost:8000/index.php/middleearth";
    private const BASE_URL = "http://localhost:8081";

    protected function setUp(): void
    {
        parent::setUp();
        $this->journal = $this->createMockedJournal();
        $this->journalMetadata = new JournalMetadata($this->journal, self::JOURNAL_URL);
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
        $this->assertEquals($this->journal->getLocalizedName(), $this->journalMetadata->getTitle());
    }

    public function testJournalAffiliationRetrieval()
    {
        $this->assertEquals($this->journal->getData('publisherInstitution'), $this->journalMetadata->getAffiliation());
    }

    public function testJournalSupportPhoneRetrieval()
    {
        $this->assertEquals($this->journal->getData('supportPhone'), $this->journalMetadata->getSupportPhone());
    }

    public function testJournalContactNameRetrieval()
    {
        $this->assertEquals($this->journal->getContactName(), $this->journalMetadata->getContactName());
    }

    public function testJournalContactEmailRetrieval()
    {
        $this->assertEquals($this->journal->getContactEmail(), $this->journalMetadata->getContactEmail());
    }

    public function testJournalOnlineIssnRetrieval()
    {
        $this->assertEquals($this->journal->getData('onlineIssn'), $this->journalMetadata->getOnlineIssn());
    }

    public function testJournalPrintIssnRetrieval()
    {
        $this->assertEquals($this->journal->getData('printIssn'), $this->journalMetadata->getPrintIssn());
    }

    public function testJournalLicenseRetrieval()
    {
        $this->assertEquals($this->journal->getData('licenseUrl'), $this->journalMetadata->getLicenseUrl());
    }

    public function testJournalUrlRetrieval()
    {
        $this->assertEquals(self::JOURNAL_URL, $this->journalMetadata->getUrl());
    }

    public function testJournalEstratoQualisRetrieval()
    {
        $httpClientMock = $this->createMock(ClientInterfaceForTests::class);
        $responseBody = json_encode([
            "issn" => "0378-5955",
            "issnUnificado" => "",
            "titulo" => "HEARING RESEARCH",
            "areaMae" => "MEDICINA I",
            "estrato" => "A1"
        ]);

        $httpClientMock->method('request')
            ->will(
                $this->returnValue(
                    new Response(200, [], $responseBody)
                )
            );
        $this->assertEquals("A1", $this->journalMetadata->getEstratoQualis($httpClientMock, self::BASE_URL));
    }
}
