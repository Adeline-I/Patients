$(document).ready(function(){
    $('input.timepicker').timepicker({});
});

$('.timepicker').timepicker({
    timeFormat: 'HH:mm',
    interval: 30,
    minTime: '08:00',
    maxTime: '20:00',
    defaultTime: `<?php if(!empty($appointmentProfil->dateHourAppointments)) {
                            echo date('H:i', strtotime($appointmentProfil->dateHourAppointments));
                        } else if(!empty($time)) {
                            echo $time;
                        } else {
                            echo '--:--';
                        }?>`,
    startTime: '08:00',
    dynamic: false,
    dropdown: true,
    scrollbar: true
});

let deleteModal = document.getElementById('deleteModal')
deleteModal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    let button = event.relatedTarget
    // Extract info from data-bs-* attributes
    let recipient = button.getAttribute('data-bs-whatever')
    let recipientOther = button.getAttribute('data-bs-whateverother')
    // If necessary, you could initiate an AJAX request here
    // and then do the updating in a callback.
    //
    // Update the modal's content.
    let modalBodyP = deleteModal.querySelector('.modal-body p')
    let modalFooterInput = deleteModal.querySelector('.modal-footer input')

    modalBodyP.textContent = recipient
    modalFooterInput.value = recipientOther
});