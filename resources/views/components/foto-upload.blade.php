<!-- Componente de Subida de Fotos Responsive -->
<div class="foto-upload-container">
    <div class="foto-upload-area" id="fotoUploadArea">
        <div class="upload-icon">
            <i class="fa fa-camera"></i>
        </div>
        <div class="upload-text">
            <h4>Subir Fotos</h4>
            <p>Arrastra las fotos aquí o haz clic para seleccionar</p>
            <small>Desde PC, galería o cámara</small>
        </div>
        <input type="file" id="fotoInput" name="fotos[]" multiple accept="image/*" capture="environment" style="display: none;">
    </div>
    
    <!-- Botones de acción -->
    <div class="upload-buttons">
        <button type="button" class="btn btn-primary" onclick="document.getElementById('fotoInput').click();">
            <i class="fa fa-folder-open"></i> Galería
        </button>
        <button type="button" class="btn btn-success" onclick="abrirCamara();">
            <i class="fa fa-camera"></i> Cámara
        </button>
    </div>
    
    <!-- Preview de fotos -->
    <div class="fotos-preview" id="fotosPreview"></div>
</div>

<style>
.foto-upload-container {
    margin: 20px 0;
}

.foto-upload-area {
    border: 3px dashed #dc2626;
    border-radius: 10px;
    padding: 40px 20px;
    text-align: center;
    background: #fef2f2;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 15px;
}

.foto-upload-area:hover {
    border-color: #991b1b;
    background: #fecaca;
}

.foto-upload-area.dragover {
    border-color: #991b1b;
    background: #fecaca;
    transform: scale(1.02);
}

.upload-icon {
    font-size: 48px;
    color: #dc2626;
    margin-bottom: 15px;
}

.upload-text h4 {
    color: #111827;
    margin-bottom: 10px;
    font-weight: 600;
}

.upload-text p {
    color: #6b7280;
    margin-bottom: 5px;
}

.upload-text small {
    color: #9ca3af;
}

.upload-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
    margin-bottom: 20px;
}

.upload-buttons .btn {
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.fotos-preview {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.foto-preview-item {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    background: white;
}

.foto-preview-item img {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.foto-preview-item .remove-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #dc2626;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Responsive */
@media (max-width: 768px) {
    .foto-upload-area {
        padding: 30px 15px;
    }
    
    .upload-icon {
        font-size: 36px;
    }
    
    .upload-buttons {
        flex-direction: column;
    }
    
    .upload-buttons .btn {
        width: 100%;
        padding: 15px;
        font-size: 16px;
    }
    
    .fotos-preview {
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 10px;
    }
    
    .foto-preview-item img {
        height: 120px;
    }
}
</style>

<script>
let fotosSeleccionadas = [];

// Configurar drag and drop
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('fotoUploadArea');
    const fotoInput = document.getElementById('fotoInput');
    
    // Click en área de upload
    uploadArea.addEventListener('click', function() {
        fotoInput.click();
    });
    
    // Drag and drop
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });
    
    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
    });
    
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const files = e.dataTransfer.files;
        procesarArchivos(files);
    });
    
    // Input file change
    fotoInput.addEventListener('change', function(e) {
        procesarArchivos(e.target.files);
    });
});

function procesarArchivos(files) {
    for (let file of files) {
        if (file.type.startsWith('image/')) {
            fotosSeleccionadas.push(file);
            mostrarPreview(file);
        }
    }
}

function mostrarPreview(file) {
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('fotosPreview');
        const index = fotosSeleccionadas.length - 1;
        
        const item = document.createElement('div');
        item.className = 'foto-preview-item';
        item.innerHTML = `
            <img src="${e.target.result}" alt="Preview">
            <button type="button" class="remove-btn" onclick="removerFoto(${index})">
                <i class="fa fa-times"></i>
            </button>
        `;
        
        preview.appendChild(item);
    };
    reader.readAsDataURL(file);
}

function removerFoto(index) {
    fotosSeleccionadas.splice(index, 1);
    actualizarPreview();
}

function actualizarPreview() {
    const preview = document.getElementById('fotosPreview');
    preview.innerHTML = '';
    fotosSeleccionadas.forEach((file, index) => {
        mostrarPreview(file);
    });
}

function abrirCamara() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    input.capture = 'environment'; // Cámara trasera en móvil
    input.onchange = function(e) {
        procesarArchivos(e.target.files);
    };
    input.click();
}

// Función para obtener las fotos seleccionadas
function obtenerFotosSeleccionadas() {
    return fotosSeleccionadas;
}
</script>