# Polymorphic Relationship
# One To One
  images
    - url
    - imageable_id -> user_id || post_id
    - imageable_type -> model User || Model Post

  One -> users -> Only Have One Images 
    - name
    - email
    - password

  One -> posts -> Only Have One Images
    - title
    - body

# One To Many
  Comment
    - body
    - commentable_id
    - commentable_type

  One Post have Many Comment
    - title
    - body
   One Video have Many Comment
    - url

# Many To Many
    Many post Have Many Tags
        - title
        - body
    Many Video Have Many Tags
        - url

    tags
        - name
    
    taggables
        - tag_id
        - taggable_id
        - taggable_type
    `
        $post = Post::first();
        $post->tags()->create(
            ['name' => 'eloquent'],
            ['name' => 'laravel']
        );

        $video = Video::first();
        $video->tags()->create(['name'=>'php']);
        $video->tags()->attach(1);
        $video->tags()->detach(1);
        $video->tags()->sync(1); //will be removed other
    `  
