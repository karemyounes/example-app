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
        //return view('product.allproducts',$prodarray);
        return response()->json($prodarray);
    }

    public function create()
    {
        return view('product.createproduct');
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
        //return redirect('product');
        return response()->json($data);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        $arr = array('product' => $product);
        //return view('product.oneproduct',$arr);
        return response()->json($arr);
    }

    public function edit($id)
    {
        $prod = Product::where('id', $id)->first();
        //return view('product.edit',['prod'=>$prod]);
        return response()->json($prod);
    }

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
        //return redirect('product');
        return response()->json($data);
    }

    public function destroy($id)
    {
        $data = Product::find($id);
        $data->delete();
        //return redirect('product');
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
            
            $count = Order::where('user_id', $usid) -> count();
            $orderno = $count + 1 ;

            // create new order
            $neworder = new Order ;
            $neworder -> name = 'order' . $orderno ;
            $neworder -> state = 'incomplete' ;
            $neworder -> user_id = Auth::user() -> id ;
            $neworder -> save() ;
            $order = Order::where([['state','incomplete'] ,['user_id',$usid]])->first();
        }

        // save new purchases product in order

        $newpurchase = new Purchase ;
        $newpurchase -> product_id = $request -> id ;
        $newpurchase -> order_id = $order -> id ;
        $newpurchase ->save() ;

        //return redirect('product')-> with('success','purchase successfully') ;
        return response()->json($newpurchase);
    }


    public function orderpage()
    {
        $id = Auth::user() -> id;
        $order = Order::where([['state','incomplete'] ,['user_id',$id]])->first();
        $orderdetails = Purchase::where('order_id', $order['id'])->get();
        return response()->json($orderdetails);
    }

    /*public function startorder()
    {
        $id = Auth::user() -> id;
        $order = Order::where([['state','incomplete'] ,['user_id',$id]])->update(['state' => 'start']);
        $updatedorder = Order::where([['state','start'] ,['user_id',$id]])->first();
        return response()->json($updatedorder);
    }

    public function indelevered(Request $request)
    {
        $id = Auth::user() -> id;
        $order = Order::where([['state','start'] ,['user_id',$id]])->update(['state' => 'indelevered']);
    }
*/
   
}
