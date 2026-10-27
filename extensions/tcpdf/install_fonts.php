<?php

require_once 'tcpdf.php';

// Regular
echo TCPDF_FONTS::addTTFfont(
    __DIR__ . '/fonts/arialnarrow.ttf',
    'TrueTypeUnicode',
    '',
    96
);
echo "<br>";

// Bold
echo TCPDF_FONTS::addTTFfont(
    __DIR__ . '/fonts/arialnarrow_bold.ttf',
    'TrueTypeUnicode',
    '',
    96
);
echo "<br>";

// Italic
echo TCPDF_FONTS::addTTFfont(
    __DIR__ . '/fonts/arialnarrow_italic.ttf',
    'TrueTypeUnicode',
    '',
    96
);
echo "<br>";

// Bold Italic
echo TCPDF_FONTS::addTTFfont(
    __DIR__ . '/fonts/arialnarrow_bolditalic.ttf',
    'TrueTypeUnicode',
    '',
    96
);