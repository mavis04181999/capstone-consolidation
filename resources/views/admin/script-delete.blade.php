<script>
    // for user 
    const markAllBtnUser = document.querySelector('#user-dashboard #checkall-user');

    markAllBtnUser.addEventListener('click', function(event) {

        var count = 0;

        const checkBoxes = document.querySelectorAll('#user-table .check-user');

        checkBoxes.forEach(element => {
            // check if there is a checkbox and count it 
            if(element.checked == true) {
                count++;
            }
        });

        if (count == 0) {
            checkBoxes.forEach(element => {
                element.checked = true;
            });
        }else {
            checkBoxes.forEach(element => {
                element.checked = false;
            });
        }

    });

    // for organizer
    const markAllBtnOrganizer = document.querySelector('#organizer-dashboard #checkall-organizer');

    markAllBtnOrganizer.addEventListener('click', function(event) {
        var count = 0;

        const checkBoxes = document.querySelectorAll('#organizer-table .check-organizer');

        checkBoxes.forEach(element => {
            // check if there is a checkbox and count it 
            if(element.checked == true) {
                count++;
            }
        });

        if (count == 0) {
            checkBoxes.forEach(element => {
                element.checked = true;
            });
        }else {
            checkBoxes.forEach(element => {
                element.checked = false;
            });
        }
    });

    console.log(markAllBtnOrganizer);

</script>