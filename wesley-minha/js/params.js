	function getUrlParams() {
		const params = new URLSearchParams(window.location.search);
		let paramsObject = {};
		params.forEach((value, key) => {
			paramsObject[key] = value;
		});
		return paramsObject;
	}

	function appendParamsToLinks() {
		const params = getUrlParams();
		const links = document.querySelectorAll('a');

		links.forEach(link => {
			const url = new URL(link.href);
			Object.keys(params).forEach(key => {
				url.searchParams.set(key, params[key]);
			});
			link.href = url.toString();
		});
	}

	function redirectWithParams(baseUrl) {
		const params = getUrlParams();
		const url = new URL(baseUrl, window.location);

		Object.keys(params).forEach(key => {
			url.searchParams.set(key, params[key]);
		});

		window.location.href = url.toString();
	}

	window.addEventListener('load', appendParamsToLinks);