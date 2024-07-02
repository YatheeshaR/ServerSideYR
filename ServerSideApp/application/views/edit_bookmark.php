<!DOCTYPE html>
<html>
<head>
    <title>Edit Bookmark</title>
</head>
<body>
    <h2>Edit Bookmark</h2>
    <?php echo validation_errors(); ?>
    <?php echo form_open('', array('id' => 'editBookmarkForm')); ?>
        <label for="title">Title</label>
        <input type="text" name="title" value="<?php echo $bookmark['title']; ?>" required><br>

        <label for="url">URL</label>
        <input type="url" name="url" value="<?php echo $bookmark['url']; ?>" required><br>

        <label for="tags">Tags</label>
        <input type="text" name="tags" value="<?php echo $bookmark['tags']; ?>"><br>

        <input type="submit" value="Update">
    <?php echo form_close(); ?>
</body>
</html>
