
document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelectorAll('.navbar-burger');
    const menu = document.querySelectorAll('.navbar-menu');
    const close = document.querySelectorAll('.navbar-close');
    const backdrop = document.querySelectorAll('.navbar-backdrop');
    const menuLinks = document.querySelectorAll('ul li a');

    const toggleMenu = () => menu.forEach(m => m.classList.toggle('hidden'));

    if (burger.length && menu.length) {
        burger.forEach(b => b.addEventListener('click', toggleMenu));
    }

    if (close.length) {
        close.forEach(c => c.addEventListener('click', toggleMenu));
    }

    if (backdrop.length) {
        backdrop.forEach(b => b.addEventListener('click', toggleMenu));
    }

    const handleIntersection = (entries) => entries.forEach(entry => {
        const link = document.querySelector(`a[href="#${entry.target.id}"]`);
        if (link) {
            const classes = ['text-gray-400', 'text-black', 'font-bold'];
            if (entry.isIntersecting) {
                link.classList.remove(...classes);
                link.classList.add('text-black', 'font-bold');
                link.style.cssText = 'transition: all 0.3s ease-in-out; transform: translateY(-5px);';
                setTimeout(() => link.style.transform = 'translateY(0)', 300);
            } else {
                link.classList.remove(...classes);
                link.classList.add('text-gray-400');
                link.style.cssText = '';
            }
        }
    });

    const observer = new IntersectionObserver(handleIntersection, { threshold: 0.1 });
    document.querySelectorAll('div[id]').forEach(section => observer.observe(section));
});

