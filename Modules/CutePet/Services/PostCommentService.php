<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/5/31
 * Time: 17:10
 */

namespace Modules\CutePet\Services;


use Modules\CutePet\Models\PostComment;
use Modules\CutePet\Models\User;

class PostCommentService
{
    /**
     * 发布帖子评论，回复帖子评论
     */
    public function recordPostComment(array $commentData)
    {
        if (! PostComment::create($commentData)){
            abort(400,'帖子增加失败');
        }
    }

    public function upPostComment(User $user,$upData)
    {
        if (! PostComment::where('id',$upData['id'])->where('comment_user_id',$user->id)->exists()){
            abort(400,'无操作数据');
        }else{
            if (PostComment::where('id',$upData['id'])->where('comment_user_id',$user->id)->update($upData) != 1 ){
                abort(400,'修改失败');
            }
        }
    }



}