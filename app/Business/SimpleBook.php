<?php

namespace App\Business;

use App\Interfaces\Billing\BillInterface;
use App\Interfaces\Booking\BookInterface;
use App\Models\Orders;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SimpleBook implements BookInterface
{
    private BillInterface $bill;
    private array $data;
    public function __construct()
    {
    }
    public function single(int $id)
    {
        return $this->access($id, Auth::guard('apiAccess')->id());
    }
    public function save(array $data)
    {
        $this->setBill($data);
        $information = $this->bill->information();
        $model = new Orders();
        $model->start_rent = $this->data['start_rent'];
        $model->end_rent = $this->data['end_rent'];
        $model->status = true;
        $model->access_token = Str::random(12);
        $model->bill = $information['price'];
        $model->customers_id = Auth::guard('apiAccess')->id();
        $model->save();
        $model->blocks()->attach($information['blocks']);
        return $model;
    }
    public function update(array $data, $id)
    {
        $this->setBill($data);
        $model = $this->access($id, Auth::guard('apiAccess')->id());
        $model->status = false;
        $model->save();
        $information = $this->bill->information();
        if (!$model->is_empty)
            throw new HttpResponseException(response()->json([
                "success" => false,
                "message" => "You cannot change booking after filling blocks",
            ], 400));
        $model->price = $information['price'];
        $model->start_rent = $this->data['start_rent'];
        $model->end_rent = $this->data['end_rent'];
        $model->blocks()->attach($information['blocks']);
        $model->save();
        return $model;
    }
    public function delete(int $id)
    {
        $model = $this->access($id, Auth::guard('apiAccess')->id());
        $model->status = false;
        $model->save();
        return $model;
    }

    /**
     * Set all data from calculation process for next operations
     * @param array $data Array of data for calculation
     * @return void
     */

    private function setBill(array $data)
    {
        $this->bill = new SimpleBill($data);
        $this->data = $data;
    }
    /**
     * Chech if current customer has access for selected booking and order data
     * @param int $order_id ID of order for checking
     * @param int $customer_id ID of customer for checking access
     * @return $model
     */
    private function access(int $order_id, int $customer_id)
    {
        $model = Orders::whereId($order_id)->where('customers_id', '=', $customer_id);
        if (!$model->count())
            throw new HttpResponseException(response()->json([
                "success" => false,
                "message" => "You don't have acces to this order or it doesn't exist",
            ], 401));
        return $model->first();
    }
}
