const init = () => {
	const input = document.querySelector('.search-autocomplete');

	if (!input) {
		return;
	}

	const awesomplete = new Awesomplete(input, { tabSelect: true, minChars: 3 });

	awesomplete.replace = function (suggestion) {
		window.location.href = suggestion.value;
	}

	function ajaxResults() {
		const ajax = new XMLHttpRequest();
		ajax.open('POST', global.ajax, true);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send('action=search_site&search=' + encodeURI(input.value));
		ajax.onload = () => {
			if (200 === ajax.status) {
				var json_list = JSON.parse(ajax.responseText);
				awesomplete.list = json_list.data;

				awesomplete.evaluate();
			}
		};

		ajax.send();
	}

	input.addEventListener('keyup', ajaxResults);
};

init();