<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class BlogPostController extends Controller {

	public function __construct()
	{
		$this->middleware('auth')->except(['show', 'index']);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$mostCommented = Cache::remember('most-comments', 60, function() {
			return  BlogPost::mostCommented()->take(5)->get();
		});

		$mostPostedUsers = Cache::remember('most-posted-users', 60, function() {
			return  User::mostPostedUser()->take(5)->get();
		});

		$posts = BlogPost::latest()->withCount('comments')->with('user')->get();
		// $mostCommented = BlogPost::mostCommented()->take(5)->get();
		// $mostPostedUsers = User::mostPostedUser()->take(5)->get();
		return view('posts.index', compact('posts', 'mostCommented', 'mostPostedUsers'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		// $this->authorize('create'); သူ့ကိုေတာ့ policy ေပးခ်င္တဲ့အခါမွာသံုးေပးတာ သူ့ကိုသံုးသည့္အတြက္ create လုပ္လို့မရဘူး။
		return view('posts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		// return $request->all();
		$post = BlogPost::create($request->all());
		return redirect()->route('posts.show',['post' => $post->id]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\BlogPost  $blogPost
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id) {
		// with ထဲမွာက်ေတာ့ comments ဆိုတာက BlogPost model ထဲမွာရွိတဲ့ method အဲ့ဒါကို key အေနနဲ့ေခၚပီးေတာ့ Comment model ထဲမွာရွိတဲ့ေကာင္ကိုက်ေတာ့ clouser function နဲ့ျန္ေခၚေပးတာ။
		// $post = BlogPost::with(['comments' => function($query) {
		// 	return $query->latest();
		// }])->findOrFail($id);

		// ** သူ့ကို default အေနနဲထုပ္ခ်င္တယ္ဆိုရင္ေတာ့ BlogPost Model ထဲမွာသြားပီးေတာ့ထုပ္လို့ရတယ္။
		$post = Cache::remember("blog-post-{$id}", 60, function() use($id) {
			return  BlogPost::with('comments')->findOrFail($id);
		});

		$sessionID = session()->getId();
		$counterKey = "blog-post-{$id}-counter";
		$userKey = "blog-post-{$id}-user";
		$users = Cache::get($userKey, []);
		$userUpdate = [];
		$difference = 0;
		$now = now();
		foreach($users as $session => $lastVisit) {
			if($now->diffInMinutes($lastVisit) >= 1) {
				$difference--;
			} else {
				$userUpdate[$session] = $lastVisit;
			}
		}
		if(!array_key_exists($sessionID, $users) || $now->diffInMinutes($users[$sessionID]))
		{
			$difference++;
		}
		$userUpdate[$sessionID] = $now;
		Cache::forever($userKey, $userUpdate);
		if(!Cache::has($counterKey)) {
			Cache::forever($counterKey, 1);
		} else {
			Cache::increment($counterKey, $difference);
		}

		$counter = Cache::get($counterKey);

		// $post = BlogPost::with('comments')->findOrFail($id);
		return view('posts.show', compact('post', 'counter'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\BlogPost  $blogPost
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request, $id) {
		$post = BlogPost::find($id);
		// dd("Update");
		// $this->authorize('edit', $post); // သူ့ကိုေအာက္လို ျပင္ေရးလို့ရတယ္ ဘာလို့လဲဆိုေတာ့ Policy ထဲမွာရွိတဲ့ Method နဲ့ Controller ထဲမွာရွိတဲ့ method ေတြေရာေနမွာဆိုးလို့ တစ္ခုတည္းေခၚလိုက္တာ။
		$this->authorize($post);
		// if(Gate::denies('update-post', $post)) {
		// 	abort(403, 'You can not edit this blog post');
		// }
		return view('posts.edit', compact('post'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\BlogPost  $blogPost
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$post = BlogPost::findOrFail($id);

		// dd("Update!");
		$this->authorize($post);

		$post->fill($request->all());
		$post->save();
		return redirect()->route('posts.show', ['post' => $id]);

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\BlogPost  $blogPost
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id) {
		$post = BlogPost::findOrFail($id);

		// if(Gate::denies('delete-post', $post)) {
		// 	abort(403, 'You can not delete this blog post');
		// }
		// အေပၚမွာ comment ပိတ္ထားတဲ့ေကာင္ေတြကိုမသံုးပဲနဲ့ အခုလိုမ်ိုး တစ္ေၾကာင္းတည္းေရးတာလဲအတူတူပဲ
		// ဒါေပမဲ့ အေပၚဆံုးမွာေတာ့ gate ကိုေခၚေပးထးဖို့လိုတယ္ ( ဆိုလိုတာက ) use Illuminate လုပ္ခိုင္းတာ။

			// dd($post);
		$this->authorize('delete', $post);

		$post->delete();
		return redirect('posts');
	}
}
