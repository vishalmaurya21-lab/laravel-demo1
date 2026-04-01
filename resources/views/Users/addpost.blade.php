<form method="POST" action="{{users.addpost}}">
        @csrf
        <input type="text" name="title" placeholder="Title">
        <textarea name="content" placeholder="Content"></textarea>
        <button type="submit">Create Post</button>
</form>