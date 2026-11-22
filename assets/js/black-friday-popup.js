(function () {
	'use strict';

	function startBlackFridayCountdown() {
		var daysElement = document.querySelector('[data-countdown-days]');
		var hoursElement = document.querySelector('[data-countdown-hours]');
		var minutesElement = document.querySelector('[data-countdown-minutes]');
		var secondsElement = document.querySelector('[data-countdown-seconds]');

		if (!daysElement || !hoursElement || !minutesElement || !secondsElement) {
			return;
		}

		var now = new Date();
		var deadline = new Date(now.getFullYear(), 10, 30, 23, 59, 59, 999).getTime();

		function formatCountdownValue(value) {
			return value < 10 ? '0' + value : String(value);
		}

		function updateCountdown() {
			var remainingSeconds = Math.max(0, Math.floor((deadline - Date.now()) / 1000));
			var days = Math.floor(remainingSeconds / 86400);
			var hours = Math.floor((remainingSeconds % 86400) / 3600);
			var minutes = Math.floor((remainingSeconds % 3600) / 60);
			var seconds = remainingSeconds % 60;

			daysElement.textContent = formatCountdownValue(days);
			hoursElement.textContent = formatCountdownValue(hours);
			minutesElement.textContent = formatCountdownValue(minutes);
			secondsElement.textContent = formatCountdownValue(seconds);

			if (remainingSeconds === 0) {
				window.clearInterval(countdownInterval);
			}
		}

		var countdownInterval = window.setInterval(updateCountdown, 1000);
		updateCountdown();
	}

	function showBlackFridayPopup() {
		startBlackFridayCountdown();
		jQuery('#blackFridayModal').modal('show');
	}

	if (document.readyState === 'complete') {
		showBlackFridayPopup();
	} else {
		window.addEventListener('load', showBlackFridayPopup, { once: true });
	}
})();
