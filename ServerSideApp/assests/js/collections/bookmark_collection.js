// bookmark_collection.js
var app = app || {};

app.collections.Bookmarks = Backbone.Collection.extend({
    model: app.models.Bookmark,
    url: '/ServerSideYR/ServerSideApp/index.php/api/bookmark' // Adjust the URL to match your API endpoint
});