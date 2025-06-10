<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\Category;
use App\Http\Models\Product, App\Http\Models\PGallery, App\Http\Models\Stock, App\Http\Models\Variant;
//use Models\PGallery;
use Validator, Str, Config;
use Intervention\Image\ImageManagerStatic as Image;
//use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('user.status');
        $this->middleware('user.permissions');
        $this->middleware('isadmin');
    }

    public function getHome($status){
        //$products = Product::with(['cat'])->orderBy('id', 'desc')->paginate(5);
        switch ($status) {
            case '0':
                $products = Product::with(['cat', 'getPrice'])->where('status','0')->orderBy('id', 'desc')->paginate(5);
                break;
            case '1':
                $products = Product::with(['cat', 'getPrice'])->where('status','1')->orderBy('id', 'desc')->paginate(5);
                break;
            case 'all':
                $products = Product::with(['cat', 'getPrice'])->orderBy('id', 'desc')->paginate(5);
                break;
            case 'trash':
                $products = Product::with(['cat', 'getPrice'])->onlyTrashed()->orderBy('id', 'desc')->paginate(5);
                break;
        }
        //return $products;
        $data = ['products' => $products];
        return view('admin.products.home', $data);
        //return "llegue2";
    }

    public function getProductAdd(){
        $cats = Category::where('module','0')->pluck('name','id');
        $data = ['cats' => $cats];
        return view('admin.products.add', $data);
        //return "llegue";
    }

    public function postProductAdd(Request $request){
        $rules = [
            'name' => 'required',
            'img' => 'required',
            'content' => 'required'
        ];

        $messages = [
            'name.required' => 'El nombre del producto es requerido',
            'img.required' => 'Seleccione una imagen destacada',
            'img.image' => 'El archivo no es una imagen',
            'content.required' => 'Ingrece una descripción del producto'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            $path = '/'.date('Y-m-d');
            $fileExt= trim($request->file('img')->getClientOriginalExtension());
            $upload_path=Config::get('filesystems.disks.uploads.root');
            $name = Str::slug(str_replace($fileExt,'',$request->file('img')->getClientOriginalName()));
            $filename=rand(1,999).'-'.$name.'.'.$fileExt;
            $file_file= $upload_path.'/'.$path.'/'.$filename;
            $product= new Product;
            $product->status = '0';
            $product->code = e($request->input('code')); 
            $product->name =e($request->input('name'));
            $product->slug =Str::slug($request->input('name'));
            $product->category_id = $request->input('category');
            $product->file_path=date('Y-m-d');
            $product->image = $filename;
            $product->in_discount = $request->input('indiscount');
            $product->discount = $request->input('discount');
            $product->content = e($request->input('content'));
            if($product->save()):
                if($request->hasFile('img')):
                    $fl=$request->img->storeAs($path, $filename, 'uploads');
                    $img=Image::make($file_file);
                    $img->fit(256,256, function($constraint){
                        $constraint->upsize();
                    });
                    $img->save($upload_path.'/'.$path.'/t_'.$filename);
                endif;
                return redirect('/admin/products/0')->with('message','Guardado con exito')->with('typealert','success');
            endif;
        endif;
    }

    public function getProductEdit($id){
        $p = Product::findOrFail($id);
        $cats = Category::where('module','0')->pluck('name','id');
        $data = ['cats' => $cats, 'p' => $p];
        return view('admin.products.edit', $data);
    }

    public function postProductEdit($id, Request $request){
        $rules = [
            'name' => 'required',
            'content' => 'required'
        ];

        $messages = [
            'name.required' => 'El nombre del producto es requerido',
            'img.image' => 'El archivo no es una imagen',
            'content.required' => 'Ingrece una descripción del producto'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            
            $product= Product::findOrFail($id);
            $ipp= $product->file_path;
            $ip = $product->image;
            $product->status = $request->input('status');
            $product->code = e($request->input('code')); 
            $product->name =e($request->input('name'));
            $product->category_id = $request->input('category');
            if($request->hasFile('img')):
                $path = '/'.date('Y-m-d');
                $fileExt= trim($request->file('img')->getClientOriginalExtension());
                $upload_path=Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt,'',$request->file('img')->getClientOriginalName()));
                $filename=rand(1,999).'-'.$name.'.'.$fileExt;
                $file_file= $upload_path.'/'.$path.'/'.$filename;
                $product->file_path=date('Y-m-d');
                $product->image = $filename;
            endif;
            $product->in_discount = $request->input('indiscount');
            $product->discount = $request->input('discount');
            $product->discount_until_date = $request->input('discount_until_date');
            $product->content = e($request->input('content'));
            if($product->save()):
                $this->getUpdateMinPrice($product->id);
                if($request->hasFile('img')):
                    $fl=$request->img->storeAs($path, $filename, 'uploads');
                    $img=Image::make($file_file);
                    $img->fit(256,256, function($constraint){
                        $constraint->upsize();
                    });
                    $img->save($upload_path.'/'.$path.'/t_'.$filename);
                    unlink($upload_path.'/'.$path.'/'.$ip);
                    unlink($upload_path.'/'.$path.'/t_'.$ip);
                endif;
                return back()->with('message','Actualizado con éxito')->with('typealert','success');
            endif;
        endif;
    }

    public function postProductGalleryAdd($id, Request $request){
        $rules = [
            'file_image' => 'required'
        ];

        $messages = [
            'file_image.required' => 'Seleccione una imagen destacada'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            if($request->hasFile('file_image')):
                $path = '/'.date('Y-m-d');
                $fileExt= trim($request->file('file_image')->getClientOriginalExtension());
                $upload_path=Config::get('filesystems.disks.uploads.root');
                $name = Str::slug(str_replace($fileExt,'',$request->file('file_image')->getClientOriginalName()));
                $filename=rand(1,999).'-'.$name.'.'.$fileExt;
                $file_file= $upload_path.'/'.$path.'/'.$filename;

                $g = new PGallery;
                $g->product_id = $id;
                $g->file_path = date('Y-m-d');;
                $g->file_name =$filename;

                if($g->save()):
                    if($request->hasFile('file_image')):
                        $fl=$request->file_image->storeAs($path, $filename, 'uploads');
                        $img=Image::make($file_file);
                        $img->fit(256,256, function($constraint){
                            $constraint->upsize();
                        });
                        $img->save($upload_path.'/'.$path.'/t_'.$filename);
                    endif;
                    return back()->with('message','Imagen subida con éxito')->with('typealert','success');
                endif;
            endif;
            
        endif;
    }

    function getProductGalleryDelete($id,$gid){
        $g = PGallery::findOrFail($gid);
        $path = $g->file_path;
        $file = $g->file_name;
        $upload_path=Config::get('filesystems.disks.uploads.root');
        if($g->product_id !=$id){
            return back()->with('message','La imagen no se puede eliminar')->with('typealert','danger');
        }else{
            if($g->delete()):
                unlink($upload_path.'/'.$path.'/'.$file);
                unlink($upload_path.'/'.$path.'/t_'.$file);
                return back()->with('message','Imagen eliminada con éxito')->with('typealert','success');
            endif;   
        }

    }

    public function postProductSearch(Request $request){
        $rules = [
            'search' => 'required'
        ];

        $messages = [
            'search.required' => 'Se necesita un término o términos de búsqueda'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return redirect('/admin/products/1')->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            switch($request->input('filter')):
                case '0':
                    $products = Product::with(['cat'])->where('name', 'LIKE', '%'.$request->input('search').'%')->where('status', $request->input('status'))->orderBy('id', 'desc')->get();
                break;
                case '1':
                    $products = Product::with(['cat'])->where('code', $request->input('search'))->orderBy('id', 'desc')->get();
                break;
                endswitch;  
            $data = ['products' => $products];
            return view('admin.products.search', $data);
        endif;
    }

    public function getProductDelete($id){
        $p = Product::findOrFail($id);
        if($p->delete()):
            return back()->with('message','Producto enviado a la papelera de reciclaje')->with('typealert','success');
        endif;
    }

    public function getProductRestore($id){
        $p = Product::onlyTrashed()->where('id',$id)->first();
        //$p->restore();
        if($p->restore()):
            return redirect('/admin/product/'.$p->id.'/edit')->with('message','Este producto se restauro con éxito')->with('typealert','success');
        endif;
    }

    public function getProductStock($id){
        $product = Product::findOrFail($id);
        $data = ['product' => $product];
        return view('admin.products.stock', $data);
    }

    public function postProductStock($id, Request $request){
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del inventario es requerido',
            'price.required' => 'Ingrece el precio del inventario',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            $stock = new Stock;
            $stock->product_id = $id;
            $stock->name = e($request->input('name'));
            $stock->quantity = $request->input('stock');
            $stock->price = $request->input('price');
            $stock->limited = $request->input('limited');
            $stock->minimun = $request->input('minimun');

            if($stock->save()):
                $this->getUpdateMinPrice($stock->product_id);
                return back()->with('message','Guardado con exito')->with('typealert','success');
            endif;
        endif;
    }

    public function getProductStockEdit($id){
        $stock = Stock::findOrFail($id);
        //$product = Product::findOrFail($stock->product_id);
        $data = ['stock' => $stock];
        return view('admin.products.stock_edit', $data);
    }

    public function postProductStockEdit($id, Request $request){
        $rules = [
            'name' => 'required',
            'price' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del inventario es requerido',
            'price.required' => 'Ingrece el precio del inventario',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            $stock = Stock::find($id);
            $stock->name = e($request->input('name'));
            $stock->quantity = $request->input('stock');
            $stock->price = $request->input('price');
            $stock->limited = $request->input('limited');
            $stock->minimun = $request->input('minimun');

            if($stock->save()):
                $this->getUpdateMinPrice($stock->product_id);
                return back()->with('message','Guardado con exito')->with('typealert','success');
            endif;
        endif;
    }

    public function getProductStockDeleted($id){
        $stock = Stock::findOrFail($id);
        if($stock->delete()):
            $this->getUpdateMinPrice($stock->product_id);
            return back()->with('message','Inventario eliminado')->with('typealert','success');
        endif;
    }

    public function postProductStockVariantAdd($id, Request $request){
        $rules = [
            'name' => 'required'
        ];

        $messages = [
            'name.required' => 'El nombre de la variante es requerido'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()):
            return back()->withErrors($validator)->with('message','Se ha producido un error')->with('typealert','danger')->withInput(); 
        else:
            $stock = Stock::findOrFail($id);
            $variant = new Variant;
            $variant->product_id = $stock->product_id;
            $variant->stock_id = $id;
            $variant->name = e($request->input('name'));

            if($variant->save()):
                return back()->with('message','Guardado con exito')->with('typealert','success');
            endif;
        endif;
    }

    public function getProductVariantDeleted($id){
        $variant = Variant::findOrFail($id);
        if($variant->delete()):
            return back()->with('message','Variante eliminada.')->with('typealert','success');
        endif;
    }

    public function getUpdateMinPrice($id){
        $product = Product::find($id);
        $price = $product->getPrice->min('price');

        $product->price = $price;
        $product->save();
    }
}
