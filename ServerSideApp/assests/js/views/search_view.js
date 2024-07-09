var SearchView = Backbone.View.extend({
    el: '#searchBookmarkForm',
    events: {
        'submit': 'searchBookmarks'
    },
    searchBookmarks: function(event) {
        event.preventDefault();
        var tag = $(event.currentTarget).find('input[name="tag"]').val();
        this.collection.search(tag);
    }
});
