//controls select-all box
function CheckUncheckAll() {
    var selectAllCheckbox = document.getElementById("checkUncheckAll");
    if (selectAllCheckbox.checked == true) {
        var checkboxes = document.getElementsByName("rowSelectCheckBox");
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = true;
        }
    } else {
        var checkboxes = document.getElementsByName("rowSelectCheckBox");
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            checkboxes[i].checked = false;
        }
    }
}

//gets selected users for email list
function GetEmails() {
        email_list = "";

        boxes = document.querySelectorAll('input.email_check');
        var i;
        var num = 0;
        for (i = 0; i < boxes.length; i++) {
            if (boxes[i].checked == true) {
                if (num > 0) email_list += ", ";
                email_list += boxes[i].value;
                num++;
            }
        }


        alert(email_list);
}

//opens and closes the add user box
function openAddUser() {
    var addBox = document.getElementById('add_user_box');

    if (addBox.classList.contains('add_user_closed')) {
        addBox.style.height = '170px';
        addBox.classList.remove('add_user_closed');
        addBox.classList.add('add_user_opened');
    } else if (addBox.classList.contains('add_user_opened')) {
        addBox.style.height = '0px';
        addBox.classList.remove('add_user_opened');
        addBox.classList.add('add_user_closed');
    }
}

//opens and closes the remove user confirmation messages
function toggleConfirm(user_ID) {
    var div_id = "confirm_box_" + user_ID.toString();
    var slide = document.getElementById(div_id);

    if (slide.classList.contains('confirm_closed')) {
        slide.style.height = '50px';
        slide.classList.remove('confirm_closed');
        slide.classList.add('confirm_opened');
        return;
    } else if (slide.classList.contains('confirm_opened')) {
        slide.style.height = '0px';
        slide.classList.remove('confirm_opened');
        slide.classList.add('confirm_closed');
        return;
    }
}