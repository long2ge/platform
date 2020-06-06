<?php
/**
 * Created by PhpStorm.
 * User: Long
 * Date: 2020/5/31
 * Time: 17:10
 */

namespace Modules\CutePet\Services;


use Modules\CutePet\Models\PostComment;
use Modules\CutePet\Models\PostCommentsPraise;
use Modules\CutePet\Models\User;

class PostCommentService
{
    /**
     * ★评论（回复主帖）
     */
    public function recordPostComment(User $user, array $commentData)
    {
        $commentData['comment_user_id'] = $user->id;
        $commentData['praise'] = 0;//点赞数
        $commentData['astrict'] =  $user->astrict ?? 0 ;//没定义的限制
        $commentData['type'] = 0;//评论类型

        if (! PostComment::create($commentData)){
            abort(400,'主帖评论失败');
        }
    }

    /**
     * ★修改帖子评论
     * @param User $user
     * @param $upData
     */
    public function upPostComment(User $user,$upData)
    {
        if (! PostComment::where('id',$upData['id'])->where('comment_user_id',$user->id)->exists()){
            abort(400,'无操作数据');
        }else{
            if (! PostComment::where('id',$upData['id'])->where('comment_user_id',$user->id)->update($upData)){
                abort(400,'修改失败');
            }
        }
    }

    /**
     * ★回复评论
     */
    public function commentReply(User $user,$urlData)
    {
        $superiorComment = PostComment::where('id',$urlData['comment_id'])->first();

        if ($superiorComment == null){
            abort(400,'评论不存在');
        }

        $writeData['post_id'] = $superiorComment->post_id;
        $writeData['comment_user_id'] = $user->id;
        $writeData['comment_content'] = $urlData['reply_content'];
        $writeData['astrict'] = $user->astrict??0;
        $writeData['type'] = 1;
        $writeData['reply_comment_id'] = $urlData['comment_id'];
        $writeData['reply_comment_user_id'] = $superiorComment->comment_user_id;

        if (!PostComment::create($writeData)){
            abort(400,'回复失败');
        }
    }

    /**
     *★删除评论
     */
    public function deleteComment(User $user,$commentId)
    {
        if (! PostComment::where('id',$commentId)->where('comment_user_id',$user->id)->exists()){
            abort(400,'无权操作');
        }

        if (! PostComment::where('id',$commentId)->where('comment_user_id',$user->id)->update(['astrict'=>2])){
            abort(400,'删除失败');
        }
    }

    /**
     * ★评论详情
     * @param User $user
     * @param $commentId
     */
    public function showComment(User $user,$commentId)
    {
        $postComment = PostComment::where('id',$commentId)->first()??abort(400,'评论不存在');

        return $postComment;
    }

    /**
     *★帖子评论列表
     */
    public function indexComment(User $user,$postId,$paginate = 10)
    {
        $postCommentBuilder  = PostComment::query();

        $postCommentS = $postCommentBuilder->where('post_id',$postId)->paginate($paginate);

        return $postCommentS;
    }

    public function praise(User $user,$commentId)
    {

        if (! PostComment::where('id',$commentId)->exists()){
        abort(404,'评论不存在');
        }

        if (PostCommentsPraise::where('user_id',$user->id)->where('praise_comment_id',$commentId)->exists()){
            PostCommentsPraise::where('user_id',$user->id)->where('praise_comment_id',$commentId)->delete();
        }else{
            PostCommentsPraise::create(['user_id'=>$user->id, 'praise_comment_id'=>$commentId,]);
        }

    }
}