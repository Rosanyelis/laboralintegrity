// Capitalización tipo Título para inputs de texto y textareas
// Exclusiones: type=email, password, number y elementos con data-no-capitalize
function isExcludedInput(element) {
    if (!element) return true;
    const tag = element.tagName?.toLowerCase();
    if (tag !== 'input' && tag !== 'textarea') return true;
    const type = (element.getAttribute('type') || '').toLowerCase();
    if (type === 'email' || type === 'password' || type === 'number') return true;
    if (element.hasAttribute('data-no-capitalize')) return true;
    return false;
}

function toTitleCase(value) {
    if (!value) return value;
    // Normalizar espacios múltiples y capitalizar cada palabra
    return value
        .toLowerCase()
        .replace(/\S+/g, (word) => word.charAt(0).toUpperCase() + word.slice(1));
}

function applyTitleCase(e) {
    const el = e.target;
    if (isExcludedInput(el)) return;

    const { selectionStart, selectionEnd, value } = el;
    const transformed = toTitleCase(value);

    if (transformed !== value) {
        el.value = transformed;
        // Restaurar caret de forma segura
        const start = selectionStart != null ? selectionStart : transformed.length;
        const end = selectionEnd != null ? selectionEnd : transformed.length;
        try {
            el.setSelectionRange(start, end);
        } catch (_) {
            // No soportado, ignorar
        }
        el.dispatchEvent(new Event('input', { bubbles: true })); // sin romper x-model
    }
}

function initGlobalCapitalization() {
    // Delegación de eventos para inputs existentes y futuros
    document.addEventListener('input', applyTitleCase, true);
    document.addEventListener('change', applyTitleCase, true);
    document.addEventListener('paste', (e) => {
        // Dejar que el pegado termine y luego transformar
        setTimeout(() => applyTitleCase(e), 0);
    }, true);
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'complete' || document.readyState === 'interactive') {
    initGlobalCapitalization();
} else {
    document.addEventListener('DOMContentLoaded', initGlobalCapitalization);
}

export {};


