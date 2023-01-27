<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Product;
use App\Http\Resources\Product as ProductResource;
   
class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Posts fetched.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'category' => 'required',
            'nama' => 'required',
            'harga' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $blog = Product::create($input);
        return $this->sendResponse(new ProductResource($blog), 'Post created.');
    }
   
    public function show($id)
    {
        $blog = Product::find($id);
        if (is_null($blog)) {
            return $this->sendError('Post does not exist.');
        }
        return $this->sendResponse(new ProductResource($blog), 'Post fetched.');
    }
    
    public function update(Request $request, Product $blog)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'category' => 'required',
            'nama' => 'required',
            'harga' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $blog->title = $input['title'];
        $blog->description = $input['description'];
        $blog->save();
        
        return $this->sendResponse(new ProductResource($blog), 'Post updated.');
    }
   
    public function destroy(Product $blog)
    {
        $blog->delete();
        return $this->sendResponse([], 'Post deleted.');
    }
}