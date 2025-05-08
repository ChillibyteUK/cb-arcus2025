document.addEventListener('DOMContentLoaded', function () {
	const complianceModal = document.getElementById('complianceModal');
	const usComplianceModal = document.getElementById('usComplianceModal');
	const modalBackdropClass = 'compliance-backdrop';

	// Reusable backdrop handling
	function addBackdropClass() {
		setTimeout(() => {
			document.querySelector('.modal-backdrop')?.classList.add(modalBackdropClass);
		}, 10);
	}
	function removeBackdropClass() {
		document.querySelector('.modal-backdrop')?.classList.remove(modalBackdropClass);
	}

	// Handle main compliance modal
	if (complianceModal) {
		complianceModal.addEventListener('show.bs.modal', addBackdropClass);
		complianceModal.addEventListener('hidden.bs.modal', removeBackdropClass);
	}

	// Handle US modal, session setting and visual effects
	if (usComplianceModal) {
		usComplianceModal.addEventListener('show.bs.modal', addBackdropClass);
		usComplianceModal.addEventListener('hidden.bs.modal', removeBackdropClass);

		const usAcceptButton = document.getElementById('usAcceptButton');
		if (usAcceptButton) {
			usAcceptButton.addEventListener('click', function () {
				fetch(ajax_object.ajax_url, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: new URLSearchParams({
						action: 'set_region_session',
						region_slug: 'rest-of-world'
					})
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						const modalInstance = bootstrap.Modal.getInstance(usComplianceModal);
						if (modalInstance) {
							modalInstance.hide();
						}
						setTimeout(() => {
							window.location.reload();
						}, 300);
					} else {
						alert('Error: ' + data.data.message);
					}
				})
				.catch(error => {
					console.error('AJAX error:', error);
				});
			});
		}
	}

	// Force US modal if URL has ?forceUS=1
	const urlParams = new URLSearchParams(window.location.search);
	if (urlParams.get('forceUS') === '1' && usComplianceModal) {
		const modal = new bootstrap.Modal(usComplianceModal);
		modal.show();
	}
});
