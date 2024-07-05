var app = app || {};

app.EditBookmarkView = Backbone.View.extend({
    el: '#edit-bookmark',

    events: {
        'submit form': 'submit'
    },

    submit: function(e) {
        e.preventDefault();
        var newTitle = this.$('input[name=title]').val();
        var newUrl = this.$('input[name=url]').val();
        this.model.save({ title: newTitle, url: newUrl });
    }
});