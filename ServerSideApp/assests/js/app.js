var app = app || {};

$(function() {
    app.bookmarks = new app.BookmarkCollection();
    app.bookmarksView = new app.BookmarkListView({ collection: app.bookmarks });

    app.bookmarks.fetch({ reset: true });
});