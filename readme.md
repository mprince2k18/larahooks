[![Latest Stable Version](https://poser.pugx.org/mprince/larahooks/v/stable)](https://packagist.org/packages/mprince/larahooks)
[![Total Downloads](https://poser.pugx.org/mprince/larahooks/downloads)](https://packagist.org/packages/mprince/larahooks)
[![Latest Unstable Version](https://poser.pugx.org/mprince/larahooks/v/unstable)](https://packagist.org/packages/mprince/larahooks) 
[![License](https://poser.pugx.org/mprince/larahooks/license)](https://packagist.org/packages/mprince/larahooks)

# Larahooks

A Laravel 8 package for action and filter hook. Its helps to you fire any event with your desire action. Its a similar service as WP action and filter.

Inspired from [nahid](https://github.com/nahid/hookr)
  
## Installation

Write these command from you terminal.

```shell
composer require mprince/larahooks
```

Thats all

## Usages

 Its so easy to use. Just follow the instruction and apply with your laravel project.
 
### Action

You want to extra control with your application without touching your code you apply Action. Suppose you have a blog editor panel. Where you want add extra buttons from others developer without rewrite your code.
so lets see.


  ```html
  <!-- post.blade.php -->
  <form>
      <div class="form-group">
          <label for="title">Title</label>
          <input type="email" class="form-control" id="title" placeholder="Email">
      </div>

      <div class="form-group">
          <label for="blog">Blog</label>
          <textarea id="blog" cols="30" rows="10" class="form-control"></textarea>
      </div>

      <button type="submit" class="btn btn-default">Publish</button>
      {{do_action('buttons')}}
  </form>
  ```
  
  
  ![Demo](http://i.imgur.com/xqN1brq.png "demo")
  
  See, here we use `do_action()` helper function which is register as named `buttons`
  So if others developer is want to add more buttons with this form they will do this
  
  ```php
  use Mprince\Larahooks\Facades\Hook;
  
  class BlogController extends Controller
  {
        public function getWritePost()
        {
            hook()->bindAction('buttons', function() {
                echo ' <button class="btn btn-info">Draft</button>';
            }, 2);
            
            return view('post');
       }
  }
  ```
  
  After run this code add new button will add with existing button. 
  
  

  ![Demo](http://i.imgur.com/Udy1TkG.png "demo")

  You can also bind multiple action with this hook. LaraHooks also support filter. Remind this when you bind multiple filter in a hook then every filter get data from previous filters return data. Suppose you want to add a filter hook in a blog view section.

```
  <h1>{{$blog->title}}</h1>
  <p>
  {{apply_filters('posts', $blog->content)}}
  </p>
```

So we register a filter as 'posts'. Now another developer wants to support markdown for blog posts. so he can bind a filter for parse markdown.


 ```php
  use Mprince\Larahooks\Facades\Hook;
  
  class BlogController extends Controller
  {
        public function getPosts()
        {
            hook()->bindFilter('posts', function($data) {
                return parse_markdown($data);
            }, 2);
            
            return view('post');
       }
  }
  ```

  Note: In filter, every callback function must have at least one param which is represent current data

  so if you want to bind multiple data then

```php
  use Mprince\Larahooks\Facades\Hook;
  
  class BlogController extends Controller
  {
        public function getPosts()
        {
            hook()->bindFilter('posts', function($data) {
                return parse_markdown($data);
            }, 2);

            hook()->bindFilter('posts', function($data) {
                return parse_bbcode($data);
            }, 3);
            
            return view('post');
       }
  }
  ```

  Now then given data is parse by markdown and bbcode. See, here is second param for `bindFilter()` is a priority for binding. Both `bindAction()` and `bindFilter()` has this feature.

  ## Blade View

  You can show a blade file through `bindAction()` and `bindFilter()`

```php
  use Mprince\Larahooks\Facades\Hook;
  
  class BlogController extends Controller
  {
        public function index()
        {
            hook()->bindFilter('posts', function($data) {
                return view('index');
            }, 2);
            
            return view('post');
       }
  }
  ```

  ## Compacting Data

```php
  use Mprince\Larahooks\Facades\Hook;
  use App\Models\User;
  
  class BlogController extends Controller
  {
        public function index()
        {
            hook()->bindFilter('posts', function($data) {
                $user = User::all();
                return view('index', compact('user'));
            }, 1);
            
            return view('post');
       }
  }
  ```
