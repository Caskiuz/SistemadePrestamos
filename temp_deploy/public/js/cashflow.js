function openDatePicker(inputId) {
    document.getElementById(inputId).focus();
}

function filtrarConcepto() {
    const tipo = document.getElementById('tipo_concepto').value;
    const desde = document.getElementById('fecha_desde').value;
    const hasta = document.getElementById('fecha_hasta').value;
    
    window.location.href = `/reportes/cashflow?desde=${desde}&hasta=${hasta}&tipo=${tipo}`;
}

function imprimirReporte() {
    window.print();
}

function revealMenu() {
    const menu = document.querySelector('.side-menu');
    menu.classList.toggle('visible');
}

function lockScreen() {
    window.location.href = '/lock';
}

// Inicializar datepickers
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="text"][id^="fecha_"]');
    inputs.forEach(input => {
        input.setAttribute('type', 'date');
    });
});
