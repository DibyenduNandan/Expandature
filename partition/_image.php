<?php
function GetImageExtension($imagetype){
    if(empty($imagetype)) return false;
    switch ($imagetype) {
        case 'image/bmp':
            return '.bmp';

        case 'image/gif':
            return '.gif';
        
        case 'image/jpeg':
            return '.jpg';

        case 'image/png':
            return '.png';

        default:
            return false;
    }
}
?>