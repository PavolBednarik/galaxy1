<?php

require_once('header.php');

?>

<br>
<br>

<!-- form for signing inn  at the moment i need to figure out why doesnt show error messages -->
<div class="container">
    <br>
    <h1 class="col-md-3 text-light">Sign in to Galaxy Cinema</h1>
    <div class="row justify-content-center">

        <div class="col-md-6">
            <form id="sign-in-form" name="myForm" action="insert-user.php" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="inputName" class="formdesign text-light">Name:</label>
                    <input type="text" class="form-control" id="inputName" name="fname" required>
                    <b><span class="formerror"></span></b>
                </div>

                <div class="form-group">
                    <label for="inputSurname" class="formdesign text-light">Surname:</label>
                    <input type="text" class="form-control" id="inputEmail" name="fsurname" required>
                    <b><span class="formerror"></span></b>
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="formdesign text-light">Email:</label>
                    <input type="email" class="form-control" id="inputEmail" name="femail" required>
                    <b><span class="formerror"></span></b>
                </div>

                <div class="form-group">
                    <label for="inputPhone" class="formdesign text-light">Phone:</label>
                    <input type="tel" class="form-control" id="inputPhone" name="fphone" required>
                    <b><span class="formerror"></span></b>
                </div>

                <div class="form-group">
                    <label for="inputPassword" class="formdesign text-light">Password:</label>
                    <input type="password" class="form-control" id="inputPassword" name="fpass" required>
                    <b><span class="formerror"></span></b>
                </div>

                <div class="form-group">
                    <label for="confirmPassword" class="formdesign text-light">Confirm Password:</label>
                    <input type="password" class="form-control" id="confirmPassword" name="fcpass" required>
                    <b><span class="formerror"></span></b>
                </div>

                <button type="submit" class="btn btn-primary but">Submit</button>

                <?php

                // Display session errors if any
                if (isset($_SESSION['error'])) {
                    echo "<div class='alert alert-danger mt-3' role='alert'>" . $_SESSION['error'] . "</div>";
                    unset($_SESSION['error']);
                }

                // Display success message if any
                if (isset($_SESSION['success'])) {
                    echo "<div class='alert alert-success mt-3' role='alert'>" . $_SESSION['success'] . "</div>";
                    unset($_SESSION['success']);
                }

                ?>
            </form>
        </div>
    </div>
</div>
<br>
<br>

<!-- Optional JavaScript -->
<script>
    // Function to clear all form error messages
    function clearErrors() {
        errors = document.getElementsByClassName('formerror');
        // Loop through each error element and clear its content
        for (let item of errors) {
            item.innerHTML = "";
        }
    }
    // Function to set error message for a specific form field
    function seterror(id, error) {
        element = document.getElementById(id);
        element.getElementsByClassName('formerror')[0].innerHTML = error;
    }
    // Function to validate the form
    function validateForm() {
        var returnval = true;
        clearErrors();
        // Get the value of the 'name' field from the form and trim any extra spaces
        var name = document.forms['myForm']["fname"].value.trim();
        if (name.length < 5) {
            seterror("inputName", "*Length of name is too short (minimum 5 characters)");
            returnval = false;
        }
        // Check if the 'name' field is empty
        if (name.length === 0) {
            seterror("inputName", "*Name cannot be empty!");
            returnval = false;
        }
        // Get the value of the 'email' field from the form and trim any extra spaces
        var email = document.forms['myForm']["femail"].value.trim();
        // Check if the email is valid using a regular expression
        if (!isValidEmail(email)) {
            seterror("inputEmail", "*Invalid email address");
            returnval = false;
        }
        // Get the value of the 'phone' field from the form and trim any extra spaces
        var phone = document.forms['myForm']["fphone"].value.trim();
        if (!isValidPhoneNumber(phone)) {
            seterror("inputPhone", "*Invalid phone number");
            returnval = false;
        }
        // Get the values of the 'password' and 'confirmPassword' fields from the form
        var password = document.forms['myForm']["fpass"].value;
        var confirmPassword = document.forms['myForm']["fcpass"].value;
        if (password.length < 6) {
            seterror("inputPassword", "*Password should be at least 6 characters long");
            returnval = false;
        }
        // Check if the 'password' and 'confirmPassword' fields match
        if (password !== confirmPassword) {
            seterror("confirmPassword", "*Password and Confirm password should match");
            returnval = false;
        }

        // If all validations pass, show a success message
        if (returnval) {
            alert("Form validated successfully!");
        }

        return returnval;
    }
    // Function to validate an email address using regular expression
    function isValidEmail(email) {
        // Simple email validation regex
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    // Function to validate a phone number using regular expression
    function isValidPhoneNumber(phone) {
        // Simple phone number validation regex
        var phoneRegex = /^\d{10}$/;
        return phoneRegex.test(phone);
    }


</script>

<?php

require_once('footer.php');

?>