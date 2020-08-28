// prism.js
require('./vendor/prism.js');
$(document).ready(function() {
	if (window.algolia) {
		require('./search.js');
	}
});
