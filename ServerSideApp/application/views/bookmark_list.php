<!DOCTYPE html>
<html>
<head>
    <title>Bookmarks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        #bookmarks {
            margin-top: 20px;
        }
        .bookmark {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        .bookmark h3 {
            margin-top: 0;
            margin-bottom: 5px;
        }
        .bookmark p {
            margin-top: 5px;
            margin-bottom: 5px;
            color: #666;
        }
        .bookmark button {
            margin-right: 5px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.4.0/backbone-min.js"></script>
</head>
<body>
    <h2>Bookmarks</h2>
    <a href="<?php echo site_url('user/logout'); ?>">Logout</a>
    <form id="addBookmarkForm">
        <input type="text" id="title" name="title" placeholder="Title" required>
        <input type="url" id="url" name="url" placeholder="URL" required>
        <input type="text" id="tags" name="tags" placeholder="Tags (comma-separated)">
        <button type="submit">Add Bookmark</button>
    </form>
    <div id="bookmarks">
        <?php foreach ($bookmarks as $bookmark): ?>
            <div class="bookmark" data-id="<?= $bookmark['id'] ?>">
                <h3><?= $bookmark['title'] ?></h3>
                <a href="<?= $bookmark['url'] ?>"><?= $bookmark['url'] ?></a>
                <p>Tags: <?= implode(', ', explode(',', $bookmark['tags'])) ?></p>
                <button class="delete">Delete</button>
                <button class="edit">Edit</button>
            </div>
        <?php endforeach; ?>
    </div>

    <script type="text/template" id="bookmarkTemplate">
        <div class="bookmark" data-id="<%= id %>">
            <h3><%= title %></h3>
            <a href="<%= url %>"><%= url %></a>
            <p>Tags: <%= tags %></p>
            <button class="delete">Delete</button>
            <button class="edit">Edit</button>
        </div>
    </script>

    <script>
$(document).ready(function() {
    // Define the Bookmark model
    var Bookmark = Backbone.Model.extend({
        urlRoot: '/ServerSideYR/ServerSideApp/index.php/bookmark',
        defaults: {
            title: '',
            url: '',
            tags: ''
        }
    });

    // Define the Bookmarks collection
    var Bookmarks = Backbone.Collection.extend({
        model: Bookmark,
        url: '/ServerSideYR/ServerSideApp/index.php/bookmark'
    });

    // Define the Bookmark view
    var BookmarkView = Backbone.View.extend({
        tagName: 'div',
        className: 'bookmark',
        template: _.template($('#bookmarkTemplate').html()),

        events: {
            'click .delete': 'deleteBookmark',
            'click .edit': 'editBookmark'
        },

        deleteBookmark: function() {
            this.model.destroy();
            this.remove();
        },

        editBookmark: function() {
            // Implementation for editing the bookmark
            var newTitle = prompt("Enter new title:", this.model.get('title'));
            var newUrl = prompt("Enter new URL:", this.model.get('url'));
            var newTags = prompt("Enter new tags (comma-separated):", this.model.get('tags'));
            if (newTitle && newUrl && newTags) {
                this.model.save({
                    title: newTitle,
                    url: newUrl,
                    tags: newTags
                }, {
                    success: function(model, response) {
                        // Optionally update view or handle success
                    },
                    error: function(model, xhr, options) {
                        var responseText = JSON.parse(xhr.responseText);
                        alert("Failed to update bookmark: " + responseText.error);
                    }
                });
            }
        },

        render: function() {
            this.$el.html(this.template(this.model.toJSON()));
            return this;
        }
    });

    // Define the Bookmarks view
    var BookmarksView = Backbone.View.extend({
        el: '#bookmarks',

        initialize: function() {
            this.collection = new Bookmarks(<?php echo json_encode($bookmarks); ?>); // Initialize with PHP data
            this.listenTo(this.collection, 'sync', this.render);
            this.render();
        },

        render: function() {
            this.$el.empty();
            this.collection.each(this.addBookmark, this);
            return this;
        },

        addBookmark: function(bookmark) {
            var view = new BookmarkView({ model: bookmark });
            this.$el.append(view.render().el);
        }
    });

    // Initialize the App view
    var appView = new BookmarksView();

    // Submit form handling
    $('#addBookmarkForm').submit(function(e) {
        e.preventDefault();
        var title = $('#title').val();
        var url = $('#url').val();
        var tags = $('#tags').val();
        var bookmark = new Bookmark({ title: title, url: url, tags: tags });
        bookmark.save(null, {
            success: function(model, response) {
                appView.collection.add(model);
                $('#title').val('');
                $('#url').val('');
                $('#tags').val('');
            },
            error: function(model, xhr, options) {
                var responseText = JSON.parse(xhr.responseText);
                alert("Failed to add bookmark: " + responseText.error);
            }
        });
    });
});

    </script>
</body>
</html>
