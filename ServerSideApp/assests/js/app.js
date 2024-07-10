var App = {};

var BookmarkModel = Backbone.Model.extend({
	defaults: {
		id: null,
		title: "",
		url: "",
		tags: "",
	},
});

const BookmarkCollection = Backbone.Collection.extend({
	model: BookmarkModel,
	url: "/api/bookmarks",
	parse: function (data) {
		this.pagination = data.pagination;
		return data.bookmarks;
	},
});

var BookmarkList = new BookmarkCollection();

const BookmarkView = Backbone.View.extend({
	tagName: "div",
	className: "bookmark",
	template: _.template($("#bookmark-template").html()),
	initialize: function () {
		this.listenTo(this.model, "change", this.render);
		this.listenTo(this.model, "destroy", this.remove);
	},
	events: {
		"click .delete": "deleteBookmark",
		"click .edit": "editBookmark",
	},
	render: function () {
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	},
	deleteBookmark: function () {
		this.model.destroy({ wait: true });
	},
	editBookmark: function () {
		const e = new EditModalView({ model: this.model });
		e.render();
	},
});

const CreateBookmarkView = Backbone.View.extend({
	el: "#addBookmarkForm",
	events: {
		submit: "submit",
	},
	submit: function (e) {
		e.preventDefault();
		const title = this.$("input[name=title]").val();
		const url = this.$("input[name=url]").val();
		const tags = this.$("input[name=tags]").val();

		BookmarkList.create({ title, url, tags });
		return this;
	},
});

const EditModalView = Backbone.View.extend({
	el: "#editModal",
	template: _.template($("#edit-template").html()),
	events: {
		"submit #editBookmarkForm": "updateBookmark",
		"click .close": "closeModal",
	},
	render: function () {
		this.$el.show();
		this.$el.html(this.template(this.model.toJSON()));
		return this;
	},
	updateBookmark: function (e) {
		e.preventDefault();

		const title = this.$("input[name=title]").val();
		const url = this.$("input[name=url]").val();
		const tags = this.$("input[name=tags]").val();

		this.model.save({ title, url, tags }, { wait: true });
		// Close edit modal
		this.closeModal();
	},
	closeModal: function () {
		this.$el.hide();
	},
});

const BookmarkListView = Backbone.View.extend({
	el: "#bookmarks",
	initialize: function () {
		this.collection.fetch();
		this.listenTo(this.collection, "add", this.renderBookmark);
		this.listenTo(this.collection, "reset", this.render);
		this.listenTo(this.collection, "all", this.render);
	},
	render: function () {
		this.$el.empty();
		this.collection.each(this.renderBookmark, this);
		return this;
	},
	renderBookmark: function (bookmark) {
		var bookmarkView = new BookmarkView({ model: bookmark });
		this.$el.append(bookmarkView.render().el);
	},
});

const SearchView = Backbone.View.extend({
	el: "#searchBookmarkForm",
	events: {
		submit: "searchBookmarks",
	},
	searchBookmarks: function (e) {
		e.preventDefault();
		const tag = this.$("input[name=tag]").val();
		this.collection.fetch({ data: { tag } });
	},
});

let page = 1;
const PaginationView = Backbone.View.extend({
	el: "#pagination",
	events: {
		"click .prev": "previous",
		"click .next": "next",
	},
	initialize: function () {
		this.listenTo(this.collection, "all", this.render);
	},
	render: function () {
		this.$(".pg-number").text(page)
		//this.$el.empty();
		//this.$el.html(this.collection.pagination);
		//
		//this.$("a").each((e, obj) => {
		//	obj.addEventListener(onClick, )
		//	console.log(obj);
		//});
	},
	previous: function(e) {
		e.preventDefault();
		if (page == 1) {
			return
		}

		page -= 1;
		this.collection.fetch({ data: { page } });
		this.render();
	},
	next: function(e) {
		e.preventDefault();
		page += 1;
		this.collection.fetch({ data: { page } });
		this.render();
	}
});

var App = {
	initialize: function () {
		this.bookmarkListView = new BookmarkListView({ collection: BookmarkList });
		this.CreateBookmarkView = new CreateBookmarkView();
		this.SearchView = new SearchView({ collection: BookmarkList });
		this.PaginationView = new PaginationView({ collection: BookmarkList });
		//this.searchView = new SearchView({
		//	collection: this.bookmarkListView.collection,
		//});
	},
};

$(document).ready(function () {
	App.initialize();
});
