<?php

namespace Encryption;

class ProcessOutput
{
    public function __construct(){}

    public function __destruct(){}

    public function processOutput($html_output): string
    {
        $minified_output = '';
        $compressed_output = '';
        $minified_output = $this->minifyHtmlOutput($html_output);
        $compressed_output = $this->compressOutput($minified_output);

        return $compressed_output;
    }

    /**
     * Remove any unnecessary characters to reduce page latency
     *
     * @param $html_output
     * @return string|string[]|null
     */
    private function minifyHtmlOutput($html_output): string
    {
        $html_minified_output = '';
        $search = array(
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s'
        );
        $replace = array(
            '>',
            '<',
            '\\1'
        );

        if (preg_match("/\<html/i",$html_output) == 1 && preg_match("/\<\/html\>/i",$html_output) == 1)
        {
            $html_minified_output = preg_replace($search, $replace, $html_output);
        }
        return $html_minified_output;
    }

    /**
     * Use a compression algorithm to reduce size, and therefore reduce transit latency
     *
     * @param $minified_output
     * @return string
     */
    private function compressOutput($minified_output): string
    {
        $compressed_output = $minified_output;
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') != 0)
        {
            if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
            {
                $compression_level = 9;
                $encoding_mode = FORCE_DEFLATE;
                $compressed_output = gzencode($minified_output, $compression_level, $encoding_mode);
            }
        }
        return $compressed_output;
    }

}