<?php

namespace App\Interfaces\Booking;

interface BookInterface
{
    /**
     * Save booking into database and return order info
     * @param array $data Data for saving and calculation processes
     * @return $model Booking information
     */

    public function save(array $data);

    /**
     * Update booking with new dates, volume or temperature
     * @param array $data Data for saving and calculation processes
     * @param int $id ID of booking for changing order information
     * @return $model Booking information
     */

    public function update(array $data, int $id);

    /**
     * Change status of booking to false and cancel it.
     * @param int $id ID of order for deleting active status 
     * @return $model Booking information
     */

    public function delete(int $id);

    /**
     * Get single order by its ID
     * @param int $id ID of expected booking
     * @return $model Booking information
     */

    public function single(int $id);
}
