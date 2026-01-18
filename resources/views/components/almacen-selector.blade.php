<!-- Selector de Almacenes -->
<div class="almacen-selector-container">
    <label for="almacen_id" class="form-label">
        <i class="fa fa-warehouse"></i> Seleccionar Almacén
    </label>
    <select name="almacen_id" id="almacen_id" class="form-control almacen-select" required>
        <option value="">Seleccione un almacén...</option>
        <option value="1">Santa Ana - Paurito (Av Paurito frente a la línea 59 roja)</option>
        <option value="2">Santa Ana - Las Américas (Av Las Américas a lado del mercado paraíso)</option>
        <option value="3">Santa Ana - El Fuerte (Av El Fuerte diagonal mercado el fuerte)</option>
    </select>
    <small class="form-text text-muted">
        <i class="fa fa-info-circle"></i> Seleccione el almacén donde se guardará el producto
    </small>
</div>

<style>
.almacen-selector-container {
    margin: 20px 0;
}

.form-label {
    font-weight: 600;
    color: #111827;
    margin-bottom: 8px;
    display: block;
}

.form-label i {
    color: #dc2626;
    margin-right: 8px;
}

.almacen-select {
    padding: 12px 15px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    background: white;
    transition: all 0.3s ease;
    width: 100%;
}

.almacen-select:focus {
    border-color: #dc2626;
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    outline: none;
}

.almacen-select:hover {
    border-color: #dc2626;
}

.form-text {
    margin-top: 5px;
    font-size: 12px;
    color: #6b7280;
}

.form-text i {
    color: #dc2626;
    margin-right: 5px;
}

/* Responsive */
@media (max-width: 768px) {
    .almacen-select {
        padding: 15px;
        font-size: 16px; /* Evita zoom en iOS */
    }
}
</style>