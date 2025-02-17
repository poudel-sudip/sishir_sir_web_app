<?php

namespace App\Http\Controllers\Admin\Books;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books\PhysicalBookOrder;

class PhysicalBookOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data['orders'] = PhysicalBookOrder::get();
        return view('admin.books.physical_order.index',$data);
    }

    public function show(PhysicalBookOrder $order)
    {
        $data['order'] = $order;
        return view('admin.books.physical_order.show',$data);
    }

    public function destroy(PhysicalBookOrder $order)
    {
        $order->delete();

        return redirect('/admin/physical-book-orders');
    }

}
