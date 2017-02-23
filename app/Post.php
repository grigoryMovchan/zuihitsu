<?php

namespace App;

use App\User;
use App\Post;
use App\Attitude;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
    * Массово присваиваемые атрибуты.
    *
    * @var ArrayAccess
    */

    protected $fillable = [
        'header', 'message'
    ];

    /**
    * Получить пользователя - владельца данной задачи
    */

    public function user()
    {
      return $this->belongTo(User::class);
    }

    /**
    * Получить все задачи заданного пользователя.
    *
    * @param User $user
    * @return Collection
    */
    public function forUser(User $user, $skip)
    {
      return $this::where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->skip($skip)
        ->take(10)
        ->get();
    }
    
    /**
     * Получает количество постов, чтобы потом посчитать количество страниц
     */
    public static function getPageCount(User $user)
    {
        return Post::where('user_id', $user->id)
        ->count();
    }

    public function getPost($id)
    {
        return $this::find($id);
    }
    
    public function setPost($request, $post)
    {
        $post_edit = $this::find($post->id);

        $post_edit->header = $request->header;
        $post_edit->message = $request->message;


//        $post_edit->tags = $request->tags;

        $post_edit->save();
    }
}
