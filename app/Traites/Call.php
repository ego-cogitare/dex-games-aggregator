<?php

namespace App\Traites;


/**
 * Trait Call
 * @package App\Traites
 */
trait Call
{
    /**
     * @param string $action
     * @param array $params
     * @param array $request
     * @param string $verb
     * @param null $payload
     * @param array $headers
     * @param bool $raw
     * @return mixed
     */
    public function call(string $action = '', array $params = [], array $request = [], string $verb = 'GET', $payload = null, array $headers = [], bool $raw = false)
    {
        $query = empty($params) ? '' : '/' . implode('/', $params);
        $request = empty($request) ? '' : '?' . http_build_query($request);
        $url = sprintf('%s/%s%s%s', $this->apiUrl, $action, $query, $request);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if ($payload) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        }
        if ($verb === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
        } else if ($verb !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $verb);
        }
        $response = curl_exec($ch);

        if ($raw) {
            return $response;
        }

        return json_decode($response, true);
    }
}

