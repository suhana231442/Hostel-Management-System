// ==========================================
// HOSTEL MANAGEMENT SYSTEM
// MAIN JAVASCRIPT
// ==========================================

const API = "/hostel-management-system/backend";


// ==========================================
// HELPER
// ==========================================

async function sendRequest(url, data = null) {

    const options = {
        method: data ? "POST" : "GET",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        }
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    const response = await fetch(url, options);

    const text = await response.text();

    try {
        return JSON.parse(text);
    } catch (error) {
        console.error("Server response:", text);

        throw new Error(
            "Server returned an invalid response"
        );
    }
}


// ==========================================
// ADMIN LOGIN
// ==========================================

const loginForm = document.getElementById("loginForm");

if (loginForm) {

    loginForm.addEventListener("submit", async function (e) {

        e.preventDefault();

        const email =
            document.getElementById("email").value;

        const password =
            document.getElementById("password").value;

        try {

            const result = await sendRequest(
                API + "/auth/login.php",
                {
                    email: email,
                    password: password
                }
            );

            if (result.success) {

                window.location.href =
                    "pages/dashboard.html";

            } else {

                alert(result.message);
            }

        } catch (error) {

            console.error(error);

            alert("Login connection error.");
        }
    });
}


// ==========================================
// STUDENT REGISTRATION
// ==========================================

const studentForm =
    document.getElementById("studentForm");

if (studentForm) {

    studentForm.addEventListener(
        "submit",
        async function (e) {

            e.preventDefault();

            const data = {

                student_id:
                    document.getElementById("student_id").value,

                full_name:
                    document.getElementById("full_name").value,

                date_of_birth:
                    document.getElementById("date_of_birth").value,

                gender:
                    document.getElementById("gender").value,

                email:
                    document.getElementById("email").value,

                phone:
                    document.getElementById("phone").value,

                course:
                    document.getElementById("course").value,

                semester:
                    document.getElementById("semester").value,

                guardian_name:
                    document.getElementById("guardian_name").value,

                guardian_phone:
                    document.getElementById("guardian_phone").value,

                registration_date:
                    document.getElementById("registration_date").value,

                status:
                    document.getElementById("status").value
            };

            try {

                const result = await sendRequest(
                    API + "/students/create.php",
                    data
                );

                alert(result.message);

                if (result.success) {

                    studentForm.reset();

                    loadStudents();
                }

            } catch (error) {

                console.error(error);

                alert(
                    "Student registration connection error."
                );
            }
        }
    );
}


// ==========================================
// LOAD STUDENTS
// ==========================================

async function loadStudents() {

    const table =
        document.querySelector("#studentsTable tbody");

    if (!table) return;

    try {

        const result = await sendRequest(
            API + "/students/read.php"
        );

        table.innerHTML = "";

        if (
            !result.success ||
            !result.students
        ) {
            return;
        }

        result.students.forEach(student => {

            table.innerHTML += `
                <tr>
                    <td>${student.student_id}</td>
                    <td>${student.full_name}</td>
                    <td>${student.course}</td>
                    <td>${student.semester}</td>
                    <td>${student.phone}</td>
                </tr>
            `;
        });

    } catch (error) {

        console.error(
            "Student loading error:",
            error
        );
    }
}

loadStudents();


// ==========================================
// FEE PAYMENT
// ==========================================

const paymentForm =
    document.getElementById("paymentForm");

if (paymentForm) {

    paymentForm.addEventListener(
        "submit",
        async function (e) {

            e.preventDefault();

            const fields =
                paymentForm.querySelectorAll(
                    "input, select"
                );

            const studentName =
                fields[0]?.value || "";

            const studentId =
                fields[1]?.value || "";

            const feeType =
                fields[2]?.value || "";

            const amount =
                fields[3]?.value || "";

            const paymentDate =
                fields[4]?.value || "";

            const data = {

                student_id: studentId,

                amount: amount,

                fee_type: feeType,

                payment_date:
                    paymentDate || new Date()
                    .toISOString()
                    .split("T")[0],

                payment_method: "Cash",

                status: "Paid",

                transaction_reference: null
            };

            try {

                const result = await sendRequest(
                    API + "/fees/create.php",
                    data
                );

                alert(result.message);

                if (result.success) {

                    paymentForm.reset();

                    if (
                        typeof closePaymentForm ===
                        "function"
                    ) {
                        closePaymentForm();
                    }

                    loadFees();
                }

            } catch (error) {

                console.error(error);

                alert(
                    "Fee payment connection error."
                );
            }
        }
    );
}


// ==========================================
// LOAD FEES
// ==========================================

async function loadFees() {

    const table =
        document.querySelector(
            "#feesTable tbody"
        );

    if (!table) return;

    try {

        const result = await sendRequest(
            API + "/fees/read.php"
        );

        if (
            !result.success ||
            !result.payments
        ) {
            return;
        }

        table.innerHTML = "";

        result.payments.forEach(payment => {

            table.innerHTML += `
                <tr>
                    <td>#PAY${payment.id}</td>

                    <td>
                        ${payment.full_name}
                    </td>

                    <td>
                        ${payment.fee_type}
                    </td>

                    <td>
                        Rs. ${payment.amount}
                    </td>

                    <td>
                        ${payment.payment_date || "-"}
                    </td>

                    <td>
                        ${payment.status}
                    </td>

                    <td>
                        <button class="view-btn">
                            View
                        </button>
                    </td>
                </tr>
            `;
        });

    } catch (error) {

        console.error(
            "Fee loading error:",
            error
        );
    }
}

loadFees();


// ==========================================
// COMPLAINTS
// ==========================================

const complaintForm =
    document.getElementById("complaintForm");

if (complaintForm) {

    complaintForm.addEventListener(
        "submit",
        async function (e) {

            e.preventDefault();

            const fields =
                complaintForm.querySelectorAll(
                    "input, select, textarea"
                );

            const data = {

                student_id:
                    fields[1]?.value || "",

                complaint_title:
                    fields[2]?.value || "",

                category:
                    fields[3]?.value || "",

                complaint_description:
                    fields[4]?.value || ""
            };

            try {

                const result = await sendRequest(
                    API + "/complaints/create.php",
                    data
                );

                alert(result.message);

                if (result.success) {

                    complaintForm.reset();

                    if (
                        typeof closeComplaintForm ===
                        "function"
                    ) {
                        closeComplaintForm();
                    }

                    loadComplaints();
                }

            } catch (error) {

                console.error(error);

                alert(
                    "Complaint connection error."
                );
            }
        }
    );
}


// ==========================================
// LOAD COMPLAINTS
// ==========================================

async function loadComplaints() {

    try {

        const result = await sendRequest(
            API + "/complaints/read.php"
        );

        if (
            !result.success ||
            !result.complaints
        ) {
            return;
        }

        console.log(
            "Complaints:",
            result.complaints
        );

    } catch (error) {

        console.error(
            "Complaint loading error:",
            error
        );
    }
}

loadComplaints();


// ==========================================
// NOTICES
// ==========================================

const noticeForm =
    document.getElementById("noticeForm");

if (noticeForm) {

    noticeForm.addEventListener(
        "submit",
        async function (e) {

            e.preventDefault();

            const fields =
                noticeForm.querySelectorAll(
                    "input, select, textarea"
                );

            const data = {

                title:
                    fields[0]?.value || "",

                category:
                    fields[1]?.value || "",

                priority:
                    fields[2]?.value || "Normal",

                description:
                    fields[3]?.value || "",

                notice_type: "General",

                expiry_date: null,

                status: "Active"
            };

            try {

                const result = await sendRequest(
                    API + "/notices/create.php",
                    data
                );

                alert(result.message);

                if (result.success) {

                    noticeForm.reset();

                    if (
                        typeof closeNoticeForm ===
                        "function"
                    ) {
                        closeNoticeForm();
                    }

                    loadNotices();
                }

            } catch (error) {

                console.error(error);

                alert(
                    "Notice connection error."
                );
            }
        }
    );
}


// ==========================================
// LOAD NOTICES
// ==========================================

async function loadNotices() {

    try {

        const result = await sendRequest(
            API + "/notices/read.php"
        );

        if (
            !result.success ||
            !result.notices
        ) {
            return;
        }

        console.log(
            "Notices:",
            result.notices
        );

    } catch (error) {

        console.error(
            "Notice loading error:",
            error
        );
    }
}

loadNotices();


// ==========================================
// ROOM ALLOCATION
// ==========================================

const roomForm =
    document.getElementById(
        "roomAllocationForm"
    );

async function loadRooms() {

    const select =
        document.getElementById(
            "room_number"
        );

    if (!select) return;

    try {

        const result = await sendRequest(
            API + "/rooms/read.php"
        );

        select.innerHTML =
            '<option value="">Select Room</option>';

        if (
            !result.success ||
            !result.rooms
        ) {
            return;
        }

        result.rooms.forEach(room => {

            if (
                Number(room.occupied_beds) <
                Number(room.capacity)
            ) {

                select.innerHTML += `
                    <option value="${room.id}">
                        Room ${room.room_number}
                        -
                        ${room.room_type}
                        (${room.occupied_beds}/${room.capacity})
                    </option>
                `;
            }
        });

    } catch (error) {

        console.error(
            "Room loading error:",
            error
        );
    }
}

loadRooms();


if (roomForm) {

    roomForm.addEventListener(
        "submit",
        async function (e) {

            e.preventDefault();

            const studentId =
                document.getElementById(
                    "student_id"
                ).value;

            const roomId =
                document.getElementById(
                    "room_number"
                ).value;

            const data = {

                student_id: studentId,

                room_id: roomId
            };

            try {

                const result = await sendRequest(
                    API + "/rooms/allocate.php",
                    data
                );

                alert(result.message);

                if (result.success) {

                    roomForm.reset();

                    if (
                        typeof closeRoomForm ===
                        "function"
                    ) {
                        closeRoomForm();
                    }

                    loadRooms();
                }

            } catch (error) {

                console.error(error);

                alert(
                    "Room allocation connection error."
                );
            }
        }
    );
}


// ==========================================
// DASHBOARD
// ==========================================

async function loadDashboardData() {

    const totalStudents =
        document.getElementById(
            "totalStudents"
        );

    if (!totalStudents) return;

    try {

        const result = await sendRequest(
            API + "/dashboard/dashboard_data.php"
        );

        if (result.success) {

            document.getElementById(
                "totalStudents"
            ).textContent =
                result.total_students;

            document.getElementById(
                "totalRooms"
            ).textContent =
                result.total_rooms;

            document.getElementById(
                "pendingFees"
            ).textContent =
                result.pending_fees;

            document.getElementById(
                "pendingComplaints"
            ).textContent =
                result.pending_complaints;
        }

    } catch (error) {

        console.error(
            "Dashboard error:",
            error
        );
    }
}

loadDashboardData();