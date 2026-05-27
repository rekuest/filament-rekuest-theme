// Neutralize the native value-stepping behavior on <input type="number">.
// CSS can hide the spinner buttons but cannot disable:
//   - mouse wheel changing the value while focused
//   - ArrowUp / ArrowDown keys changing the value while focused
// Both are handled here via delegated listeners on the document.

const isNumberInput = (element) =>
    element instanceof HTMLInputElement && element.type === 'number';

// Block wheel-to-step. The browser only steps when the input is focused, so
// blurring it on wheel is the simplest neutralizer that still allows the
// surrounding page to scroll normally.
document.addEventListener(
    'wheel',
    (event) => {
        const active = document.activeElement;

        if (isNumberInput(active) && active === event.target) {
            active.blur();
        }
    },
    { passive: true },
);

// Block ArrowUp / ArrowDown stepping while keeping every other key behavior
// (typing digits, Tab, navigation between fields, etc.) untouched.
document.addEventListener('keydown', (event) => {
    if (event.key !== 'ArrowUp' && event.key !== 'ArrowDown') {
        return;
    }

    if (isNumberInput(event.target)) {
        event.preventDefault();
    }
});
