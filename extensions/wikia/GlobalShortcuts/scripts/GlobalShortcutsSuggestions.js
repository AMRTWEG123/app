define('GlobalShortcutsSuggestions',
	['mw', 'wikia.nirvana', 'PageActions', 'GlobalShortcuts', 'GlobalShortcuts.RenderKeys'],
	function (mw, nirvana, PageActions, GlobalShortcuts, RenderKeys) {
		'use strict';

		function GlobalShortcutsSuggestions( $el, closeCb ) {
			this.$el = $el;
			this.closeCb = closeCb;
			this.init();
		}

		GlobalShortcutsSuggestions.prototype.close = function() {
			this.closeCb && this.closeCb();
		};

		GlobalShortcutsSuggestions.prototype.suggestions = function() {
			var ret = [];
			PageActions.sortList(PageActions.all).forEach(function(pageAction){
				var shortcuts = GlobalShortcuts.find(pageAction.id);
				ret.push({
					value: pageAction.caption,
					data: {
						actionId: pageAction.id,
						shortcuts: shortcuts,
						html: RenderKeys.getHtml(shortcuts),
						category: pageAction.category
					}
				});
			});
			return ret;
		};

		GlobalShortcutsSuggestions.prototype.init = function() {
			var autocompleteReEscape = new RegExp('(\\' + ['/', '.', '*', '+', '?', '|', '(', ')',
					'[', ']', '{', '}', '\\'].join('|\\') + ')', 'g');
			this.$el.autocomplete2({
				lookup: this.suggestions(),
				onSelect: function(suggestion) {
					console.log(arguments);
					var actionId = suggestion.data.actionId;
					this.close();
					PageActions.find(actionId).execute();
				}.bind(this),
				onHide: function() {
					//this.close();
				}.bind(this),
				groupBy: 'category',
				appendTo: this.$el.parent().next(),
				maxHeight: 320,
				minChars: 0,
				selectedClass: 'selected',
				width: '100%',
				preserveInput: true,
				formatResult: function(suggestion, currentValue) {
					//console.log(arguments);
					var out = '',
						pattern = '(' + currentValue.replace(autocompleteReEscape, '\\$1') + ')';
					out += '<span class="label-in-suggestions">' +
						suggestion.value.replace(new RegExp(pattern, 'gi'), '<strong>$1<\/strong>') +
						'</span>';
					if (suggestion.data.shortcuts) {
						out += suggestion.data.html;
					}
					//console.log(out);
					return out;
				}.bind(this),
				// BugId:4625 - always send the request even if previous one returned no suggestions
				skipBadQueries: true
			})
			//	.autocomplete2('getSuggestions','')
			;
		};

		return GlobalShortcutsSuggestions;
	}
);
