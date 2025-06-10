<?php

namespace App\Http\Controllers;

use App\Http\Models\Category;
use Illuminate\Http\Request;
use App\Http\Models\Product, App\Http\Models\Favorite, App\Http\Models\Stock, App\Http\Models\Coverage;
use PHPUnit\Metadata\Covers;
use Validator, Str, Config, Auth;

class ApiJsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['getProductsSection']);
    }

    function getProductsSection($section, Request $request){
        $items_x_page= Config::get('cms.products_per_page');
        $items_x_page_random= Config::get('cms.products_per_page_random');
        switch($section):
            case 'home':
                $products= Product::where('status', 1)->inRandomOrder()->paginate($items_x_page_random);
            break;
            case 'store':
                $products= Product::where('status', 1)->orderBy('id', 'Desc')->paginate($items_x_page);
            break;
            case 'store_category':
                $products= $this->getProductsCategory($request->get('object_id'), $items_x_page);
            break;
            default:
                $products= Product::where('status', 1)->inRandomOrder()->paginate($items_x_page);
            break;
        endswitch;
        //return $items_x_page;
        return $products;
    }

    public function getProductsCategory($id, $ipp){
        $category= Category::find($id);
        if($category->parent == "0"):
            $products= Product::where('status', 1)->where('category_id', $id)->orderBy('id', 'Desc')->paginate($ipp);
        else:
            $products= Product::where('status', 1)->where('subcategory_id', $id)->orderBy('id', 'Desc')->paginate($ipp);
        endif;
        return $products;
    }

    function postFavoriteAdd($object, $module, Request $request){
        $query = Favorite::where('user_id', Auth::id())->where('module', $module)->where('object_id', $object)->count();
        if($query > 0):
            $data = ['status' => 'error', 'msg' => 'Este item ya está en tus favoritos'];
        else:
            $favorite = new Favorite;
            $favorite->user_id = Auth::id();
            $favorite->module= $module;
            $favorite->object_id = $object;
            if($favorite->save()):
                $data = ['status' => 'success', 'msg' => 'Se guardo su favorito'];
            endif;
        endif;
        return response()->json($data);
    }

    public function postUserFavorites(Request $request){
        $query = Favorite::where('user_id', Auth::id())->where('module', $request->input('module'))->whereIn('object_id', explode(",", $request->input('objects')))->pluck('object_id');
        return response()->json($query);
        if(count(collect($query)) > 0): 
            $data = ['status' => 'success', 'count' => count(collect($query)), 'objects' => $query];
        else:
            $data = ['status' => 'success', 'count' => count(collect($query))];
        endif;
        return response()->json($data);
    }

    public function postProductStockVariants($id){
        $query = Stock::find($id);
        return response()->json($query->getVariants);
    }

    public function postCoverageCitiesFromState($state){
        //$cities = Coverage::where('ctype', '1')->where('state_id', $state)->pluck('name', 'id');
        $cities = Coverage::where('state_id', $state)->get();
        return response()->json($cities);
    }
}
