<?php
namespace App\Traits;

trait HandlesOrthancAuth
{
    protected function orthancAuthHeader(): array
    {
        $username = config('services.orthanc.username');
        $password = config('services.orthanc.password');
        return [
            'Authorization: Basic ' . base64_encode("$username:$password"),
            'Content-Type: application/json'
        ];
    }
}