function updateURLOrder(orderStatus) {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('order_status', orderStatus);
    window.location.href = currentUrl;
}
function updateURLProcess(ordercode) {  
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('order_code', ordercode);
    window.location.href = currentUrl;
}
function goBack() {
    window.history.back(); // Trở lại trang trước đó
}
