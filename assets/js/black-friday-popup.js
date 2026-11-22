(function () {
	'use strict';

	function showBlackFridayPopup() {
		jQuery('#blackFridayModal').modal('show');
	}

	if (document.readyState === 'complete') {
		showBlackFridayPopup();
	} else {
		window.addEventListener('load', showBlackFridayPopup, { once: true });
	}
})();
