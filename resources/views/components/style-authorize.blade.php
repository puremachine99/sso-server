@push('styles')
<style>
    :root {
        --neu-bg: #f0f2f5;
        --neu-dark: rgba(163,177,198,0.6);
        --neu-light: rgba(255,255,255,0.7);
        --primary-start: #4a6bff;
        --primary-end: #2541b2;
        --primary-hover-start: #3d5af1;
        --primary-hover-end: #1a2f8f;
        --secondary-start: #f0f0f0;
        --secondary-end: #c9c9c9;
        --secondary-hover-start: #e0e0e0;
        --secondary-hover-end: #b9b9b9;
    }

    /* === Neumorphic Base === */
    .shadow-neumorph {
        box-shadow: 8px 8px 16px var(--neu-dark),
                    -8px -8px 16px var(--neu-light);
        border: 1px solid rgba(255,255,255,0.2);
    }

    /* === Buttons === */
    .btn-primary,
    .btn-secondary {
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-start), var(--primary-end));
        box-shadow: 4px 4px 8px rgba(37,65,178,0.2),
                    -2px -2px 4px rgba(255,255,255,0.4);
        color: #fff;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-hover-start), var(--primary-hover-end));
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(37,65,178,0.3),
                    -3px -3px 6px rgba(255,255,255,0.5);
    }
    .btn-secondary {
        background: linear-gradient(135deg, var(--secondary-start), var(--secondary-end));
        box-shadow: 4px 4px 8px rgba(163,177,198,0.3),
                    -2px -2px 4px rgba(255,255,255,0.5);
        color: #555;
    }
    .btn-secondary:hover {
        background: linear-gradient(135deg, var(--secondary-hover-start), var(--secondary-hover-end));
        transform: translateY(-2px);
        box-shadow: 6px 6px 12px rgba(163,177,198,0.4),
                    -3px -3px 6px rgba(255,255,255,0.6);
    }

    /* === Inputs === */
    .form-control {
        background: var(--neu-bg);
        border-radius: 8px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: inset 3px 3px 6px rgba(163,177,198,0.3),
                    inset -3px -3px 6px rgba(255,255,255,0.8);
        padding: 0.6rem 1rem;
    }
    .form-control:focus {
        outline: none;
        box-shadow: inset 2px 2px 5px rgba(37,65,178,0.3),
                    inset -2px -2px 5px rgba(255,255,255,0.8);
    }

    /* === Alerts === */
    .alert {
        border-radius: 8px;
        padding: 0.8rem 1rem;
        box-shadow: 4px 4px 8px rgba(163,177,198,0.3),
                    -2px -2px 4px rgba(255,255,255,0.5);
    }
    .alert-success {
        background: linear-gradient(135deg, #d4edda, #b8e0c2);
        color: #155724;
    }
    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f1b0b7);
        color: #721c24;
    }

    /* === Permission Item === */
    .permission-item {
        background: var(--neu-bg);
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: inset 3px 3px 6px rgba(163, 177, 198, 0.3),
                    inset -3px -3px 6px rgba(255, 255, 255, 0.8);
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
    }
</style>
@endpush
