document.addEventListener('DOMContentLoaded', function () {
    const display = document.getElementById('display');
    const keys = document.querySelector('.calculator-keys');

    let currentInput = '';
    let previousInput = '';
    let operator = null;
    let resultDisplayed = false;

    function calculate(a, b, op) {
        a = parseFloat(a);
        b = parseFloat(b);
        switch (op) {
            case 'add':
                return a + b;
            case 'subtract':
                return a - b;
            case 'multiply':
                return a * b;
            case 'divide':
                if (b === 0) {
                    alert("Cannot divide by zero");
                    return a;
                }
                return a / b;
            default:
                return b;
        }
    }

    keys.addEventListener('click', function (e) {
        const target = e.target;
        if (!target.classList.contains('key')) return;

        if (target.dataset.digit !== undefined) {
            if (resultDisplayed) {
                currentInput = '';
                resultDisplayed = false;
            }
            if (target.dataset.digit === '.' && currentInput.includes('.')) {
                return;
            }
            currentInput += target.dataset.digit;
            display.value = currentInput;
        } else if (target.dataset.action !== undefined) {
            switch (target.dataset.action) {
                case 'clear':
                    currentInput = '';
                    previousInput = '';
                    operator = null;
                    display.value = '';
                    break;
                case 'backspace':
                    currentInput = currentInput.slice(0, -1);
                    display.value = currentInput;
                    break;
                case 'add':
                case 'subtract':
                case 'multiply':
                case 'divide':
                    if (currentInput === '') return;
                    if (previousInput !== '') {
                        previousInput = calculate(previousInput, currentInput, operator).toString();
                    } else {
                        previousInput = currentInput;
                    }
                    operator = target.dataset.action;
                    currentInput = '';
                    display.value = previousInput;
                    break;
                case 'equals':
                    if (currentInput === '' || operator === null) return;
                    currentInput = calculate(previousInput, currentInput, operator).toString();
                    display.value = currentInput;
                    previousInput = '';
                    operator = null;
                    resultDisplayed = true;
                    break;
            }
        }
    });
});
