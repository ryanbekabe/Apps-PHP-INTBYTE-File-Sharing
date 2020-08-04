<?php

if (!defined('PCLERROR_LIB')) {
    define('PCLERROR_LIB', 1);
    $g_pcl_error_version = '1.0';
    $g_pcl_error_string = '';
    $g_pcl_error_code = 1;

    function PclErrorLog($p_error_code = 0, $p_error_string = '')
    {
        global $g_pcl_error_string;
        global $g_pcl_error_code;

        $g_pcl_error_code = $p_error_code;
        $g_pcl_error_string = $p_error_string;
    }

    function PclErrorFatal($p_file, $p_line, $p_error_string = '')
    {
        global $g_pcl_error_string;
        global $g_pcl_error_code;

        $v_message = '<html><body>';
        $v_message .= "<p align=center><font color=red bgcolor=white><b>PclError Library has detected a fatal error on file '$p_file', line $p_line</b></font></p>";
        $v_message .= "<p align=center><font color=red bgcolor=white><b>$p_error_string</b></font></p>";
        $v_message .= '</body></html>';
        die($v_message);
    }

    function PclErrorReset()
    {
        global $g_pcl_error_string;
        global $g_pcl_error_code;

        $g_pcl_error_code = 1;
        $g_pcl_error_string = '';
    }

    function PclErrorCode()
    {
        global $g_pcl_error_string;
        global $g_pcl_error_code;

        return $g_pcl_error_code;
    }

    function PclErrorString()
    {
        global $g_pcl_error_string;
        global $g_pcl_error_code;

        return $g_pcl_error_string." [code $g_pcl_error_code]";
    }
}
