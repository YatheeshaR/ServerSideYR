// bookmark_model.js
var BookmarkModel = Backbone.Model.extend({
    url: function() {
        return 'api/bookmarks/' + this.id;
    },
    defaults: {
        title: '',
        url: '',
        tags: ''
    }
});
