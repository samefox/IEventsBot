<?php
if (function_exists('curl_init'))
{
    function get_response_curl($url, $params = array(), $type = 'GET')
    {
        $params = http_build_query($params);
        $type = $type == 'GET' ? 'GET' : 'POST';
        
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);

        if ($type == 'GET') 
        {
            curl_setopt($curl, CURLOPT_URL, $url.'?'.$params);
        }
        else if ($type == 'POST') 
        {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        } 
        
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}

if (function_exists('file_get_contents'))
{
    function get_response_file($url, $params = array(), $type = 'GET')
    {
        $response = '';
        
        $params = http_build_query($params);
        $type = $type == 'GET' ? 'GET' : 'POST';

        if ($type == 'GET') 
        {
            $response = file_get_contents($url.'?'.$params);
        }
        else if ($type == 'POST') 
        {
            $headers = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $params
                )
            );

            $context = stream_context_create($headers);
            $response = file_get_contents($url, FALSE, $context);
        }  

        return $response;
    }
}


function get_response($url, $params = array(), $type = 'GET')
{
    $response = '';

    if (function_exists('get_response_curl'))
    {
        $response = get_response_curl($url, $params, $type);
    }
    else if (function_exists('get_response_file'))
    {
        $response = get_response_file($url, $params, $type);
    }

    return $response;
}
?>