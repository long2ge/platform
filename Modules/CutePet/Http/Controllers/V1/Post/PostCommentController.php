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
     * 发布帖子评论/回复评论
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'post_id' => 'required|int',//所属帖子ID
            'comment_content' => 'required|string',//评论内容
            'type' => 'nullable|int',//类型 0回复主帖 1回复评论
            'reply_comment_id' => 'nullable|int',//回复的评论ID  （type为1的数据）
            'reply_comment_user_id' => 'nullable|int',//回复的评论用户ID  （type为1的数据）
        ]);


        $commentData = $request->only([
            'post_id',
            'comment_content',
            'type',
            'reply_comment_id',
            'reply_comment_user_id',
        ]);

        $commentData['comment_user_id'] = $request->user()->id;

        app(PostCommentService::class)->recordPostComment($commentData);

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
}

