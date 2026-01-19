@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Configuración de Notificaciones</h1>
            <div class="section-header-breadcrumb">
                <a href="{{ route('configuracion.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Alertas y Avisos Automáticos</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('configuracion.actualizar') }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Días antes de vencimiento para alertar</label>
                                        <input type="number" name="notif_dias_vencimiento" class="form-control" 
                                               value="{{ $configuraciones['notif_dias_vencimiento']->valor ?? '3' }}" 
                                               min="1" max="30">
                                        <small class="text-muted">Cuántos días antes del vencimiento enviar alertas</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Hora de envío de notificaciones</label>
                                        <input type="time" name="notif_hora_envio" class="form-control" 
                                               value="{{ $configuraciones['notif_hora_envio']->valor ?? '08:00' }}">
                                        <small class="text-muted">Hora del día para enviar notificaciones automáticas</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Notificaciones Automáticas</label>
                                        <select name="notif_automaticas" class="form-control">
                                            <option value="1" {{ ($configuraciones['notif_automaticas']->valor ?? '1') == '1' ? 'selected' : '' }}>Activadas</option>
                                            <option value="0" {{ ($configuraciones['notif_automaticas']->valor ?? '1') == '0' ? 'selected' : '' }}>Desactivadas</option>
                                        </select>
                                        <small class="text-muted">Activar o desactivar el sistema de notificaciones automáticas</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Proveedor SMS</label>
                                        <select name="sms_provider" class="form-control">
                                            <option value="local" {{ ($configuraciones['sms_provider']->valor ?? 'local') == 'local' ? 'selected' : '' }}>API Local</option>
                                            <option value="twilio" {{ ($configuraciones['sms_provider']->valor ?? 'local') == 'twilio' ? 'selected' : '' }}>Twilio</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>API Key SMS</label>
                                        <input type="text" name="sms_api_key" class="form-control" 
                                               value="{{ $configuraciones['sms_api_key']->valor ?? '' }}" 
                                               placeholder="Clave API para SMS">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>WhatsApp Token</label>
                                        <input type="text" name="whatsapp_token" class="form-control" 
                                               value="{{ $configuraciones['whatsapp_token']->valor ?? '' }}" 
                                               placeholder="Token de WhatsApp Business">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Canales de Notificación</label>
                                        <div class="form-check">
                                            <input type="checkbox" name="canales[]" value="email" class="form-check-input" 
                                                   {{ in_array('email', explode(',', $configuraciones['canales_notif']->valor ?? 'email,sms')) ? 'checked' : '' }}>
                                            <label class="form-check-label">Email</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="canales[]" value="sms" class="form-check-input" 
                                                   {{ in_array('sms', explode(',', $configuraciones['canales_notif']->valor ?? 'email,sms')) ? 'checked' : '' }}>
                                            <label class="form-check-label">SMS</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="checkbox" name="canales[]" value="whatsapp" class="form-check-input" 
                                                   {{ in_array('whatsapp', explode(',', $configuraciones['canales_notif']->valor ?? 'email,sms')) ? 'checked' : '' }}>
                                            <label class="form-check-label">WhatsApp</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-info">
                                    <i class="fa fa-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection