export function lockScroll(node) {
    document.body.classList.add('overflow-hidden');

    return {
        destroy() {
            document.body.classList.remove('overflow-hidden');
        }
    };
}