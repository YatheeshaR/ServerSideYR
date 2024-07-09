var CreateBookmarkView = Backbone.View.extend({
	el: "#addBookmarkForm",
	events: {
		"submit": "submit",
	},
	submit: function (e) {
		e.preventDefault();
		const title = this.$("input[name=title]");
		const url = this.$("input[name=url]");
		const tags = this.$("input[name=tags]");

		console.log(BookmarkCollection())
		BookmarkCollection.create({ title, url, tags });
		return this;
	},
});
