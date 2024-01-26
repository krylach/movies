<?php

namespace App\Actions\Traits;

trait HasPrepared
{
    protected function preparation(array $data)
    {
        foreach ($data as $key => $value) {
            if (is_string($data[$key])) {
                $data[$key] = htmlspecialchars($data[$key], ENT_QUOTES, 'UTF-8');
            }

            if (is_array($data[$key])) {
                $data[$key] = $this->preparation($data[$key]);
            }
        }

        return $data;
    }
}
