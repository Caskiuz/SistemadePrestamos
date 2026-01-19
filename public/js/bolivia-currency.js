// Bolivia Currency JavaScript - Reemplazar símbolos $ por Bs
document.addEventListener('DOMContentLoaded', function() {
    
    // Función para reemplazar texto en elementos
    function replaceTextInElement(element, searchText, replaceText) {
        if (element.nodeType === Node.TEXT_NODE) {
            if (element.textContent.includes(searchText)) {
                element.textContent = element.textContent.replace(new RegExp(searchText, 'g'), replaceText);
            }
        } else {
            for (let child of element.childNodes) {
                replaceTextInElement(child, searchText, replaceText);
            }
        }
    }
    
    // Función para reemplazar en atributos específicos
    function replaceInAttributes(element, searchText, replaceText) {
        // Reemplazar en placeholders
        if (element.placeholder && element.placeholder.includes(searchText)) {
            element.placeholder = element.placeholder.replace(new RegExp(searchText, 'g'), replaceText);
        }
        
        // Reemplazar en títulos
        if (element.title && element.title.includes(searchText)) {
            element.title = element.title.replace(new RegExp(searchText, 'g'), replaceText);
        }
        
        // Reemplazar en data attributes
        if (element.dataset) {
            Object.keys(element.dataset).forEach(key => {
                if (element.dataset[key] && element.dataset[key].includes(searchText)) {
                    element.dataset[key] = element.dataset[key].replace(new RegExp(searchText, 'g'), replaceText);
                }
            });
        }
    }
    
    // Selectores específicos para reemplazar
    const selectorsToReplace = [
        'label',
        'th',
        'td',
        '.form-text',
        '.help-text',
        '.small',
        '.text-muted',
        'span',
        'p',
        'div',
        'button',
        'input[placeholder*="$"]',
        'input[title*="$"]'
    ];
    
    // Reemplazar en elementos específicos
    selectorsToReplace.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(element => {
            // Reemplazar texto
            replaceTextInElement(element, '\\$', 'Bs');
            
            // Reemplazar atributos
            replaceInAttributes(element, '\\$', 'Bs');
        });
    });
    
    // Reemplazos específicos para formularios de configuración
    const configLabels = document.querySelectorAll('.form-group label');
    configLabels.forEach(label => {
        if (label.textContent.includes('($)')) {
            label.textContent = label.textContent.replace(/\(\$\)/g, '(Bs)');
        }
        if (label.textContent.includes('Monto') && label.textContent.includes('$')) {
            label.textContent = label.textContent.replace(/\$/g, 'Bs');
        }
    });
    
    // Reemplazos específicos para tablas
    const tableCells = document.querySelectorAll('th, td');
    tableCells.forEach(cell => {
        if (cell.textContent.includes('$') && !cell.querySelector('input, select, textarea')) {
            replaceTextInElement(cell, '\\$', 'Bs');
        }
    });
    
    // Reemplazos para elementos con clases específicas
    const currencyElements = document.querySelectorAll('.currency, .price, .amount, .monto, .precio, .total');
    currencyElements.forEach(element => {
        replaceTextInElement(element, '\\$', 'Bs');
    });
    
    // Observer para elementos dinámicos
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            mutation.addedNodes.forEach(function(node) {
                if (node.nodeType === Node.ELEMENT_NODE) {
                    // Reemplazar en el nuevo elemento
                    replaceTextInElement(node, '\\$', 'Bs');
                    replaceInAttributes(node, '\\$', 'Bs');
                    
                    // Reemplazar en elementos hijos
                    const childElements = node.querySelectorAll('*');
                    childElements.forEach(child => {
                        replaceTextInElement(child, '\\$', 'Bs');
                        replaceInAttributes(child, '\\$', 'Bs');
                    });
                }
            });
        });
    });
    
    // Observar cambios en el DOM
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    // Función específica para SweetAlert y modales
    function replaceCurrencyInModals() {
        // SweetAlert
        const swalElements = document.querySelectorAll('.swal2-container *');
        swalElements.forEach(element => {
            replaceTextInElement(element, '\\$', 'Bs');
        });
        
        // Bootstrap modals
        const modalElements = document.querySelectorAll('.modal *');
        modalElements.forEach(element => {
            replaceTextInElement(element, '\\$', 'Bs');
        });
    }
    
    // Ejecutar reemplazos en modales cuando se abran
    document.addEventListener('shown.bs.modal', replaceCurrencyInModals);
    
    // Para SweetAlert (si se usa)
    if (typeof Swal !== 'undefined') {
        const originalFire = Swal.fire;
        Swal.fire = function(...args) {
            const result = originalFire.apply(this, args);
            setTimeout(replaceCurrencyInModals, 100);
            return result;
        };
    }
    
    // Reemplazos específicos para DataTables
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $(document).on('draw.dt', function() {
            setTimeout(() => {
                const tableElements = document.querySelectorAll('.dataTables_wrapper *');
                tableElements.forEach(element => {
                    replaceTextInElement(element, '\\$', 'Bs');
                });
            }, 100);
        });
    }
    
    // Función para reemplazar en elementos específicos por ID o clase
    function replaceInSpecificElements() {
        // Configuración de préstamos
        const prestamoLabels = document.querySelectorAll('#modalNuevoPrestamo label, .prestamo-config label');
        prestamoLabels.forEach(label => {
            if (label.textContent.includes('$')) {
                label.textContent = label.textContent.replace(/\$/g, 'Bs');
            }
        });
        
        // Reportes
        const reporteElements = document.querySelectorAll('.reporte-monto, .cashflow-amount, .total-amount');
        reporteElements.forEach(element => {
            replaceTextInElement(element, '\\$', 'Bs');
        });
        
        // Inventario
        const inventarioElements = document.querySelectorAll('.precio-venta, .precio-compra, .valuacion');
        inventarioElements.forEach(element => {
            replaceTextInElement(element, '\\$', 'Bs');
        });
    }
    
    // Ejecutar reemplazos específicos
    replaceInSpecificElements();
    
    // Ejecutar cada 2 segundos para capturar contenido dinámico
    setInterval(() => {
        replaceInSpecificElements();
        replaceCurrencyInModals();
    }, 2000);
    
    console.log('Bolivia Currency Replacer initialized');
});

// Función global para reemplazar manualmente
window.replaceDollarToBs = function(element = document.body) {
    function replaceTextInElement(element, searchText, replaceText) {
        if (element.nodeType === Node.TEXT_NODE) {
            if (element.textContent.includes(searchText)) {
                element.textContent = element.textContent.replace(new RegExp(searchText, 'g'), replaceText);
            }
        } else {
            for (let child of element.childNodes) {
                replaceTextInElement(child, searchText, replaceText);
            }
        }
    }
    
    replaceTextInElement(element, '\\$', 'Bs');
};