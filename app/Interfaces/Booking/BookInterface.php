<?php

namespace App\Interfaces\Booking;

interface BookInterface
{
    public function save(array $data);
    public function update(array $data, int $id);
    public function delete(int $id);
    public function single(int $id);
}
