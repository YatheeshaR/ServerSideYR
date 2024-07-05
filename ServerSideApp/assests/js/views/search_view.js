var app = app || {};

app.SearchView = Backbone.View.extend({
    el: '#search-bookmark',

    events: {
        'submit form': 'search'
    },

    search: function(e) {
        e.preventDefault();
        var tag = this.$('input[name=tag]').val();
        var filtered = this.collection.filter(function(bookmark) {
            return bookmark.get('tags').indexOf(tag) !== -1;
        });
        app.bookmarksView.render(filtered);
    }
});