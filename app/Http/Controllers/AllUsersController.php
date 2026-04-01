<?php

namespace App\Http\Controllers;

use App\Models\AllUsers;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // ✅ add this

class AllUsersController extends Controller
{
    public function index()
    {
        return view('Users.index');
    }

    public function create()
    {
        return view('Users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);
        // $ALL = new AllUser();
        // $ALL->name = $request->name;
        // $ALL->save();

        // $data['password'] = bcrypt($data['password']);

        $user = AllUsers::create($data);

        session(['user_id' => $user->id, 'user_name' => $user->name]);

        return redirect()->route('users.dashboard');
    }

    public function dashboard()
    {
        if (!session()->has('user_id')) {
            return redirect()->route('users.login')->with('error', 'Please login first');
        }

        $user  = AllUsers::findOrFail(session('user_id'));
        $posts = Posts::where('user_id', session('user_id'))->latest()->get();

        return view('Users.dashboard', compact('user', 'posts'));
    }

    public function showLogin()
    {
        return view('Users.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = AllUsers::where('email', $request->email)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Invalid email or password');
        }

        session(['user_id' => $user->id, 'user_name' => $user->name]);

        return redirect()->route('users.dashboard');
    }

    public function logout()
    {
        session()->forget(['user_id', 'user_name']);
        return redirect()->route('users.login')->with('success', 'Logged out successfully');
    }

    /**
     * Add a new post with optional image upload.
     */
    public function addpost(Request $request)
    {
        if (!session()->has('user_id')) {
            return redirect()->back()->with('error', 'Please login first');
        }

        $request->validate([
            'title'   => 'required|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // ✅ nullable    → image is optional
            // ✅ image       → must be an image file
            // ✅ mimes:...   → only these formats allowed
            // ✅ max:2048    → max file size 2MB
        ]);

        $imagePath = null; // default to null if no image uploaded

        if ($request->hasFile('image')) {
            // ✅ store() saves the file to storage/app/public/posts/
            // and returns the path like "posts/filename.jpg"
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Posts::create([
            'user_id' => session('user_id'),
            'title'   => $request->title,
            'content' => $request->content,
            'image'   => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Post created successfully');
    }

    /**
     * Show edit form with existing post data.
     */
    public function editpost($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('users.login')->with('error', 'Please login first');
        }

        $post = Posts::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        return view('Users.editpost', compact('post'));
    }

    /**
     * Update post with optional new image.
     */
    public function updatepost(Request $request, $id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('users.login')->with('error', 'Please login first');
        }

        $request->validate([
            'title'   => 'required|max:255',
            'content' => 'required',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $post = Posts::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        $imagePath = $post->image; // keep the existing image by default

        if ($request->hasFile('image')) {
            // ✅ Delete old image from storage if it exists
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            // ✅ Store the new image
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        // ✅ If user checked "remove image"
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = null;
        }

        $post->update([
            'title'   => $request->title,
            'content' => $request->content,
            'image'   => $imagePath,
        ]);

        return redirect()->route('users.dashboard')->with('success', 'Post updated successfully');
    }

    /**
     * Delete a post and its image.
     */
    public function deletepost($id)
    {
        if (!session()->has('user_id')) {
            return redirect()->route('users.login')->with('error', 'Please login first');
        }

        $post = Posts::where('id', $id)
            ->where('user_id', session('user_id'))
            ->firstOrFail();

        // ✅ Delete the image file from storage before deleting the post
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('users.dashboard')->with('success', 'Post deleted successfully');
    }
}
