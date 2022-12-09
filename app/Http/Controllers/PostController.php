<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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
            'get_tag_list' => function($qry){
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
            'get_tag_list' => function($qry){
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
        return $request;
    }

}
