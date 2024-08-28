<?php

class GenerateCsv
{
    public static function execute($journalReportDao)
    {
        header('content-type: text/comma-separated-values');
        header("content-disposition: attachment; filename=journalReport-" . date('Ymd') . '.csv');

        $columns = array(
            "ID", "Título", "Instituição", "Telefone", "Editor responsável", "E-mail", "ISSN Online",
            "ISSN", "Tipo de licença"
        );

        try {
            $fp = fopen('php://output', 'wt');
            fputcsv($fp, $columns);
            fputcsv($fp, [
                $journalReportDao->getId(),
                $journalReportDao->getTitle(),
                $journalReportDao->getAffiliation(),
                $journalReportDao->getSupportPhone(),
                $journalReportDao->getContactName(),
                $journalReportDao->getContactEmail(),
                $journalReportDao->getOnlineIssn(),
                $journalReportDao->getPrintIssn(),
                $journalReportDao->getLicenseUrl()
            ]);
        } catch(Exception $e) {
            error_log("Erro na tentativa de montar o CSV: " . $e->getMessage());
        } finally {
            fclose($fp);
        }
    }
}
