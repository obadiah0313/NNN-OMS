$("#signup").click(function () {
	$("#first").fadeOut("fast", function () {
		$("#second").fadeIn("fast");
	});
});

$("#signin").click(function () {
	$("#second").fadeOut("fast", function () {
		$("#first").fadeIn("fast");
	});
});



$(function () {
	$("form[name='login']").validate({
		rules: {

			email: {
				required: true,
				email: true
			},
			phone: {
				required: true
			},
			password: {
				required: true,
			}
		},
		messages: {
			email: "Please enter a valid email address",
			
			phone: "Please enter a valid phone number",

			password: {
				required: "Please enter password",
			}

		},
		submitHandler: function (form) {
			form.submit();
		}
	});
});



$(function () {

	$("form[name='registration']").validate({
		rules: {
			fullname: "required",
			phone: "required",
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 8,
				maxlength: 20
			}
		},

		messages: {
			fullname: "Please enter your full name",
			phone: "Please enter your phone number",
			password: {
				required: "Please provide a password",
				minlength: "Your password must be at least 8 characters long",
				maxlength: "Your password must be shorter than 20 characters"
			},
			email: "Please enter a valid email address"
		},

		submitHandler: function (form) {
			form.submit();
		}
	});
});
