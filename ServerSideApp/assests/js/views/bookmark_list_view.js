var app = app || {};

app.BookmarkListView = Backbone.View.extend({
    el: '#bookmark-list',

    initialize: function() {
        this.listenTo(this.collection, 'reset add change remove', this.render);
    },

    render: function() {
        this.$el.empty();
        this.collection.each(function(bookmark) {
            var view = new app.BookmarkView({ model: bookmark });
            this.$el.append(view.render().el);
        }, this);
        return this;
    }
});