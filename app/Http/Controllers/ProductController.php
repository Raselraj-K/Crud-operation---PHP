<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Auth;
use Hash;
use DB;
use App\Models\User;
class ProductController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->input('nameKey'),'password' => $request->input('passwordKey') ])){
            $user = Auth::user();
            $success['token'] = $user->createToken('myapp')->accessToken;
            return response()->json([
                'status' => true,
                'data' => [$success,["role" => Auth::user()->Is_admin],["email" => Auth::user()->email],["name" => Auth::user()->name]],
                'message' => '',
            ],200);
        }
        else{
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'Invalid Username Password',
            ]);
        }
    }

    public function getProductList(){
        $products = DB::select("select * from products");
        if($products){
            return response()->json([
                'status' => true,
                'data' => $products,
                'message' => '',
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'No Products found in Data base',
            ]);

        }
    }

    public function order(Request $request){
        $name = $request->input('nameKey');
        $address = $request->input('addressKey');
        $phone = $request->input('phoneKey');
        $productName = $request->input('productnameKey');
        $date = $request->input('dateKey');
        $time = $request->input('timeKey');
         $email = $request->input('emailKey');
        $password = $request->input('passwordKey');
        $insertorder = DB::insert("insert into orders(name,address,phone,productname,deliverydate,deliverytime,email,password) values(?,?,?,?,?,?,?,?)",[$name,$address,$phone,$productName,$date,$time,$email,$password]);
        if($insertorder){
            $this->authtable($name,$email,$password);
            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'Ordered Successfully...',
            ]);
        }
    }
    public function authtable($name,$email,$password){
        $hashPassword = Hash::make($password);
        $auth = DB::insert("insert into Users(name,email,password) values(?,?,?)",[$name,$email,$hashPassword]);
        return response()->json([$auth]);

    }
    public function addProduct(Request $request){
        $productName = $request->input('productKey');
        $addProduct = DB::insert("insert into products(productname) values(?)",[$productName]);
        if($addProduct){
            return response()->json([
                'status' => true,
                'data' => [],
                'message' => 'product Added Successfully...',
            ]);
        }
    }

    public function getUserdata(Request $request){
        $username = $request->input('usernameKey');
        $selectUser = DB::select("select * from orders where email = '$username'");
        $count = count($selectUser);
        if($count > 0 ){
            return response()->json([
                        'status' => true,
                        'data' => $selectUser,
                        'message' => 'yes',
                    ]);
                }
                else{
                    return response()->json([
                        'status' => false,
                        'data' => [],
                        'message' => 'You are Not Order Anything',
                    ]);
                }
            }

    public function getAllUserData(){
        $allUserData = DB::select("select id,name,address,phone,productname,deliverydate,email,status from orders");
        if($allUserData){
            return response()->json([
                'status' => true,
                'data' => $allUserData,
                'message' => '',
            ]);

        }else{
            return response()->json([
                'status' => false,
                'data' => [],
                'message' => 'No user Data Found',
            ]);
        }
        
    }

    public function getUpdatests(Request $request){
        $id = $request->input('key1');
        $status = $request->input('key2');
        $update = DB::update("update orders set status ='$status' where id = '$id'");
        if($update){
           $s = DB::select("select * from orders");
           return response()->json([
               'status' => true,
               'data' => $s,
               'message' => 'Update Successfully', 
           ]);
        }
        else{
            $s = DB::select("select * from orders");
            return response()->json([
                'status' => false,
                'data' => $s,
                'message' => 'Nothing to Update',
            ]);
        }

    }

    public function cancelOrder(request $request){
        $userId = $request->input('idKey');
        $delete = DB::delete("delete from orders where id = '$userId'");
            if($delete){
                $select = DB::select("select id from orders where id != '$userId'");
                return response()->json([
                    'status' => true,
                    'data' => $select,
                    'message' => '',
                ]);
            }
            else{
                return reposnse()->json([
                    'status' => false,
                    'data' => [],
                    'message' => 'Erro in Cancel Order',
                ]);
    
            }

        
     

    }
}
