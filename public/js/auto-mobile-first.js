// Auto-aplicar diseño mobile-first a todo el sistema
document.addEventListener('DOMContentLoaded', function() {
    
    // Detectar si ya tiene diseño mobile-first
    if (document.querySelector('.mobile-header') || document.querySelector('x-mobile-header')) {
        return; // Ya tiene diseño mobile-first
    }
    
    // Aplicar mobile-first automáticamente
    applyMobileFirstDesign();
    
    function applyMobileFirstDesign() {
        const mainContent = document.querySelector('.main-content');
        if (!mainContent) return;
        
        // Ocultar elementos legacy en móvil
        if (window.innerWidth <= 768) {
            hideDesktopElements();
            createMobileStructure();
        }
    }
    
    function hideDesktopElements() {
        const elementsToHide = [
            '.section-header',
            '.yp-header',
            '.toolbar',
            '.table-responsive',
            '.cashflow-page header',
            '.cashflow-page .toolbar'
        ];
        
        elementsToHide.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(el => el.style.display = 'none');
        });
    }
    
    function createMobileStructure() {
        const mainContent = document.querySelector('.main-content');
        if (!mainContent) return;
        
        // Crear mobile header
        const mobileHeader = createMobileHeader();
        mainContent.insertBefore(mobileHeader, mainContent.firstChild);
        
        // Crear mobile content wrapper
        const mobileContent = document.createElement('div');
        mobileContent.className = 'mobile-content';
        
        // Mover contenido existente
        const existingContent = Array.from(mainContent.children).slice(1);
        existingContent.forEach(child => {
            if (!child.classList.contains('mobile-header')) {
                mobileContent.appendChild(child);
            }
        });
        
        mainContent.appendChild(mobileContent);
        
        // Convertir tablas a listas mobile
        convertTablesToMobileLists();
        
        // Convertir formularios
        convertFormsToMobile();
        
        // Aplicar estilos mobile
        applyMobileStyles();
    }
    
    function createMobileHeader() {
        const header = document.createElement('div');
        header.className = 'mobile-header';
        
        const title = document.title || 'Sistema';
        
        header.innerHTML = `
            <div class="mobile-header-content">
                <div class="header-info">
                    <h1><i class="fa fa-cog"></i> ${title}</h1>
                </div>
            </div>
        `;
        
        return header;
    }
    
    function convertTablesToMobileLists() {
        const tables = document.querySelectorAll('.table-responsive table');
        
        tables.forEach(table => {
            const listMobile = document.createElement('div');
            listMobile.className = 'list-mobile';
            
            const rows = table.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                if (cells.length === 0) return;
                
                const listItem = document.createElement('div');
                listItem.className = 'list-item';
                
                listItem.innerHTML = `
                    <div class="list-item-header">
                        <div>
                            <h4 class="list-item-title">${cells[0]?.textContent || 'Item'}</h4>
                            <span class="list-item-subtitle">${cells[1]?.textContent || ''}</span>
                        </div>
                    </div>
                    <div class="info-card">
                        ${Array.from(cells).slice(2).map((cell, index) => `
                            <div class="info-row">
                                <span class="label">Campo ${index + 1}:</span>
                                <span class="value">${cell.textContent}</span>
                            </div>
                        `).join('')}
                    </div>
                `;
                
                listMobile.appendChild(listItem);
            });
            
            table.parentElement.parentElement.replaceWith(listMobile);
        });
    }
    
    function convertFormsToMobile() {
        const forms = document.querySelectorAll('form');
        
        forms.forEach(form => {
            // Envolver en card-mobile si no está
            if (!form.closest('.card-mobile')) {
                const cardMobile = document.createElement('div');
                cardMobile.className = 'card-mobile';
                
                form.parentNode.insertBefore(cardMobile, form);
                cardMobile.appendChild(form);
            }
            
            // Convertir botones
            const buttons = form.querySelectorAll('.btn:not(.btn-mobile)');
            buttons.forEach(btn => {
                btn.className = btn.className.replace(/btn-\w+/g, '') + ' btn-mobile primary';
            });
        });
    }
    
    function applyMobileStyles() {
        // Aplicar clases mobile a elementos existentes
        const cards = document.querySelectorAll('.card:not(.card-mobile)');
        cards.forEach(card => {
            card.classList.add('card-mobile');
        });
        
        const badges = document.querySelectorAll('.badge:not(.status-badge)');
        badges.forEach(badge => {
            badge.classList.add('status-badge');
        });
        
        // Crear action-grid para botones
        const buttonGroups = document.querySelectorAll('.btn-group');
        buttonGroups.forEach(group => {
            group.classList.add('action-grid');
            const buttons = group.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.classList.add('btn-mobile');
            });
        });
    }
    
    // Aplicar en resize
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            applyMobileFirstDesign();
        }
    });
});

// Función global para forzar mobile-first
window.forceMobileFirst = function() {
    document.body.classList.add('mobile-applied');
    
    // Aplicar CSS variables globalmente
    const root = document.documentElement;
    root.style.setProperty('--primary-color', '#dc2626');
    root.style.setProperty('--primary-dark', '#991b1b');
    root.style.setProperty('--gray-50', '#f9fafb');
    root.style.setProperty('--gray-100', '#f3f4f6');
    root.style.setProperty('--gray-200', '#e5e7eb');
    root.style.setProperty('--gray-500', '#6b7280');
    root.style.setProperty('--gray-800', '#1f2937');
    root.style.setProperty('--border-radius', '8px');
    root.style.setProperty('--border-radius-lg', '12px');
    root.style.setProperty('--shadow', '0 2px 8px rgba(0,0,0,0.1)');
    root.style.setProperty('--spacing-sm', '8px');
    root.style.setProperty('--spacing-lg', '16px');
    root.style.setProperty('--spacing-xl', '20px');
};

// Auto-ejecutar
window.forceMobileFirst();