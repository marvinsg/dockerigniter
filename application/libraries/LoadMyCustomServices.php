<?php
defined('BASEPATH') or exit('No direct script access allowed');

final class LoadMyCustomServices
{
    private const CUSTOM_SERVICES_PATH = 'application/services';

    public function __construct()
    {
        foreach (scandir(self::CUSTOM_SERVICES_PATH) as $filename) {
            $path = self::CUSTOM_SERVICES_PATH . '/' . $filename;
            if (is_file($path)) {
                require $path;
            }
        }
    }
}