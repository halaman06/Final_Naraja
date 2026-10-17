var searchBox = document.getElementById("search");

function loadItems() {
    var q = searchBox.value;
    fetch("search.php?q=" + encodeURIComponent(q))
        .then(function (response) { return response.text(); })
        .then(function (data) {
            document.getElementById("results").innerHTML = data;
        })
        .catch(function () {
            document.getElementById("results").innerHTML =
                "<tr><td colspan='5'>Error loading items.</td></tr>";
        });
}

if (searchBox) {
    searchBox.addEventListener("keyup", loadItems);
    loadItems();
}

var registerForm = document.getElementById("registerForm");
if (registerForm) {
    registerForm.addEventListener("submit", function (e) {
        var name = document.getElementById("name").value.trim();
        var email = document.getElementById("email").value.trim();
        var password = document.getElementById("password").value;
        var confirm = document.getElementById("confirm").value;
        var error = "";

        if (name == "" || email == "" || password == "") {
            error = "Please fill in all fields.";
        } else if (password.length < 6) {
            error = "Password must be at least 6 characters.";
        } else if (password != confirm) {
            error = "Passwords do not match.";
        }

        if (error != "") {
            e.preventDefault();
            document.getElementById("formError").textContent = error;
        }
    });
}

var loginForm = document.getElementById("loginForm");
if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
        var email = document.getElementById("email").value.trim();
        var password = document.getElementById("password").value;

        if (email == "" || password == "") {
            e.preventDefault();
            document.getElementById("formError").textContent = "Please enter your email and password.";
        }
    });
}

var itemForm = document.getElementById("itemForm");
if (itemForm) {
    itemForm.addEventListener("submit", function (e) {
        var name = document.getElementById("name").value.trim();
        var category = document.getElementById("category").value.trim();
        var quantity = document.getElementById("quantity").value;
        var price = document.getElementById("price").value;
        var error = "";

        if (name == "" || category == "") {
            error = "Name and category are required.";
        } else if (quantity === "" || quantity < 0) {
            error = "Quantity must be 0 or more.";
        } else if (price === "" || price < 0) {
            error = "Price must be 0 or more.";
        }

        if (error != "") {
            e.preventDefault();
            document.getElementById("formError").textContent = error;
        }
    });
}
