<?php

interface Pdf_Creator
{


    public function genPDF($html, $style = null);

    /**
     *  To include params into html
     * @param string $html
     * @return string $html
     */
    public function varsToHtml($html);

    /**
     *  To remove of all pdf files that time was exceeded (The time has been set in config.php)
     * @param array $dir , string $structure
     * @return boolean
     */
    public function removeOldestPdf($dir, $structure = null);


}

?>
