let profileForm = document.getElementById('profile-form');
let profileInfo = document.getElementById("profile-info");


document.getElementById("edit-profile").addEventListener("click", function () {
    profileInfo.style.display = "none";
    profileForm.style.display = "block";
});

profileForm.addEventListener("submit", function (evt) {
    evt.preventDefault();
    let formData = new FormData(profileForm); // Use the correct form reference
    formData.append("routeAjax", "updateProfile");
    fetch("index.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.text())
        .then(text => {
            console.log("Response:", text);
            return JSON.parse(text);
        })
        .then(data => {
            if (data.success) {
                document.getElementById("username").textContent = data.username;
                document.getElementById("message").textContent = "Profile updated successfully!";
                profileInfo.style.display = "block";
                profileForm.style.display = "none";
            } else {
                document.getElementById("message").textContent = "Error while updating the profile";
            }
        })
        .catch(error => console.error("Error:", error));
});
