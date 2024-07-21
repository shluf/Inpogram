const lightModeButton = document.getElementById('lightMode');
const darkModeButton = document.getElementById('darkMode');
const systemModeButton = document.getElementById('systemMode');
const rootElement = document.documentElement;

// Function to apply the theme
function applyTheme(theme) {
    rootElement.classList.remove('light-mode', 'dark-mode');
    if (theme === 'dark') {
        rootElement.classList.add('dark-mode');
    } else if (theme === 'light') {
        rootElement.classList.add('light-mode');
    }
}

// Event listeners for the buttons
lightModeButton.addEventListener('click', () => {
    localStorage.setItem('theme', 'light');
    applyTheme('light');
});

darkModeButton.addEventListener('click', () => {
    localStorage.setItem('theme', 'dark');
    applyTheme('dark');
});

systemModeButton.addEventListener('click', () => {
    localStorage.removeItem('theme');
    applyTheme(systemPrefersDark() ? 'dark' : 'light');
});

// Function to check system preference
function systemPrefersDark() {
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
}

// Apply the saved or system theme on load
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    applyTheme(savedTheme);
} else {
    applyTheme(systemPrefersDark() ? 'dark' : 'light');
}

// Watch for system preference changes
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', event => {
    if (!localStorage.getItem('theme')) {
        applyTheme(event.matches ? 'dark' : 'light');
    }
});