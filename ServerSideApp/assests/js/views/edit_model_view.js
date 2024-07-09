// edit_modal_view.js
var EditModalView = Backbone.View.extend({
    el: '#editModal',
    template: _.template($('#edit-template').html()),
    events: {
        'submit #editBookmarkForm': 'updateBookmark'
    },
    render: function() {
        this.$el.html(this.template(this.model.toJSON()));
        return this;
    },
    updateBookmark: function(event) {
        event.preventDefault();
        var formData = $(event.currentTarget).serializeObject();
        this.model.save(formData);
        // Close edit modal
        this.$el.hide();
    }
});
