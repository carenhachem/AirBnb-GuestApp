import './bootstrap';
document.addEventListener('DOMContentLoaded', () => {
    console.log('Accommodation page loaded');

    // Highlight accommodation cards on hover
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.classList.add('shadow-lg');
        });
        card.addEventListener('mouseleave', () => {
            card.classList.remove('shadow-lg');
        });
    });

    // Example: Log filter inputs
    const filterForm = document.querySelector('form');
    filterForm.addEventListener('submit', (e) => {
        console.log('Filters submitted:', {
            min_price: document.getElementById('min_price').value,
            max_price: document.getElementById('max_price').value,
            location: document.getElementById('location').value,
            type: document.getElementById('type').value,
            guest_capacity: document.getElementById('guest_capacity').value,
            amenities: document.getElementById('amenities').value,
        });
    });
});
