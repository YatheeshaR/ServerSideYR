// bookmark_collection.js
var BookmarkCollection = Backbone.Collection.extend({
	model: BookmarkModel,
	url: "/api/bookmarks",
	parse: function (data) {
		return data.bookmarks;
	},
});
