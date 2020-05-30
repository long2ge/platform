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
use Modules\Post\Models\Response;
use Modules\Post\Models\ResponseFavor;
use Modules\Post\Models\SpeechRecord;
// use Modules\User\Models\User; // method 3

class ResponseService
{
    /* response ids cache count */
    public $cache = 2;

    /**
     * 发表回复
     * @param int | string $userId 用户id
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     * @param int | string $respondentId 回复id
     * @param $content
     */
    public function responseIssue($userId, $postId, $commentId, $respondentId, $content)
    {
        $dbConnection = config('cutepet.db-connection');

        try {
            DB::connection($dbConnection)->beginTransaction();

            $response = Response::create([
                'user_id' => $userId,
                'post_id' => $postId,
                'comment_id' => $commentId,
                'respondent_id' => $respondentId,
                'content' => $content
            ]);

            if (null === $response) {
                throw new \Exception('保存数据失败!');
            }

            $speechRecord = SpeechRecord::create([
                'post_id' => $postId,
                'comment_id' => $commentId,
                'response_id' => $response->id
            ]);

            if (null === $speechRecord) {
                throw new \Exception('保存数据失败!');
            }

            /* transform json to array */
            $responseIds = app(CommentService::class)->jsonDecode($commentId);

            if (count($responseIds) < $this->cache) {
                $responseIds[] = $response->id;

                $comment = Comment::where('id', $commentId)
                    ->update(['response_ids_cache' => json_encode($responseIds)]);

                if (false === $comment) {
                    throw new \Exception('保存数据失败!');
                }
            }

            DB::connection($dbConnection)->commit();
        } catch (\Exception $e) {
            DB::connection($dbConnection)->rollBack();
        }
    }

    /**
     * 删除回复
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     * @param int | string $responseId 回复id
     */
    public function responseDelete($postId, $commentId, $responseId)
    {
        $dbConnection = config('cutepet.db-connection');

        try {
            DB::connection($dbConnection)->beginTransaction();
            $response = Response::where('id', $responseId)->delete();

            if (false === $response) {
                throw new \Exception('保存数据失败!');
            }

            $speechRecord = SpeechRecord::where('post_id', $postId)
                ->where('comment_id', $commentId)
                ->where('response_id', $responseId)
                ->delete();

            if (false === $speechRecord) {
                throw new \Exception('保存数据失败!');
            }

            /* transform json to array */
            $responseIds = app(CommentService::class)->jsonDecode($commentId);

            if (in_array($responseId, $responseIds)) {
                $updatedResponseIds = Response::where('comment_id', $commentId)
                    ->select(['id'])
                    ->limit($this->cache)
                    ->pluck('id')
                    ->toArray();

                $comment = Comment::where('id', $commentId)
                    ->update([
                        'response_ids_cache' => empty($updatedResponseIds) ? false :
                            json_encode($updatedResponseIds)
                    ]);

                if (false === $comment) {
                    throw new \Exception('保存数据失败!');
                }
            }

            DB::connection($dbConnection)->commit();
        } catch (\Exception $e) {
            DB::connection($dbConnection)->rollBack();
        }
    }

    /**
     * 恢复回复
     * @param int | string $postId 帖子id
     * @param int | string $commentId 评论id
     * @param int | string $responseId 回复id
     */
    public function responseRecover($postId, $commentId, $responseId)
    {
        $dbConnection = config('cutepet.db-connection');

        try {
            DB::connection($dbConnection)->beginTransaction();
            $response = Response::onlyTrashed()->where('id', $responseId)->restore();

            if (false === $response) {
                throw new \Exception('保存数据失败!');
            }

            $speechRecord = SpeechRecord::create([
                'post_id' => $postId,
                'comment_id' => $commentId,
                'response_id' => $responseId
            ]);

            if (null === $speechRecord) {
                throw new \Exception('保存数据失败!');
            }

            /* transform json to array */
            $responseIds = app(CommentService::class)->jsonDecode($commentId);

            if (max($responseIds) > $responseId) {
                $responseIds[] = $responseId;
                asort($responseIds);

                if (count($responseIds) > $this->cache) {
                    array_pop($responseIds);
                }

                $comment = Comment::where('id', $commentId)
                    ->update(['response_ids_cache' => json_encode(array_values($responseIds))]);

                if (false === $comment) {
                    throw new \Exception('保存数据失败!');
                }
            }

            DB::connection($dbConnection)->commit();
        } catch (\Exception $e) {
            DB::connection($dbConnection)->rollBack();
        }
    }

    /**
     * 回复点赞
     * @param int | string $responseId 回复id
     * @param int | string $userId 回复id
     * @param bool $isFavor 是否点赞
     */
    public function switchFavor($postId, $commentId, $responseId, $userId, $isFavor)
    {
        $isFavor ? ResponseFavor::create([
            'response_id' => $responseId,
            'user_id' => $userId,
        ])
            : ResponseFavor::where('response_id', $responseId)
            ->where('user_id', $userId)
            ->delete();
    }
}