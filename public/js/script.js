let profileForm = document.getElementById('profile-form');
let profileInfo = document.getElementById("profile-info");


document.getElementById("edit-profile").addEventListener("click", function () {
    profileInfo.style.display = "none";
    profileForm.style.display = "block";
});

profileForm.addEventListener("submit", function (evt) {
    evt.preventDefault();
    let formData = new FormData(profileForm);
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
                let user = data['user'];
                document.getElementById("username").textContent = user.username;
                document.getElementById("profilePicture").src = user.profilePicture;
                document.getElementById("bio").textContent = user.bio;
                document.getElementById("message").textContent = "Profile updated successfully!";
                profileInfo.style.display = "block";
                profileForm.style.display = "none";
            } else {
                document.getElementById("message").textContent = "Error while updating the profile";
            }
        })
        .catch(error => console.error("Error:", error));
});


let feedForm = document.getElementById("feed-form");
let searchInput = document.getElementById("feed-search");
let feedList = document.getElementById("feed-list");

// ajax to update preferences
feedForm.addEventListener("submit", function (evt) {
    evt.preventDefault();
    selectedOption = feedList.options[feedList.selectedIndex];
    // Get feedID and feedName
    let feedID = selectedOption.value;
    let feedName = selectedOption.getAttribute("data-name");
    let formData = new FormData();
    formData.append("feedID", feedID);
    formData.append("feedName", feedName);
    formData.append("routeAjax", "updatePreferences");
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
                let li = document.createElement('li');
                li.textContent = data.feed;
                let preferences = document.getElementById('preferences-list');
                preferences.appendChild(li);
            } else {
                console.log("Error while updating preferences");
            }
        })
        .catch(error => console.error("Error:", error));
});

searchInput.addEventListener("input", function () {
    let searchValue = this.value.toLowerCase();
    let options = feedList.options;
    let firstMatch = null;
    let matchCount = 0;

    for (let option of options) {
        let text = option.text.toLowerCase();
        if (text.includes(searchValue)) {
            option.style.display = "block";
            if (!firstMatch) firstMatch = option;
            matchCount++;
        } else {
            option.style.display = "none";
        }
    }

    // Open the dropdown by increasing size
    feedList.size = matchCount > 0 ? Math.min(matchCount, 6) : 1; // Limit size to 6 max

    if (firstMatch) {
        feedList.value = firstMatch.value;
    }
});

document.addEventListener("click", function (event) {
    if (!searchInput.contains(event.target) && !feedList.contains(event.target)) {
        feedList.size = 1;
    }
});

searchInput.addEventListener("focus", function () {
    let visibleOptions = [...feedList.options].filter(opt => opt.style.display !== "none");
    feedList.size = visibleOptions.length > 0 ? Math.min(visibleOptions.length, 6) : 1;
});