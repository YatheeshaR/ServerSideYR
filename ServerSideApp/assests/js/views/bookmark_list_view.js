// bookmark_list_view.js
var BookmarkListView = Backbone.View.extend({
    el: '#bookmarks',
    initialize: function() {
        this.collection = new BookmarkCollection();
        this.collection.fetch();
        this.listenTo(this.collection, 'add', this.renderBookmark);
        this.listenTo(this.collection, 'reset', this.render);
    },
    render: function() {
        this.$el.empty();
        this.collection.each(this.renderBookmark, this);
        return this;
    },
    renderBookmark: function(bookmark) {
        var bookmarkView = new BookmarkView({ model: bookmark });
        this.$el.append(bookmarkView.render().el);
    }
});
