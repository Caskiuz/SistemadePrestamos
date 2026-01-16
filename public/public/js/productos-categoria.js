// Función global para botones móviles
window.toggleRow = function(button) {
    const row = button.closest('tr');
    const icon = button.querySelector('i');
    
    row.classList.toggle('expanded');
    
    if (row.classList.contains('expanded')) {
        icon.classList.remove('fa-plus');
        icon.classList.add('fa-minus');
    } else {
        icon.classList.remove('fa-minus');
        icon.classList.add('fa-plus');
    }
};

// Función para previsualizar imagen en edición
window.previewEditImage = function(input) {
    const newPreviewContainer = document.getElementById('newImagePreviewContainer');
    const newPreviewImg = document.getElementById('newImagePreviewImg');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validar tamaño (12MB = 12 * 1024 * 1024 bytes)
        const maxSize = 12 * 1024 * 1024;
        if (file.size > maxSize) {
            Swal.fire({
                icon: 'error',
                title: 'Archivo muy grande',
                text: 'La imagen no debe superar los 12MB',
                confirmButtonColor: '#d33'
            });
            input.value = ''; // Limpiar input
            newPreviewContainer.style.display = 'none';
            return;
        }
        
        // Validar tipo de archivo
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            Swal.fire({
                icon: 'error',
                title: 'Formato no válido',
                text: 'Solo se permiten archivos JPG, JPEG o PNG',
                confirmButtonColor: '#d33'
            });
            input.value = ''; // Limpiar input
            newPreviewContainer.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            newPreviewImg.src = e.target.result;
            newPreviewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        newPreviewContainer.style.display = 'none';
    }
};

// Función para limpiar imagen seleccionada en edición
window.clearEditImage = function() {
    const input = document.getElementById('editarImagen');
    const newPreviewContainer = document.getElementById('newImagePreviewContainer');
    
    input.value = '';
    newPreviewContainer.style.display = 'none';
};

// Función para cargar imagen actual al abrir el modal
window.loadCurrentProductImage = function(imageUrl, productName) {
    const currentImageContainer = document.getElementById('currentImagePreview');
    const currentImageContainerDiv = document.getElementById('currentImageContainer');
    
    if (imageUrl && imageUrl.trim() !== '') {
        currentImageContainer.innerHTML = `
            <img src="${imageUrl}" alt="${productName}" 
                 class="img-thumbnail" style="max-width: 150px; max-height: 150px; object-fit: cover;">
            <div class="mt-1">
                <small class="text-muted">${imageUrl.split('/').pop()}</small>
            </div>
        `;
        if (currentImageContainerDiv) {
            currentImageContainerDiv.style.display = 'block';
        }
    } else {
        currentImageContainer.innerHTML = `
            <div class="text-center py-3">
                <i class="fas fa-image fa-2x text-muted"></i>
                <div class="small text-muted mt-1">Sin imagen</div>
            </div>
        `;
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Variables para almacenar filtros activos
    let activeFilters = {
        search: '',
        stock: 'all',
        price: 'all',
        status: 'all'
    };

    // Variables de paginación
    let currentPage = 1;
    let itemsPerPage = 10;
    let totalItems = 0;
    let filteredItems = 0;

    // Elementos del DOM
    const quickSearch = document.getElementById('quickSearch');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const filterBadges = document.querySelectorAll('.filter-badge');
    const productRows = document.querySelectorAll('.product-row');
    const resultsCount = document.querySelector('.results-count');

    // Elementos de paginación
    const perPageSelect = document.getElementById('perPageSelect');
    const paginationInfo = document.getElementById('paginationInfo');
    const pageNumbersContainer = document.getElementById('pageNumbers');
    const firstPageBtn = document.getElementById('firstPage');
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const lastPageBtn = document.getElementById('lastPage');

    // Leer datos de la aplicación
    const appData = document.getElementById('app-data');
    const productoEditandoId = appData ? appData.dataset.productoEditandoId : '';
    const hasEditErrors = appData && appData.dataset.hasEditErrors === 'true';
    const hasAnyErrors = appData && appData.dataset.hasAnyErrors === 'true';

    // Modal de editar producto
    let modalEditar, modalNuevo;
    if (document.getElementById('modalEditarProducto')) {
        modalEditar = new bootstrap.Modal(document.getElementById('modalEditarProducto'));
    }
    if (document.getElementById('modalNuevoProducto')) {
        modalNuevo = new bootstrap.Modal(document.getElementById('modalNuevoProducto'));
    }

    // Función para aplicar todos los filtros
    function applyFilters() {
        let visibleCount = 0;
        let visibleRows = [];

        productRows.forEach(row => {
            let showRow = true;

            // 1. Filtro de búsqueda (nombre, código, proveedor)
            if (activeFilters.search) {
                const searchTerm = activeFilters.search.toLowerCase();
                const nombre = row.dataset.nombre;
                const codigo = row.dataset.codigo;
                const proveedor = row.dataset.proveedor;

                if (!nombre.includes(searchTerm) &&
                    !codigo.includes(searchTerm) &&
                    !proveedor.includes(searchTerm)) {
                    showRow = false;
                }
            }

            // 2. Filtro por stock
            if (showRow && activeFilters.stock !== 'all') {
                const stock = parseInt(row.dataset.stock);
                const stockMinimo = parseInt(row.dataset.stockMinimo);

                switch (activeFilters.stock) {
                    case 'low':
                        if (stock >= 20) showRow = false;
                        break;
                    case 'normal':
                        if (stock <= stockMinimo) showRow = false;
                        break;
                    case 'zero':
                        if (stock > 0) showRow = false;
                        break;
                }
            }

            // 3. Filtro por precio
            if (showRow && activeFilters.price !== 'all') {
                const precio = parseFloat(row.dataset.precio);

                switch (activeFilters.price) {
                    case 'low':
                        if (precio >= 100) showRow = false;
                        break;
                    case 'medium':
                        if (precio < 100 || precio > 500) showRow = false;
                        break;
                    case 'high':
                        if (precio <= 500) showRow = false;
                        break;
                }
            }

            // 4. Filtro por estado
            if (showRow && activeFilters.status !== 'all') {
                const estado = row.dataset.estado;
                const expectedEstado = activeFilters.status === 'active' ? '1' : '0';

                if (estado !== expectedEstado) showRow = false;
            }

            // Mostrar/ocultar fila
            if (showRow) {
                row.classList.remove('hidden-row');
                visibleRows.push(row);
                visibleCount++;
            } else {
                row.classList.add('hidden-row');
            }
        });

        totalItems = productRows.length;
        filteredItems = visibleCount;
        updatePagination(visibleRows);

        // Actualizar contador
        updateResultsCount(visibleCount);

        // Mostrar/ocultar botón de limpiar filtros
        if (hasActiveFilters()) {
            clearFiltersBtn.classList.remove('d-none');
        } else {
            clearFiltersBtn.classList.add('d-none');
        }
    }

    // Función para actualizar paginación
    function updatePagination(visibleRows) {
        // Si "Todos" está seleccionado, mostrar todo sin paginación
        if (itemsPerPage === 'all') {
            visibleRows.forEach((row, index) => {
                row.style.display = '';
            });

            updatePaginationInfo(1, filteredItems, filteredItems);
            renderPageNumbers(1, 1);
            return;
        }

        const perPage = parseInt(itemsPerPage);
        const totalPages = Math.ceil(filteredItems / perPage);

        // Asegurar que currentPage sea válido
        if (currentPage > totalPages) {
            currentPage = totalPages || 1;
        }

        // Calcular índices de inicio y fin
        const startIndex = (currentPage - 1) * perPage;
        const endIndex = Math.min(startIndex + perPage, filteredItems);

        // Mostrar/ocultar filas según la página actual
        visibleRows.forEach((row, index) => {
            if (index >= startIndex && index < endIndex) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Actualizar información de paginación
        updatePaginationInfo(startIndex + 1, endIndex, filteredItems);

        // Renderizar números de página
        renderPageNumbers(currentPage, totalPages);

        // Actualizar estado de botones de navegación
        updateNavigationButtons(currentPage, totalPages);
    }

    // Función para actualizar información de paginación
    function updatePaginationInfo(start, end, total) {
        if (paginationInfo) {
            document.getElementById('startItem').textContent = start;
            document.getElementById('endItem').textContent = end;
            document.getElementById('totalItems').textContent = total;
        }
    }

    // Función para renderizar números de página
    function renderPageNumbers(currentPage, totalPages) {
        if (!pageNumbersContainer) return;
        
        pageNumbersContainer.innerHTML = '';

        if (totalPages <= 1) {
            // Solo una página
            const pageBtn = createPageButton(1, currentPage === 1);
            pageNumbersContainer.appendChild(pageBtn);
            return;
        }

        // Determinar qué números de página mostrar
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, currentPage + 2);

        // Ajustar para mostrar siempre 5 páginas si es posible
        if (endPage - startPage < 4) {
            if (startPage === 1) {
                endPage = Math.min(totalPages, startPage + 4);
            } else if (endPage === totalPages) {
                startPage = Math.max(1, endPage - 4);
            }
        }

        // Botón para primera página si no está visible
        if (startPage > 1) {
            const firstBtn = createPageButton(1, currentPage === 1);
            pageNumbersContainer.appendChild(firstBtn);

            if (startPage > 2) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'page-btn disabled';
                ellipsis.textContent = '...';
                ellipsis.style.cursor = 'default';
                pageNumbersContainer.appendChild(ellipsis);
            }
        }

        // Botones de páginas numeradas
        for (let i = startPage; i <= endPage; i++) {
            const pageBtn = createPageButton(i, i === currentPage);
            pageNumbersContainer.appendChild(pageBtn);
        }

        // Botón para última página si no está visible
        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'page-btn disabled';
                ellipsis.textContent = '...';
                ellipsis.style.cursor = 'default';
                pageNumbersContainer.appendChild(ellipsis);
            }

            const lastBtn = createPageButton(totalPages, currentPage === totalPages);
            pageNumbersContainer.appendChild(lastBtn);
        }
    }

    // Función para crear un botón de página
    function createPageButton(pageNumber, isActive) {
        const button = document.createElement('button');
        button.className = `page-btn ${isActive ? 'active' : ''}`;
        button.textContent = pageNumber;
        button.dataset.page = pageNumber;

        button.addEventListener('click', function() {
            if (!this.classList.contains('active')) {
                currentPage = parseInt(this.dataset.page);
                applyFilters();
            }
        });

        return button;
    }

    // Función para actualizar botones de navegación
    function updateNavigationButtons(currentPage, totalPages) {
        if (!firstPageBtn || !prevPageBtn || !nextPageBtn || !lastPageBtn) return;
        
        const isFirstPage = currentPage === 1;
        const isLastPage = currentPage === totalPages || totalPages === 0;

        firstPageBtn.classList.toggle('disabled', isFirstPage);
        prevPageBtn.classList.toggle('disabled', isFirstPage);
        nextPageBtn.classList.toggle('disabled', isLastPage);
        lastPageBtn.classList.toggle('disabled', isLastPage);

        // Habilitar/deshabilitar eventos
        if (!isFirstPage) {
            firstPageBtn.onclick = () => {
                currentPage = 1;
                applyFilters();
            };
            prevPageBtn.onclick = () => {
                currentPage--;
                applyFilters();
            };
        } else {
            firstPageBtn.onclick = null;
            prevPageBtn.onclick = null;
        }

        if (!isLastPage) {
            nextPageBtn.onclick = () => {
                currentPage++;
                applyFilters();
            };
            lastPageBtn.onclick = () => {
                currentPage = totalPages;
                applyFilters();
            };
        } else {
            nextPageBtn.onclick = null;
            lastPageBtn.onclick = null;
        }
    }

    // Función para actualizar contador de resultados
    function updateResultsCount(count) {
        if (resultsCount) {
            resultsCount.textContent = `(${count} productos encontrados)`;
        }
    }

    // Función para verificar si hay filtros activos
    function hasActiveFilters() {
        return activeFilters.search !== '' ||
               activeFilters.stock !== 'all' ||
               activeFilters.price !== 'all' ||
               activeFilters.status !== 'all';
    }

    // Función para limpiar todos los filtros
    function clearAllFilters() {
        activeFilters = {
            search: '',
            stock: 'all',
            price: 'all',
            status: 'all'
        };

        if (quickSearch) quickSearch.value = '';
        currentPage = 1;

        // Resetear badges a estado inicial
        filterBadges.forEach(badge => {
            if (badge.dataset.value === 'all') {
                badge.classList.add('active-filter');
            } else {
                badge.classList.remove('active-filter');
            }
        });

        // Resetear selector de items por página
        if (perPageSelect) {
            perPageSelect.value = '10';
            itemsPerPage = 10;
        }

        applyFilters();
    }

    // Event Listeners

    // Búsqueda en tiempo real
    if (quickSearch) {
        quickSearch.addEventListener('input', function() {
            activeFilters.search = this.value.trim().toLowerCase();
            currentPage = 1; // Volver a primera página al buscar
            applyFilters();
        });
    }

    // Filtros por badges
    filterBadges.forEach(badge => {
        badge.addEventListener('click', function() {
            const filterType = this.dataset.filter;
            const filterValue = this.dataset.value;

            // Remover clase activa de todos los badges del mismo tipo
            document.querySelectorAll(`[data-filter="${filterType}"]`).forEach(b => {
                b.classList.remove('active-filter');
            });

            // Agregar clase activa al badge clickeado
            this.classList.add('active-filter');

            // Actualizar filtro activo
            activeFilters[filterType] = filterValue;
            currentPage = 1; // Volver a primera página al filtrar

            applyFilters();
        });
    });

    // Selector de items por página
    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            itemsPerPage = this.value;
            currentPage = 1; // Volver a primera página al cambiar items por página
            applyFilters();
        });
    }

    // Botón limpiar filtros
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', clearAllFilters);
    }

    // Inicializar badges activos
    document.querySelectorAll('[data-value="all"]').forEach(badge => {
        badge.classList.add('active-filter');
    });

    // Función para mostrar imagen ampliada
    const imagenes = document.querySelectorAll('img[data-bs-toggle="modal"]');
    imagenes.forEach(img => {
        img.addEventListener('click', function() {
            document.getElementById('imagenAmpliada').src = this.src;
        });
    });

    // Modal de editar producto con manejo de imagen
    document.querySelectorAll('.btn-editar-producto').forEach(button => {
        button.addEventListener('click', function() {
            const producto = this.dataset;
            const imagenUrl = this.getAttribute('data-imagen') || '';

            document.getElementById('editarIdProducto').value = producto.id;
            document.getElementById('editarNombre').value = producto.nombre;
            document.getElementById('editarCodigo').value = producto.codigo;
            document.getElementById('editarDescripcion').value = producto.descripcion;
            document.getElementById('editarProveedor').value = producto.proveedor;
            document.getElementById('editarPrecioCompra').value = producto.precioCompra;
            document.getElementById('editarPrecioVenta').value = producto.precioVenta;
            document.getElementById('editarStock').value = producto.stock;
            document.getElementById('editarStockMinimo').value = producto.stockMinimo;

            document.getElementById('formEditarProducto').action = `/producto/${producto.id}`;
            
            // Cargar imagen actual
            window.loadCurrentProductImage(imagenUrl, producto.nombre);
            
            // Limpiar previsualización de nueva imagen
            window.clearEditImage();

            if (modalEditar) modalEditar.show();
        });
    });

    // --- Abrir modal automáticamente si hubo error en edición ---
    if (hasEditErrors || productoEditandoId) {
        const boton = document.querySelector(`.btn-editar-producto[data-id="${productoEditandoId}"]`);
        if (boton) boton.click();
        else if (modalEditar) modalEditar.show();
    }

    // --- Abrir modal nuevo producto si hay errores de registro ---
    if (hasAnyErrors && !hasEditErrors && modalNuevo) {
        modalNuevo.show();
    }

    // Inicializar
    applyFilters();
});