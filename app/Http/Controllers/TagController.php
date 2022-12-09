<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends BaseController
{
    /*
      * API: 1
      * Purpose: Get Tag List
      * Route: api/get-tag-list
      * Method: Get
     */
    public function get_tag_list()
    {
        $tag_list = Tag::get(['id','tag_title']);

        //~ Check Availability of data
        if(count($tag_list)>0){
            return $this->sendResponse(200,'Success.',
                [
                    'count_data' => count($tag_list),
                    'tag_list' => $tag_list
                ]
            );
        }
        //~ Empty Data Response
        return $this->sendError('204','Data not found!');
    }

    /*
     * API: 2
     * Purpose: Get Single Tag Information
     * Route: api/get-single-tag-info
     * Method: tag_id
    */
    public function get_single_tag_info($tag_id)
    {
        $single_tag_info = Tag::where('id',$tag_id)->first(['id','tag_title']);

        //~ Check Availability of data
        if(!empty($single_tag_info)){
            return $this->sendResponse(200,'Success.',
                [
                    'single_tag_info' => $single_tag_info
                ]
            );
        }
        //~ Empty Data Response
        return $this->sendError('204','Data not found!');
    }

    /*
     * API: 3
     * Purpose: Create Tag
     * Route: api/create-tag
     * Method: Post
    */
    public function create_tag(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'tag_title' =>'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status_code'=>400,
                'message'=>'Validation Error.',
            ]);
        }

        $tag = new Tag();
        $tag->tag_title = $request->tag_title;

        if($tag->save())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Tag created successfully!",
                'id' => $tag->id,
                'tag_title' => $tag->tag_title
            ]);
        }
        else
        {
            return response()->json([
                'status_code' =>400,
                'message' =>"Tag not created!"
            ]);
        }
    }

    /*
     * API: 4
     * Purpose: Update Tag
     * Route: api/update-tag
     * Method: Put
     * Parameter: tag_id
    */
    public function update_tag(Request $request, $tag_id)
    {
        $validator = Validator::make($request->all(),[
            'tag_title' =>'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status_code'=>400,
                'message'=>'Validation Error.',
            ]);
        }

        $update_tag = Tag::where('id',$tag_id)->first();
        $update_tag->tag_title = $request->tag_title;

        if($update_tag->save())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Tag updated successfully!",
                'id' => $update_tag->id,
                'tag_title' => $update_tag->tag_title
            ]);
        }
        else
        {
            return response()->json([
                'status_code' =>400,
                'message' =>"Tag not updated !"
            ]);
        }
    }

    /*
     * API: 5
     * Purpose: Delete Tag
     * Route: api/delete-tag
     * Method: delete
     * Parameter: tag_id
    */
    public function delete_tag($tag_id)
    {
        $tag = Tag::where('id',$tag_id)->first();

        if($tag->delete())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Tag deleted successfully!"
            ]);
        }
        else {
            return response()->json([
                'status_code' =>400,
                'message' =>"Tag not deleted!"
            ]);
        }
    }

}
