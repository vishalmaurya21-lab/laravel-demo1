<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body        { font-family: Arial, sans-serif; max-width: 700px; margin: 30px auto; }
        .post-card  { border: 1px solid #ccc; padding: 15px; margin: 10px 0; border-radius: 6px; }
        .post-image { width: 100%; max-height: 300px; object-fit: cover; border-radius: 4px; margin-bottom: 10px; }
        .btn-edit   { background: #f0ad4e; color: white; padding: 5px 12px; text-decoration: none; border-radius: 4px; }
        .btn-delete { background: #d9534f; color: white; padding: 5px 12px; text-decoration: none; border-radius: 4px; margin-left: 8px; }
    </style>
</head>
<body>

    <h2>Welcome, {{ $user->name }}!</h2>
    <a href="{{ route('users.logout') }}">Logout</a>

    <hr>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    {{-- Create Post Form --}}
    <h3>Create a Post</h3>

    {{-- ✅ enctype="multipart/form-data" is REQUIRED for file uploads --}}
    <form action="{{ route('users.addpost') }}" method="POST" enctype="multipart/form-data">
        @csrf
        Title:<br>
        <input type="text" name="title" placeholder="Title" style="width:100%"><br><br>

        Content:<br>
        <textarea name="content" placeholder="Content" rows="4" style="width:100%"></textarea><br><br>

        {{-- ✅ Image upload input --}}
        Image (optional):<br>
        <input type="file" name="image" accept="image/*"><br>
        <small style="color:gray">Accepted: jpg, png, gif, webp — Max: 2MB</small><br><br>

        <button type="submit">Create Post</button>
    </form>

    <hr>

    {{-- Posts List --}}
    <h3>Your Posts</h3>
    @forelse($posts as $post)
        <div class="post-card">

            {{-- ✅ Show image if the post has one --}}
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="post-image">
            @endif

            <h4>{{ $post->title }}</h4>
            <p>{{ $post->content }}</p>
            <small>{{ $post->created_at->diffForHumans() }}</small>

            <div style="margin-top:10px">
                <a href="{{ route('users.editpost', $post->id) }}" class="btn-edit">Edit</a>
                <a href="{{ route('users.deletepost', $post->id) }}"
                   class="btn-delete"
                   onclick="return confirm('Are you sure you want to delete this post?')">
                   Delete
                </a>
            </div>
        </div>
    @empty
        <p>No posts yet. Create your first post above!</p>
    @endforelse

</body>
</html>