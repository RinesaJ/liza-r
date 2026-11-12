<?php
// Rruga drejt dokumentit PDF
$file = 'uploads/dokumente/strategjia_2024_2027.pdf';

if (file_exists($file)) {
    // I tregojmë browserit që ky skedar duhet të trajtohet si PDF
    header('Content-type: application/pdf');
    
    // 'inline' bën që PDF-ja të hapet brenda browserit dhe të mos shkarkohet automatikisht
    header('Content-Disposition: inline; filename="Strategjia_Liza-R_2024-2027.pdf"');
    
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
    
    // Leximi dhe shfaqja e skedarit
    @readfile($file);
} else {
    // Mesazhi në rast se harron ta ngarkosh skedarin te folderi uploads
    echo "Dokumenti i strategjisë nuk u gjet në server. Ju lutem kontrolloni folderin 'uploads/dokumente/'.";
}
?>