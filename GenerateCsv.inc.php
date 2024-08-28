<?php

class GenerateCsv
{
    public static function execute($journalReportDao)
    {
        header('content-type: text/comma-separated-values');
        header("content-disposition: attachment; filename=journalReport-" . date('Ymd') . '.csv');

        $columns = array(
            "ID"
        );

        try {
            $fp = fopen('php://output', 'wt');
            fputcsv($fp, $columns);
            fputcsv($fp, [$journalReportDao->getId()]);
        } catch(Exception $e) {
            error_log("Erro na tentativa de montar o CSV: " . $e->getMessage());
        } finally {
            fclose($fp);
        }
    }
}
