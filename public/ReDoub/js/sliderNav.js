document.addEventListener("DOMContentLoaded", () => {
    // Lấy danh sách các slide và box mô tả
    const slides = document.querySelectorAll(".slide");
    const boxes = document.querySelectorAll(".box");

    // biến lưu trữ slide hiện tại. ban đầu = 0
    // biến interval để lưu trữ id từng slide sử dụng để chuyển đổi giữa các slide sau một thời gian đã cài đặt
    let currentSlide = 0;
    let intervalID;

    let startAutoSlide = () => {
        intervalID = setInterval(() => {
            goToSlide((currentSlide + 1) % slides.length);
        }, 3000);
    };

    // Bắt đầu tự động chuyển slide
    startAutoSlide();

    // Điều hướng đến slide khi click vào box tương ứng
    boxes.forEach((box, index) => {
        box.addEventListener("click", () => {
            // Xóa bỏ interval hiện tại
            clearInterval(intervalID);

            // Chuyển đến slide được nhấp vào
            goToSlide(index);

            // Bắt đầu lại tự động chuyển slide
            startAutoSlide();
        });
    });

    let goToSlide = (index) => {
        // Ẩn slide hiện tại và hiển thị slide mới
        slides[currentSlide].classList.remove("active");
        boxes[currentSlide].classList.remove("active");

        slides[index].classList.add("active");
        boxes[index].classList.add("active");

        // Cập nhật vị trí slide hiện tại
        currentSlide = index;
    };
});
