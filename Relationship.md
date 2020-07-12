# One To One
```
Schema::create('users', function (Blueprint $table) {

    $table->increments('id');

    $table->string('name');

    $table->string('email')->unique();

    $table->string('password');

    $table->rememberToken();

    $table->timestamps();

});
```
```
Schema::create('phones', function (Blueprint $table) {

    $table->increments('id');

    $table->integer('user_id')->unsigned();

    $table->string('phone');

    $table->timestamps();

    

    $table->foreign('user_id')->references('id')->on('users')

        ->onDelete('cascade');

});
```
```
<?php


namespace App;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * Get the phone record associated with the user.
     */
    public function phone()
    {
        return $this->hasOne('App\Phone');
    }
}
```

```
<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Phone extends Model
{
    /**
     * Get the user that owns the phone.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
```
# Retrieve Records:
```
$phone = User::find(1)->phone;
dd($phone);
$user = Phone::find(1)->user;
dd($user);
```
# Create Records:
```
$user = User::find(1);
 
$phone = new Phone;
$phone->phone = '9429343852';
 
$user->phone()->save($phone);

$phone = Phone::find(1);
 
$user = User::find(10);
 
$phone->user()->associate($user)->save();
```
https://www.itsolutionstuff.com/post/laravel-one-to-one-eloquent-relationship-tutorialexample.html

# One To Many
```
Schema::create('posts', function (Blueprint $table) {

    $table->increments('id');

    $table->string("name");

    $table->timestamps();

});

```
```
Schema::create('comments', function (Blueprint $table) {

    $table->increments('id');

    $table->integer('post_id')->unsigned();

    $table->string("comment");

    $table->timestamps();

    $table->foreign('post_id')->references('id')->on('posts')

        ->onDelete('cascade');

});
```

```
<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
```
```
<?php


namespace App;


use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
    /**
     * Get the post that owns the comment.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
```
# Retrieve Records:
```
$post = Post::find(1);
 
$comments = $post->comments;

dd($comments);
$comment = Comment::find(1);
 
$post = $comment->post;
 
dd($post);
```
# Create Records:
```
$post = Post::find(1);
 
$comment = new Comment;
$comment->comment = "Hi ItSolutionStuff.com";
 
$post = $post->comments()->save($comment);
$post = Post::find(1);
 
$comment1 = new Comment;
$comment1->comment = "Hi ItSolutionStuff.com Comment 1";
 
$comment2 = new Comment;
$comment2->comment = "Hi ItSolutionStuff.com Comment 2";
 
$post = $post->comments()->saveMany([$comment1, $comment2]);

$comment = Comment::find(1);
$post = Post::find(2);
 
$comment->post()->associate($post)->save();
```

# One To Many (Inverse)
# Many To Many
```
Schema::create('users', function (Blueprint $table) {

    $table->increments('id');

    $table->string('name');

    $table->string('email')->unique();

    $table->string('password');

    $table->rememberToken();

    $table->timestamps();

});
```
```
Schema::create('roles', function (Blueprint $table) {

    $table->increments('id');

    $table->string('name');

    $table->timestamps();

});
```
```
Schema::create('role_user', function (Blueprint $table) {

    $table->integer('user_id')->unsigned();

    $table->integer('role_id')->unsigned();

    $table->foreign('user_id')->references('id')->on('users')

        ->onDelete('cascade');

    $table->foreign('role_id')->references('id')->on('roles')

        ->onDelete('cascade');

});
```
```
<?php
 
namespace App;
 
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
 
class User extends Authenticatable
{
    use Notifiable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
 
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
 
    /**
     * The roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }
}
```
```
<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Role extends Model
{
    /**
     * The users that belong to the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
```
```

<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class UserRole extends Model
{
     
}

```
# Retrieve Records:
```
$user = User::find(1);	
dd($user->roles);

$role = Role::find(1);	
dd($role->users);
```
# Create Records:
```
$user = User::find(2);	
 
$roleIds = [1, 2];
$user->roles()->attach($roleIds);
$user = User::find(3);	
 
$roleIds = [1, 2];
$user->roles()->sync($roleIds);

$role = Role::find(2);	
 
$userIds = [10, 11];
$role->users()->sync($userIds);
```
https://www.itsolutionstuff.com/post/laravel-many-to-many-eloquent-relationship-tutorialexample.html

## Another example for Many To Many
# Post Model
```
<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   public function tags(){
     return $this->belongsToMany('App\Model\User\Tag','post__tags', 'post_id', 'tag_id');
  }

  public function categories() {
     return $this->belongsToMany('App\Model\User\Category','category__posts','post_id', 'category_id');
  }
}
```

# Post Model
```
<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   public function tags(){
     return $this->belongsToMany('App\Model\User\Tag','post__tags', 'post_id', 'tag_id');
  }

  public function categories() {
     return $this->belongsToMany('App\Model\User\Category','category__posts','post_id', 'category_id');
  }
}
```

# Category Model
```
<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   public function posts(){
      return $this->belongsToMany('App\Model\User\Category','category__posts', 'post_id', 'category_id');
   }

}
```

# Post Model
```
<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   public function tags(){
     return $this->belongsToMany('App\Model\User\Tag','post__tags', 'post_id', 'tag_id');
  }

  public function categories() {
     return $this->belongsToMany('App\Model\User\Category','category__posts','post_id', 'category_id');
  }
}
```

# Category Model

```
<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   public function posts(){
      return $this->belongsToMany('App\Model\User\Category','category__posts', 'post_id', 'category_id');
   }

}
```

# Tag Model

```
<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
   public function posts() {
       return $this->belongsToMany('App\Model\User\Post','post__tags','post_id','tag_id');
   }
}
```

# Post Model

```
<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   public function tags(){
     return $this->belongsToMany('App\Model\User\Tag','post__tags', 'post_id', 'tag_id');
  }

  public function categories() {
     return $this->belongsToMany('App\Model\User\Category','category__posts','post_id', 'category_id');
  }
}
```

Category Model
```
<?php

namespace App\Model\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   public function posts(){
      return $this->belongsToMany('App\Model\User\Category','category__posts', 'post_id', 'category_id');
   }

}
```

# Tag Model
```
<?php

namespace App\Model\User;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
   public function posts() {
       return $this->belongsToMany('App\Model\User\Post','post__tags','post_id','tag_id');
   }
}
```

## PostController.php
```
public funcion store()
{
// do validation here
   try{
      $post = new Post;
      $post->title = $request->title;
      $post->subtitle  =  $request->subtitle;
      $post->slug  =  $request->slug;
      $post->body  =  $request->body;           
      $post->status  =  1;                   
      $post->save();     // This works correct 
      $post->tags()->sync($request->tags); // Not working
      $post->categories()->sync($request->categories);  // Not working
   }
   catch(\Exception $e){ 
      return redirect(route('post.index'))->with('message', 'Error Adding Post into system!'.$e->getMessage()); // getting Message "Method sync does not exist. "
    }      
}
```
```
 // change your code like this
 $post->tags()->sync($request->tags);
 $post->categories()->sync($request->categories);


 $post->tags()->sync($request->tags);
$post->categories()->sync($request->categories);
Don't forget the () in tags and categories

$post->categories without () is a Collection instance.

$post->categories() is a belongsToMany instance
```

# Defining Custom Intermediate Table Models
# Has One Through
```
users
    id - integer
    reviewer_id - integer

reviewers
    id - integer

activities
    id - integer
    user_id - integer
```

```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    /**
     * Get the reviewer's activity.
     */
    public function activity()
    {
        return $this->hasOneThrough('App\Activity', 'App\User');
    }
}
```
```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reviewer extends Model
{
    /**
     * Get the reviewer's activity.
     */
    public function activity()
    {
        return $this->hasOneThrough(
            'App\Activity',
            'App\User',
            'reviewer_id', // Foreign key on users table...
            'user_id', // Foreign key on activities table...
            'id', // Local key on reviewers table...
            'id' // Local key on users table...
        );
    }
}
```

```
$reviewer = Reviewer::first();
$activity = $reviewer->activity;
```

# Has Many Through
```
Schema::create('users', function (Blueprint $table) {

    $table->increments('id');

    $table->string('name');

    $table->string('email')->unique();

    $table->string('password');

    $table->integer('country_id')->unsigned();

    $table->rememberToken();

    $table->timestamps();

    $table->foreign('country_id')->references('id')->on('countries')

                ->onDelete('cascade');

});
```
```
Schema::create('posts', function (Blueprint $table) {

    $table->increments('id');

    $table->string("name");

    $table->integer('user_id')->unsigned();

    $table->timestamps();

    $table->foreign('user_id')->references('id')->on('users')

                ->onDelete('cascade');

});
```

```
Schema::create('countries', function (Blueprint $table) {

    $table->increments('id');

    $table->string('name');

    $table->timestamps();

});Schema::create('countries', function (Blueprint $table) {

    $table->increments('id');

    $table->string('name');

    $table->timestamps();

});
```

```
<?php
 
namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Country extends Model
{
    public function posts()
    {
        return $this->hasManyThrough(
            Post::class,
            User::class,
            'country_id', // Foreign key on users table...
            'user_id', // Foreign key on posts table...
            'id', // Local key on countries table...
            'id' // Local key on users table...
        );
    }
}
```

```
$country = Country::find(1);	
 
dd($country->posts);
```
https://www.itsolutionstuff.com/post/laravel-has-many-through-eloquent-relationship-tutorialexample.html