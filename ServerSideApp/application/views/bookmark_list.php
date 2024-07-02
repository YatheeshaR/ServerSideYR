<!DOCTYPE html>
<html>
<head>
    <title>Bookmarks</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        h2 {
            color: #2c3e50;
            font-weight: 300;
        }
        form {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        form input, form button {
            font-size: 16px;
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }
        form input:focus {
            border-color: #3498db;
        }
        form button {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        form button:hover {
            background-color: #2980b9;
        }
        #bookmarks {
            margin-top: 20px;
        }
        .bookmark {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .bookmark h3 {
            margin-top: 0;
            color: #3498db;
        }
        .bookmark a {
            color: #2980b9;
            text-decoration: none;
            word-wrap: break-word;
        }
        .bookmark a:hover {
            text-decoration: underline;
        }
        .bookmark p {
            color: #666;
        }
        .bookmark button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 10px;
            margin-right: 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .bookmark button.edit {
            background-color: #f39c12;
        }
        .bookmark button:hover {
            opacity: 0.8;
        }
        .logout {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #e74c3c;
            color: #fff;
            text-decoration: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .logout:hover {
            opacity: 0.8;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Bookmarks</h2>
    <a href="<?php echo site_url('user/logout'); ?>">Logout</a>

    <form id="searchBookmarkForm" action="<?php echo site_url('bookmark/search'); ?>" method="POST">
        <input type="text" id="tag" name="tag" placeholder="Search by tag" required>
        <button type="submit">Search</button>
    </form>

    <form id="addBookmarkForm" action="<?php echo site_url('bookmark/create'); ?>" method="POST">
        <input type="text" id="title" name="title" placeholder="Title" required>
        <input type="url" id="url" name="url" placeholder="URL" required>
        <input type="text" id="tags" name="tags" placeholder="Tags (comma-separated)">
        <button type="submit">Add Bookmark</button>
    </form>
    <div id="bookmarks">
        <?php foreach ($bookmarks as $bookmark): ?>
            <div class="bookmark" data-id="<?php echo $bookmark['id']; ?>">
                <h3><?php echo $bookmark['title']; ?></h3>
                <a href="<?php echo $bookmark['url']; ?>"><?php echo $bookmark['url']; ?></a>
                <p>Tags: <?php echo $bookmark['tags']; ?></p>
                <button class="delete" data-id="<?php echo $bookmark['id']; ?>">Delete</button>
                <button class="edit" data-id="<?php echo $bookmark['id']; ?>">Edit</button>
            </div>
        <?php endforeach; ?>
    </div>
  
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-body"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

    <script>
        $(document).ready(function() {
            $('.delete').on('click', function() {
                var id = $(this).data('id');
                $.ajax({
                    url: '/ServerSideYR/ServerSideApp/index.php/bookmark/delete/' + id,
                    type: 'DELETE',
                    success: function(result) {
                        alert('Bookmark deleted successfully');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to delete bookmark');
                    }
                });
            });

            $('.edit').on('click', function() {
                var id = $(this).data('id');
                $.get('/ServerSideYR/ServerSideApp/index.php/bookmark/edit/' + id, function(data) {
                    $('#modal-body').html(data);
                    $('#editModal').show();

                    $('#editBookmarkForm').on('submit', function(e) {
                        e.preventDefault();
                        var formData = $(this).serialize();
                        $.ajax({
                            url: '/ServerSideYR/ServerSideApp/index.php/bookmark/update/' + id,
                            type: 'POST',
                            data: formData,
                            success: function(result) {
                            // Directly use 'result', assuming it's already an object
                             if (result.success) {
                                alert('Bookmark updated successfully');
                                location.reload();
                          } else {
                            alert('Failed to update bookmark');
                            }
                        },
                    error: function(xhr, status, error) {
                        alert('Failed to update bookmark');
                                }
                        });
                    });
                });
            });

            $('#addBookmarkForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(result) {
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to add bookmark');
                    }
                });
            });

            $('#searchBookmarkForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(result) {
                        $('#bookmarks').html(result);
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to search bookmarks');
                    }
                });
            });

            // Close the modal when the user clicks on <span> (x)
            $(document).on('click', '.close', function() {
                $('#editModal').hide();
            });

            // Close the modal when the user clicks anywhere outside of the modal
            $(window).on('click', function(event) {
                if ($(event.target).is('#editModal')) {
                    $('#editModal').hide();
                }
            });
        });
    </script>
</body>
</html>
