var app = app || {};

app.BookmarkView = Backbone.View.extend({
    tagName: 'li',
    template: _.template($('#bookmark-template').html()),

    render: function() {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    }
});