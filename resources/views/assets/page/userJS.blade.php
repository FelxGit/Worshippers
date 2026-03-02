<?php
  $users = !empty($users)? $users : [];
?>
@push('assetJs')
<script>
/*======================================================================
* CONSTANTS
*======================================================================*/
const ROUTE_URL = `{{ route('admin.user') }}`;

/*======================================================================
* VARIABLES
*======================================================================*/
var users = [];
var userIds = [];

/*======================================================================
* INITIAL
*======================================================================*/

users = `{{ json_encode($users) }}`;

$(function() {
  $("#birthdate").datepicker();
});

/*======================================================================
* METHODS
*======================================================================*/
function getUserIds() {
  try {
    // Use DOMParser to parse the HTML-encoded JSON
    const parser = new DOMParser();
    const parsedUsers = parser.parseFromString(users, "text/html").body.textContent;

    // Parse the JSON string to convert it into an array of user objects
    const usersArray = JSON.parse(parsedUsers).data;

    // Extract user IDs from the user objects using map()
    const userIds = usersArray.map((user) => user.id);

    return userIds;
  } catch (error) {
    console.error("Error parsing users JSON:", error);
    return [];
  }
}

function submitForm() {
  const form = document.getElementById("form");

  if (form) {
    form.submit();
  } else {
    console.error("Form not found!");
  }
}

function deleteUser(userId) {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = ROUTE_URL + "/delete"; // Replace ROUTE_URL with your actual constant value

  // Create formData object and append the required parameters
  const formData = new FormData();
  formData.append("_token", _g.token);
  formData.append("_method", "DELETE");
  formData.append("id", userId);

  // Loop through the formData entries and append them as hidden inputs to the form
  for (const [key, value] of formData.entries()) {
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = key;
    input.value = value;
    form.appendChild(input);
  }

  // Append the form to the document body and submit it
  document.body.appendChild(form);
  form.submit();
}

function bulkDelete() {
  const form = document.createElement("form");
  form.method = "POST";
  form.action = ROUTE_URL + "/deletebulk"; // Replace ROUTE_URL with your actual constant value

  const formData = {
    _token: _g.token,
    _method: "DELETE",
    ids: userIds.join(", ")
  };

  // Create formData object and append the required parameters
  const formDataObject = new FormData();

  for (const key in formData) {
    if (formData.hasOwnProperty(key)) {
      const value = formData[key];
      formDataObject.append(key, value);
    }
  }

  // Loop through the formData entries and append them as hidden inputs to the form
  for (const [key, value] of formDataObject.entries()) {
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = key;
    input.value = value;
    form.appendChild(input);
  }

  // Append the form to the document body and submit it
  document.body.appendChild(form);
  form.submit();
}

function toggleDropdown() {
 var dropdownContent = document.getElementById("dropdownContent");
 dropdownContent.style.display = dropdownContent.style.display === "block" ? "none" : "block";
}

function addSelectedUsers(event) {
  const selectUserInput = event.target;
  const userId = selectUserInput.getAttribute("data-user-id");

  if (selectUserInput.checked) {
    // If the checkbox is checked, add the user ID to the userIds array
    if (!userIds.includes(userId)) {
      userIds.push(userId);

    }
  } else {
    // If the checkbox is unchecked, remove the user ID from the userIds array
    const index = userIds.indexOf(userId);
    if (index !== -1) {
      userIds.splice(index, 1);
    }
  }
  replaceModalConfirmDescription();
}

function selectAllFromPage() {
  const selectAllCheckbox = document.getElementById('user-checkboxes-select');
  const userCheckboxes = document.querySelectorAll('.user-checkbox');

  // If the 'Select All' checkbox is checked, toggle all user checkboxes to true.
  // If it's unchecked, toggle all user checkboxes to false.
  const selectAllState = selectAllCheckbox.checked;
  userCheckboxes.forEach((checkbox) => (checkbox.checked = selectAllState));

  // Update the 'userIds' array based on the value of each selected checkbox.
  userIds.length = 0; // Clear the 'userIds' array before updating it.
  userCheckboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      userIds.push(checkbox.value);
    }
  });

  replaceModalConfirmDescription();
}

function replaceModalConfirmDescription() {
  let modalBulkDeleteDescription = document.querySelector('#modal-confirm-bulkdelete .modal-description');
  let modifiedText = modalBulkDeleteDescription.innerHTML.replace(/(\().*?(\))/, '$1' + userIds.join(', ') + '$2');
  modalBulkDeleteDescription.innerHTML = modifiedText;
}

function clearFormData() {
    // Get the form element by its ID
    const form = document.getElementById('form');

    // Reset the form to its initial state, clearing all field values
    form.reset();

    const fields = [
      { name: "firstname", label: "First Name" },
      { name: "middlename", label: "Middle Name" },
      { name: "lastname", label: "Last Name" },
      { name: "username", label: "Username" },
      { name: "nick_name", label: "Nickname" },
      { name: "tel", label: "Telephone" },
      { name: "zip_code", label: "Zip Code" },
      { name: "address", label: "Address" }
    ];

    // Function to focus on the input field if it has a value
    function focusOnFieldWithValues() {
      for (const field of fields) {
        const inputField = document.querySelector(`[name="${field.name}"]`);
        if (inputField && inputField.value) {
          inputField.focus();
        }
      }
    }

    // Call the function
    focusOnFieldWithValues();

}

function storeTmp(event) {
  const token = _g.token; // Assuming _g.token is a global variable containing the token value
  const fileType = event.target.getAttribute('fileType'); // Assuming you set the 'fileType' attribute on the input element

  const formData = new FormData();
  formData.append('_token', token);
  formData.append('_method', 'POST');
  formData.append('fileType', fileType);
  formData.append('validateField', 'avatarImg');
  formData.append('avatarImg', event.target.files[0]);
  formData.append('image', event.target.files[0]);

  const uploadURL = ROUTE_URL + '/upload';

  fetch(uploadURL, {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    var avatarRemoveBtn = document.getElementById('avatar-remove-btn');
    var avatarViewLink = document.getElementById('avatar-view-link');
    var inputAvatar = document.getElementById('avatar');

    avatarRemoveBtn.innerHTML = '<span class="fa fa-times text-danger" aria-hidden="true"></span>';

    avatarViewLink.href = data;
    avatarViewLink.textContent = data;
    inputAvatar.value = data;
  })
  .catch(error => {
    // Handle errors here
    console.error('Error:', error);
  });
}

function deleteAvatar() {
  var avatarRemoveBtn = document.getElementById('avatar-remove-btn');
  var avatarViewLink = document.getElementById('avatar-view-link');
  var avatarInput = document.getElementById('avatar');

  avatarRemoveBtn.textContent = '';
  avatarViewLink.textContent = '';
  avatarInput.value = '';
}

/*======================================================================
* DOM EVENTS
*======================================================================*/

$("#birthdate-btn").on("click", function() {
  $("#birthdate").datepicker("show");
});

</script>
@endpush