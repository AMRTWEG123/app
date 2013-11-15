describe('Test matcher', function() {
	'use strict';
	var matcher = modules.SuggestionsMatcher();

	it('is defined', function() {
		expect(matcher).toBeDefined();
	});

	it('checks suggestion match', function() {
		var suggestion = {
			title: '',
			redirects: []
		};
		expect(matcher.matchSuggestion( suggestion, '')).toBeUndefined();
		var suggestion = {
			title: 'asdf',
			redirects: [ 'asd fig', 'asd fih', 'asdfj' ]
		};
		expect(matcher.matchSuggestion( suggestion, 'asd')).toEqual(
			{ prefix : '', match : 'asd', suffix : 'f', type : 'title' }
		);
		expect(matcher.matchSuggestion( suggestion, 'fig')).toEqual(
			{ prefix : 'asd ', match : 'fig', suffix : '', type : 'redirect' }
		);
	});

	it('checks matching logic', function() {
		var test;
		expect(matcher.match(test, '')).toBeNull();
		test = '';
		expect(matcher.match(test, '')).toBeNull();
		test = 'abcd';
		expect(matcher.match(test, 'a')).toEqual( { prefix: '', match: 'a', suffix: 'bcd' } );
		expect(matcher.match(test, 'd')).toBeNull();
		test = 'a:b:c:d:e';
		expect(matcher.match(test, 'b')).toEqual( { prefix: 'a:', match: 'b', suffix: ':c:d:e' } );
		expect(matcher.match(test, 'bc')).toBeNull();
		test = 'the a-test';
		expect(matcher.match(test, 'a:')).toEqual( { prefix: 'the ', match: 'a', suffix: '-test' } );
		test = 'Map Pack';
		expect(matcher.match(test, 'map:')).toEqual( { prefix: '', match: 'Map', suffix: ' Pack' } );
		test = 'Maps';
		expect(matcher.match(test, 'map:')).toEqual( { prefix: '', match: 'Map', suffix: 's' } );
		expect(matcher.match(test, 'map: ')).toEqual( { prefix: '', match: 'Map', suffix: 's' } );
		expect(matcher.match(test, 'maps:')).toEqual( { prefix: '', match: 'Maps', suffix: '' } );
		expect(matcher.match(test, 'maps: ')).toEqual( { prefix: '', match: 'Maps', suffix: '' } );
		expect(matcher.match(test, ':maps ')).toEqual( { prefix: '', match: 'Maps', suffix: '' } );
		test = 'Map';
		expect(matcher.match(test, 'maps')).toBeNull();
	});

});
