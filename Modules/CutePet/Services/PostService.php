<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/1/22
 * Time: 5:40 PM
 */

namespace Modules\CutePet\Services;




use Modules\CutePet\Models\Classify;
use Modules\CutePet\Models\Post;
use Modules\CutePet\Models\PostClassify;
use Modules\CutePet\Models\PostEnshrine;
use Modules\CutePet\Models\PostPraise;
use Modules\CutePet\Models\User;

/**
 *
 * Class PostService
 * @package Modules\Post\Services
 */
class PostService
{
    /**
     * 发布帖子
     */
    public function addPost($data,$classifyId)
    {
        if (! Classify::where('id',$classifyId)->exists()){
        abort(404,'板块不存在');
        }

        $post = Post::create($data);
        if(!$post){
         abort(400 ,'发布失败，请检查网络');
        }

        PostClassify::create(['post_id'=>$post->id,'classify_id'=>$classifyId]);

    }

    /**删除帖子
     * @param $userId //用户ID
     * @param $postId //帖子ID
     */
    public function deletePost($userId,$postId)
    {
        $delete = Post::where('user_id',$userId)
            ->where('id',$postId)
            ->delete();
        if ($delete == 0){
            abort(400 ,'帖子不存在');
        }
    }

    /**
     * @param $userId
     * @param null $visitor
     * @return mixed
     */
    public function showUserId($userId,$visitor = null)
    {
        if ($userId == $visitor){
            $posts = Post::where('user_id',$userId)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        return $posts;
    }

    /**
     *帖子列表
     */
    public function index($classifyId,$userId,$paginate)
    {
        if (! Classify::where('id',$classifyId)->exists()){
            abort(404,'板块不存在');
        }
        $classifyPostIds = PostClassify::where('classify_id',$classifyId)->select('post_id')->get()->pluck('post_id');

        $postQuery = Post::query();
        $posts = $postQuery
            ->whereIn('id',$classifyPostIds)
            ->orderBy('top','desc')
            ->orderBy('created_at','desc')

            ->with([
            'publishUser'=>function($query){
            $query->select('id','user_name');
        }
        ])
            ->withCount([
                'postPraise',
                'PostComment',
            ])
            ->paginate($paginate);

        $postIds = $posts->pluck('id');

        $postPraises = PostPraise::where('user_id',$userId)
            ->whereIn('post_id',$postIds)
            ->select('post_id','user_id')
            ->get()
            ->pluck('post_id')
            ->toArray();

        $postEnshrine = PostEnshrine::where('user_id',$userId)
            ->whereIn('post_id',$postIds)
            ->select('post_id','user_id')
            ->get()
            ->pluck('post_id')
            ->toArray();

        foreach ($posts as $post){
            $post->visitorPraise = in_array($post->id,$postPraises)?1:0;
            $post->visitorEnshrine = in_array($post->id,$postEnshrine)?1:0;
            $post->visitorUserId = $userId;
        }

        return $posts;
    }



        /**回复列表
     * @param $userId //用户ID
     * @return mixed
     */
//    public function indexReply($userId)
//    {
//        return PostComment::where('post_user_id',$userId)
//            ->orderBy('created_at', 'desc')
//            ->paginate(5);
//
//    }

    /**
     * 帖子详情
     */
//    public function showPostId($postId,$userId)
//    {
//        $postQuery = Post::query();
//        $post = $postQuery->with
//            ([
//            'publishUser'=>function($query){
//            $query->select('id','user_name');
//            }])
//            ->withCount(['postPraise','comment','enshrine'])
//            ->where('id',$postId)
//            ->first();
//
//        if ($userId != null){
//            $post->visitorPraise = intval(PostPraise::where('post_id',$postId)->where('user_id',$userId)->exists());
//            $post->visitorEnshrine = intval(PostEnshrine::where('post_id',$postId)->where('user_id',$userId)->exists());
//            $this->addRecentPost($userId,$postId);
//        }else{
//            $post->visitorPraise = 2;
//            $post->visitorEnshrine = 2;
//
//        }
//
//        return $post;
//    }

    /**收藏列表
     * @param $userId
     * @return mixed
     */
    public function indexEnshrine($user,$paginate = 1)
    {
        $postEnshrines = PostEnshrine::where('user_id',$user->id)
            ->orderBy('created_at','desc')
            ->paginate($paginate);
        $posts = Post::
            with('publishUser')
            ->withCount('postPraise')
            ->whereIn('id',$postEnshrines->pluck('post_id'))
            ->get()
            ->keyBy('id')
            ->toArray();

        foreach ($postEnshrines as $postEnshrine){
            $postEnshrine->post = $posts[$postEnshrine->post_id] ?? [];
        }

        return $postEnshrines;
    }

/**
 * 评论列表
 */

//    public function indexComment($postId,$userId,$type)
//    {
//
//        $commentQuery = PostComment::query()
//            ->with(['user'=>function($query){
//                $query->select('id','user_name','sex');
//            }])
//            ->withCount(['commentPraise'])
//            ->where('post_id',$postId);
//
//        if ($type == 'created_at_asc'){
//            $commentQuery = $commentQuery->orderBy('created_at','asc');
//        }
//
//        if ($type == 'created_at_desc'){
//            $commentQuery = $commentQuery->orderBy('created_at','desc');
//        }
//
//        if ($type == 'praise_desc'){
//            $commentQuery = $commentQuery->orderBy('comment_praise_count','desc')
//            ->orderBy('created_at','desc');
//        }
//
//        $comments = $commentQuery->paginate(5);
//
//        if ($userId != null){
//            $commentIds = $comments->pluck('id');
//            $commentPraise = PostCommentsPraise::whereIn('comment_id',$commentIds)
//                ->where('user_id',$userId)
//                ->select('comment_id')
//                ->get()
//                ->pluck('comment_id')
//                ->toArray();
//
//            foreach ($comments as $comment){
//                $comment->visitPraise = in_array($comment->id,$commentPraise)?1:0;
//            }
//
//        }else{
//            foreach ($comments as $comment){
//                $comment->visitPraise = 3;
//            }
//        }
//
//        return $comments;
//    }


    /**
     * 分配帖子到板块
     */
    public function addPostClassify($userId,$postId,$classifyId)
    {
        if (Post::where('id',$postId)
            ->where('user_id',$userId)
            ->exists()){
            PostClassify::create(['post_id'=>$postId,'classify_id'=>$classifyId]);
        }else{
            abort(400,'出了未知錯誤');
        }
    }

    /**
     * 用户关注板块
     */
    public function userAddClassify($userId,$classifyId)
    {

        if (UserClassify::where('user_id',$userId)
        ->where('classify_id',$classifyId)
        ->exists())
        {

            UserClassify::where('user_id',$userId)
                ->where('classify_id',$classifyId)
                ->delete();
            return [0];
        }else{

            UserClassify::create(['user_id'=>$userId,'classify_id'=>$classifyId]);
            return [1];
        }
    }

    //最近浏览帖子记录
    public function recentPost($userId)
    {
        return PostBrowse::where('user_id',$userId)
            ->with(['post'])
            ->orderBy('created_at','desc')
            ->Limit(10)
            ->get();
    }

    public function addRecentPost($userId,$postId)
    {
        if (PostBrowse::where('user_id',$userId)
            ->where('post_id',$postId)
            ->exists()
        ){
            PostBrowse::where('user_id',$userId)
                ->where('post_id',$postId)
                ->delete();
        }
        PostBrowse::create(['user_id'=>$userId,'post_id'=>$postId]);
    }


    /**
     *帖子分类统计
     **/

    public function classifyStatistics()
    {
        $postClassifys = PostClassify::query()
            ->selectRaw('classify_id,count(*) as post_count')
            ->groupBy('classify_id')
            ->get();

        $classify = Classify::whereIn('id',$postClassifys->pluck('classify_id'))
            ->get()
            ->keyBy('id');

        foreach ($postClassifys as $postClassify){
            $postClassify->name = $classify->get($postClassify->classify_id)->name??null;
        }

        return $postClassifys;
    }

    /**
     * 帖子点赞99
     */
    public function praise(User $user,$postId)
    {
        if (! Post::where('id',$postId)->exists()){
            abort(404,'帖子不存在');
        }

        if (PostPraise::where('user_id',$user->id)->where('post_id',$postId)->exists()){
            PostPraise::where('user_id',$user->id)->where('post_id',$postId)->delete();
        }else{
            PostPraise::create(['user_id'=>$user->id, 'post_id'=>$postId,]);
        }

    }
    /**
     * 收藏帖子 ,取消收藏帖子
     */
    public function enshrine(User $user,$postId)
    {
        if (! Post::where('id',$postId)->exists()){
            abort(404,'帖子不存在');
        }

        if (PostEnshrine::where('user_id',$user->id)->where('post_id',$postId)->exists()){
            PostEnshrine::where('user_id',$user->id)->where('post_id',$postId)->delete();
        }else{
            PostEnshrine::create([
               'user_id'=>$user->id,
               'post_id'=>$postId,
            ]);
        }
    }























}









































