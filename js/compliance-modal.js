// Helper: get query string parameters
function getQueryParam(key) {
    const params = new URLSearchParams(window.location.search);
    return params.get(key);
}

const forceUS = getQueryParam('forceUS') === '1';

document.addEventListener('DOMContentLoaded', function () {
    fetch('https://ip-api.com/json/')
        .then(res => res.json())
        .then(data => {
            if (data.countryCode === 'US' || forceUS) {
                // US visitor: show US-specific modal and skip default logic
                const usModalElement = document.getElementById('usComplianceModal');
                const usAcceptButton = document.getElementById('usAcceptButton');

                if (!usModalElement || !usAcceptButton) {
                    console.error('US compliance modal elements not found.');
                    return;
                }

                const usModal = new bootstrap.Modal(usModalElement, {
                    backdrop: 'static',
                    keyboard: false
                });
                usModal.show();

                return; // Skip the rest of the default logic
            }

            // === non-US modal logic begins here ===

            const modalElement = document.getElementById('complianceModal');
            const disclaimerText = document.getElementById('disclaimerText');
            const acceptButton = document.getElementById('acceptButton');
            const regionSelect = document.getElementById('regionSelect');
            // const investorCheckbox = document.getElementById('investorCheckbox');
            const btnProfessional = document.getElementById('btnProfessional');
            const btnRetail = document.getElementById('btnRetail');
            const step1 = document.getElementById('step1');
            const step2 = document.getElementById('step2');
            const step3 = document.getElementById('step3');

            if (!modalElement) {
                console.error('Modal element not found.');
                return;
            }

            const modal = new bootstrap.Modal(modalElement, {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();

            // Helper: Show specific step
            const showStep = (stepToShow) => {
                [step1, step2, step3].forEach((step) => {
                    step.classList.add('d-none');
                });
                stepToShow.classList.remove('d-none');
            };

            // Add scroll target to the bottom of disclaimerText
            const scrollTarget = document.createElement('div');
            scrollTarget.setAttribute('id', 'scrollTarget');
            scrollTarget.style.height = '1px'; // Small height, just for detection
            disclaimerText.appendChild(scrollTarget);

            // Intersection Observer for enabling the Accept button
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        acceptButton.disabled = false; // Enable the button when visible
                    } else {
                        acceptButton.disabled = true; // Disable the button otherwise
                    }
                });
            }, {
                root: disclaimerText, // Observe within the disclaimerText container
                threshold: 1.0 // Fully visible in the viewport
            });

            // Observe the scrollTarget
            observer.observe(scrollTarget);

            // Checkbox: Show Step 2 when checked
            // investorCheckbox.addEventListener('change', function () {
            //     if (this.checked) {
            //         showStep(step2); // Show Step 2 (select a region)
            //     } else {
            //         showStep(step1); // Reset to Step 1
            //     }
            // });

            btnProfessional.addEventListener('click', function () {
                showStep(step2); // Proceed to region selection
            });
            
            btnRetail.addEventListener('click', function () {
                showStep(step3); // Skip region, show warning
                disclaimerText.innerHTML = '<p class="h3">Important Information</p><p>This site is not suitable for retail clients. Please seek professional advice.</p>';
                acceptButton.style.display = 'none';
                acceptButton.disabled = true; // Prevent acceptance
            });

            // Dropdown: Fetch disclaimer and show Step 3 (while keeping dropdown visible)
            regionSelect.addEventListener('change', function () {
                const selectedRegionSlug = regionSelect.options[regionSelect.selectedIndex].getAttribute('data-region');
                if (!selectedRegionSlug) {
                    disclaimerText.innerHTML = '<p>Please select a region to view the disclaimer.</p>';
                    return;
                }

                // Fetch disclaimer content
                fetch('/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=fetch_region_disclaimer&region_slug=${encodeURIComponent(selectedRegionSlug)}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            disclaimerText.innerHTML = data.data.disclaimer;

                            // Re-append scroll target after content update
                            disclaimerText.appendChild(scrollTarget);

                            // Transition to Step 3 while keeping the dropdown visible
                            step2.classList.remove('d-none'); // Keep dropdown visible
                            step3.classList.remove('d-none'); // Show disclaimer
                        } else {
                            disclaimerText.innerHTML = `<p>Error: ${data.data.message}</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching disclaimer:', error);
                        disclaimerText.innerHTML = '<p>Failed to load disclaimer. Please try again later.</p>';
                    });
            });

            // Accept button: Set session variable and reload
            acceptButton.addEventListener('click', function () {
                const selectedRegionSlug = regionSelect.options[regionSelect.selectedIndex].getAttribute('data-region');
                if (!selectedRegionSlug) {
                    console.error('No region selected. Cannot set session variable.');
                    return;
                }

                // Set the appropriate region slug - use 'rest-of-world' if user selected USA
                let regionSlugToSet = selectedRegionSlug;

                // Check if the selected country is USA - you can modify this check based on how USA is stored in your regions
                const selectedCountry = regionSelect.options[regionSelect.selectedIndex].text.trim();
                if (selectedCountry === 'United States of America' || selectedRegionSlug === 'usa') {
                    regionSlugToSet = 'rest-of-world';
                }

                // Set session variable via AJAX
                fetch('/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=set_region_session&region_slug=${encodeURIComponent(selectedRegionSlug)}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            modal.hide(); // Hide modal
                            setTimeout(() => {
                                location.reload(); // Reload page
                            }, 300);
                        } else {
                            console.error('Error setting session variable:', data.data.message);
                        }
                    })
                    .catch(error => {
                        console.error('AJAX error:', error);
                    });
            });

        })
        .catch(error => {
            console.error('Error during geolocation check:', error);
            // Optional fallback: show your original modal by default here if needed
            // Handle forceUS even if geolocation fails
            if (forceUS) {
                const usModalElement = document.getElementById('usComplianceModal');
                if (usModalElement) {
                    const usModal = new bootstrap.Modal(usModalElement, {
                        backdrop: 'static',
                        keyboard: false
                    });
                    usModal.show();
                }
            } else {
                // Show regular modal if not forcing US and geolocation failed
                const modalElement = document.getElementById('complianceModal');
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement, {
                        backdrop: 'static',
                        keyboard: false
                    });
                    modal.show();
                }
            }
        });

        const complianceModal = document.getElementById('complianceModal');
        const usComplianceModal = document.getElementById('usComplianceModal');
    
        if (complianceModal) {
            complianceModal.addEventListener('show.bs.modal', function () {
                setTimeout(() => {
                    document.querySelector('.modal-backdrop').classList.add('compliance-backdrop');
                }, 10);
            });
    
            complianceModal.addEventListener('hidden.bs.modal', function () {
                document.querySelector('.modal-backdrop')?.classList.remove('compliance-backdrop');
            });
        }
    
        if (usComplianceModal) {
            usComplianceModal.addEventListener('show.bs.modal', function () {
                setTimeout(() => {
                    document.querySelector('.modal-backdrop')?.classList.add('compliance-backdrop');
                }, 10);
            });
    
            usComplianceModal.addEventListener('hidden.bs.modal', function () {
                document.querySelector('.modal-backdrop')?.classList.remove('compliance-backdrop');
            });
        }
    
        const usAcceptButton = document.getElementById('usAcceptButton');
    
        if (usAcceptButton) {
            usAcceptButton.addEventListener('click', function () {
                fetch('/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=set_region_session&region_slug=rest-of-world'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const usModalInstance = bootstrap.Modal.getInstance(usComplianceModal);
                        usModalInstance.hide();
                        setTimeout(() => {
                            location.reload();
                        }, 300);
                    } else {
                        console.error('Failed to set session:', data.data.message);
                    }
                })
                .catch(error => {
                    console.error('AJAX error:', error);
                });
            });
        }
});
