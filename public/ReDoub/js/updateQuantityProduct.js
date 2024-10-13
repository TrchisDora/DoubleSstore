$(document).ready(function () {
    $(".cart-quantity").on("change", function () {
        var MaSP = $(this).closest("tr").find('input[name="MaSP[]"]').val();
        var SoLuongCapNhat = $(this).val();

        // Gửi request AJAX lên server
        updateCartQuantity(MaSP, SoLuongCapNhat);
    });
});

function updateCartQuantity(MaSP, SoLuongCapNhat) {
    $.ajax({
        type: "POST",
        url: "index.php?page=cart",
        data: {
            update_quantity: 1,
            MaSP: MaSP,
            SoLuongCapNhat: SoLuongCapNhat,
        },
        success: function (response) {},
    });
}
