<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2020/1/22
 * Time: 5:40 PM
 */

namespace Modules\Post\Services;


use Illuminate\Http\Request;
use Modules\Post\Models\Classify;
use Modules\Post\Models\PostBrowse;
use Modules\Post\Models\PostClassify;
use Modules\Post\Models\PostComment;
use Modules\Post\Models\PostCommentsPraise;
use Modules\Post\Models\PostEnshrine;
use Modules\Post\Models\PostPraise;
use Modules\Post\Models\UserClassify;
use Modules\Post\Post;
use Modules\User\Services\UserService;

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
    public function addPost($data)
    {
        $post = Post::create($data);
        if(!$post){
         abort(400 ,'发布失败，请检查网络');
        }

        app(UserService::class)->userContribute($data['user_id'],'post_sum',1);
    }

    /**删除帖子
     * @param $userId //用户ID
     * @param $postId //帖子ID
     */
    public function deletePost($userId,$postId)
    {

        Post::where('user_id',$userId)
            ->where('id',$postId)
            ->delete();

        app(UserService::class)->userContribute($userId,'post_sum',-1);
    }

    /**显示用户帖子列表
     * @param $showUserId
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
    public function index($select,$rank,$userId)
    {
        $postQuery = Post::query();
        $posts = $postQuery->with([
            'publishUser'=>function($query){
            $query->select('id','user_name');
        }
        ])
            ->withCount(['postPraise','comment','enshrine'])
            ->orderBy($select,$rank)
            ->paginate(3);

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
        }
        return $posts;
    }

    /**回复列表
     * @param $userId //用户ID
     * @return mixed
     */
    public function indexReply($userId)
    {
        return PostComment::where('post_user_id',$userId)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

    }

    /**
     * 帖子详情
     */
    public function showPostId($postId,$userId)
    {
        $postQuery = Post::query();
        $post = $postQuery->with
            ([
            'publishUser'=>function($query){
            $query->select('id','user_name');
            }])
            ->withCount(['postPraise','comment','enshrine'])
            ->where('id',$postId)
            ->first();

        if ($userId != null){
            $post->visitorPraise = intval(PostPraise::where('post_id',$postId)->where('user_id',$userId)->exists());
            $post->visitorEnshrine = intval(PostEnshrine::where('post_id',$postId)->where('user_id',$userId)->exists());
            $this->addRecentPost($userId,$postId);
        }else{
            $post->visitorPraise = 2;
            $post->visitorEnshrine = 2;

        }

        return $post;
    }

    /**收藏列表
     * @param $userId
     * @return mixed
     */
    public function indexEnshrine($userId)
    {
        $postEnshrines = PostEnshrine::where('user_id',$userId)
            ->withCount(['postPraise','comment','enshrine'])
            ->with('post')
            ->orderBy('created_at','desc')
            ->select('post_id')
            ->paginate(5);

        foreach ($postEnshrines as $postEnshrine){
            $postEnshrine->user_id = $postEnshrine->post->user_id??null;
            $postEnshrine->title = $postEnshrine->post->title??null;
            $postEnshrine->content = $postEnshrine->post->content??null;
            $postEnshrine->view = $postEnshrine->post->view??null;
            $postEnshrine->hot = $postEnshrine->post->hot??null;
            $postEnshrine->perfect = $postEnshrine->post->perfect??null;
            $postEnshrine->top = $postEnshrine->post->top??null;
            $postEnshrine->shield = $postEnshrine->post->shield??null;
            $postEnshrine->is_video = $postEnshrine->post->is_video??null;
            $postEnshrine->created_at = $postEnshrine->post->created_at??null;
            unset($postEnshrine->post);
        }



        return $postEnshrines;
    }

/**
 * 评论列表
 */

    public function indexComment($postId,$userId,$type)
    {

        $commentQuery = PostComment::query()
            ->with(['user'=>function($query){
                $query->select('id','user_name','sex');
            }])
            ->withCount(['commentPraise'])
            ->where('post_id',$postId);

        if ($type == 'created_at_asc'){
            $commentQuery = $commentQuery->orderBy('created_at','asc');
        }

        if ($type == 'created_at_desc'){
            $commentQuery = $commentQuery->orderBy('created_at','desc');
        }

        if ($type == 'praise_desc'){
            $commentQuery = $commentQuery->orderBy('comment_praise_count','desc')
            ->orderBy('created_at','desc');
        }

        $comments = $commentQuery->paginate(5);

        if ($userId != null){
            $commentIds = $comments->pluck('id');
            $commentPraise = PostCommentsPraise::whereIn('comment_id',$commentIds)
                ->where('user_id',$userId)
                ->select('comment_id')
                ->get()
                ->pluck('comment_id')
                ->toArray();

            foreach ($comments as $comment){
                $comment->visitPraise = in_array($comment->id,$commentPraise)?1:0;
            }

        }else{
            foreach ($comments as $comment){
                $comment->visitPraise = 3;
            }
        }

        return $comments;
    }


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


}
//<?php
///**
// * Created by PhpStorm.
// * User: LONG
// * Date: 2019/4/18
// * Time: 19:47
// */
//
//namespace Modules\Post\Services;
//
//use Modules\Post\Models\Post;
//use Modules\Post\Models\PostFavor;
///* method 3
//use Modules\User\Services\UserService;
//use Modules\Post\Models\SpeechRecord; */
//
//class PostService
//{
//    /**
//     * 发表帖子
//     * @param int | string $userId 帖子id
//     * @param string $title 标题
//     * @param string $content 内容
//     */
//    public function postIssue($userId, $title, $content)
//    {
//        Post::create([
//            'user_id' => $userId,
//            'title' => $title,
//            'content' => $content,
//        ]);
//    }
//
//    /**
//     * 删除帖子
//     * @param int | string $postId 帖子id
//     */
//    public function postDelete($postId)
//    {
//        Post::findOrFail($postId)->delete();
//    }
//
//    /**
//     * 恢复帖子
//     * @param int | string $postId 帖子id
//     */
//    public function postRecover($postId)
//    {
//        Post::onlyTrashed()->where('id', $postId)->restore();
//    }
//
//    /**
//     * 显示单条帖子
//     * @param int | string $postId 帖子id
//     * @return null
//     */
//    public function postShow($postId)
//    {
//        /* method 1 */
//        $post = Post::where('id', $postId)->with([
//            'user' => function ($queryUserName) {
//            $queryUserName->select(['user_name']);
//        }])->firstOrFail();
//
//        $post->user_name = $post->user->user_name;
//        $post->speechCount = $post->speechRecord ? $post->speechRecord->count() : 0;
//
//        /* method 2
//        $post = Post::findOrFail($postId);
//        $post->user_name = $post->user()->select(['user_name'])->first()->user_name;
//        $post->speechCount = $post->speechRecord()->count(); */
//
//        /* method 3
//        $post = Post::findOrFail($postId);
//        $post->speechCount = $post->speechRecord()->count(); */
//
//        return $post;
//    }
//
//    /**
//     * 帖子置顶
//     * @param int | string $postId 帖子id
//     * @param int | string $userId 用户id
//     * @param bool $isStick 是否置顶
//     */
//    public function switchStick($postId, $userId, $isStick)
//    {
//        if ($isStick) {
//            Post::where('user_id', $userId)
//                ->where('stick', 1)
//                ->update(['stick' => 0]);
//
//            Post::where('post_id', $postId)
//                ->where('user_id', $userId)
//                ->update(['stick' => 1]);
//
//            return;
//        }
//
//        Post::where('user_id', $userId)
//            ->where('post_id', $postId)
//            ->update(['stick' => 0]);
//    }
//
//    /**
//     * 帖子点赞
//     * @param int | string $postId 帖子id
//     * @param int | string $userId 帖子id
//     * @param bool $isFavor 是否点赞
//     */
//    public function switchFavor($postId, $userId, $isFavor)
//    {
//        $isFavor ? PostFavor::create([
//                        'post_id' => $postId,
//                        'user_id' => $userId,
//                    ])
//                 : PostFavor::where('post_id', $postId)
//                     ->where('user_id', $userId)
//                     ->delete();
//    }
//
//    /**
//     * 显示帖子标题
//     * @param int | string $postId 帖子id
//     * @return mixed
//     */
//    public function showPostTitle($postId)
//    {
//        $title = Post::findOrFail($postId)->title;
//        return $title;
//    }
//
//    /**
//     * 显示帖子回复数
//     * @param int | string $postId 帖子id
//     * @return mixed
//     */
//    public function speechCount($postId)
//    {
//        $post = $this->postShow($postId);
//        return $post->speechCount;
//    }
//}