<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <style>
        body          { font-family: Arial, sans-serif; max-width: 600px; margin: 30px auto; }
        .current-image{ width: 100%; max-height: 250px; object-fit: cover; border-radius: 6px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <h2>Edit Post</h2>

    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- ✅ enctype="multipart/form-data" required for file upload --}}
    <form action="{{ route('users.updatepost', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        Title:<br>
        <input type="text" name="title" value="{{ old('title', $post->title) }}" style="width:100%"><br><br>

        Content:<br>
        <textarea name="content" rows="6" style="width:100%">{{ old('content', $post->content) }}</textarea><br><br>

        {{-- ✅ Show current image if post has one --}}
        @if($post->image)
            <p>Current Image:</p>
            <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="current-image">

            {{-- ✅ Checkbox to remove the current image --}}
            <label>
                <input type="checkbox" name="remove_image" value="1">
                Remove current image
            </label><br><br>
        @endif

        {{-- ✅ Upload new image --}}
        Upload New Image (optional):<br>
        <input type="file" name="image" accept="image/*"><br>
        <small style="color:gray">Accepted: jpg, png, gif, webp — Max: 2MB</small><br><br>

        <button type="submit">Update Post</button>
        <a href="{{ route('users.dashboard') }}" style="margin-left:10px">Cancel</a>
    </form>

</body>
</html>