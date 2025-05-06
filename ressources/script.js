function toggleMenu() {
    const sidebar = document.querySelector('.sidebar-nav');
    sidebar.classList.toggle('active');

    // Optionnel: empêche le défilement du body quand le menu est ouvert
    document.body.classList.toggle('no-scroll');
}

document.addEventListener('click', function(event) {
    if(window.innerWidth > 768) return;

    const sidebar = document.querySelector('.sidebar-nav');
    const isClickInside = sidebar.contains(event.target);
    const isMenuButton = event.target.closest('.menu-toggle');

    if (!isClickInside && !isMenuButton && sidebar.classList.contains('active')) {
        toggleMenu();
    }
});

// Gestion des messages flash
function displayFlashMessage(message, type) {
    const container = document.getElementById('flash-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `flash-message ${type}`;
    messageDiv.textContent = message;

    container.appendChild(messageDiv);

    setTimeout(() => {
        messageDiv.remove();
    }, 5000);
}

document.querySelectorAll('.category-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        card.style.setProperty('--mouse-x', `${x}px`);
        card.style.setProperty('--mouse-y', `${y}px`);
    });
});

document.querySelector('form').addEventListener('submit', function(e) {
    const input = document.getElementById('artist');
    if(input.value.toLowerCase() !== "<?= strtolower($artiste) ?>") {
        this.classList.add('incorrect-shake');
        setTimeout(() => this.classList.remove('incorrect-shake'), 500);
    }
});
document.querySelectorAll('button').forEach(btn => {
    btn.style.pointerEvents = 'auto';
});
