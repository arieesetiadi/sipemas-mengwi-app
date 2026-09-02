document.addEventListener('DOMContentLoaded', () => {
    initToastify();
});

function initToastify() {
    if (toastText) {
        Toastify({
            text: toastText,
            duration: 3000,
            close: false,
            gravity: "top",
            position: "center",
            className: "rounded-5",
            style: {
                background: "white",
                color: "black",
                borderRadius: "8px",
            },
        }).showToast();
    }
}
