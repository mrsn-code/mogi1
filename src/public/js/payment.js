document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('payment-select');
    const display = document.getElementById('selected-payment');

    if (!select || !display) return;

    function updatePaymentText() {
        const selectedText = select.options[select.selectedIndex].text;
        display.textContent = select.value === '' ? '未選択' : selectedText;
    }

    updatePaymentText();
    select.addEventListener('change', updatePaymentText);
});