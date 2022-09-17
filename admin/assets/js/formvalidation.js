$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='registration']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      name: "required",

      contact: {
        required: true,
     number: true,
     minlength: 10,
     maxlength: 10
   },
      formFileSm: "required"
    },
    // Specify validation error messages
    messages: {
      name: "Please enter name",

      contact: {
        required: "Please center contact no",
        minlength: "Please enter 10 digit contact no",
        maxlength: "Please enter 10 digit contact no"
      },
      formFileSm: "Please select logo"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});
