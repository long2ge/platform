<?php


namespace Modules\CutePet\Http\Controllers\V1\Post;

use Illuminate\Http\Request;
use Modules\CutePet\Http\Controllers\CutePetController;
use Modules\CutePet\Services\PostService;
use Modules\CutePet\Services\TaskService;


class PostController extends CutePetController
{
    /**
     * 发布帖子
     */
    public function addPost(Request $request)
    {

        $this->validate($request,[
            'title'=>'required|string',
            'content'=>'required|string',
            'is_video'=>'required|int',
            'classify_id'=>'required|int',
        ]);

        $classifyId = $request->input('classify_id');
        $data = $request->only(['title','content','is_video',]);
        $data['user_id'] = $request->user()->id;

        app(PostService::class)->addPost($data,$classifyId);


        return response()->json([], 204);
    }

    /**
     * 删除帖子
     */
    public function deletePost(Request $request)
    {
        $userId = $request->user()->id;
        $postId = $request->input('post_id');

        app(PostService::class)->deletePost($userId,$postId);

        return response()->json([], 204);
    }

    /**
     * 修改帖子
     *
     */
    public function putPost(Request $request)
    {
        $userId = $request->user()->id;
        $postId = $request->input('post_id');

        $postData = $request->only([
            'content',
            'title',
        ]);

        app(PostService::class)->putPost($userId,$postId,$postData);

        return response()->json([], 204);
    }

    /**
     *帖子详情
     */
    public function showPost(Request $request)
    {
        $postId = $request->input('post_id');
        $userId = $request->user()->id;

        $post = app(PostService::class)->getIndexPost([$postId],$userId);

        app(PostService::class)->addView($postId);

        return response()->json(['data'=>$post]);

    }
    /**
     * 自发帖子列表
     */
    public function indexOwn(Request $request)
    {

        $userId  = $request->user()->id;

        $posts = app(PostService::class)->showUserIdPost($userId);

        return response()->json($posts);
    }

    /**
     * 板块帖子列表（根据板块）
     *
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'paginate' => 'nullable|int',
            'classify_id' => 'required|int',
        ]);
        $userId = $request->user()->id??0;
        $paginate = $request->input('paginate') ?? 10;
        $classifyId = $request->input('classify_id');
        $posts = app(PostService::class)->index($classifyId,$userId,$paginate);

        return response()->json($posts);
    }

    /**
     * 回复列表88
     */
    public function indexReply(Request $request)
    {
        $userId = $request->user()->id;

        return response()->json(
            app(PostService::class)->indexReply($userId)
        );
    }


    /**
     * 热门帖子列表
     */

    /**
     * 精华帖子列表
     */

    /**
     * 视频帖子列表
     */

    /**
     * 帖子评论列表
     **/

    /**
     * 分配帖子到板块
     */


    /**用户关注板块
     * @param Request $request
     * @param $classifyId
     * @return mixed
     */

    /**
     *帖子点赞
     *
     */
    public function praise(Request $request,$postId)
    {
        app(PostService::class)->praise($request->user(),$postId);

        return response()->json([], 204);
    }

    /**
     * 用户收藏帖子
     */
    public function postEnshrine(Request $request,int $postId)
    {
        $user = $request->user();

        app(PostService::class)->enshrine($user,$postId);
    }

    /**
     * 收藏列表
     */
    public function indexEnshrine(Request $request)
    {
        $user = $request->user()??null;

        return response()->json(app(PostService::class)->indexEnshrine($user));
    }

    /**
     * 推荐列表
     */
    public function indexRecommend()
    {
        return response()->json(app(PostService::class)->indexRecommend());
    }


}
