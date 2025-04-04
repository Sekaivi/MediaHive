let profileForm = document.getElementById('profile-form');
let profileInfo = document.getElementById("profile");
let edit_profile = document.getElementById("edit-profile");

let pref_btn = document.getElementById('preferences-btn') ;
let bookmarks_btn = document.getElementById('bookmarks-btn') ;
let pref_section = document.getElementById('preferences-section') ;
let book_section = document.getElementById('bookmarks-section') ;

function display_preferences() {
    book_section.style.display = 'none';
    pref_section.style.display = 'flex';
    pref_btn.classList.add('active');
    bookmarks_btn.classList.remove('active');
  }
  
  function display_bookmarks() {
    book_section.style.display = 'flex';
    pref_section.style.display = 'none';
    pref_btn.classList.remove('active');
    bookmarks_btn.classList.add('active');
  }

if (edit_profile) {
    edit_profile.addEventListener("click", function () {
        profileInfo.style.display = "none";
        profileForm.style.display = "flex";
    });
}

if (profileForm) {
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
}


let feedForm = document.getElementById("feed-form");
let searchInput = document.getElementById("feed-search");
let feedList = document.getElementById("feed-list");

// ajax to update preferences

if (feedForm) {
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
                    let noPrefElement = document.getElementById('noPref');
                    if (noPrefElement) {
                        noPrefElement.textContent = '';
                    }
                    prefID = data.prefID;
                    message.textContent = "";
                    let form = document.createElement('form');
                    form.classList = 'delete-pref';
                    form.id = prefID;
                    form.addEventListener("submit", function (evt) {
                        delete_pref(evt, form);
                    });
                    let li = document.createElement('li');
                    li.textContent = data.feedName;
                    let button = document.createElement('button');
                    button.type = 'submit';
                    button.textContent = 'Delete';
                    let preferences = document.getElementById('preferences-list');
                    form.appendChild(li);
                    form.appendChild(button);
                    preferences.appendChild(form);
                } else {
                    let message = document.getElementById('message');
                    message.textContent = `You cannot add this feed (you either aready selected 6 feeds or already saved "${feedName}"`;
                }
            })
            .catch(error => console.error("Error:", error));
    });
}


if (searchInput) {
    searchInput.addEventListener("input", function () {
        let searchValue = this.value.toLowerCase();
        let options = feedList.options;
        let firstMatch = null;
        let matchCount = 0;

        for (let option of options) {
            let text = option.text.toLowerCase();
            if (text.includes(searchValue)) {
                option.style.display = "flex";
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
}

/* document.addEventListener("click", function (event) {
    if (!searchInput.contains(event.target) && !feedList.contains(event.target)) {
        feedList.size = 1;
    }
}); */

if (searchInput) {
    searchInput.addEventListener("focus", function () {
        let visibleOptions = [...feedList.options].filter(opt => opt.style.display !== "none");
        feedList.size = visibleOptions.length > 0 ? Math.min(visibleOptions.length, 6) : 1;
    });
}

// delete pref :D
let preferences_delete_forms = document.querySelectorAll('.delete-pref');
preferences_delete_forms.forEach(form => {
    form.addEventListener("submit", function (evt) {
        delete_pref(evt, form);
    });
});

function delete_pref(evt, form) {
    evt.preventDefault();
    let prefID = form.id;
    let formData = new FormData();
    formData.append("prefID", prefID);
    formData.append("routeAjax", "removePref");
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
                document.getElementById(`${prefID}`).remove();
            } else {
                document.getElementById("message").textContent = "Error while updating the profile";
            }
        })
        .catch(error => console.error("Error:", error));
}