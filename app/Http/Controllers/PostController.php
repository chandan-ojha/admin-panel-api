<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends BaseController
{
    /*
     * API: 1
     * Purpose: Get Post List
     * Route: api/get-post-list
     * Method: Get
    */
    public function get_post_list()
    {
        $post_list = Post::with([
            'get_categories' => function($qry){
                $qry->orderBy('id','asc');
                $qry->select(['id','cat_name']);
            },
            'get_tags' => function($qry){
                $qry->orderBy('id','asc');
                $qry->select([]);
            }
        ])
            ->orderBy('id','asc')
            ->get(['id','post_title','description','image','cat_id']);

        //~ Check Availability of data
        if(count($post_list)>0){
            return $this->sendResponse(200,'Success.',
                [
                    'count_data' => count($post_list),
                    'post_list' => $post_list
                ]
            );
        }
        //~ Empty Data Response
        return $this->sendError('204','Data not found!');
    }

    /*
     * API: 2
     * Purpose: Get Single Post Info
     * Route: api/get-single-post-info
     * Method: Get
     * Parameter: post_id
    */
    public function get_single_post_info($post_id)
    {
        $single_post_info = Post::with([
            'get_categories' => function($qry){
                $qry->orderBy('id','asc');
                $qry->select(['id','cat_name']);
            },
            'get_tags' => function($qry){
                $qry->orderBy('id','asc');
                $qry->select([]);
            }
        ])
            ->where('id',$post_id)
            ->orderBy('id','asc')
            ->get(['id','post_title','description','image','cat_id']);

        //~ Check Availability of data
        if(!empty($single_post_info)){
            return $this->sendResponse(200,'Success.',
                [
                    'single_post_info' => $single_post_info
                ]
            );
        }
        //~ Empty Data Response
        return $this->sendError('204','Data not found!');
    }

    /*
    * API: 3
    * Purpose: Create Post
    * Route: api/create-post
    * Method: Post
   */
    public function create_post(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'post_title' =>'required',
            'description' => 'required',
            'cat_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status_code'=>400,
                'message'=>'Validation Error.',
            ]);
        }

        $post = new Post();
        $post->post_title = $request->post_title;
        $post->description = $request->description;
        $post->image = $request->image;
        $post->cat_id = $request->cat_id;

        if($post->save())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Post created successfully!",
                'id' => $post->id,
                'post_title' => $post->post_title,
                'description' => $post->description,
                'cat_id' => $post->cat_id,
            ]);
        }
        else
        {
            return response()->json([
                'status_code' =>400,
                'message' =>"Post not created!"
            ]);
        }
    }

    /*
     * API: 4
     * Purpose: Update Post
     * Route: api/update-post
     * Method: Put
     * Parameter: post_id
    */
    public function update_post(Request $request, $post_id)
    {
        $validator = Validator::make($request->all(),[
            'post_title' =>'required',
            'description' => 'required',
            'cat_id' => 'required'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status_code'=>400,
                'message'=>'Validation Error.',
            ]);
        }

        $update_post = Post::where('id',$post_id)->first();
        $update_post->post_title = $request->post_title;
        $update_post->description = $request->description;
        $update_post->image = $request->image;
        $update_post->cat_id = $request->cat_id;

        if($update_post->save())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Post updated successfully!",
                'id' => $update_post->id,
                'post_title' => $update_post->post_title,
                'description' => $update_post->description,
                'cat_id' => $update_post->cat_id,
            ]);
        }
        else
        {
            return response()->json([
                'status_code' =>400,
                'message' =>"Post not updated!"
            ]);
        }
    }

    /*
     * API: 5
     * Purpose: Delete Post
     * Route: api/delete-post
     * Method: delete
     * Parameter: post_id
    */
    public function delete_post($post_id)
    {
        $post = Post::where('id',$post_id)->first();

        if($post->delete())
        {
            return response()->json([
                'status_code' =>200,
                'message' =>"Post deleted successfully!"
            ]);
        }
        else {
            return response()->json([
                'status_code' =>400,
                'message' =>"Post not deleted!"
            ]);
        }
    }

}
