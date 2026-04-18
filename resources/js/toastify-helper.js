window.showToast = function (message, type = "success", duration = 3000) {
    const colors = {
        success: "linear-gradient(to right, #10b981, #059669)",
        error: "linear-gradient(to right, #ef4444, #dc2626)",
        warning: "linear-gradient(to right, #f59e0b, #d97706)",
        info: "linear-gradient(to right, #3b82f6, #2563eb)",
    };

    if (!document.getElementById("toastify-progress-style")) {
        const style = document.createElement("style");
        style.id = "toastify-progress-style";
        style.textContent = `
            .toastify {
                overflow: hidden !important;
            }
            .toast-progress {
                position: absolute;
                bottom: 0;
                left: 0;
                height: 3px;
                width: 100%;
                background: rgba(255, 255, 255, 0.6);
                border-radius: 0 0 8px 8px;
            }
        `;
        document.head.appendChild(style);
    }

    const toast = Toastify({
        text: message,
        duration: duration,
        gravity: "top",
        position: "right",
        stopOnFocus: true,
        close: true,
        style: {
            background: colors[type] || colors.success,
            borderRadius: "8px",
            padding: "12px 20px",
            fontSize: "14px",
            fontWeight: "600",
            boxShadow: "0 4px 12px rgba(0,0,0,0.15)",
        },
    });

    toast.showToast();

    setTimeout(() => {
        const toastEl = toast.toastElement;
        if (!toastEl) return;

        const progress = document.createElement("div");
        progress.className = "toast-progress";
        progress.style.transition = `width ${duration}ms linear`;

        toastEl.appendChild(progress);

        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                progress.style.width = "0%";
            });
        });
    }, 10);
};

window.showSuccess = function (message, duration = 3000) {
    showToast(message, "success", duration);
};

window.showError = function (message, duration = 3000) {
    showToast(message, "error", duration);
};

window.showWarning = function (message, duration = 3000) {
    showToast(message, "warning", duration);
};

window.showInfo = function (message, duration = 3000) {
    showToast(message, "info", duration);
};
