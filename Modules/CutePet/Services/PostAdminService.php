<?php


namespace Modules\CutePet\Services;


use http\QueryString;
use Modules\Post\Models\Classify;
use Modules\Post\Models\PostClassify;
use Modules\Post\Models\UserClassify;
use Modules\Post\Post;
use Modules\User\Models\User;
use MongoDB\Driver\Query;
use function GuzzleHttp\Promise\all;

class PostAdminService
{
    /**冻结用户
     * @param $blockedUserId //冻结用户ID
     * @param $user //操作者
     */
    public function blockedAccount($blockedUserId,$user)
    {
        $a = User::where('id',$blockedUserId)->update(['status' => 0]);

        if ($a < 1){
            abort(400,'用户不存在');
        }
    }
    /**
     *用户列表
     */
    public function indexUser($keyword,$direction = 'desc')
    {
        $users = User::query();

        if($keyword){
            $users = $users->where(function ($query) use ($keyword){
                $query->where('user_name','like', '%' . $keyword . '%')
                    ->orwhere('profile','like', '%' . $keyword . '%')
                    ->orwhere('phone_number','like', '%' . $keyword . '%')
                    ->orwhere('address','like', '%' . $keyword . '%');
            });
        }

        return $users->orderBy('created_at',$direction)->get();
    }

    /**
     *帖子列表
     */
    public function indexPost()
    {
        $postQuery = Post::query();
        $post = $postQuery->with('publishUser');
        $posts = $post->paginate(10);
        return $posts;
    }

    /**
     * 统计版块内的帖子数
     * @param $classifyId
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function statisticsClassifyPost($classifyId)
    {
       $postClassifyQuery = PostClassify::query();
       $userClassifyQuery = UserClassify::query();
       if ($classifyId == 0){
           $classifys = Classify::query()->select('id','name')->get();

            $userClassify = $userClassifyQuery->selectRaw('classify_id, count(user_id) as user_count')
                ->groupBy('classify_id')
                ->get()
                ->keyBy('classify_id');

           $postClassify = $postClassifyQuery->selectRaw('classify_id, count(post_id) as post_count')
               ->groupBy('classify_id')
               ->get()
               ->keyBy('classify_id');
       }else{
           $classifys = Classify::query()->where('id',$classifyId)->select('id','name')->get();

           $userClassify = $userClassifyQuery->selectRaw('classify_id, count(user_id) as user_count')
               ->groupBy('classify_id')
               ->having('classify_id',$classifyId)
               ->get()
               ->keyBy('classify_id');

           $postClassify = $postClassifyQuery->selectRaw('classify_id, count(post_id) as post_count')
               ->groupBy('classify_id')
               ->having('classify_id',$classifyId)
               ->get()
               ->keyBy('classify_id');
       }

       foreach ($classifys as &$classify){
           $classify->post_count = $postClassify->get($classify->id)->post_count??0;
           $classify->user_count = $userClassify->get($classify->id)->user_count??0;
       }

       return $classifys;
    }
}
