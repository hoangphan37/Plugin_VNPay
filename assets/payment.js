jQuery(document).ready(function ($) {
  $("#payment-form").on("submit", function (e) {
    e.preventDefault(); // Ngăn form tải lại trang

    const data = {
      action: "handle_payment", // Tên hành động trùng với tên bạn khai báo trong add_action
      amount: $("#amount").val(), // Lấy giá trị số tiền
      payment_method: $("#payment-method").val(), // Lấy hình thức thanh toán
    };

    $.post(ajaxurl, data, function (response) {
      if (response.success) {
        alert(response.data); // Hiển thị thông báo thành công
      } else {
        alert(response.data); // Hiển thị thông báo lỗi
      }
    });
  });
});
