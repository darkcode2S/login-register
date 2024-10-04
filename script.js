$(document).ready(function () {
  $("#registrationForm").submit(function (event) {
    event.preventDefault();

    let email = $("#email").val();
    let password = $("#password").val();

    $.ajax({
      url: "register.php",
      type: "POST",
      data: {
        email: email,
        password: password,
      },
      success: function (response) {
        if (response === "Registration successful!") {
          $("#successModal").modal("show");
        } else {
          alert(response);
        }
        $("#registrationForm")[0].reset();
      },
      error: function () {
        alert("An error occurred while processing your request.");
      },
    });
  });
});
