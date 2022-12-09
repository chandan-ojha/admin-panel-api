<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends BaseController
{
     /*
      * API: 1
      * Purpose: Get Category List
      * Route: api/get-category-list
      * Method: Get
     */
     public function get_category_list()
     {
        $category_list = Category::get(['id','cat_name']);

        //~ Check Availability of data
        if(count($category_list)>0){
            return $this->sendResponse(200,'Success.',
                [
                    'count_data' => count($category_list),
                    'category_list' => $category_list
                ]
            );
        }
        //~ Empty Data Response
        return $this->sendError('204','Data not found!');
    }

    /*
     * API: 2
     * Purpose: Get Single Category Information
     * Route: api/get-single-category-info
     * Method: cat_id
    */
    public function get_single_category_info($cat_id)
    {
        $single_category_info = Category::where('id',$cat_id)->first(['id','cat_name']);

        //~ Check Availability of data
        if(!empty($single_category_info)){
            return $this->sendResponse(200,'Success.',
                [
                    'single_category_info' => $single_category_info
                ]
            );
        }
        //~ Empty Data Response
        return $this->sendError('204','Data not found!');
    }

    /*
     * API: 3
     * Purpose: Create Category
     * Route: api/create-category
     * Method: Post
    */
    public function create_category(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'cat_name' =>'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status_code'=>400,
                'message'=>'Validation Error.',
            ]);
        }

        $category = new Category();
        $category->cat_name = $request->cat_name;

        if($category->save())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Category created successfully!",
                'id' => $category->id,
                'cat_name' => $category->cat_name
            ]);
        }
        else
        {
            return response()->json([
                'status_code' =>400,
                'message' =>"Category not created!"
            ]);
        }
    }

    /*
     * API: 4
     * Purpose: Update Category
     * Route: api/update-category
     * Method: Put
     * Parameter: cat_id
    */
    public function update_category(Request $request, $cat_id)
    {
        $validator = Validator::make($request->all(),[
            'cat_name' =>'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status_code'=>400,
                'message'=>'Validation Error.',
            ]);
        }

        $update_category = Category::where('id',$cat_id)->first();
        $update_category->cat_name = $request->cat_name;

        if($update_category->save())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Category updated successfully!",
                'id' => $update_category->id,
                'cat_name' => $update_category->cat_name
            ]);
        }
        else
        {
            return response()->json([
                'status_code' =>400,
                'message' =>"Category not updated !"
            ]);
        }

    }

    /*
     * API: 5
     * Purpose: Delete Category
     * Route: api/delete-category
     * Method: delete
     * Parameter: cat_id
    */
    public function delete_category($cat_id)
    {
        $category = Category::where('id',$cat_id)->first();

        if($category->delete())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Category deleted successfully!"
            ]);
        }
        else {
            return response()->json([
                'status_code' =>400,
                'message' =>"Category not deleted!"
            ]);
        }
    }

}
