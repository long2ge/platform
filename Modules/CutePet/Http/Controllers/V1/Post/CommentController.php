<?php

namespace Modules\Post\Http\Controllers\V1;

use App\Services\InvokeService;
use Illuminate\Http\Request;
use Modules\CutePet\Http\Controllers\CutePetController;
use Modules\Post\Models\Comment;
use Modules\Post\Services\CommentService;

class CommentController extends CutePetController
{
    /**
     * @var commentService 评论服务
     */
    private $getCutePet;

    /**
     * 构造函数
     * commentService constructor.
     * @param commentService $commentService
     */
    public function __construct()
    {
        $this->getCutePet = app(InvokeService::class)->getCutePet();
    }

    /**
     * 发表评论
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(Request $request)
    {
        $this->requestValidator($request, [
            'post_id' => 'required|int',
            'content' => 'required|string',
        ]);

        $userId = $request->user()->id;
        $postId = $request->input('post_id');
        $content = $request->input('content');

        $this->commentService->commentIssue($userId, $postId, $content);

        return $this->response()->created();
    }

    /**
     * 删除评论
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->requestValidator($request, [
            'post_id' => 'required|int',
            'comment_id' => 'required|int'
            ]);

        $postId = $request->input('post_id');
        $commentId = $request->input('comment_id');
        $this->commentService->commentDelete($postId, $commentId);
        return $this->response()->noContent();
    }

    /**
     * 恢复评论
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function restore(Request $request)
    {
        $this->requestValidator($request, [
            'post_id' => 'required|int',
            'comment_id' => 'required|int'
        ]);

        $postId = $request->input('post_id');
        $commentId = $request->input('comment_id');
        $this->commentService->commentRecover($postId, $commentId);
        return $this->response()->created();
    }

    /**
     * 评论点赞/取消点赞
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function favor(Request $request)
    {
        // 校验参数
        $this->requestValidator($request, [
            'post_id' => 'required|int', //帖子id
            'comment_id' => 'required|int', // 评论id
            'is_favor' => 'required|boolean', // 是否点赞
        ]);

        $userId = $request->user()->id;
        $postId = $request->input('post_id');
        $commentId = $request->input('comment_id');
        $isFavor = $request->input('is_favor');

        $this->commentService->switchFavor($postId, $commentId, $userId, $isFavor);

        return $this->response()->noContent();
    }

    /**
     * 显示单条评论
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     * @return \Dingo\Api\Http\Response
     */
    public function show($postId, $commentId)
    {
        $comment = $this->commentService->commentShow($postId, $commentId);

        return $this->response
            ->item($comment, new CommentTransformer())
            ->setStatusCode(200);
    }

    /**
     * 显示评论列表
     * @param int | string $postId 帖子id
     * @return \Dingo\Api\Http\Response
     */
    public function index($postId)
    {
        $title = Post::findOrFail($postId)->title;

        $paginator = app(Comment::class)
            ->where('post_id', $postId)
            ->paginate(20);

        return $this->response
            ->paginator($paginator, new CommentTransformer())
            ->setMeta(['title' => $title])
            ->setStatusCode(200);
    }
}
