<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/5/31
 * Time: 16:56
 */

namespace Modules\CutePet\Http\Controllers\V1\Post;


use Illuminate\Http\Request;
use Modules\CutePet\Http\Controllers\CutePetController;
use Modules\CutePet\Services\PostCommentService;

class PostCommentController extends CutePetController
{
    /**
     * 评论（回复主帖）
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|int',//所属帖子ID
            'comment_content' => 'required|string',//评论内容
        ]);

        $commentData = $request->only([
            'post_id',
            'comment_content',
        ]);

        app(PostCommentService::class)->recordPostComment($request->user(),$commentData);

        return response()->json([], 204);
    }




    /**
     * 回复评论
     */
    public function commentReply(Request $request)
    {

        $this->validate($request, [
            'comment_id' => 'required|int',//评论ID
            'reply_content' => 'required|string',//评论内容
        ]);

        $urlData = $request->only([
            'comment_id',
            'reply_content',
        ]);

        app(PostCommentService::class)->commentReply($request->user(),$urlData);

        return response()->json([], 204);
    }

    /**
     *用户修改评论
     */
    public function upPostComment(Request $request)
    {
        $this->validate($request,[
            'post_comment_id'=>'required|int',
            'up_comment_content'=>'required|string',
            ]);

        $upData['id'] = $request->input('post_comment_id');
        $upData['comment_content'] = $request->input('up_comment_content');

        app(PostCommentService::class)->upPostComment($request->user(),$upData);

        return response()->json([], 204);
    }


    /**
     * 删除评论
     */
    public function deleteComment(Request $request)
    {
        $this->validate($request,[
            'comment_id'=>'required|int',
        ]);

        $commentId = $request->input('comment_id');

        app(PostCommentService::class)->deleteComment($request->user(),$commentId);

        return response()->json([], 204);
    }

    /**
     * 评论详情
     */
    public function show(Request $request)
    {
        $this->validate($request,[
            'comment_id'=>'required|int',
        ]);

        $commentId = $request->input('comment_id');

        $data = app(PostCommentService::class)->showComment($request->user(),$commentId);

        return response()->json(['data'=>$data], 200);
    }

    /**
     * 帖子评论列表
     */
    public function index(Request $request)
    {
        $this->validate($request,[
            'post_id'=>'required|int',
        ]);

        $postId = $request->input('post_id');

        $data = app(PostCommentService::class)->indexComment($request->user(),$postId);

        return response()->json($data, 200);
    }

    /**
     *★评论点赞
     */
    public function praise(Request $request,$commentId)
    {
        app(PostCommentService::class)->praise($request->user(),$commentId);

        return response()->json([], 204);
    }



}

