// bookmark_model.js
var app = app || {};
app.models.BookmarkModel = Backbone.Model.extend({
    url: function() {
        return '/ServerSideYR/ServerSideApp/index.php/api/bookmark/' + this.id;
    },
    defaults: {
        title: '',
        url: '',
        tags: ''
    }
});