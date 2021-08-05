<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Purchase;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        $prodarray = array('product' => $product);
        return response()->json($prodarray);
    }
    public function getmen()
    {
        $product = Product::where('type','رجالي').get();
        $prodarray = array('product' => $product);
        return response()->json($prodarray);
    }
    public function getwomen()
    {
        $product = Product::where('type','حريمي').get();
        $prodarray = array('product' => $product);
        return response()->json($prodarray);
    }
    public function getchild()
    {
        $product = Product::where('type','أطفالي').get();
        $prodarray = array('product' => $product);
        return response()->json($prodarray);
    }

    public function store(Request $request)
    {    if ($request->hasFile('picture')) {
                $validation = $request->validate([
                    'productname'=> 'required|max:255',
                    'type' => 'required|max:50',
                    'price' => 'required|max:20',
                    'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);}
        
        $imagename = time() . '.' . $request->picture->extension();
        
        $request -> picture -> move(public_path('images'),$imagename);

        $data = new Product ;
        $data->productname = $request->productname ;
        $data->type = $request->type ;
        $data->price = $request->price ;
        $data->picture = $imagename ;
        $data->save();
        return response()->json($data);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        return response()->json($product);
    }

    // public function edit($id)
    // {
    //     $prod = Product::where('id', $id)->first();
    //     //return view('product.edit',['prod'=>$prod]);
    //     return response()->json($prod);
    // }

    public function update(Request $request)
    {
        if ($request->hasFile('picture')) {
            $validation = $request->validate([
                'productname'=> 'required|max:255',
                'type' => 'required|max:50',
                'price' => 'required|max:20',
                'picture' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);}

        $imagename = time() . '.' . $request->picture->extension();
        $request->picture->move(public_path('images'), $imagename);


        $data = Product::find($request->id);
        $data->productname = $request->productname ;
        $data->type = $request->type ;
        $data->price = $request->price ;
        $data->picture = $imagename ;
        $data->save();
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Product::find($id);
        $data->delete();
        return response()->json($data);
    }


    // states [incomplete , start , in delever ,  delievered]
    public function createorder(Request $request)
    {   
        // get or create current order
        //$order = Auth::user() -> with('Order') -> where('state', 'incomplete')->first();

        $userid = Auth::user()->id ;
        $order = Order::where([['state','incomplete'] ,['user_id',$userid]])->first();
        if($order == null)
        {  
            // get the number of user orders
            
            $count = Order::where('user_id', $userid) -> count();
            $orderno = $count + 1 ;

            // create new order
            $neworder = new Order ;
            $neworder -> name = 'order' . $orderno ;
            $neworder -> state = 'incomplete' ;
            $neworder -> user_id = Auth::user() -> id ;
            $neworder -> save() ;
            $order = Order::where([['state','incomplete'] ,['user_id',$userid]])->first();
        }

        // save new purchases product in order

        $newpurchase = new Purchase ;
        $newpurchase -> product_id = $request -> id ;
        $newpurchase -> order_id = $order -> id ;
        $newpurchase ->save() ;

        return response()->json($newpurchase);
    }

    // get details of order

    public function get_incomplete_order()
    {
        $counter = 0 ;
        $list = [] ;
        $id = Auth::user() -> id;
        $order = Order::where([['state','incomplete'] ,['user_id',$id]])->first();

        if(!$order)
        {   
            $response = [
                'message' => 'sorry you donot have any orders yet'
            ];
            return response($response);
        }
        else
        {
        $orderdetails = Purchase::where('order_id', $order['id']) -> get();
        foreach($orderdetails as $ord)
        {
             
            $list[$counter] = Product::where('id', $ord['product_id']) -> get();
            $counter++ ;
        }
        $response = 
        [
            'order' => $order -> name ,
            'products' => $list,
        ];
        return $response;
        }
        
    }


    public function startorder(Request $request)
    {
        $order = Order::where('id',$request->id) -> first() ;
        if($order->state != 'started')
        {
            $update = Order::where('id',$request->id)->update(['state'=>'started']);
            $order = Order::where('id',$request->id)->first();
            return response()->json($order);
        }
        else{
            $response = [ 'message' => 'this order already started'];
            return response($response);
        }
    }

    public function indelevered(Request $request)
    {
        $order = Order::where('id',$request->id) -> first() ;
        if($order->state != 'indelevered')
        {
            $update = Order::where('id',$request->id)->update(['state'=>'indelevered']);
            $order = Order::where('id',$request->id)->first();
            return response()->json($order);
        }
        else{
            $response = [ 'message' => 'this order already indelevered'];
            return response($response);
        }
    }

   
}
