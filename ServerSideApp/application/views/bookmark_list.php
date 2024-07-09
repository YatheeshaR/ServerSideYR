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

        form input,
        form button {
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

				.modal-content .header {
						display: flex;
flex-direction: row;
align-items: center;
justify-content: space-between;
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.4/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.1/backbone-min.js"></script>
</head>
<body>
    <h2>Bookmarks</h2>
    <a href="<?php echo site_url('user/logout'); ?>">Logout</a>

<!-- search form -->
<form id="searchBookmarkForm">
  <input type="text" id="tag" name="tag" placeholder="Search by tag" required>
  <button type="submit">Search</button>
</form>

<!-- add bookmark form -->
<form id="addBookmarkForm">
  <input type="text" id="title" name="title" placeholder="Title" required>
  <input type="url" id="url" name="url" placeholder="URL" required>
  <input type="text" id="tags" name="tags" placeholder="Tags (comma-separated)">
  <button type="submit">Add Bookmark</button>
</form>

 <!-- bookmark_list.php -->
<div id="bookmarks">
</div>

<div id="pagination">
</div>


<!-- edit modal -->
<div id="editModal" class="modal">
</div>

<!-- templates -->
<script type="text/template" id="bookmark-template">
  <div class="bookmark" data-id="<%= id %>">
    <h3><%= title %></h3>
    <a href="<%= url %>"><%= url %></a>
    <p>Tags: <%= tags %></p>
    <button class="delete" data-id="<%= id %>">Delete</button>
    <button class="edit" data-id="<%= id %>">Edit</button>
  </div>
</script>

<script type="text/template" id="edit-template">
  <div class="modal-content">
		<div class="header">
			<h2>Edit Bookmark</h2>
			<span class="close">&times;</span>
		</div>
		<form id="editBookmarkForm">
			<label for="title">Title</label>
			<input type="text" name="title" value="<%= title %>" required><br>

			<label for="url">URL</label>
			<input type="url" name="url" value="<%= url %>" required><br>

			<label for="tags">Tags</label>
			<input type="text" name="tags" value="<%= tags %>"><br>

			<input type="submit" value="Update">
		</form>

    <div id="modal-body"></div>
  </div>
</script>

<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.13.4/underscore-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.6.0/backbone-min.js"></script>

<script src="/assests/js/app.js" type="text/javascript" ></script>
</body>
</html>
