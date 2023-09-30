<?php

if (!function_exists('metabaseAsset')) {
    /**
     * @param  string  $path
     *
     * @return string
     */
    function metabaseAsset(string $path): string
    {
        $path = str($path)->replaceMatches('/^[\/\s]+|[\/\s]+$/', '');
        return str(config('koffinate.metabase.url'))
            ->replaceMatches('/[\/\s]+$/', '')
            ->append('/')
            ->append($path)
            ->toString();
    }
}
