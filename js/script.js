function showMessage() {
    alert("All recent activities will be displayed here.");
}


function openRoomForm() {
    document.getElementById("roomModal").style.display = "flex";
}


function closeRoomForm() {
    document.getElementById("roomModal").style.display = "none";
}


window.onclick = function(event) {

    let modal = document.getElementById("roomModal");

    if (event.target === modal) {
        modal.style.display = "none";
    }

};
document.getElementById("studentForm").addEventListener("submit", function(event) {

    event.preventDefault();

    alert("Student registered successfully!");

    this.reset();

});
function openPaymentForm() {
    document.getElementById("paymentModal").style.display = "flex";
}


function closePaymentForm() {
    document.getElementById("paymentModal").style.display = "none";
}


document.getElementById("paymentForm").addEventListener("submit", function(event) {

    event.preventDefault();

    alert("Payment record saved successfully!");

    this.reset();

    closePaymentForm();

});
function openComplaintForm() {
    document.getElementById("complaintModal").style.display = "flex";
}


function closeComplaintForm() {
    document.getElementById("complaintModal").style.display = "none";
}


document.getElementById("complaintForm").addEventListener("submit", function(event) {

    event.preventDefault();

    alert("Complaint submitted successfully!");

    this.reset();

    closeComplaintForm();

});
function openNoticeForm() {
    document.getElementById("noticeModal").style.display = "flex";
}


function closeNoticeForm() {
    document.getElementById("noticeModal").style.display = "none";
}


document.getElementById("noticeForm").addEventListener("submit", function(event) {

    event.preventDefault();

    alert("Notice published successfully!");

    this.reset();

    closeNoticeForm();

});


