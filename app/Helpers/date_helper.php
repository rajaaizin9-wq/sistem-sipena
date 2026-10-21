<?php

if (! function_exists('tanggal_indonesia')) {
    function tanggal_indonesia(?string $date): string
    {
        if (! $date) {
            return '-';
        }

        return (new IntlDateFormatter(
            'id_ID',
            IntlDateFormatter::LONG,
            IntlDateFormatter::NONE
        ))->format(new DateTime($date));
    }
}