<?php
    function _json($data)
    {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
    }
?>