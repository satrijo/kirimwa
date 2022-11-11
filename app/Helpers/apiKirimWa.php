<?php
namespace App\Helpers;

use Exception;

class apiKirimWa
{
    public $token = 'JYmU8E5eswOll6qd@Us1_Qw_iMtzNnLtefFTjvdXyNrUaqu~-satriyo'; // token dari api.kirimwa.id

    public function apiKirimWaRequest(array $params) {
        $httpStreamOptions = [
          'method' => $params['method'] ?? 'GET',
          'header' => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . ($params['token'] ?? '')
          ],
          'timeout' => 15,
          'ignore_errors' => true
        ];

        if ($httpStreamOptions['method'] === 'POST') {
          $httpStreamOptions['header'][] = sprintf('Content-Length: %d', strlen($params['payload'] ?? ''));
          $httpStreamOptions['content'] = $params['payload'];
        }

        // Join the headers using CRLF
        $httpStreamOptions['header'] = implode("\r\n", $httpStreamOptions['header']) . "\r\n";

        $stream = stream_context_create(['http' => $httpStreamOptions]);
        $response = file_get_contents($params['url'], false, $stream);

        // Headers response are created magically and injected into
        // variable named $http_response_header
        $httpStatus = $http_response_header[0];

        preg_match('#HTTP/[\d\.]+\s(\d{3})#i', $httpStatus, $matches);

        if (! isset($matches[1])) {
          throw new Exception('Can not fetch HTTP response header.');
        }

        $statusCode = (int)$matches[1];
        if ($statusCode >= 200 && $statusCode < 300) {
          return ['body' => $response, 'statusCode' => $statusCode, 'headers' => $http_response_header];
        }

        throw new Exception($response, $statusCode);
    }

    public function addDevice($name){
        try {
            $reqParams = [
              'token' => $this->token,
              'url' => 'https://api.kirimwa.id/v1/devices',
              'method' => 'POST',
              'payload' => json_encode([
                'device_id' => $name
              ])
            ];

            $response = $this->apiKirimWaRequest($reqParams);
            echo $response['body'];
        } catch (Exception $e) {
            print_r($e);
        }

        return $response;
    }

    public function getDevices(){
        try {
            $reqParams = [
              'token' => $this->token,
              'url' => 'https://api.kirimwa.id/v1/devices',
            ];

            $response = $this->apiKirimWaRequest($reqParams);
            echo $response['body'];
        } catch (Exception $e) {
            print_r($e);
        }

        return $response;
    }

    public function getDeviceDetail($id){
        try {
            $reqParams = [
              'token' => $this->token,
              'url' => sprintf('https://api.kirimwa.id/v1/devices/%s', $id),
            ];

            $response = $this->apiKirimWaRequest($reqParams);
            echo $response['body'];
          } catch (Exception $e) {
            print_r($e);
          }

        return $response;
    }

    public function qrCode($id)
    {
        try {
            $query = http_build_query(['device_id' => $id]);
            $reqParams = [
              'token' => $this->token,
              'url' => sprintf('https://api.kirimwa.id/v1/qr?%s', $query)
            ];

            $response = $this->apiKirimWaRequest($reqParams);
            echo $response['body'];
          } catch (Exception $e) {
            print_r($e);
          }

        return $response;
    }

    public function sendMessage($no, $message)
    {
        try {
            $reqParams = [
              'token' => $this->token,
              'url' => 'https://api.kirimwa.id/v1/messages',
              'method' => 'POST',
              'payload' => json_encode([
                'message' => 'https://ik.imagekit.io/satrio/undangan.jpg?ik-sdk-version=javascript-1.4.3&updatedAt=1667718586139',
                'phone_number' => $no,
                'message_type' => 'image',
                'device_id' => 'redmi1',
                'caption' => $message,
              ])
            ];

            $response = $this->apiKirimWaRequest($reqParams);
            echo $response['body'];
          } catch (Exception $e) {
            print_r($e);
          }

        return $response;
    }

    public function getGroups()
    {
        try {
            $query = http_build_query(['device_id' => 'redmi1']);
            $reqParams = [
              'token' => $this->token,
              'url' => sprintf('https://api.kirimwa.id/v1/groups?%s', $query)
            ];

            $response = $this->apiKirimWaRequest($reqParams);
            echo $response['body'];
          } catch (Exception $e) {
            print_r($e);
          }

        return $response;
    }

    public function getGroupDetail($id)
    {
        try {
            $query = http_build_query(['device_id' => 'redmi1']);
            $reqParams = [
              'token' => $this->token,
              'url' => sprintf('https://api.kirimwa.id/v1/groups/%s?%s', $id, $query)
            ];

            $response = $this->apiKirimWaRequest($reqParams);
            echo $response['body'];
          } catch (Exception $e) {
            print_r($e);
          }

        return $response;
    }


}
