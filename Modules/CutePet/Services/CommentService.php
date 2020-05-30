<?php
/**
 * Created by PhpStorm.
 * User: LONG
 * Date: 2019/4/18
 * Time: 20:02
 */

namespace Modules\CutePet\Services;


use Illuminate\Support\Facades\DB;
use Modules\Post\Models\Comment;
use Modules\Post\Models\CommentFavor;
use Modules\Post\Models\Response;
use Modules\Post\Models\SpeechRecord;
/* method 3
use Modules\User\Services\UserService; */

class CommentService
{
    /**
     * 发表评论
     * @param int | string $userId 用户id
     * @param int | string $postId 帖子id
     * @param string $content 内容
     */
    public function commentIssue($userId, $postId, $content)
    {
        $dbConnection = config('cutepet.db-connection');

        try {
            DB::connection($dbConnection)->beginTransaction();

            $comment = Comment::create([
                'user_id' => $userId,
                'post_id' => $postId,
                'content' => $content
            ]);

            if (null === $comment) {
                throw new \Exception('保存数据失败!');
            }

            $speechRecord = SpeechRecord::create([
                'post_id' => $postId,
                'comment_id' => $comment->id
            ]);

            if (null === $speechRecord) {
                throw new \Exception('保存数据失败!');
            }

            DB::connection($dbConnection)->commit();
        } catch (\Exception $e) {
            DB::connection($dbConnection)->rollBack();
        }
    }

    /**
     * 删除评论
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     */
    public function commentDelete($postId, $commentId)
    {
        $dbConnection = config('cutepet.db-connection');

        try {
            DB::connection($dbConnection)->beginTransaction();
            $comment = Comment::where('id', $commentId)->delete();

            if (false === $comment) {
                throw new \Exception('保存数据失败!');
            }

            $speechRecord = SpeechRecord::where('post_id', $postId)
                ->where('comment_id', $commentId)
                ->delete();

            if (false === $speechRecord) {
                throw new \Exception('保存数据失败!');
            }

            DB::connection($dbConnection)->commit();
        } catch (\Exception $e) {
            DB::connection($dbConnection)->rollBack();
        }
    }

    /**
     * 恢复评论
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     */
    public function commentRecover($postId, $commentId)
    {
        $dbConnection = config('cutepet.db-connection');

        try {
            $comment = Comment::onlyTrashed()->where('id', $commentId)->restore();

            if (false === $comment) {
                throw new \Exception('保存数据失败!');
            }

            $commentRecord = SpeechRecord::create([
                'post_id' => $postId,
                'comment_id' => $commentId
            ]);

            if (null === $commentRecord) {
                throw new \Exception('保存数据失败!');
            }

            $responseIds = Comment::where('id', $commentId)
                ->responses()
                ->select(['id'])
                ->pluck('id');

            foreach ($responseIds as $responseId) {
                $responseRecord = SpeechRecord::create([
                    'post_id' => $postId,
                    'comment_id' => $commentId,
                    'response_id' => $responseId
                ]);

                if (null === $responseRecord) {
                    throw new \Exception('保存数据失败!');
                }
            }

            DB::connection($dbConnection)->commit();
        } catch (\Exception $e) {
            DB::connection($dbConnection)->rollBack();
        }
    }

    /**
     * 显示单条评论
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     * @return false
     */
    public function commentShow($postId, $commentId)
    {
        /* method 1 */
        $comment = Comment::where('id', $commentId)->with([
            'user' => function ($queryUserName) {
            $queryUserName->select(['user_name']);
            }, 'post' => function ($queryPostTitle) {
            $queryPostTitle->select(['title']);
        }])->firstOrFail();

        $comment->user_name = $comment->user->user_name;
        $comment->title = $comment->post->title;
        $comment->responseCount = $comment->speechRecord ? $comment->speechRecord->count() : 0;

        /* method 2
        $comment = Comment::findOrFail($commentId);
        $comment->user_name = $comment->user()->select(['user_name'])->first()->user_name;
        $comment->title = $comment->post()->select(['title'])->first()->title;
        $comment->responseCount = $comment->speechRecord()->count();
        $comment->responses_cache = $comment->responses()->limit(2)->get(); */

        /* method 3
        $comment = Comment::findOrFail($commentId);
        $comment->user_name = app(UserService::class)->getUserNameById($comment->user_id);
        $comment->title = app(PostService::class)->showPostTitle($postId);
        $comment->responseCount = app(SpeechRecord::class)->where('comment_id', $commentId)->count();
        $comment->responses_cache = $comment->responses()->limit(2)->get(); */

        if (! empty($comment->response_ids_chache)) {
            $responseIds = json_decode($comment->response_ids_chache);
            $responsesCache = Response::whereIn('id', $responseIds)->get();
            $comment->responsesCache = $responsesCache;
        }

        return $comment;
    }

    /**
     * 评论点赞
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     * @param int | string $userId 用户id
     * @param $isFavor
     */
    public function switchFavor($postId, $commentId, $userId, $isFavor)
    {
        $isFavor ? CommentFavor::create([
            'comment_id' => $commentId,
            'user_id' => $userId,
        ])
            : CommentFavor::where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * 显示评论回复数
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     * @return mixed
     */
    public function responseCount($postId, $commentId)
    {
        $comment = $this->commentShow($postId, $commentId);
        return $comment->responseCount;
    }

    /**
     * 把回复id缓存转化为数组
     * @param int | string $commentId 评论id
     * @return array|mixed
     */
    public function jsonDecode($commentId)
    {
        $responseIdsCache = Comment::find($commentId)->response_ids_cache;

        if (empty($responseIdsCache)) {
            return array();
        } else {
            $responseIds = json_decode($responseIdsCache);
            return $responseIds;
        }
    }
}