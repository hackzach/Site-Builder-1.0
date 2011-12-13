function validate() {
	pass1 = document.create.password.value;
	pass2 = document.create.password_test.value;

	if(pass1 != pass2) {
		alert("Passwords do not match.");
		return false;
	}
		else {
			return true;
		}
}