<?php
/*

* Policy ကိုေဆာက္ဖို့ဆိုရင္ run ရမဲ့ command က
* php artisan make:policy BlogPostPolicy --model=BlogPost
* Gate နဲ့ Policy က Route နဲ့ Controller လိုပဲ။

*/


namespace App\Policies;

use App\User;
use App\BlogPost;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlogPostPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any blog posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function view(User $user, BlogPost $blogPost)
    {
        //
    }

    /**
     * Determine whether the user can create blog posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function update(User $user, BlogPost $blogPost)
    {
        return $user->id == $blogPost->user_id;
    }

    /**
     * Determine whether the user can delete the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function delete(User $user, BlogPost $blogPost)
    {
        return $user->id == $blogPost->user_id;
    }

    /**
     * Determine whether the user can restore the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function restore(User $user, BlogPost $blogPost)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the blog post.
     *
     * @param  \App\User  $user
     * @param  \App\BlogPost  $blogPost
     * @return mixed
     */
    public function forceDelete(User $user, BlogPost $blogPost)
    {
        //
    }
}
