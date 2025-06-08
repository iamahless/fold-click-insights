const screenHeight = window.innerHeight;
const screenWidth = window.innerWidth;

document.addEventListener('DOMContentLoaded', function () {
	const getVisibleLinks = () => {
		const links = Array.from(document.querySelectorAll('a'));
		const visibleLinks = links.filter(link => {
			if (link.closest('#wpadminbar')) return false;

			const rect = link.getBoundingClientRect();
			return (
				rect.top >= 0 &&
				rect.left >= 0 &&
				rect.bottom <= (screenHeight || document.documentElement.clientHeight) &&
				rect.right <= (screenWidth || document.documentElement.clientWidth)
			);
		});
		const normalize = href => href.replace(/#$/, '');
		const uniqueLinks = Array.from(
			new Set(visibleLinks.map(link => normalize(link.href)))
		);
		return uniqueLinks;
	};

	const sendData = () => {
		fetch(fci_data.rest_url, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': fci_data.nonce,
			},
			body: JSON.stringify({
				screenWidth: screenWidth,
				screenHeight: screenHeight,
				visibleLinks: getVisibleLinks(),
			}),
		})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					console.log('FoldClick Insights: Data sent successfully.');
				} else {
					console.error('FoldClick Insights: Error sending data.');
				}
			})
			.catch((error) => {
				console.error('FoldClick Insights: Network error.', error);
			});
	};

	// const sendData = () => {
	// 	fetch(fci_data.rest_url, {
	// 		method: 'POST',
	// 		headers: {
	// 			'Content-Type': 'application/json',
	// 			'X-WP-Nonce': fci_data.nonce,
	// 		},
	// 		body: JSON.stringify({
	// 			screenWidth: screenWidth,
	// 			screenHeight: screenHeight,
	// 			visible_links: getVisibleLinks(),
	// 		})
	// 			.then(response => response.json())
	// 			.then(data => {
	// 				if (data.success) {
	// 					console.log('Data sent successfully:',);
	// 				} else {
	// 					console.log('Error sending data:');
	// 				}
	// 			}).catch((error) => {
	// 				console.log('FoldClick Insights: Network error.', error);
	// 			})
	// 	});
	// };

	if (getVisibleLinks().length > 0) {
		sendData();
	}
});