<?php
namespace reseller\Action;
class Pdf extends ActionAbstract
{


    public function genPDF($html, $style = null)
    {

        $html_to_pdf = $this->varsToHtml($html);

        $_params = $this->Request->getParams();

        //check unicode
        $only_latin = true;
        foreach ($_params as $key => $item) {
            if (strlen($item) != strlen(utf8_decode($item))) {
                $only_latin = false;
            }
        }

        $mpdf = new \mPDF('utf-8', 'LETTER', '11', 'Arial', 10, 10, 8, 10, 20, 20, 'P', $only_latin); /* set format (margin, padding size, etc) */

        $mpdf->charset_in = 'utf-8';

//        $mpdf->SetAutoFont(AUTOFONT_CJK);

        $mpdf->simpleTables = true;
        $mpdf->useSubstitutions = false;

        $mpdf->SetTitle($this->Request->getConfig()->getPdf()->getTitle());
        $mpdf->SetAuthor($this->Request->getConfig()->getPdf()->getAuthor());

        if (!empty($style))
            $mpdf->WriteHTML($style, 1);

        $mpdf->list_indent_first_level = 0;

        $mpdf->WriteHTML($html_to_pdf, 2);

        $structure = $this->Request->getConfig()->getRootDirectory();

        if (!file_exists($structure . '/files/' . $this->Request->getParam('OrderID')))
            if (!mkdir($structure . '/files/' . $this->Request->getParam('OrderID'), 0777, true)) {
                throw new \InvalidArgumentException('Failed to create folders...');
            }

        $this->file_path = $structure . '/files/' . $this->Request->getParam('OrderID') . '/SiteLicense-' . $this->Request->getParam('LicenseKey') . '.pdf';
        $mpdf->Output($this->file_path, 'F');
        return true;
    }

    /**
     *  To include params into html
     * @param string $html
     * @return string $html
     */
    public function varsToHtml($html)
    {
        $params = $this->Request->getParams();
        foreach ($params as $params_key => $params_item) {
            if ($params_key == 'OrderProductNames') {
                $opn = array('{#OrderProductNames#}' => $this->registry->get('order_product_names')[$params["OrderProductNames"]]);
                $html = strtr($html, $opn);

            } else {
                if (!empty($params_item) && $params_item != '') {
                    $html = strtr($html, array('{#' . $params_key . '#}' => $params_item));
                } else if ($params_item == '' || !isset($params_item)) {
                    $html = preg_replace('/{#' . $params_key . '#}<br>/i', '', $html);

                }
            }
        }

        $arr = array('/<b>{#.+#}<\/b><br>/i', '/<b>{#.+#}<\/b>/i', '/<b>{#.+#}.+<\/b>/i', '/{#.+#},/i', '/<br>{#.+#}.+<\/b><br>/i', '/<br>{#.+#}.+<br>/i', '/{#.+#}<\/br>/i');
        $html = preg_replace($arr, '', $html);
        return $html;
    }

    /**
     *  To remove of all pdf files that time was exceeded (The time has been set in config.php)
     * @param array $dir , string $structure
     * @return boolean
     */
    public function removeOldestPdf($dir, $structure = null)
    {
        $dir = $structure . $dir;
        $folder = explode('/', $dir);
        $folder = array_pop($folder);

        if (!file_exists($dir)) {
            return array('dirname' => $dir, 'result' => true);
        }

        if ((!is_dir($dir) || is_link($dir)) && $folder != 'files') {
            $this->rmdir[] = $dir;
            return array('dirname' => $dir, 'result' => unlink($dir));
        }

        if (!is_file($dir))
            foreach (scandir($dir) as $item) {

                if ($item == '.' || $item == '..' || $item == 'SiteLicense.html') continue;
                $fstat = stat($dir . "/" . $item);

                $convert = $fstat['ctime'];


                if (strtotime("+" . $this->Request->getConfig()->getPdf()->getLifetime() . " seconds", $convert) < strtotime("now")) {
                    $getRes = $this->removeOldestPdf($dir . "/" . $item);
                    if ($getRes['result'] == false) {
//                            chmod($dir . "/" . $item, 0777);
                        $getRes = $this->removeOldestPdf($dir . "/" . $item);
                        if ($getRes['result'] == false) return array('dirname' => $dir . "/" . $item, 'result' => false);
                    }
                }

            }

        if ($folder != 'files') {
//            if (is_file($dir)) {
            $this->rmdir[] = $dir;

            return rmdir($dir);
//            }
        }

    }


}

?>
