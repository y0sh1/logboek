var Cypher = function() {
	var alphabet = 'abcdefghijklmnopqrstuvwxyz'.split(''),
	    upperAlphabet = alphabet.map(function(letter) {
		    return letter.toUpperCase();
	    });

	var detectable_words = {
		'Cg': 'Is',
		'Aq.': 'Gr.',
		'CbV': 'Ben',

		'Ykvo': 'Hebt',
		'Aklwb': 'Geluk',

		'oiq': 'hoi',
		'yzllt': 'hallo',
		'stllkazg': 'collegas',
		'Pkqbklchb': 'Werkelijk',
		'Jkqqwbo': 'Verrukt',

		'bqzggkq': 'krasser',
		'Ebxkkrb': 'Krasser',
		'Hweeqtwphzuuck': 'Juffrouwjannie',
		'Uckwpg': 'Nieuws',
		'Yckqvch': 'Hierbij',

		'Ytwiku': 'Houden',
		'Zlnyku': 'Alphen',

		'Pzsyoku': 'Wachten',
		'Ikxkgxzkbkq': 'Demesmaeker',
		'Aqtko': 'Groet',
		'Xzokqczzl': 'Materiaal'
	};

	var map = window.map = { };

	function addToMap(letters) {
		letters.map(function(letter) {
			if(!map.hasOwnProperty(letter))
			map[letter] = letter;
		});
	};

	addToMap(alphabet);

	var form = document.getElementById('cipher-form'),
	    inputs = form.querySelector('.inputs'),
	    sourceText = form.querySelector('textarea[name=source]'),
	    targetText = form.querySelector('textarea[name=target]');

	var action = function(event) {
		var target = event.target;

		if(target.type == 'text') {
			map[target.name] = target.value;
		}
		decode();
	};

	form.addEventListener('keyup', action, true);
	form.addEventListener('change', action, true);
	form.addEventListener('submit', function(event) {
		event.preventDefault();
		decode();
	}, true);

	var addInput = function(letter) {
		var div = document.createElement('div');
		var input = document.createElement('input'),
		    label = document.createElement('label');

		label.innerHTML = letter;

		var targetLetter;
		if(map.hasOwnProperty(letter))
			targetLetter = map[letter];
		else
			targetLetter = letter;

		input.setAttribute('type', 'text');
		input.setAttribute('name', letter);
		input.setAttribute('placeholder', letter);
		input.value = targetLetter;

		div.appendChild(label);
		div.appendChild(input);
		inputs.appendChild(div);
	};

	this.init = function() {
		alphabet.map(addInput);

		document.getElementById('load-button')
			.addEventListener('click', function() {
				try {
					var data = JSON.parse(prompt('Plak je JSON hier'));
				} catch(e) {
					alert('JSON laden is mislukt.');
				}
				if(data) load(data);
			}, true);

		this.decode();

		document.getElementById('dump-button')
			.addEventListener('click', function() {
				console.log(JSON.stringify(map, undefined, 1));
			});

		document.getElementById('learn-button')
			.addEventListener('click', function() {
				detect();
			});

		document.getElementById('prettify-button')
			.addEventListener('click', function() {
				sourceText.value = prettify(sourceText.value);
			});
	}

	var load = this.load = function(data) {
		map = data;
		decode();
	};

	function learnWord(source, target) {
		source.split('').map(function(from_letter, index) {
			var to_letter = target[index];
			if(from_letter == to_letter) return;
			map[from_letter.toLowerCase()] = to_letter.toLowerCase();
		});
	}

	window.learn = learnWord;

	function detect() {
		var source = sourceText.value;
		for(var source_word in detectable_words) {
			if(source.indexOf(source_word) != -1)
				learnWord(source_word, detectable_words[source_word]);
		}
		decode();
	}

	function prettify(str) {
		return str.split('')
			.map(function(letter) {
				if(letter == ',' || letter == '.')
				return letter + ' ';
				else if(letter === letter.toUpperCase())
				return ' ' + letter;
				else
				return letter;
			}).join('').replace('  ', ' ').replace('  ', ' ').replace('  ', ' '); // Fixme
	}

	var decode = this.decode = function() {
		var source = sourceText.value.split(''), result;
		if(source.length == 0)
			return;

		result = source.map(function(letter) {
			var lowerLetter = letter.toLowerCase();
			if(map.hasOwnProperty(letter)) {
				return map[letter];
			} else if(map.hasOwnProperty(lowerLetter)) {
				return map[lowerLetter].toUpperCase();
			}
			return letter;
		}).join('');

		targetText.value = result;
	};
};

document.addEventListener("DOMContentLoaded", function() {
	new Cypher().init();
}, true);
