// Sidebar toggle
const body = document.body;
const sidebar = document.getElementById('sidebar');
const sidebarContent = document.getElementById('sidebar-content');
const sidebarToggle = document.getElementById('sidebar-toggle');
const sidebarOverlay = document.getElementById('sidebar-overlay');

if (sidebar && sidebarToggle && sidebarContent && sidebarOverlay) {
    sidebarToggle.addEventListener('click', () => {
        if (isMobile()) {
            toggleMobileSidebar();
            return;
        }

        sidebar.dataset.state = sidebar.dataset.state === 'expanded' ? 'collapsed' : 'expanded';
        sidebar.dataset.collapsible = sidebar.dataset.state === 'expanded' ? '' : 'icon';

        fetch('/sidebar-toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ state: sidebar.dataset.state })
        });
    });

    sidebarOverlay.addEventListener('click', () => {
        if (isMobile()) {
            toggleMobileSidebar();
        }
    });

    window.addEventListener('resize', () => {
        if (!isMobile()) {
            resetMobileState();
        }
    });
}

function isMobile() {
    return window.matchMedia('(max-width: 767px)').matches;
}

function apply(el, add = [], remove = []) {
    el.classList.add(...add);
    el.classList.remove(...remove);
}

function resetMobileState() {
    apply(body, [], ['overflow-hidden', 'mr-[15px]']);
    apply(sidebar, ['hidden'], ['translate-x-0', '-translate-x-full', 'absolute', 'z-50']);
    apply(sidebarContent, ['hidden', 'p-2']);
    sidebarOverlay.classList.add('hidden');
}

function openMobileSidebar() {
    apply(body, ['overflow-hidden', 'mr-[15px]']);
    apply(sidebar, ['translate-x-0', 'absolute', 'z-50'], ['hidden', '-translate-x-full']);
    apply(sidebarContent, [], ['hidden', 'p-2']);
    sidebarOverlay.classList.remove('hidden');
}

function closeMobileSidebar() {
    resetMobileState();
}

function toggleMobileSidebar() {
    const isClosed = sidebar.classList.contains('hidden') || sidebar.classList.contains('-translate-x-full');
    isClosed ? openMobileSidebar() : closeMobileSidebar();
}


// Profile tabs
document.addEventListener('DOMContentLoaded', function () {
    const tabLinks = document.querySelectorAll('.tab-link');
    const tabContents = document.querySelectorAll('.tab-content');

    if (tabLinks.length === 0 || tabContents.length === 0) return;

    tabLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            const targetTab = this.getAttribute('data-tab');

            tabLinks.forEach(l => l.classList.remove('bg-muted'));
            this.classList.add('bg-muted');

            tabContents.forEach(content => {
                content.classList.add('animate-fade-out');
                setTimeout(() => {
                    content.classList.add('hidden');
                }, 150);
            });

            setTimeout(() => {
                const targetContent = document.getElementById(targetTab);
                targetContent.classList.remove('hidden');
            }, 150);
        });
    });
});


// Flash message
document.addEventListener('DOMContentLoaded', function () {
    const flashMessage = document.querySelector('.flash-message');
    if (flashMessage) {
        const isError = flashMessage.classList.contains('bg-red-100');

        if (!isError) {
            setTimeout(() => {
                hideFlashMessage(flashMessage);
            }, 5000);
        }

        const closeButton = flashMessage.querySelector('.flash-close');
        if (closeButton) {
            closeButton.addEventListener('click', () => {
                hideFlashMessage(flashMessage);
            });
        }
    }

    function hideFlashMessage(element) {
        element.dataset.state = 'hide';
        element.parentElement.addEventListener('animationend', () => {
            element.parentElement.remove();
        });
    }
});