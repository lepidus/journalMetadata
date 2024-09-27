<?php

class CsvBuilder
{
    public static function generate($journalMetadata)
    {
        header('content-type: text/comma-separated-values');
        header("content-disposition: attachment; filename=journalMetadata-" . date('Ymd') . '.csv');

        $columns = array(
            "Título", "Instituição", "Telefone", "Editor responsável", "E-mail", "ISSN Online",
            "ISSN", "URL", "Tipo de licença", "Estrato Qualis"
        );

        try {
            $httpClient = Application::get()->getHttpClient();
            $fp = fopen('php://output', 'wt');
            fputcsv($fp, $columns);
            fputcsv($fp, [
                $journalMetadata->getTitle(),
                $journalMetadata->getAffiliation(),
                $journalMetadata->getSupportPhone(),
                $journalMetadata->getContactName(),
                $journalMetadata->getContactEmail(),
                $journalMetadata->getOnlineIssn(),
                $journalMetadata->getPrintIssn(),
                $journalMetadata->getUrl(),
                $journalMetadata->getLicenseUrl(),
                $journalMetadata->getEstratoQualis($httpClient)
            ]);
        } catch (Exception $e) {
            error_log("Erro na tentativa de montar o CSV: " . $e->getMessage());
        } finally {
            fclose($fp);
        }
    }
}
