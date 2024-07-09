// bookmark_view.js
var BookmarkView = Backbone.View.extend({
    tagName: 'div',
    className: 'bookmark',
    template: _.template($('#bookmark-template').html()),
    events: {
        'click .delete': 'deleteBookmark',
        'click .edit': 'editBookmark'
    },
    render: function() {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    },
    deleteBookmark: function() {
        this.model.destroy();
    },
    editBookmark: function() {
        // Open edit modal
        var editModal = new EditModalView({ model: this.model });
        editModal.render();
    }
});
