<?php
class view
{
    function generate($template, $content = null, $data = null)
    {
        include_once "./application/views/".$template;
    }

    function generate_json_data($data)
    {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        print_r($data);
    }
}