<?php
function truncateText($text, $maxLength) {
    if (strlen($text) > $maxLength) {
        $truncatedText = substr($text, 0, $maxLength - 3) . '...';
        return $truncatedText;
    }
    return $text;
}