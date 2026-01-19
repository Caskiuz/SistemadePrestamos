function openDatePicker(inputId) {
    document.getElementById(inputId).focus();
}

function filtrarConcepto() {
    actualizarCashFlow();
}

function actualizarCashFlow() {
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

// Inicializar datepickers y eventos
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="text"][id^="fecha_"]');
    inputs.forEach(input => {
        input.setAttribute('type', 'date');
        
        // Actualizar automáticamente cuando cambie la fecha
        input.addEventListener('change', function() {
            setTimeout(actualizarCashFlow, 500); // Delay para evitar múltiples llamadas
        });
    });
    
    // Actualizar automáticamente cuando cambie el tipo
    const tipoSelect = document.getElementById('tipo_concepto');
    if (tipoSelect) {
        tipoSelect.addEventListener('change', actualizarCashFlow);
    }
});
