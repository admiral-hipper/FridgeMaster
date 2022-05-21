<?php

namespace App\Http\Controllers;

use App\Business\SimpleBill;
use App\Business\SimpleBook;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookUpdateRequest;
use App\Http\Requests\CalculationRequest;
use App\Http\Resources\CalculationResource;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\LessBlocksResource;
use App\Http\Resources\OrderResource;
use App\Models\Customers;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        return new CustomerResource(Customers::findOrFail(Auth::guard('apiAccess')->id()));
    }
    public function calculate(CalculationRequest $request): JsonResource
    {
        $calculation = new SimpleBill($request->all());
        $result = $calculation->information();
        return $result['blocks_count'] ? new CalculationResource($result) : new LessBlocksResource($result);
    }
    public function book(BookRequest $request): JsonResource
    {
        $booking = new SimpleBook();
        return new OrderResource($booking->save($request->all()));
    }
    public function terminateBook($id): JsonResource
    {
        $booking = new SimpleBook();
        return new OrderResource($booking->delete($id));
    }
    public function changeBook(BookUpdateRequest $request, $id)
    {
        $booking = new SimpleBook();
        return new OrderResource($booking->update($request->all(), $id));
    }
    public function singleBook($id)
    {
        $booking = new SimpleBook();
        return new OrderResource($booking->single($id));
    }
}
