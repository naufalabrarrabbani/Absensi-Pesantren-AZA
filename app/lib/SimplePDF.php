<?php
/**
 * Simple PDF Generator Class
 * Alternative to mPDF for basic PDF generation
 */
class SimplePDF {
    private $content = '';
    private $title = '';
    
    public function __construct($title = 'Document') {
        $this->title = $title;
    }
    
    public function WriteHTML($html) {
        // Convert HTML to plain text for simple PDF
        $this->content = $this->htmlToText($html);
    }
    
    private function htmlToText($html) {
        // Remove HTML tags and convert to readable text
        $text = strip_tags($html);
        $text = html_entity_decode($text);
        return $text;
    }
    
    public function Output($filename, $mode = 'D') {
        if ($mode == 'D') {
            // Force download
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Cache-Control: private, max-age=0, must-revalidate');
            header('Pragma: public');
        }
        
        // Generate basic PDF structure
        echo $this->generatePDF();
    }
    
    private function generatePDF() {
        $pdf = "%PDF-1.4\n";
        $pdf .= "1 0 obj\n";
        $pdf .= "<<\n";
        $pdf .= "/Type /Catalog\n";
        $pdf .= "/Pages 2 0 R\n";
        $pdf .= ">>\n";
        $pdf .= "endobj\n";
        
        $pdf .= "2 0 obj\n";
        $pdf .= "<<\n";
        $pdf .= "/Type /Pages\n";
        $pdf .= "/Kids [3 0 R]\n";
        $pdf .= "/Count 1\n";
        $pdf .= ">>\n";
        $pdf .= "endobj\n";
        
        $content = $this->content;
        $contentLength = strlen($content);
        
        $pdf .= "3 0 obj\n";
        $pdf .= "<<\n";
        $pdf .= "/Type /Page\n";
        $pdf .= "/Parent 2 0 R\n";
        $pdf .= "/MediaBox [0 0 612 792]\n";
        $pdf .= "/Contents 4 0 R\n";
        $pdf .= "/Resources <<\n";
        $pdf .= "/Font <<\n";
        $pdf .= "/F1 <<\n";
        $pdf .= "/Type /Font\n";
        $pdf .= "/Subtype /Type1\n";
        $pdf .= "/BaseFont /Helvetica\n";
        $pdf .= ">>\n";
        $pdf .= ">>\n";
        $pdf .= ">>\n";
        $pdf .= ">>\n";
        $pdf .= "endobj\n";
        
        $pdf .= "4 0 obj\n";
        $pdf .= "<<\n";
        $pdf .= "/Length " . ($contentLength + 44) . "\n";
        $pdf .= ">>\n";
        $pdf .= "stream\n";
        $pdf .= "BT\n";
        $pdf .= "/F1 12 Tf\n";
        $pdf .= "50 720 Td\n";
        $pdf .= "(" . $content . ") Tj\n";
        $pdf .= "ET\n";
        $pdf .= "endstream\n";
        $pdf .= "endobj\n";
        
        $pdf .= "xref\n";
        $pdf .= "0 5\n";
        $pdf .= "0000000000 65535 f \n";
        $pdf .= "0000000009 65535 n \n";
        $pdf .= "0000000074 65535 n \n";
        $pdf .= "0000000131 65535 n \n";
        $pdf .= "0000000329 65535 n \n";
        $pdf .= "trailer\n";
        $pdf .= "<<\n";
        $pdf .= "/Size 5\n";
        $pdf .= "/Root 1 0 R\n";
        $pdf .= ">>\n";
        $pdf .= "startxref\n";
        $pdf .= "438\n";
        $pdf .= "%%EOF\n";
        
        return $pdf;
    }
}
?>
